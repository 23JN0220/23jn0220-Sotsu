<?php

    require_once './helpers/CartDAO.php';
    require_once './helpers/MemberDAO.php';
    require_once './helpers/compositioncheckDAO.php';

    session_start();
    $errs=NULL;

    if(empty($_SESSION['member'])){
        header('Location: login.php');
        exit;
    }
    $member = $_SESSION['member'];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['add'])){
            $goodscode=$_POST['goods_code'];

            $num = $_POST['number'];
            if($num === '')
            {
                $num=0;
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;

            }
        
            
            $cartDAO=new CartDAO();
            $cartDAO->insert($member->member_id, $goodscode, $num);
        }
        else if(isset($_POST['cart_change'])){
            $goodscode=$_POST['goodscode'];
            $num=$_POST['num'];
            if($num === ''){
                $errs['num']='値を入力してください';
            }else{
                $cartDAO=new CartDAO();
                $cartDAO->update($member->member_id, $goodscode, $num);
            }
            
        }
        else if(isset($_POST['cart_delete'])){
            $goodscode=$_POST['goodscode'];

            $cartDAO=new CartDAO();
            $cartDAO->delete($member->member_id, $goodscode);
        }
        
    }
    if(!empty($_SESSION['goodscode'])){
        $goodscode=$_SESSION['goodscode'];

        foreach($goodscode as $gc){
            $num=1;
            $cartDAO=new CartDAO();
            $cartDAO->insert($member->member_id, $gc->goods_code, $num);
        }

        unset($_SESSION['goodscode']);
    }

    $cartDAO=new CartDAO();
    $cart_list = $cartDAO->get_cart_by_memberid($member->member_id);
    $sum = 0;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/cart.css">
    <title>カート画面</title>
</head>
<body>
    <?php include "header.php";?>
    <?php if(empty($cart_list)) : ?>
        <p>カートに商品はありません</p>
    <?php else: ?>
    <h1>カート</h1>  
    <hr color="steelblue">  
    <?php foreach($cart_list as $cart) : ?>
        <table border="1">
            <tr>
                <th class="cart_name"></th>
                <th class="cart_goodsdetail">商品情報</th>
                <th class="cart_goodsprice">値段</th>
                <th class="cart_goodsbuttons">変更・削除</th>
            </tr>
            <tr>        
                <td class="cart_img">
                    <a href="goodsreview.php?goods_code=<?=$cart->goods_code ?>">
                        <p><img src="images/goods/<?=$cart->goods_image?>" width="128px"></p>
                    </a>
                </td>
                <form action="" method="POST">    
                <td class="cart_detail">
                <a href="goodsreview.php?goods_code=<?=$cart->goods_code ?>">
                    <p><?=$cart->goods_name?></p>
                </a>
                        <div class="row">
                            <div class="col-md-auto">
                                <p>数量：</p>
                            </div>
                            <div class="col-md-3">
                                <input type="number" maxlength="2" name="num" class="form-control" min="1" max="99" step="1" value="<?=$cart->number?>">
                                <span style="color:red"><?= @$errs['num'] ?></span>
                            </div>
                        </div>
                    </td> 
                    <td class="cart_price">
                        <p>\<?=number_format($cart->price)?></p>
                    </td>
                    <td class="cart_button">
                        <input type="hidden" name="goodscode" value="<?= $cart->goods_code?>">
                        <input type="submit" name="cart_change" value="変更">
                        <input type="submit" name="cart_delete" value="削除">
                    </td>
                </form> 
            </tr>
            </table>
            <?php 
                $total = $cart->price * $cart->number;
                $sum += $total;
            ?>    
    <?php endforeach?>    
            <hr color="steelblue">    
                <div class=cart_center>
                    <p>合計金額：\<?=number_format($sum)?></p>
                </div>    
            <hr color="steelblue">
            <!--<div class="cart_buttons">-->
            <div class="container text-center">
                <div class="row row-cols-2">
                    <div class="p-2 g-col-6">
                        <form action="category.php" method="POST">
                            <input type="submit" class="btn btn-secondary" name="back" value="買い物を続ける">
                        </form>
                    </div>
                    <div class="p-2 g-col-6">
                        <form action="haisousiharaisentaku.php" method="POST">
                            <input type="submit" class="btn btn-primary" name="buy" value="商品購入">
                        </form>
                    </div>
                </div>
            </div>
            <!--</div>-->
    <?php endif; ?>
    <?php include "footer.php";?>
</body>
</html>