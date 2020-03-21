<?php
  namespace MyApp\Controller;
  // 名前空間を設定

  class Signup extends \MyApp\Controller{  /*Controllerクラスを継承*/

    public function run(){
      if($this->isLogeedIn()){
        // Login済み 現在のURLを再読み込み
        header('Location: ' . SITE_URL);/* $_SERVER['HTTP_HOST'] 現在のアドレス、ポートを取得*/
        exit;
      }
      if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $this->signupProcess();
      // $_SERVER :サーバーの様々な情報を取得する際のアクセス変数
      // $_SERVER['REQUEST_METHOD'] :現在のページにアクセスする際に使用されたメソッド(POST,GETなど)を返す
      }
    }

    protected function signupProcess(){
    // validate:検証
      try{
        $this->_validate();
        // POST[token]が空,もしくはPOSTとSESSIONのtokenが一致しない場合のエラー
      }catch(\MyApp\Exception\InvalidEmail $e){
        // echo $e->getMessage();/*Invaildemailクラスを変数$e(exception)に代入$e->*/
        // exit;
        $this->setErrors('email',$e->getMessage());

      }catch(\MyApp\Exception\InvalidPassword $e){
        // echo $e->getMessage();
        // exit;
        $this->setErrors('password',$e->getMessage());
      }

      $this->setValues('email' , $_POST['email']);
      // 例外処理の後に クラス_values emailプロパティをFromに入力された値に設定する

      if ($this->hasError()){
        return;
      }else{
      // create user
      try {
        $userModel = new \MyApp\Model\User();
        $userModel->create([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }

        // redirect to login
        header('Location: ' . SITE_URL . '/login.php');
        exit;
        }
      }
      
      private function _validate(){
        // 外部からのアクセスを防止するため、formから送られたPOSTとSESSIONで保持するtokenの照合を行う
        if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
          echo "Invaild token!";
          exit;
        }

        if (!filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)){
          /*filter_var('info@wepicks.net', FILTER_VALIDATE_EMAIL)
          filter_var:データ検証メソッド （第一引数：チェックしたい変数 第二引数：FILTER_VALIDATE.オプション)*/
          // emailの検証
          throw new \MyApp\Exception\InvalidEmail();/*例外を投げる*/
        }

        if (!preg_match('/\A[a-zA-Z0-9]+\z/' , $_POST['password'])){
          /*preg_match :正規表現の検索 戻り値0:truth 1:false
          返り値 = preg_match(/正規表現パターン/,検索対象の文字列,[配列],[動作フラグ],[検索開始位置])
          正規表現 \A:入力の先頭から\z:入力の末尾までが[a-zA-Z0-9]:Aa 〜 Zz と 0 〜 9で構成されているか */
          // passwordの検証
          throw new \MyApp\Exception\InvalidPassword();
        }
      }




    }
