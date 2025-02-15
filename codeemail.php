<?php
    require_once './helpers/MemberDAO.php';
    $errs=NULL;
    session_start();
    $memberDAO=new MemberDAO();

    if(!empty($_SESSION['member'])){
        header('Location: mypage.php');
        exit;
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email=$_POST['userEmail'];

        //if($_SESSION['email']=null){
            //$errs['email']='メールアドレスが空白です';
        //};
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errs['email']='メールアドレスの形式が正しくありません。';
        }
        if($memberDAO->email_exists($email) === false){
            $errs['email']='このメールアドレスは登録されていません。';
        }
        if(empty($email)){
            $errs['email']='メールアドレスを入力してください';
        }

        if(empty($errs)){
            $_SESSION['email']=$email;
            //var_dump($email);
          
            header('Location: email.php');
            exit;
        }
        //$_SESSION['email']=null;
    }
    

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/code.css">
    <title>メール入力</title>
</head>
<body>
<?php include "header.php"; ?>
<div class=code_center>
    <h1>アカウントに関連付けられているEメールアドレスを入力してください</h1>
    <form action="codeemail.php" method="POST">
        <label>メールアドレス * </label>
        <input type="email" class="m"  autofocus name="userEmail"><br>
        <span style="color:red"><?= @$errs['email'] ?></span><br>
    <input type="submit" class="btn_code" value="コードを送信する" > 
   </form>
    <?php include "footer.php"; ?>
</body>
</html>