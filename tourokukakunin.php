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
    <link rel="stylesheet" href="css/tourokukakunin.css">
    <title>会員登録確認</title>
</head>
<body>
    <?php include "header2.php"; ?>
    <div class="container">
    <h1>登録確認</h1>
    <p>以下の内容で登録してもよろしいですか？</p>
        <label>メールアドレス * </label><input type="email" class="form-control" required autofocus name="userEmail" readonly value=<?= $email ?>><br>
        <label>パスワード(8文字以上) * </label><input type="password" class="form-control" required autofocus name="userEmail" readonly value=<?= $password ?>><br>
        <label>お名前 * </label><input type="text" class="form-control" required name="userName" readonly  value=<?= $username ?>><br>
        <label>郵便番号 * </label><input type="text" class="form-control" required name="userPostcode" readonly value=<?= $zipcode ?>><br>
        <label>住所 * </label><input type="text" class="form-control" required name="userAddress" readonly value=<?= $address ?>><br>
        <label>電話番号 </label>
        <div class="row">
            <div class="col">
                <input type="tel" class="form-control" name="tel1" size="4" readonly <?php
                 if($tel1!==''){ ?>
                    value=<?= $tel1 ?>
                 <?php } ?>>
            </div>
            <div class="col-md-auto">
             ー
            </div>
            <div class="col">
                <input type="tel" class="form-control" name="tel2" size="4" readonly <?php
                 if($tel2!==''){ ?>
                    value=<?= $tel2 ?>
                 <?php } ?>>
            </div>
            <div class="col-md-auto">
            ー
            </div>
            <div class="col">
                <input type="tel" class="form-control" name="tel3" size="4" readonly<?php
                 if($tel3!==''){ ?>
                    value=<?= $tel3 ?>
                 <?php } ?>><br>
            </div>
        </div>
        <label class="credit-card">クレジットカード</label><br>
        <label>カード番号 </label><input type="text" class="form-control" minlength="14"maxlength="16" name="card number" readonly <?php
                 if($cnumber!==''){ ?>
                    value=<?= $cnumber ?>
                 <?php } ?>><br> 
        
        <label>有効期限 </label><br>
        <div class="row">
            <div class="w-25 p-3">
                <input type="text" class="form-control" minlength="14"maxlength="16" name="cMonth" readonly <?php
                    if($cnumber!==''){ ?>
                        value=<?= $cMonth ?>
                    <?php } ?>>
            </div>
            <div class="w-25 p-3">
                <input type="text" class="form-control" minlength="14"maxlength="16" name="cYear" readonly <?php
                    if($cnumber!==''){ ?>
                        value=<?= $cYear ?>
                    <?php } ?>><br>
            </div>
        </div>
        <button id="btn1" class="margin-left" onclick="location.href='touroku.php'">戻る</button>
        <button id="btn2" class="margin-right" onclick="location.href='emailtouroku.php'">確認</button>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>