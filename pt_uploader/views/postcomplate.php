<?php
require_once(__DIR__. '/../config/config.php');

$app = new MyApp\Controller\Postcomplate();
$app->run();
echo $_POST['presenter'];
?>

<!DOCTYPE html>
<html lang="ja" >
  <?php include('head.inc.php'); ?>
  <body>
    <?php include('header.inc.php'); ?>

    <h1 id="confirm-t">登録確認</h1>
    <h3 class="text-center"><?php echo  h($app->getErrors('post')); ?></h3>
    <h3 class="mx-5 text-center"><?php echo  h($_POST['title']); ?></h3>
    <?php include('footer.inc.php'); ?>
  </body>
</html>
