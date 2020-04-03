<?php

class ClassLoader{

    protected $dirs;

    public function register(){
        sql_autoload_register(array($this, 'loadClass'));
        // 関数の引数にオブジェクトのインスタンスを渡すには配列を使用。配列0にオブジェクト、1 にメソッド名を指定
        // クラス定義時にこのクラスの$this->loadclassが実行されるよう登録する
    }

    public function registerDir($dir){
        $this->dirs[] = $dir;
    }

    public function loadClass($class){
        foreach ($this->dirs as $dir){
            $file = $dir . '/' . $class . '.php';
            // is_readable:ファイルの存在、読み込み可否を返す
            // dir名/class名.phpで登録されたファイルをDir総当たりで検索
            if(is_readable($file)){
                require $file;

                return;
            }
        }
    }

}
