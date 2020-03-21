<?php

namespace MyApp\Controller;

class Update extends \MyApp\Controller{ 

  public function run(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      // get journal info
      $journalModel = new \MyApp\Model\Journal();
      $this->setValues('journals' , $journalModel->findId($_POST['id']));
      // $_values->key('journals') = $value('journalテーブルのarry')
    }
  }
}
?>
