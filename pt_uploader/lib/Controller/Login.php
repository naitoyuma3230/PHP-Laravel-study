<?php
  namespace MyApp\Controller;


  class Login extends \MyApp\Controller{  /*Controllerクラスを継承*/

    public function run(){
      if($this->isLogeedIn()){
        // Login済み 現在のURLを再読み込み
        header('Location: ' . SITE_URL);
        /* $_SERVER['HTTP_HOST'] 現在のアドレス、ポートを取得*/
        exit;
      }
      if ($_SERVER['REQUEST_METHOD'] === 'POST'){/*POSTメソッドでアクセスしたなら*/
        $this->postProcess();
// $_SERVER :サーバーの様々な情報を取得する際のアクセス変数
// $_SERVER['REQUEST_METHOD'] :現在のページにアクセスする際に使用されたメソッド(POST,GETなど)を返す
      }
    }

    protected function postProcess(){
    // formに投稿された情報の検証、ユーザーDBに登録、リダイレクトするメソッド

    // validate:検証
      try{
        $this->_validate();
        // エラー条件に引っかかったらInvaildクラスを投げる
      }catch(\MyApp\Exception\EmptyPost $e){
        // 何も入力されなかった場合の例外処理*/
        $this->setErrors('login',$e->getMessage());
      }

        $this->setValues('email' , $_POST['email']);
        // 例外処理の後に クラス_values emailプロパティをFromに入力された値に設定する

        if ($this->hasError()){
          return;
        }else{
        // create user
          try{
            $userModel = new \MyApp\Model\User();
            $user = $userModel->login([
              'email' => $_POST['email'],
              'password' => $_POST['password']
            ]); 
          }catch(\MyApp\Exception\UnmatchEmailOrPassword $e){
            // パスワードかEmailが一致しない場合
            $this->setErrors('login', $e->getMessage());
            return;
          }
            
          // login処理
          session_regenerate_id(true);
          $this->setValues('coment', 'SignUp Success');
          // セッションハイジャック対策
          $_SESSION['me'] = $user;

          
        // redirect to home
          header('Location:' . SITE_URL);
          exit;
        }
    }
      private function _validate(){
        if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
          echo "Invaild token!";
          exit;
          // POST[token]が空,もしくはPOSTとSESSIONのtokenが一致しない場合
          // 他のURLからのPOSTを弾く
        }

        if(!isset($_POST['email']) || !isset($_POST['password'])){
          echo "Invaild Form!";
          exit;
        }

        if ($_POST['email'] === '' || $_POST['password'] === ''){
          throw new \MyApp\Exception\EmptyPost();
        }
      }
    }
