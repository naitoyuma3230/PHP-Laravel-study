<?php

class DbManager{

    protected $connection = array();
    protected $repository_connection_map = array();

    
    // __destruct():インスタンスの破棄、プロセス終了時に自動的に呼び出される
    public function __destruct(){
        foreach($this->repositories as $repository){
            unset($repository);
        }

        foreach($this->connection as $con){
            unset($con);
        }
    }

    public function connect($name, $params){
        // $paramsにPDOデータベース接続に使用する項目を格納
        $params = array_merge(array(
            'dsn'       =>null,
            'user'      =>'',
            'password'  =>'',
            'option'    =>array(),
        ),$params);

        // PDOデータベース接続を実行
        $con = new PDO(
            $params['dsn'],
            $params['user'],
            $params['password'],
            $params['option']
        );

        // オプションでエラー表示設定を有効
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // PDO接続の名前をkeyに内容をvalueに格納
        $this->connection[$name] = $con;
    }

    // PDO接続の名前から内容を取り出す関数
    public function getConnection($name = null){
        if(is_null($name)){
            
            // 配列にはポインタがあり、foreachで回す時とかポインタも回ってる。
            // 名前指定がない場合、currentはポインタの初期位置、配列の最初の要素を取り出す。
            return current($this->connection);
        }
        return $this->connections[$name];
    }

    public function setRepositoryConnectionMap($reponsitory_name){
        if(isset($this->repository_connection_map[$reponsitory_name])){
            $name = $this->repository_connection_map[$reponsitory_name];
            $con = $this->getConnection();
        }else{
            $con = $this->getConnection();
        }

        return $con;
    }

    public function get($repository_name){
        if(!isset($this->repositories[$reponsitory_name])){
            
            $repository_class = $repository_name . 'Repository';
            $con = $this->getConnectionForRepository($repository_name);

            // 変数をclassとして扱う class名を動的に扱うことが可能
            $repository = new $repository_class($con);

            $this->repositories[$reponsitory_name] = $repository;
        }

        return $this->repositories[$repository_name];
    }

}