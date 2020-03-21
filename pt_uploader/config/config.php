<?php

ini_set('display_errors',1); //ブラウザーエラー表示

// データベースにアクセス
define('DB_DATEBASE','pt_upload_db');
define('DB_USERNAME','pt_user');
define('DB_PASSWORD','1071');
define('PDO_DSN','mysql:dbhost=localhost;dbname=' . DB_DATEBASE);

define('SITE_URL','http://'. $_SERVER['HTTP_HOST']);/* $_SERVER['HTTP_HOST'] 現在のアドレス、ポートを取得*/

require_once(__DIR__. '/../lib/functions.php');
require_once('autoload.php');

session_start();
?>
