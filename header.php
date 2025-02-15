<?php
  require_once './helpers/GoodsDAO.php';
  require_once './helpers/MemberDAO.php';
  require_once './helpers/Category_GroupDAO.php';
  require_once './helpers/MakerDAO.php';

  if(session_status() === PHP_SESSION_NONE){
      session_start();
  }

  if(!empty($_SESSION['member'])){
      $member=$_SESSION['member'];
  }
  if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $goods_list = $goodsDAO->get_goods_by_keyword($keyword);
  }
  else if(isset($_GET['cate'])){
    $cate = $_GET['cate'];
    $goodsDAO = new GoodsDAO();
    $goods_list = $goodsDAO->get_goods_by_group_code($cate);
  }
  else if(isset($_GET['maker'])){
    $maker = $_GET['maker'];
    $goodsDAO = new GoodsDAO();
    $goods_list = $goodsDAO->get_goods_by_maker_id($maker);
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="css/headerStyle.css" rel="stylesheet">
  <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
  <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
  <title>Header</title>
</head>
<body>
  <header>
    <div class="header">
      <div id="header_logo">
        <a href="top.php"><img src="images/logo.png" alt="ロゴ"></a>
      </div>
        <form action="list.php" name="keyword" class="header_search" method="GET">
          <label>
            <input  class="textbox" type="text" name="keyword" placeholder="キーワードを入力" value="<?php if (isset($_GET['keyword'])) : echo $keyword; endif;?>">
          </label>
          <div>
            <button type="submit" onclick="location.href='list.php'" aria-label="検索"></button>
          </div>
        </form>
      <div class="header_link">
        <?php if(isset($member)): ?>
          <?= $member->member_name ?>さん
          <a href="logout.php">ログアウト</a>
          <a href="mypage.php">マイページ</a>
          <a href="cart.php">カート</a>
          <a href="koseicheck.php">構成チェック</a>
        <?php else: ?>
          <a href="login.php">ログイン</a>
        <?php endif; ?>
      </div>
      <div id="clear">
        <hr>
      </div>
    <div>
  </header>
</body>
</html>
