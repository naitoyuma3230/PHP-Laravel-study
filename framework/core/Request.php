<?php

class Request{

    // Postリクエストの判別
    public function isPost(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            return true;
        }
        return false;
    }

    // Getリクエスト情報の取得 [?クエリ文字列(URLパラメータ)]
    public function getGet($name, $default = null){
        if(isset($_GET[$name])){
            return $_GET[$name];
        }

        return $default;
    }

    // Postリクエスト情報の取得
    public function getPost($name, $default = null){
        if(isset($_POST[$name])){
            return $_POST[$name];
        }

        return $fefault;
    }

    // [Host名(ドメイン)]の取得
    public function getHost(){
        if(!empty($_SERVER['HTTP_HOST'])){
            return $_SERVER['HTTP_HOST'];

        }

        return  $_SERVER['SERVER_NAME'];
        // アパッチ側のHost名
    }

    // Https：暗号化通信の使用の有無を判別
    public function isSsl(){
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS' === 'on']){
            return true;
        }

        return false;
    }

    // [Path名] + [?クエリ文字列(GETパラメータ)] の取得 間に[PATH_INFO]が入る
    public function getRequestUri(){
        return $_SERVER['REQUEST_URI'];
    }


    //      [プロトコル]          [Host名(ドメイン)]        [Path名]       [?クエリ文字列(GETパラメータ)]     
    //   Http:// or Https://     (www).exanple.com   /core/index.php                ?id=123
    
    // [BaseURL]:ファイル名省略に対応した[Path名]
    // [PATH_INFO]:内部的URL    [Path名]と[GETパラメータ]の間にありRouterで使用
    public function getBaseUrl(){
        
        // [Path名]の取得
        $script_name = $_SERVER['SCRIPT_NAME'];

        // [Path名] + [?クエリ文字列(URLパラメータ)] の取得
        $request_uri = $this->getRequestUri();

        // strposで$script_nameの場所を検索 0=先頭
        if(0 === strpos($request_uri, $script_name)){
            return $script_name;

        // dirname($script_name):index.php(ファイル名）が省略されている場合 dirnameでディレクトリのみ抜き出し検索
        }else if(0 === strpos($request_uri, dirname($script_name))){
            // 省略の場合 末尾が'/'になるためトリミング
            return rtrim(dirname($script_name), '/');
        }

        return;
    }

    public function getPathInfo(){

        $base_url = $this->getBaseUrl();
        $request_uri = $this->getRequestUri();

        // strposで'?'の位置を取得
        if(false !== ($pos = strpos($request_uri, '?'))){

            // substrで先頭=0 から'?'の位置までのURLを取得 GETパラメータを取り除く
            $request_uri = substr($request_uri, 0, $pos);
        }

        // BaseURLを取り除く
        $path_info = (string)substr($request_uri, strlen($base_url));


        return $path_info;
    }












}