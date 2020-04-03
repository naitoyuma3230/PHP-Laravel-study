<?php

class Router{

    protected $routes;

    public function __construct($definitions){
        $this->toutes = $this->complieRoutes($definitions);
    }

    public function complieRoutes($definitions){
        $routes = array();

        foreach($definitions as $url => $params){
            // explodeでURLを'/'区切りで分割し配列にする  ltrimで取り除かれる'/'は最初の一つのみ？
            $tokens = explode('/', ltrim($url, '/'));
            foreach($tokens as $i => $token){
                if(0 === strpos($token, ';')){
                    $name = substr($token, '/');
                    $token = '(?P<' . $name .'>[^/]+)';

                }
            }


        }
    }
}