
<?php
require_once './helpers/MemberDAO.php';
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!empty($_SESSION['member'])){
    header('Location: mypage.php');
    exit;
}

$email=$_SESSION['email'];
if(empty($_SESSION['email'])){
    header('Location: top.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $npassword=$_POST['npassword'];
    $cpassword=$_POST['cpassword'];
    if (empty($npassword or $cpassword)){
        $errs['password']='パスワードを入力してください';
    }
    elseif(!preg_match('/\A[a-zA-Z0-9]{8,}\z/',$npassword)){
        $errs['password']='パスワードは半角英数字8文字以上で入力してください。';
    }
    elseif ($npassword !== $cpassword) {
        $errs['password']='パスワードが一致していません';
    }
    elseif ($npassword === $cpassword){
        $_SESSION['email']=$email;
        $_SESSION['npassword']=$npassword;
        header('Location: newpasswordchange.php');
    }

}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <title>新パスワード入力</title>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="container">
    <h1>パスワードの再設定</h1>
            <p>次回ログインから利用するパスワードを設定してください。</p>
            <p>新しいパスワード</p>
    <form action="" method="POST">
            <input type="password" class="form-control"  name="npassword"><br>
            <p>※パスワードは８文字以上で入力してください</p><br>
            <p>もう一度パスワードを入力してください</p>
            <input type="password" class="form-control"  name="cpassword"><br>
        <input type="submit" class="btn btn-primary" name="update" value="変更内容を保存">
        <span style="color:red"><?=@$errs['password'] ?></span><br>
    </fotm>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>





    