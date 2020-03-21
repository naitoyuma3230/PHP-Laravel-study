<?php
namespace MyApp\Controller;

class Editmenu extends \MyApp\Controller{ 

  public function run(){
      // get journal info
      $journalModel = new \MyApp\Model\Journal();
      $this->setValues('journals' , $journalModel->findId($_GET['id'])); 
      // $this->_values->$key('journals') = $value('journalテーブルのarry')
  }
}

?>
