
<?php
require_once './helpers/MemberDAO.php';
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(empty($_SESSION['email'])){
    header('Location: top.php');
    exit;
}
if (isset($_SESSION['email'])) {
    $email=$_SESSION['email'];
    //var_dump($email);
}
if (isset($_SESSION['key'])) {
    $key=$_SESSION['key'];
    //var_dump($key);
    //var_dump($email);
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
$enterTheCode=$_POST['enterTheCode'];
if(empty($_SESSION['member'])){
    
}
elseif($enterTheCode==$key){
    header('Location: torokukannryou.php');
    exit;
}
elseif($enterTheCode !== $key){
    $errs['password']='認証コードに誤りがあります。';
}
if(!empty($_SESSION['member'])){
    
}
elseif($enterTheCode==$key){
    
    
    header('Location: torokukannryou.php');
    exit;
}
elseif($enterTheCode !== $key){
    $errs['password']='認証コードに誤りがあります。';
}


}

//if (isset($_SESSION['email'])) {
  //  $email=$_SESSION['email'];
//$email = $email->email;
//}
//$_SESSION['email']=$email;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <title>認証コード入力</title>
</head>
<body>
    <?php include "header2.php"; ?>
    <div class="container">
    <h1>認証コード入力</h1>
    <p>セキュリティのため、認証コードを<?= $email ?>に送信しました。</p>
    <form action="" method="POST">
        <input type="text" size="12" class="form-control" required name="enterTheCode" maxlength="6">
        <?=@$errs['password'] ?>
        <div class="grid gap-0 row-gap-3">
            <div class="p-2 g-col-6">
           
                <u class=text-primary><a href="emailtouroku.php">認証コードを再送信する</a></u><br>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <input type="submit"  class="btn btn-primary" value="コードを送信する">
                </div>
            </div>
        </div>
    </form>
    </div>           
    <div id="test"><?php include "footer.php"; ?></div>
</body>
</html>