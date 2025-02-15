<?php
require_once './helpers/MemberDAO.php';
require_once './helpers/GoodsDAO.php';
require_once './helpers/ReviewDAO.php';
require_once './helpers/CartDAO.php';
session_start();
$errs=NULL;
 

//URL リクエストパラメーターに商品コードが設置されてるとき
if(isset($_GET['goods_code'])){
    //リクエストパラメーターの商品コードを得る。
    $goods_code=$_GET['goods_code'];
    $goodsDAO=new GoodsDAO();
    $goods = $goodsDAO->get_goods_by_goodscode($goods_code);

    if(!is_bool($goods)){
        $reviewDAO = new ReviewDAO();
    
        $review_result=$reviewDAO->review_result($goods_code);
        if($review_result){
            $code_count = count($review_result);

            $star_sum = 0;

            foreach($review_result as $result_star){
                $star_sum += $result_star->star_quantity;
            }
            $evaluation = $star_sum/$code_count;
        }
        else{
            $evaluation = "総合評価がありません";
        }
    }else{
        $message ="お探しの商品は削除されたか、ありません。";
    }

    
}
else{
    $message ="お探しの商品は削除されたか、ありません。";
}
if(!empty($_SESSION['member'])){
    $login_member = $_SESSION['member'];

    $member_id=$login_member->member_id;
    
}else{
    $member_id = 0;
    
}

 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_SESSION['member'])){
        header('Location: login.php');
        exit;
    }
    $member_id=$_POST['member_id'];
    $goods_code=$_POST['goods_code'];
    $star_quantity=$_POST['star_quantity'];
    
    $reviewDAO = new ReviewDAO(); 
    $goodsDAO = new GoodsDAO();
    $memberDAO = new MemberDAO();
    
    if($star_quantity === ''){
        $errs='選択してください';
    }
    if($reviewDAO->review_exists($member_id,$goods_code) === true){
        $errs='すでに登録されています';
    }
    if (empty($errs)) {
        $reviewDAO->review_insert($member_id,$goods_code,$star_quantity);
        $ret='レビューを投稿しました！';
    }
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>商品ページ</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/goodsreview.css">
</head>
<body>
    <?php include "header.php";?>
        <div class="goodsreview">
            <div class ="goods">
                
                <?php if(isset($message)) : ?>
                    <p><?= $message ?></p>
                <?php else: ?>    
                <table border="1">
                    <tr>
                        <td class="img">
                            <!--<a href="list.php?cate=<?=$goods->group_code ?>"style="display:block;">-->
                                <p><img src="images/goods/<?=$goods->goods_image?>" ></p>
                            <!--</a>    -->
                        </td>
                        <td class="goodsinfo">
                            <p><?=$goods->goods_name ?></p>
                            <p>
                                <input type="hidden" name="goods_code" value="<?=$goods_code?>">
                                <?php if(strpos($evaluation,"総合評価がありません") !== false) : ?>
                                    <?=$evaluation ?>    
                                <?php else: ?>
                                    総合評価 : <?=number_format($evaluation, 1) ?>
                                <?php endif;?>
                            </p>
                            <p>\<?=number_format($goods->price) ?></p>
                        </td> 
                        <td class="select">
                            <div class=continer>
                                <div class="row">
                                    <form action="cart.php" method="POST">
                                        <div style="width: 50px;">
                                            個数：
                                        </div>
                                        <div class="col-md-auto">
                                            <input name="number" type="number" class="form-control" min="1"  max="99" step="1" style="width:100px;"value="1">
                                            
                                        </div>
                                        <input type="hidden" name="goods_code" value="<?=$goods_code?>">
                                        <input type="submit" class="btn btn-primary" id="btn" name="add" value="カートに入れる" required /><br>
                                    </form>
                                    <form action="koseicheck.php" method="POST" >
                                        <input type="hidden" name="goods_code" value="<?=$goods_code?>">
                                        <input type="submit" class="btn btn-primary" id="btn"name="add" value="構成チェックに追加"><br>
                                    </form>
                                    <form action="bookmark.php" method="POST" >
                                        <input type="hidden" name="goods_code" value="<?=$goods_code?>">
                                        <input type="submit" class="btn btn-primary" id="btn" name="add"value="ブックマークに登録"><br>
                                    </form>
                                </div>
                            </div>        
                        </td>
                    </tr>
                </table>
                
            </div>
        </div>        
        <form action="" method="POST"  class="button">
            <p>この商品を評価する</p>
            
            <span class="rate-wrap">評価
                <select name="star_quantity">
                    <span class="num">
                        <option value="">選択してください</option>
                        <option value="5">5</option>
                        <option value="4">4</option>
                        <option value="3">3</option>
                        <option value="2">2</option>
                        <option value="1">1</option>
                    </span>    
                </select>
            </span>
            <input type="hidden" name="member_id" value="<?=$member_id?>">
            <input type="hidden" name="goods_code" value="<?=$goods_code?>">
            
        
            <input type="submit" class="btn btn-primary" value="レビューする"><br>
            <span style="color:red"><?= @$errs ?></span>
            <span style="color:blue"><?= @$ret ?><br>
        </form>
        <?php endif; ?>   
    <?php include "footer.php"; ?>
</body>
</html>