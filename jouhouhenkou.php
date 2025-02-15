<?php
require_once './helpers/MemberDAO.php';

$errs=NULL;

if(session_status() === PHP_SESSION_NONE){
    session_start();
}
if(empty($_SESSION['member'])){
    header('Location: top.php');
    exit;
}
if(isset($_POST['back'])) {
    header('Location: mypage.php');
    exit;
}

if(!empty($_SESSION['member'])){
    $member=$_SESSION['member'];

    $email=$member->email;
    $password=$member->password;
    $username=$member->member_name;
    $zipcode=$member->zip_code;
    $address=$member->address;
    $tel=$member->tel;
    $cnumber=$member->credit_card;
    $cDate=$member->credit_expiration_date;
    $card_date = $member->credit_expiration_date;

    $card_date_str =strval($card_date);

    if(strlen($card_date_str) == 5) {
        $card_date_m = substr($card_date_str,0,1);
        $card_date_y = substr($card_date_str,1);
    }
    else {
        $card_date_m = substr($card_date_str,0,2);
        $card_date_y = substr($card_date_str,2);
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email=$_POST['userEmail'];
        $newpassword=$_POST['newpassword'];
        $newpassword2=$_POST['newpassword2'];
        $username=$_POST['userName'];
        $zipcode=$_POST['userPostcode'];
        $address=$_POST['userAddress'];
        $tel=$_POST['tel'];
        $cnumber=$_POST['cnumber'];
        $cDate = $_POST['cTermMonth'].$_POST["cTermYear"];

        $memberDAO=new MemberDAO();

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errs['email']='メールアドレスの形式が正しくありません。';
        }

        if($newpassword !==''){
            if(!preg_match('/\A[a-zA-Z0-9]{8,}\z/',$newpassword)){
                $errs['password']='パスワードは半角英数字8文字以上で入力してください。';
            }
            elseif($newpassword !== $newpassword2){
                $errs['password']='パスワードが一致しません。';
            }
        }

        if($username == ''){
            $errs['username']='お名前を入力してください。';
        }

        if(!preg_match('/\A.{7,}\z/',$zipcode)){
            $errs['zipcode']='郵便番号は7桁で入力してください。';
        }

        if($address == ''){
            $errs['address']='住所を入力してください。';
        }

        


        if(empty($errs)){
            $member->member_id=$member->member_id;
            $member->email=$email;
            $member->password=$newpassword;
            $member->member_name=$username;
            $member->zip_code=$zipcode;
            $member->address=$address;
            $member->tel=$tel;
            $member->credit_card=intval($cnumber);
            $member->credit_expiration_date=$cDate;
            $_SESSION['member']=$member;
            $_SESSION['email']=$email;

            header('Location: email.php');
            exit;
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
        <link rel="stylesheet" href="css/jouhouhenkou.css">
    <title>会員情報変更</title>
    <script src="./jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="container">
        <h1>会員情報変更</h1>
            <p>情報を変更し、変更ボタンをクリックしてください。(*は必須)</p>
            <form action="jouhouhenkou.php" method="POST">
                <button type="submit" disabled style="display: none;"></button>
                <label>メールアドレス * </label><input type="email" class="form-control" required autofocus name="userEmail" value=<?= $email ?>><br>
                <span style="color:red"><?=@$errs['email'] ?></span><br>
                <label>新パスワード(8文字以上) </label><input type="password" class="form-control" autofocus name="newpassword" ><br>
                <span style="color:red"><?=@$errs['password'] ?></span><br>
                <label>新パスワード(再確認) </label><input type="password" class="form-control" autofocus name="newpassword2" ><br>
                <label>お名前 * </label><input type="text" class="form-control" required name="userName" value=<?= $username ?>><br>
                <span style="color:red"><?=@$errs['membername'] ?></span><br>
                <label>郵便番号 * </label>
                <input type="text" class="form-control" id="number" required name="userPostcode" value=<?= $zipcode ?>>
                <span style="color:red"><?=@$errs['zipcode'] ?></span><br>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <input type="button" class="btn btn-primary" id="load" value="住所検索"><br>
                    </div>
                <label>住所 * </label>
                <input type="text" class="form-control" id=from required name="userAddress" value=<?= $address ?>><br>
                <label>電話番号 </label>
            <div class="row">
                <div class="col">
                    <input type="tel" class="form-control" name="tel" <?php if($tel!==''){ ?> value=<?= $tel ?><?php } ?>><br>
                 </div>
            </div>
                <label class="credit-card">クレジットカード</label><br>
                <label>カード番号</label>
                    <input type="text" class="form-control" minlength="14"maxlength="16" name="cnumber" value=<?php if ($cnumber != 0 ) { echo $cnumber; }?>><br>
            <div class="row">
                <label class="jouhouhenkou_label">有効期限</label>
                <div class="w-25 p-3">
                        <select class="form-select" aria-label="Default select example" name="cTermMonth">
                            <option value="1"<?php if ($card_date_m === '1' ) { echo ' selected'; }?>>01</option>
                            <option value="2"<?php if ($card_date_m === '2' ) { echo ' selected'; }?>>02</option>
                            <option value="3"<?php if ($card_date_m === '3' ) { echo ' selected'; }?>>03</option>
                            <option value="4"<?php if ($card_date_m === '4' ) { echo ' selected'; }?>>04</option>
                            <option value="5"<?php if ($card_date_m === '5' ) { echo ' selected'; }?>>05</option>
                            <option value="6"<?php if ($card_date_m === '6' ) { echo ' selected'; }?>>06</option>
                            <option value="7"<?php if ($card_date_m === '7' ) { echo ' selected'; }?>>07</option>
                            <option value="8"<?php if ($card_date_m === '8' ) { echo ' selected'; }?>>08</option>
                            <option value="9"<?php if ($card_date_m === '9' ) { echo ' selected'; }?>>09</option>
                            <option value="10"<?php if ($card_date_m === '10' ) { echo ' selected'; }?>>10</option>
                            <option value="11"<?php if ($card_date_m === '11' ) { echo ' selected'; }?>>11</option>
                            <option value="12"<?php if ($card_date_m === '12' ) { echo ' selected'; }?>>12</option>
                        </select>
                    </div>
                <div class="w-25 p-3">
                    <select class="form-select" aria-label="Default select example" name="cTermYear">
                        <option value="2025"<?php if ($card_date_y === '2025' ) { echo ' selected'; } ?>>2025</option>
                        <option value="2026"<?php if ($card_date_y === '2026' ) { echo ' selected'; } ?>>2026</option>
                        <option value="2027"<?php if ($card_date_y === '2027' ) { echo ' selected'; } ?>>2027</option>
                        <option value="2028"<?php if ($card_date_y === '2028' ) { echo ' selected'; } ?>>2028</option>
                        <option value="2029"<?php if ($card_date_y === '2029' ) { echo ' selected'; } ?>>2029</option>
                        <option value="2030"<?php if ($card_date_y === '2030' ) { echo ' selected'; } ?>>2030</option>
                        <option value="2031"<?php if ($card_date_y === '2031' ) { echo ' selected'; } ?>>2031</option>
                    </select><br>
            </div>
            <div class="grid gap-0 column-gap-3">
                <button  class="p-2 g-col-6" id=btn1 name="back" >変更せずに戻る</button>
                <button  class="p-2 g-col-6" id=btn2 name="change">次へ進む</button>
                
            </div>
        </div>
    </div>
</div class="jouhouhenkou_center">
</form>
<script>
        $(function () {
            $('#load').click(function(){
                $('#from').load("zipcodeSerch.php",
                {
                    userPostcode: $('#number').val()
                },
                function(result){
                    $('#from').val(result);
                }
                );
            });
        });
    </script>
<?php include "footer.php"; ?>
</body>
</html>