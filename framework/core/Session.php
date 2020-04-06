<?php

class Session{
    // static:インスタンス化せず使用する静的プロパティ、静的メソッドの定義
    protected static $sessionStarted = false;
    protected static $sessionIdRegenerated = false;

    public function __construct(){
        if(!self::$sessionStarted){
            session_start();
        
            self::$sessionStarted = true;
            // self:: 自クラスを示す。インスタンス化されない静的メソッド、プロパティを呼び出す
        }
    }

    public function set($name, $value){
        $_SESSION[$name] = $value;
    }

    public function get($name, $default = null){
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        }

        return $default;
    }

    public function remove($name){
        unset($_SESSION[$name]);
    }

    public function clear(){
        $_SESSION = array();
    }

    public function regenerate($destroy = true){
        if(!self::$sessionIdRegenerated){
            session_regenerate_id($destroy);

            self::$sessionIdRegenerated = true;
        }
    }

    public function setAuthenticated($bool){
        $this->set('_authenticated', (bool)$bool);

        $this->regenerate();
    }

    public function isAuthenticated(){
        return $this->get('_authenticated', false);
    }

}
