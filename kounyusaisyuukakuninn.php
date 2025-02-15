<?php
    require_once './helpers/MemberDAO.php';
    require_once './helpers/CartDAO.php';

    session_start();

    if(empty($_SESSION['member'])){
        header('Location: login.php');
        exit;
    }

    $member = $_SESSION['member'];

    if (isset($_SESSION['zip_code']) and isset($_SESSION['address']) and isset($_SESSION['any'])) {
        $zip_code = $_SESSION['zip_code'];
        $address = $_SESSION['address'];
        $any = $_SESSION['any'];
    }
    else {
        header('Location: cart.php');
        exit;
    }

    


    if(isset($_SESSION['konbini'])){

        $konbini = $_SESSION['konbini'];

    }else{
        $konbini = NULL;
    }
    
    if(isset($_SESSION['credit_card'])){

        
        $credit_card = $_SESSION['credit_card'];
        

    }
    
    
    

    $tel = $member->tel;

    $cartDAO=new CartDAO();
    $cart_list = $cartDAO->get_cart_by_memberid($member->member_id);

    $price = 0;
    $number_total = 0;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
        

        if(isset($_POST['next2'])){


            $_SESSION['member'] = $member;
            $_SESSION['price'] = $_POST['price'];
            $_SESSION['convinience_store'] = $_POST['konbini'];
            header('Location: emailcyumon.php');
            exit;
        }
        else if (isset($_POST['back3'])){
            unset($_SESSION['konbini']);
            $_SESSION['any'] = $any;
            $_SESSION['zip_code'] = $zip_code;
            $_SESSION['address'] = $address;
            header('Location: haisousiharaisentaku.php');
            exit;
        }


    }

    $postage = 360;


?>
<!DOCTYPE html>
<html>
    <head>
        <title>購入最終確認</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
        <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/kounyusaisyuukakuninn.css">  
</head>
<body>
    <?php include "header.php"; ?>
    <form action="" method="POST">
        <div class=continer>
            <div class="kounyusaisyuukakuninn_center">
                <h1>注文内容の確認</h1>
                    <div>
                        <table border="1">
                            <?php foreach($cart_list as $cart) : ?>
                                <tr>
                                    <td>
                                        <img src="images/goods/<?= $cart->goods_image?>" width="128px">
                                    </td>
                                    <td style="width: 500px;">
                                        <?= $cart->goods_name?>
                                    </td>
                                    <td style="width: 100px;">
                                        数量 : <?= $cart->number?>
                                    </td>
                                    <td style="width: 80px;">
                                        \<?=number_format($cart->price)?>     
                                    </td>
                                </tr>
                                    <?php
                                        $number_total += $cart->number;
                                        $total = $cart->price * $cart->number;
                                        $price += $total;
                                    ?>
                            <?php endforeach ?>
                        </table>
                    </div class="d-flex justify-content-center">
                        商品合計:<?= $number_total?>個<br>
                        送料 : \<?= number_format($postage)?><br>
                        合計 : \<?= number_format($price += $postage) ?><br>
                        <h1>お届け先</h1>
                        <p class="text-center">
                            お名前 : <?= $member->member_name?>様<br>
                        </p>
                        <p class="text-center">
                            住所 : <?= $zip_code ?> <?= $address?> <?php if ($any !== NULL) { echo($any); } ?><br>
                        </p>
                            電話番号 : <?= $tel ?><br>
                        <h2>支払い方法</h2>
                        <h3><?php if(!isset($konbini)){echo $credit_card;}else{echo($konbini);}?></h3>
                    <input type="hidden" name="price" value="<?=$price?>">
                    <input type="hidden" name="konbini" value="<?=$konbini?>">
                    <input type="submit" class="btn btn-primary" name="back3" value="戻る">
                    <input type="submit" class="btn btn-primary" name="next2" value="注文内容購入">
                </div>
            </div>
        </form>
    <?php include "footer.php"; ?>
</body>
</html>

