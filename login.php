<?php
    require_once './helpers/MemberDAO.php';
    $email='';
    $errs_m = NULL;
    $errs_p=NULL;

    session_start();

    if(!empty($_SESSION['member'])){
        header('Location: top.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email=$_POST['userEmail'];
        $password=$_POST['userPassword'];


        if($email === ''){
            $errs_m='メールアドレスを入力して下さい。';
        }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errs_m='メールアドレスの形式に誤りがあります。';
        }
        
        if($password === ''){
            $errs_p='パスワードを入力して下さい。';
        }

        if(empty($errs_m) and empty($errs_p)){
            $memberDAO = new MemberDAO();
            $member=$memberDAO->get_member($email, $password);

            if($member !== false){
                session_regenerate_id(true);
                $_SESSION['member']=$member;
                header('Location: top.php');
                exit;
            }
            else{
                $errs_p='メールアドレスまたはパスワードに誤りがあります。';
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
    <title>ログイン</title>
</head>
<body>
<?php include "header2.php"; ?>
    <div class="container">
    <h1>ログイン</h1>
    <form action="" method="POST">
        <p>メールアドレス</p>
        <input type="email" class="form-control" required autofocus name="userEmail"><br>
        <span style="color:red"><?= $errs_m ?></span><br>
        <p>パスワード</p>
        <input type="password" class="form-control" required name="userPassword"><br>
        <span style="color:red"><?= $errs_p ?></span><br>
        <input type="submit" class="btn btn-primary" name="login" value="ログイン" ><br>
    </form>
        <a class="link-opacity-100" href="codeemail.php">パスワードを忘れた場合</a>
        <h1>新規会員登録</h1>
        <input type="submit" class="btn btn-primary" onclick="location.href='touroku.php'" value="アカウントを作成する">
    </div>
</body>
</html>
