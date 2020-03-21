<?php

require_once(__DIR__. '/../config/config.php');


$app = new MyApp\Controller\Index();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<?php include('head.inc.php'); ?>
  <body>
    <?php include('header.inc.php'); ?>
    <div class="main-container">
      <h1>Academic Presentation</h1>
      <p>Standing on the shoulders of giants</p>
    </div>
    <div class="share">
        <div class="share-comment">
          <p>Post your journals</p>
        </div>
    </div>
    <div class="login ">
    <p><a href="post.php" >New Post</a></p>
    </div>
    <div class="upload">
    <?php foreach ($app->getValues()->journals as $journal) : ?>
    <div class="upload-container">
      <div class="title">
        <p>タイトル</p>
        <a class="title-link" href="editmenu.php?id=<?=$journal->id?>"><p><?= h($journal->title); ?></p></a>
      </div>
      <div class="presenter">
        <p>発表者</p>
        <p><?= h($journal->presenter); ?></p>
      </div>
      <div class="intr">
        <p>Abstract</p>
        <p><?= h($journal->abstract); ?></p>
      </div>
      <div class="keyword">
        <p>Key Word</p>
        <p><?= h($journal->keyword1); ?></p>
        <p><?= h($journal->keyword2); ?></p>
        <p><?= h($journal->keyword3); ?></p>
      </div>
    </div>
    <?php endforeach; ?>
    </div>
    <div class="next">
      <a href="#" >次のページ</a>
    </div>
    <?php include('footer.inc.php'); ?>
  </body>
</html>
