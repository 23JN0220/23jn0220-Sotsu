<?php
    require_once './helpers/MemberDAO.php';
    require_once './helpers/Goods_OrderDAO.php';

    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    
    if(empty($_SESSION['member'])){
        header('Location: login.php');
        exit;
    }
    
    $member=$_SESSION['member'];
    $email=$member->email;
    $member_1d=$member->member_id;

    $memberDAO = new MemberDAO();
    $orderDAO=new Goods_OrderDAO();

    $memberDAO->delete_review($member_1d);
    $memberDAO->delete_cart($member_1d);
    $memberDAO->delete_bookmark($member_1d);
    $memberDAO->delete_composition($member_1d);

    $order_id=$orderDAO->get_order_id_bymember_id($member_1d);
    foreach($order_id as $or){
        $memberDAO->delete_order($or->order_id);
    }
    
    $member=$memberDAO->delete_goods_order($member_1d);
    $member=$memberDAO->delete_member($member_1d);
    
    
    
    $_SESSION=[];
    $session_name=session_name();

    if(isset($_COOKIE[$session_name])){
        setcookie($session_name,'',time()-3600);
    }

    session_destroy();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/taikaikanryou.css">
    <title>退会完了</title>
</head>
<body>
    <?php include "header2.php"; ?>
 <div class="taikaikanryou_center">
     <h1>会員退会</h1>
        <p>退会完了</p>
        <p>ご利用ありがとうございました</p>
        <p class=top><a href="top.php">トップへ</a></p>
 </div>
    <?php include "footer.php"; ?>
</body>
</html>
