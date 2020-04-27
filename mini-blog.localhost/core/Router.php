<?php

class Router{

    protected $routes;

    public function __construct($definitions){
        $this->routes = $this->compileRoutes($definitions);
    }

    // compileRoutes : Routeをキャプチャ可能な形に仕分ける
    public function compileRoutes($definitions){
        $routes = array();

        //  $definitions : resieterRoutes()でarrayを格納する
        //  例） array(
        //          '/user/edit' （PATH_INFO）
        //              => array('controller' => 'user', 'action' => 'edit'),
        //                            コントローラーとアクションを指定
        // );

        foreach($definitions as $url => $params){
            // explodeでURLを'/'区切りで分割し配列にする  ltrimで最初の一つのみ'/'を取り除く
            $tokens = explode('/', ltrim($url, '/'));

            foreach($tokens as $i => $token){
                // 先頭が':'で始まる動的パラメータの変換
                if(0 === strpos($token, ':')){
                    // substrで':'以下を取得
                    $name = substr($token, 1);
                    // (?P<name>パターン)でマッチングしたパターンをname付きでキャプチャ
                    $token = '(?P<' . $name .'>[^/]+)';

                }
                // $tokensを動的パラメータをキャプチャできるよう取り出す
                // 静的パラメータの配列として格納
                $tokens[$i] = $token;
            }

            // 分割された配列($tokens)をimplode（'/'）で連結。動的パラメータのみキャプチャできる形でURLの形に再変換
            $pattern = '/' . implode('/',$tokens);

            // routesプロパティのkeyとして格納 valueの$paramsはいじってない
            $routes[$pattern] = $params;
        }

        return $routes;
    }

    public function resolve($path_info){
        // PATH_INFOが'/'から始まっていなかったら先頭に'/'を付ける
        if('/' !== substr($path_info, 0, 1)){
            $path_info = '/' . $path_info;
        }

        foreach($this->routes as $pattern => $params){
            // $routesに格納されたパターンで検索、結果':'以降の動的パラメータを$matchesに格納
            if(preg_match('#^' . $pattern . '$#', $path_info, $matches)){
                $params = array_merge($params, $matches);

                return $params;
            }
        }
        return false;
    }

}