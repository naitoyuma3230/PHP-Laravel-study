<?php

abstract class DbRepository{

// 抽象クラスを継承したクラスは必ず抽象クラスのメソッド、プロパティを定義する
    protected $con;

    public function __construct($con){
        $this->setConnection($con);
    }

    public function setConnection($con){
        $this->con = $con;
    }

    public function ececute($sql, $parms = array()){
        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    public function fetch($sql, $params = array()){
        return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);

    }

    public function fetchAll($sql, $params = array()){
        return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

}