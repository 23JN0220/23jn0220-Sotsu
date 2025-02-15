<?php
require_once './helpers/MemberDAO.php';
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!empty($_SESSION['member'])){
    header('Location: mypage.php');
    exit;
}

if(empty($_SESSION['email'])){
    header('Location: top.php');
    exit;
}
$email=$_SESSION['email'];
//var_dump($email);
$npassword=$_SESSION['npassword'];
//var_dump($npassword);

$memberDAO=new MemberDAO();

$memberDAO->newpassword2($email, $npassword);
if(empty($_SESSION['email'])){
    header('Location: top.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/newpasswordchange.css">
    <title>パスワード変更完了</title>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="newpasschg">
        <h1>パスワード変更</h1>
        <p>パスワードの変更が完了しました。</p>
        <p>新しいパスワードでログインしてください</p>
        <a href="login.php">ログイン画面に戻る</a>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>