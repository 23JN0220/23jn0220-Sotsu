
<?php
require_once './helpers/MemberDAO.php';
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
//if (isset($_SESSION['email'])) {
  //  $email=$_SESSION['email'];
//$email = $email->email;
//}
//$_SESSION['email']=$email;
$_POST['email']=$email;
var_dump($email);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <title>new認証コード入力</title>
</head>
<body>
    <?php include "header2.php"; ?>
    <div class="container">
    <h1>new認証コード入力</h1>
    <p>セキュリティのため、認証コードをメール<?php $email ?>に送信しました。</p>
        <input type="text" size="12" class="form-control" required name="enterTheCode" maxlength="6">
        <div class="grid gap-0 row-gap-3">
            <div class="p-2 g-col-6">
                <u class=text-primary><a href="">認証コードを再送信する</a></u><br>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <input type="submit" onclick="location.href='newpassword.php'" class="btn btn-primary" value="コードを送信する">
                </div>
            </div>
        </div>
    </div>           
    <div id="test"><?php include "footer.php"; ?></div>
</body>
</html>