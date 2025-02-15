<?php
require_once './helpers/MemberDAO.php';

if(session_status() === PHP_SESSION_NONE){
    session_start();
}
if (isset($_SESSION['email'])) {
    $email=$_SESSION['email'];
    $password=$_SESSION['password'];
    $username=$_SESSION['username'];
    $zipcode=$_SESSION['zipcode'];
    $address=$_SESSION['address'];
    $tel1=$_SESSION['tel1'];
    $tel2=$_SESSION['tel2'];
    $tel3=$_SESSION['tel3'];
    $cnumber=$_SESSION['cnumber'];
    $cMonth=$_SESSION['cMonth'];
    $cYear=$_SESSION['cYear'];

    $memberDAO=new MemberDAO();
    $member=new Member();
    $member->email      =$email;
    $member->password   =$password;
    $member->member_name =$username;
    $member->zip_code    =$zipcode;
    $member->address    =$address;

    $member->tel='';
    if($tel1!=='' && $tel2!=='' && $tel3!==''){
        $member->tel="{$tel1}-{$tel2}-{$tel3}";
    }
    $member->credit_card='0';
    if($cnumber!==''){
        $member->credit_card=$cnumber;
    } 

    $member->credit_expiration_date='0';
    if($cMonth!=='' && $cYear!==''){
        $member->credit_expiration_date="{$cMonth}{$cYear}";
    }

    $memberDAO->insert($member);
}
else
{
    header('Location: top.php');
    exit;
}
    

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/torokukannryou.css">
    <title>登録完了</title>
</head>
<body>
    <?php include "header2.php"; ?>
        <h1 class="toukan_h1">会員登録完了</h1>
            <div class="toukan_massage">        
                <p>登録が完了しました。</p>
            </div>
            <div class="toukan_link">    
                <p><a href="login.php">ログイン画面へ</a></p>
        </div>
    <?php include "footer.php"; ?>           
</body>
</html>