<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(empty($_SESSION['member'])){
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/taikai.css">
    <title>情報変更完了</title>
</head>
<body>
    <?php include "header2.php"; ?>
<div class="taikai_center">
    <h1>会員退会</h1>
        <p>退会手続きを実行します</p>
    <div class="taikai_marigin">
      <input id="no" type="button" onclick="location.href='mypage.php'" class="btn btn-secondary" name="no" value="退会しない">
      <input type="button" onclick="location.href='password.php'" class="btn btn-primary" name="yes" value="退会する">
    </div>
</div>  
    <?php include "footer.php"; ?>
</body>
</html>
