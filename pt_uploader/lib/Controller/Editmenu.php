<?php
namespace MyApp\Controller;

class Editmenu extends \MyApp\Controller{ 

  public function run(){
    if(isset($_POST['id'])){
      $_SESSION['id'] = $_POST['id'];
    }
    // get journal info
    $journalModel = new \MyApp\Model\Journal();
    $this->setValues('journals' , $journalModel->findId($_SESSION['id'])); 
    // $this->_values->$key('journals') = $value('journalテーブルのarry')
      
    }

}

?>
