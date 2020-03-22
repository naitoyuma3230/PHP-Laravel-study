<?php
require_once(__DIR__. '/../config/config.php');

$app = new MyApp\Controller\Deletecomplate();
$app->run();
?>

<!DOCTYPE html>
<html lang="ja" >
  <?php include('head.inc.php'); ?>
  <body>
    <?php include('header.inc.php'); ?>

    <h1 id="confirm-t">削除確認</h1>
    <h4 class="text-center"><?php echo  h($app->getErrors('post')); ?></h4>
    <h4 class="text-center"><?php echo  h($app->getValues()->journals->title); ?></h4>

    <?php include('footer.inc.php'); ?>
  </body>
</html>
