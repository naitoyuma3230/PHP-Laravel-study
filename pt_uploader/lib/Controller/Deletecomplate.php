<?php
namespace MyApp\Controller;

class Deletecomplate extends \MyApp\Controller{

    public function run(){
        echo $_SERVER['REQUEST_METHOD'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            /*POSTメソッドでアクセスしたなら*/
            $journalModel = new \MyApp\Model\Journal();
            $this->setValues('journals' , $journalModel->findId($_POST['id']));
            $this->deleteProcess();
        }
        
    }
    
    // validate
    private function _validate(){
        if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
            throw new \MyApp\Exception\DuplicateJournal();
        }
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
         // リロードによる二重投稿の防止のため$_SESSION['token']を再設定
    }

    private function deleteProcess(){
            // delete
            try{
                $journalModel = new \MyApp\Model\Journal();
                $journalModel->delete([
                    'id' => $_POST['id']
                    ]);
            }catch(\MyApp\Exception\DuplicateJournal $e){
                $this->setErrors('post', $e->getMessage());
                return;
            }
    
    }
}