<?php
    require_once './helpers/MemberDAO.php';
    $errs=NULL;

    session_start();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email=$_POST['userEmail'];
        $password=$_POST['userPassword'];
        $password2=$_POST['userPassword2'];
        $username=$_POST['userName'];
        $zipcode=$_POST['userPostcode'];
        $address=$_POST['userAddress'];
        $tel1=$_POST['tel1'];
        $tel2=$_POST['tel2'];
        $tel3=$_POST['tel3'];
        $cnumber=$_POST['cardNumber'];
        $cMonth=$_POST['cTermMonth'];
        $cYear=$_POST['cTermYear'];

        $memberDAO=new MemberDAO();

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errs['email']='メールアドレスの形式が正しくありません。';
        }
        elseif($memberDAO->email_exists($email) === true){
            $errs['email']='このメールアドレスはすでに登録されてます。';
        }

        if(!preg_match('/\A[a-zA-Z0-9]{8,}\z/',$password)){
            $errs['password']='パスワードは8文字以上の半角英数字で入力してください。';
        }
        elseif($password !== $password2){
            $errs['password']='パスワードが一致しません。';
        }

        if($username === ''){
            $errs['username']='お名前を入力してください。';
        }

        if(!preg_match('/\A.{7,7}\z/',$zipcode)){
            $errs['zipcode']='郵便番号は半角数字7桁で入力してください。';
        }elseif(!preg_match('/^[0-9]+$/',$zipcode)) {
            $errs['zipcode']='郵便番号は半角数字で入力してください。';
        }

        if($address === ''){
            $errs['address']='住所を入力してください。';
        }

        if(!empty($tel1) or !empty($tel2) or !empty($tel3)) {
            if (empty($tel1) or empty($tel2) or empty($tel3)) {
                $errs['tel']='入力してください';
            }
            elseif(!preg_match('/\A(\d{2,5})?\z/',$tel1) ||
            !preg_match('/\A(\d{1,4})?\z/',$tel2) ||
            !preg_match('/\A(\d{4})?\z/',$tel3)) {
                $errs['tel']='電話番号は半角数字2~5桁、1~4桁、4桁で入力してください。';
            }

            }        

        if(!preg_match('/\A(\d{14,16})?\z/',$cnumber)){
            $errs['cardNumber']='半角数字で14～16桁入力してください';
        }

        if(empty($errs)){
            $_SESSION['email']=$email;
            $_SESSION['password']=$password;
            $_SESSION['username']=$username;
            $_SESSION['zipcode']=$zipcode;
            $_SESSION['address']=$address;
            $_SESSION['tel1']=$tel1;
            $_SESSION['tel2']=$tel2;
            $_SESSION['tel3']=$tel3;
            $_SESSION['cnumber']=$cnumber;
            $_SESSION['cMonth']=$cMonth;
            $_SESSION['cYear']=$cYear;

            header('Location: tourokukakunin.php');
            exit;
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/touroku.css">
    <title>会員登録</title>
    <script src="./jquery-3.6.0.min.js"></script>
</head>
<body>
<?php include "header2.php"; ?>
    <div class="container">
        <h1>会員登録</h1>
        <p>以下の項目を入力し、確認ボタンをクリックしてください。(*は必須)</p>
        <div class="touroku_label">
            <form action="touroku.php" method="POST">
                <button type="submit" disabled style="display: none;"></button>
                <label>メールアドレス * </label>
                <input type="email"class="form-control" required autofocus name="userEmail"><br>
                <span style="color:red"><?= @$errs['email'] ?></span><br>

                <label>パスワード(8文字以上) * </label>
                <input type="password" class="form-control" required name="userPassword"><br>
                <span style="color:red"><?=@$errs['password'] ?></span><br>

                <label>パスワード(再入力)* </label>
                <input type="password" class="form-control" required name="userPassword2"><br>

                <label>お名前 * </label>
                <input type="text" class="form-control" required name="userName">
                <span style="color:red"><?=@$errs['username'] ?></span><br>

                <label id="label1">郵便番号(ハイフンなし) * </label>
                <input type="text" id="number" class="form-control" required name="userPostcode">
                <span style="color:red"><?=@$errs['zipcode'] ?></span><br>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <input type="button" class="btn btn-primary" id="load" value="住所検索"><br>
                </div>
                <label>住所 * </label>
                <input type="text" class="form-control" id=from required name="userAddress">
                <span style="color:red"><?=@$errs['address'] ?></span><br>
                <label>電話番号 </label>
                <div class="row">
                    <div class="col"> 
                        <input type="tel" class="form-control"  name="tel1"> 
                    </div>
                    <div class="col-md-auto">
                        ー
                    </div>
                    <div class="col">
                        <input type="tel" class="form-control"  name="tel2"> 
                    </div>
                    <div class="col-md-auto">
                        ー
                    </div>
                    <div class="col">
                        <input type="tel" class="form-control"  name="tel3">
                        <span style="color:red"><?=@$errs['tel'] ?></span><br>
                    </div>
                </div>

            <label class="credit-card">クレジットカード</label><br>
            <label>カード番号</label>
            <input type="text" class="form-control" minlength="14"maxlength="16" name="cardNumber"><br>
            <span style="color:red"><?=@$errs['cardNumber'] ?></span><br>
            <div class="row">
                <label>有効期限</label>
                    <div class="w-25 p-3">
                        <select class="form-select" aria-label="Default select example" name="cTermMonth">
                            <option value="1" selected="selected">01</option>
                            <option value="2">02</option>
                            <option value="3">03</option>
                            <option value="4">04</option>
                            <option value="5">05</option>
                            <option value="6">06</option>
                            <option value="7">07</option>
                            <option value="8">08</option>
                            <option value="9">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                <div class="w-25 p-3">
                    <select class="form-select" aria-label="Default select example" name="cTermYear">
                        <option value="2025" selected="selected">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                    </select>
                </div>
            </div>
            <button class="btn1"><div id="test">登録</button>
            </div>
        </div>
    </div>
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