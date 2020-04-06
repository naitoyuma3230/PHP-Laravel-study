<?php

class Router{

    protected $routes;

    public function __construct($definitions){
        $this->routes = $this->complieRoutes($definitions);
    }

    public function complieRoutes($definitions){
        $routes = array();

        foreach($definitions as $url => $params){
            // explodeでURLを'/'区切りで分割し配列にする  ltrimで取り除かれる'/'は最初の一つのみ？
            $tokens = explode('/', ltrim($url, '/'));

            foreach($tokens as $i => $token){
                // 先頭が':'で始まる動的パラメータの変換
                if(0 === strpos($token, ':')){
                    // substrで':'以下を取得
                    $name = substr($token, 1);
                    // (?P<name>パターン)でマッチングしたパターンをname付きでキャプチャ
                    $token = '(?P<' . $name .'>[^/]+)';

                }
                // $tokensを動的パラメータをキャプチャできるよう配列を変換
                // 静的URLはそのまま
                $tokens[$i] = $token;
            }

            // 分割された配列を'/'でつなぎ動的パラメータのみキャプチャできる形でURLの形に再変換
            $pattern = '/' . implode('/',$tokens);

            // routesプロパティのkeyとして格納 valueの$paramsはいじってない
            $routes[$pattern] = $params;
        }

        return $routes;
    }

    public function resolve($path_info){
        if('/' !== substr($path_info, 0, 1)){
            $path_info = '/' . $path_info;
        }

        foreach($this->routes as $pattern => $params){
            // $routesに格納されたパターンで検索、結果':'以降の動的パラメータを$matchesに格納
            if(preg_match('#^' . $pattern . '$#', $path_info, $matches)){
                $parms = array_merge($params, $matches);

                return $params;
            }
        }
        return false;
    }







}