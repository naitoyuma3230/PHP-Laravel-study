<?php

require_once(__DIR__ .'/../config/config.php');

$app = new MyApp\Controller\Update();
$app->run();

?>

<!DOCTYPE html>
<html lang="en" >
<?php include('head.inc.php'); ?>
<body>
  <?php include('header.inc.php'); ?>

  <h2>抄録の修正</h2>
  <form class="form" action="updatecomplate.php" method="post">

      <div class="form-gloup">
      <?php if(isset($app->getValues()->journals)){ 
      foreach ($app->getValues()->journals as $journal) : ?>
        <label class="control-label ">タイトル</label>
        
        <textarea class="form-control" type="text" name="title" rows="2" cols="20" 
        required><?= h($journal->title); ?></textarea>

        <input type="hidden" name="presenter" value="<?php echo h( $_SESSION['me']->email); ?>">
      
        <label class="control-label">ABSTRACT</label>
        <textarea class="form-control" type="text" name="abstract" rows="8" cols="80" required><?= h($journal->abstract);?></textarea>
        <label>KeyWord 1</label>
        <input class="form-control" type="text" name="keyword1" value="<?= h($journal->keyword1);?>" required >
        <label>KeyWord 2</label>
        <input class="form-control" type="text" name="keyword2" value="<?= h($journal->keyword2);?>" required>
        <label>KeyWord 3</label>
        <input class="form-control" type="text" name="keyword3" value="<?= h($journal->keyword3);?>" required>
        <label >本文</label>
        <textarea class="form-control" name="maintext" rows="15" cols="80" required><?= h($journal->maintext);?></textarea>
        <?php endforeach; } ?>
      </div>
    <input type="hidden" name="id" value="<?php echo h($_POST['id']);?>">

    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <button class="btn-square ">投稿確認</button>
  </form>
  <?php include('footer.inc.php'); ?>
  <body>
</html>
