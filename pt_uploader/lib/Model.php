<?php

namespace MyApp;

class Model {
    // 全てのテーブル操作に共通のメソッド、プロパティ
    
	protected $db;

	public function __construct() {
			// detanase 接続
			try{
				$this->db = new \PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD );
			}catch (\PDOException $e) {
				echo $e->getMessage();
				exit;
			}
	}
}