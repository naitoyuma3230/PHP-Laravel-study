<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller{ 

  public function run(){

    // get journal info
    $journalModel = new \MyApp\Model\Journal();
    $this->setValues('journals' , $journalModel->findAll());
    
    // $this->_values->$key('journals') = $value('journalテーブルのarry')
  }
}
