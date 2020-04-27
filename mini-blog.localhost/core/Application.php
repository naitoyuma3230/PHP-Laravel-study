<?php

abstract class Application{
    
    protected $debug = false;
    protected $request;
    protected $session;
    protected $db_manager;
    
    protected $login_action = array();
    
    // デバックモード切り替え,全クラスの初期化
    public function __construct($debug = false){
        $this->setDebugMode($debug);
        $this->initialize();
        $this->configure();
    }

    public function run(){
        try{
            $params = $this->router->resolve($this->request->getPathInfo());
            
            if($params === false){
                // todo-A
                throw new HttpNotFoundException('No route found for ' . $this->request->getPathInfo());
            }
            
            $controller = $params['controller'];
            $action = $params['action'];
            
            $this->runAction($controller, $action, $params);
        }catch(HttpNotFoundException $e){
            $this->render404Page($e);

        }catch(UnauthorizedActionException $e){
            list($controller, $action) = $this->login_action;
            $this->runAction($controller, $action);
        }
        $this->response->send();
    }


    protected function setDebugMode($debug){
        if($debug){
            $this->debug = true;
            // デバックモード中はエラー表示オン
            ini_set('display_errors', 1);
            // エラー表示のレベル設定  '-1'はすべてのエラーを表示
            error_reporting(-1);
        }else{
            $this->debug = false;
            ini_set('display_errors', 0);
        }
    }

    protected function initialize(){
        // 全クラスの初期化
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->db_manager = new DbManager();
        $this->router = new Router($this->registerRoutes());
    }

    protected function configure(){
    }

    abstract public function getRootDir();

    abstract protected function registerRoutes();

    public function isDebugMode(){
        return $this->debug;
    }

    public function getRequest(){
        return $this->request;
    }

    public function getResponse(){
        $this->response;
    }

    public function getSession(){
        return $this->session;
    }


    public function getDbManager(){
        return $this->db_manager;
    }

    public function getControllerDir(){
        return $this->getRootDir() . '/controllers';
    }

    public function getViewDir(){
        return $this->getRootDir() . '/views';
    }

    public function getModelDir(){
        return $this->getRootDir() . '/models';
    }

    public function getWebDir(){
        return $this->getRootDir() . '/Web';
    }

    protected function render404Page($e){
        $this->response->setStatusCode(404, 'Not Found');
        $message = $this->isDebugMode() ? $e->getMessage() : 'Page not found.';
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $this->response->setContent(<<<EOF
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>404</title>
        </head>
        <body>
            {$message}
        </body>
        </html>
        EOF
                );
    }


    public function runAction($controller_name, $action, $params = array()){
        //ucfirst: コントローラー名を大文字に
        $controller_class = ucfirst($controller_name) . 'Controller';

        $controller = $this->findController($controller_class);
        if($controller === false){
            // todo-B
            throw new HttpNotFoundException($controller_class . ' controller is not found.');
        }

        $content = $controller->run($action, $params);

        $this->response->setContent($content);


    }

    protected function findController($controller_class){
        if(!class_exists($controller_class)){
            $controller_file = $this->getControllerDir() . '/' . $controller_class . '.php';
            if(!is_readable($controller_file)){
                return false;
            }else{
                require_once $controller_file;
                
                if(!class_exists($controller_class)){
                    return false;
                }
            }
        }

        return new $controller_class($this);
    }
    
}
