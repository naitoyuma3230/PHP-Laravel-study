<?php

namespace MyApp\Controller;

class Update extends \MyApp\Controller{ 
  
  public function run(){
    if(!$this->isLogeedIn()){
      // Loginしてなかったら
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }
    if($_SESSION['me']->email !== $_POST['presenter']){
      $_SESSION['message'] = "投稿者とログインユーザーが一致しません";
      header('Location: ' . SITE_URL . '/editmenu.php');
      exit;
    }else{
      $_SESSION['message'] = "";
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      // get journal info
    $journalModel = new \MyApp\Model\Journal();
    $this->setValues('journals' , $journalModel->findId($_SESSION['id']));
    }
  }
}
?>
