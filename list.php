<?php
  require_once './helpers/GoodsDAO.php';
  require_once './helpers/Category_GroupDAO.php';
  require_once './helpers/MakerDAO.php';
  require_once './helpers/Goods_CPUDAO.php';
  require_once './helpers/Goods_CoolerDAO.php';
  require_once './helpers/Goods_MotherBoardDAO.php';
  require_once './helpers/Goods_MemoryDAO.php';
  require_once './helpers/Goods_GPUDAO.php';
  require_once './helpers/Goods_SSDDAO.php';
  require_once './helpers/Goods_HDDDAO.php';
  require_once './helpers/Goods_PowerDAO.php';
  require_once './helpers/Goods_CaseDAO.php';
  require_once './helpers/Goods_FanDAO.php';
  require_once './helpers/Goods_OSDAO.php';

  if (isset($_GET['keyword'])) {
    $goodsDAO = new GoodsDAO();
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
  else{
    $goodsDAO = new GoodsDAO();
    $goods_list = $goodsDAO->get_Goods();
  }
  
 
    
 
 
  $Category_GroupDAO = new Category_GroupDAO();
  $category_list = $Category_GroupDAO->get_category_group();
  $MakerDAO = new MakerDAO();
  $maker_list = $MakerDAO->get_maker();



?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/list.css">
    <title>商品一覧</title>
    <meta charset="utf-8">
</head>
<body>
<?php include "header.php"; ?>
        <div class="container">
            <div class="main">
                <div class="contains">
                    <form action="" method="GET" class="categoryList">
                        <h6>カテゴリで検索</h6>
                        <?php foreach($category_list as $category_group) : ?>
                            <input type="radio" name="cate" value=<?= $category_group->group_code ?>>
                            <?= $category_group->group_name ?><br>    
                        <?php endforeach; ?>
                        <input type="submit" value="検索">   
                    </form>
                
                    <form action="" method="GET" class="filterList">
                        <h6>メーカーで検索</h6>
                        <?php foreach($maker_list as $maker) : ?>
                            <input type="radio" name="maker" value=<?= $maker->maker_id ?>>
                            <?= $maker->maker_name ?><br>
                        <?php endforeach; ?>
                        <input type="submit" value="検索">    
                    </form>
                </div>
                <?php if(empty($goods_list)) : ?>
                    <p>お探しの商品はありません</p>
                <?php else: ?>
                    <div class="list">
                        <table class="table table-bordered table-hover">
                            <?php foreach($goods_list as $goods) : ?> 
                                <div class="table-responsive text-nowrap">
                                    <tr class="table-info">
                                        <tr>
                                            <td>
                                                <a href="goodsreview.php?goods_code=<?=$goods->goods_code ?>"style="display:block;">
                                                    <img src="images/goods/<?= $goods->goods_image ?>">
                                                </a>
                                            </td>   
                                            <td>
                                                <a href="goodsreview.php?goods_code=<?=$goods->goods_code ?>"style="display:block;width:100%;height:100%;">
                                                    <?= $goods->goods_name ?><br>
                                                    <?= number_format($goods->price) ?>円
                                                </a>    
                                            </td>
                                        </tr>
                                    </tr>        
                                </div>
                            <?php endforeach ; ?>
                        </table>
                    </div>        
                <?php endif; ?>     
            </div>
        </div>
        
<?php include "footer.php"; ?>
</body>
</html>