<?php
require_once './helpers/MemberDAO.php';
require_once './helpers/CartDAO.php';
require_once './helpers/Goods_OrderDAO.php';
require_once './helpers/Order_DetailDAO.php';

session_start();

if(empty($_SESSION['member'])){
    header('Location: login.php');
    exit;
}

if (!empty($_SESSION['price'])) {
    $member = $_SESSION['member'];
    $price = $_SESSION['price'];

    if(isset($_SESSION['convinience_store'])){

       $convenience_store = $_SESSION['convinience_store'];
       $creditcard_number = 0;

    }else if(isset($_SESSION['cnumber'])){

        $creditcard_number =$_SESSION['cnumber'];
        $convenience_store = "";
    }
    
    
    $paymented = 0;
    

    $Goods_OrderDAO = new Goods_OrderDAO();

    $Goods_OrderDAO->insert($member->member_id,$price,$creditcard_number,$convenience_store,$paymented);

    $CartDAO = new CartDAO();

    $Cart_list = $CartDAO->get_cart_by_memberid($member->member_id);


    $Order_DetailDAO = new Order_DetailDAO();

    $order_id = $Order_DetailDAO->Get_order_id($member->member_id);

    foreach($Cart_list as $Cart){

        $Order_DetailDAO->insert($order_id,$Cart->goods_code,$Cart->number);

    }

    $CartDAO->delete_by_memberid($member->member_id);



    unset($_SESSION['zip_code']);
    unset($_SESSION['address']);
    unset($_SESSION['any']);
    unset($_SESSION['cnumber']);
    unset($_SESSION['cardDate']);
    unset($_SESSION['cTerm']);

    
}
else {
    header('Location: top.php');
    exit;
}


?>
<!DOCTYPE html>
<html>
    <head>
        <title>購入完了</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/kounyuukanryou.css">
</head>
<body>
    <?php include "header.php"; ?>
    <div class="kounyuukanryou_center">
        <img class="kounyuukanryou_neko" src="images/THANK YOU.jpg">
      </div>
   <p>ご注文内容はメールにてご確認お願いします</p><br>
   <p class=top><a href="top.php">トップページへ</a></p>
</form>
<?php include "footer.php"; ?>
</body>
</html>
