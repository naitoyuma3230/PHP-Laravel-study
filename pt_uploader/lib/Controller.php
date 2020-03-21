<?php

namespace MyApp;

class Controller{

    private $_values;
    private $_errors;

    public function __construct(){
            if(!isset($_SESSION['token'])){
                $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
              // SESSIONにtoken（ランダムな数列）を設定  SESSIONはブラウザを閉じるまで保持される
              // bin2hex:指定した文字列を16進数に変換する
              // openssl_random_pseudo_bytes(16):ランダム性の高い32桁の数列
            }

        $this->_values = new \stdClass();
        $this->_errors = new \stdClass();
        // new stdClass:クラス定義なしでインスタンスを作成可能._values,_errorsインスタンスを作成
        }

        protected function setValues($key, $value){
            $this->_values->$key = $value;
            // stdClassによる$key=$valueを_valuesのプロパティに代入
        }

        public function getValues(){
            return $this->_values;
            // $valueを返す
        }

        public function setErrors($key, $error){
            $this->_errors->$key = $error;
        }

        public function getErrors($key){
            return isset($this->_errors->$key)  ?   $this->_errors->$key : '';
        }

        public function hasError(){
            return  !empty(\get_object_vars($this->_errors));
        }

        protected function isLogeedIn(){
            return isset($_SESSION['me']) && !empty($_SESSION['me']);/*戻り値：Yes or No*/
        }

        public function me(){
            return $this->isLogeedIn() ? $_SESSION['me'] : null;
        }

        

}