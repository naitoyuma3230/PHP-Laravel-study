<?php

require_once(__DIR__. '/../config/config.php');


$app = new MyApp\Controller\Editmenu();
$app->run();

?>
<!DOCTYPE html>
<html lang="ja">
<?php include('head.inc.php'); ?>
  <body>
  <?php include('header.inc.php'); ?>
  <div class="upload">
    <?php foreach ($app->getValues()->journals as $journal) : ?>
    <div class="upload-container">
      <p class="h4 text-center text-danger "><?= h($app->getMessage()); ?></p>
      <div class="title">
        <p>タイトル</p>
        <a class="title-link"><p><?= h($journal->title); ?></p></a>
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
      <div class="maintext">
        <p>本文</p>
        <p><?=  h($journal->maintext); ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="menu-container">
    <form action="update.php" method="post">
    <input type="hidden" name="presenter" value="<?= h($journal->presenter); ?>">
      <input type="hidden" name="id" value="<?= h($journal->id); ?>">
      <button class="btn-square">投稿の修正</button>
    </form>

    <form name="myform" action="deletecomplate.php" method="post">
      <input type="hidden" name="id" value="<?=$journal->id?>">
      <button class="delete btn-square">投稿の削除</button>
    </form>

    <form action="" method="post">
      <input type="hidden" name="id" value="<?=$journal->id?>">
      <button class="btn-square">コメント</button>
    </form>

  </div>
    <?php include('footer.inc.php'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
    $('.delete').click(function() {
      if (!confirm('この投稿を削除しても宜しいですか？')){
        return false;
      }else{
        $('delete').click();
      }
    })
  </script>

  </body>
</html>
