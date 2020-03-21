<?php
namespace MyApp\Controller;

class Postcomplate extends \MyApp\Controller{

    public function run(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo $_POST['token'];
            /*POSTメソッドでアクセスしたなら*/
            $this->postProcess();
        }
    }
    
    // validate
    private function _validate(){
        if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
            throw new \MyApp\Exception\UnmatchToken();
        }
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
         // リロードによる二重投稿の防止のため$_SESSION['token']を再設定
    }

    private function postProcess(){
         // validate
        try{
            echo "再設定しました";
            $this->_validate();
        }catch(\MyApp\Exception\UnmatchToken $e){
            $this->setErrors('post', $e->getMessage());
            
        }

        if($this->hasError()){
            return;
        }else{
            // create
            try{
                $journalModel = new \MyApp\Model\Journal();
                // FormからPostされた情報を引数（$values(array)）としてcreateメソッドを実行
                $journalModel->create([
                    'title' => $_POST['title'],
                    'presenter' => $_POST['presenter'],
                    'abstract' => $_POST['abstract'],
                    'keyword1' => $_POST['keyword1'],
                    'keyword2' => $_POST['keyword2'],
                    'keyword3' => $_POST['keyword3'],
                    'maintext' => $_POST['maintext']
                    ]);
            }catch(\MyApp\Exception\DuplicateJournal $e){
                $this->setErrors('post', $e->getMessage());
                return;
            }
        }
    }
}