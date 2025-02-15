<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    if (empty($_SESSION['member'])) {
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
    <link rel="stylesheet" href="css/logout.css">
    <title>ログアウト</title>
</head>
<body>
<?php include "header2.php"; ?>
    <div class="logout_center">
        <h1>ログアウトしますか？</h1>
        <input type="submit" onclick="location.href='top.php'" class="btn btn-primary" value="キャンセル">
        <input type="submit" onclick="location.href='logoutprocess.php'" class="btn btn-primary" value="ログアウト">
    </div>
</div>   
<?php include "footer.php"; ?>
</body>
</html>
