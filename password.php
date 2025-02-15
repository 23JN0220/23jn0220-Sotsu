<?php
    require_once './helpers/MemberDAO.php';
    $errs=NULL;

    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    
    if(empty($_SESSION['member'])){
        header('Location: login.php');
        exit;
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $member=$_SESSION['member'];
        $email=$member->email;
        $password=$_POST['password'];
        
        if($password === ''){
            $errs='パスワードを入力して下さい。';
        }

        if(empty($errs)){
            $memberDAO = new MemberDAO();
            $member=$memberDAO->get_member($email, $password);

            if($member !== false){
                session_regenerate_id(true);
                $_SESSION['member']=$member;
                header('Location: taikaikanryou.php');
                exit;
            }
            else{
                $errs='パスワードに誤りがあります。';
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <title>パスワード入力</title>
</head>
<body>
    <?php include "header2.php"; ?>
    <div class="container">
        <h1>パスワード入力</h1>
        <p>パスワードを入力してください</p>
        <form action="" method="POST">
            <input type="password" class="form-control" name="password"><br>
            <span style="color:red"><?= $errs ?></span><br>
            <input type="submit"  class="btn btn-primary" value="OK"><br>
        </form>
        <p>※パスワードを忘れた方は戻って「会員情報変更」から新しいパスワードを設定してください</p>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>