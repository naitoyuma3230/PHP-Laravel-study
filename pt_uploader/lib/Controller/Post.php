<?php
namespace MyApp\Controller;

class Post extends \MyApp\Controller{
    // 継承でSESSION['token']を自動生成
    // formからPOST['token']をComplate.phpに送る
    public function run(){
        if(!$this->isLogeedIn()){
            // Login済みなら
            header('Location: ' . SITE_URL . '/login.php');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $journalModel = new \MyApp\Model\Journal();
            $this->setValues('journals' , $journalModel->findId($_GET['id']));
        }
    }
    
}