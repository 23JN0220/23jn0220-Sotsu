<?php
    require_once './helpers/MemberDAO.php';

    session_start();

    if(empty($_SESSION['member'])){
        header('Location: login.php');
        exit;
    }
    $member = $_SESSION['member'];
    //var_dump($err);
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        //支払が押されていたら
        if(isset($_POST['payment'])) {

            //POSTの値を変数paymentに代入
            $payment = $_POST['payment'];

            //変数paymentがccPaymentだったら
            if($payment === "ccPayment"){

                //次へ進むをクリック
                if(isset($_POST['next'])){

                    //郵便番号が空白じゃなかったら
                    if($_POST['zip_code'] !== ""){

                        if(preg_match('/\A.{7,7}\z/',$_POST['zip_code'])){


                            

                            if(preg_match('/\A[0-9]+$/',$_POST['zip_code'])){

                                
                                //郵便番号をセッション変数に代入
                                $_SESSION['zip_code'] = $_POST['zip_code'];

                            }else{

                                $err['zip_code']='郵便番号は数字で入力してください。';

                            }
                            

                        }else{

                            $err['zip_code']='郵便番号は7桁で入力してください。';
                            
                        }
        
                    }else{

                        //そうじゃなければエラー文を表示
                        $err['zip_code'] = "郵便番号を入力してください";

                    }

                    if($_POST['address'] !== ""){

                        if(!preg_match('/[a-zA-Z]/',$_POST['address'])){

                            if(!preg_match('/[0-9]/',$_POST['address'])){
        
                            $_SESSION['address'] = $_POST['address'];

                            }else{

                                $err['address'] = '住所は数字を使用しないでください';

                            }

                        }
                        else{

                            $err['address'] = '住所に英字を使用しないでください';

                        }
        
                    }else {

                        
                        $err['address'] = '住所を入力してください';
                    }
        
                    if(isset($_POST['any'])){
        
                        $_SESSION['any'] = $_POST['any'];

                    }
                    
                    if (empty($err)) {
                    header('Location: kurezittosiharai.php');
                    exit;
                    }

                }else{
                    header('Location: cart.php');
                }

                
                
            }
            else if($payment === "csPayment" ){
                
                if(isset($_POST['next'])){

                    if(($_POST['zip_code']) !== ""){
                        
                        if(preg_match('/\A.{7,7}\z/',$_POST['zip_code'])){
                            
                            

                            if(preg_match('/\A[0-9]+$/',$_POST['zip_code'])){
                                
                            $_SESSION['zip_code'] = $_POST['zip_code'];

                            }else{
                                $err['zip_code']='郵便番号は数字で入力してください。';
                                
                            }
                        
                        }else{

                        $err['zip_code']='郵便番号は7桁で入力してください。';
                        

                        }
                    
                    
                    }else{

                        $err['zip_code'] = '郵便番号を入力してください';
                    
                    }
                    
                    if(($_POST['address']) !== ""){
                            
                        if(!preg_match('/[a-zA-Z]/',$_POST['address'])){
                            
                            if(!preg_match('/[0-9]/',$_POST['address'])){
                                
                                $_SESSION['address'] = $_POST['address'];

                            }else{
                                $err['address'] = '住所は数字を使用しないでください';
                            }
                        }else{
                            $err['address'] = '住所に英字を使用しないでください';
                        }
                    
                    }else{

                        $err['address'] = '住所を入力してください';
        
                    }
        
                    if(isset($_POST['any'])){
        
                        $_SESSION['any'] = $_POST['any'];
                           
                    }

                       if (empty($err)) {
                        header('Location: konbinisiharai.php');
                        exit;
                    } 
                    
                }else{
                    header('Location: cart.php');
                }
                
                

                

            }
            
        }
        else if(isset($_POST['next'])) {
            $errs['payment'] = 'コンビニ支払いかクレジット支払いを選択してください。';
        }
        else if(isset($_POST['back'])) {
            header('Location: cart.php');
            exit;
        }


        $zip_code = $member->zip_code;
        $address = $member->address;
         
    }
       
        
    
        if(isset($_SESSION['any'])){

            $any = $_SESSION['any'];

        }else{
            $any = "";
        }

        if(isset($_SESSION['zip_code'])){
            $zip_code = $_SESSION['zip_code'];

        }else{
            $zip_code = $member->zip_code;

        }

        if(isset($_SESSION['address'])){

            $address = $_SESSION['address'];

        }
        else {
            $address = $member->address;
        }
    
        /*if(isset($_SESSION['back2'])){
            $zip_code = $_SESSION['zip_code'];
            $address = $_SESSION['address'];
            var_dump($_SESSION['zip_code']);
            var_dump($_SESSION['address']);
            
            if(isset($_SESSION['any'])){

                $any = $_SESSION['any'];
    
            }else{
                $any = "";
            }
            
        }
        else if(isset($_SESSION['back3'])){
            $zip_code = $_SESSION['zip_code'];
            var_dump($_SESSION['zip_code']);
            $address = $_SESSION['address'];
            var_dump($_SESSION['address']);
        }elseif(isset($_SESSION['back4'])){

            $zip_code = $_SESSION['zip_code'];
            var_dump($_SESSION['zip_code']);
            $address = $_SESSION['address'];
            var_dump($_SESSION['address']);
            

        }else{
            $zip_code = $member->zip_code;
            $address = $member->address;

            if(isset($_SESSION['any'])){

                $any = $_SESSION['any'];
    
            }else{
                $any = "";
            }
            
        }*/
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>配送先支払いへ</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/haisousiharaisentaku.css">
        <script src="./jquery-3.6.0.min.js"></script>
    </head>
<body>
    <?php include "header.php"; ?>
        <div class=continer>
            <div class="haisousentaku_center">
                <h1>配送先入力</h1>
                <form action="" method="POST">
                        <div class="mb-3 row">
                            <div class="col-sm-10">
                                <p class="font">
                                    <div class="row">
                                        <div class="col-md-auto">
                                            <p>郵便番号(ハイフンなし)</p>
                                        </div>
                                        <div class="col-md-15">
                                            <input type="textbox" id="number" class="form-control" name="zip_code" value="<?= $zip_code ?>" maxlength="7">
                                            <span style="color:red"><?= @$err['zip_code'] ?></span><br>
                                        </div>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <input type="button" class="btn btn-primary" id="load" value="住所検索" name="addressSearch"><br>
                                        </div>
                                        <div class="col-md-auto">
                                            <p>市区町村 番地</p>
                                        </div>
                                        <div class="col-md-15">
                                            <input type="textbox" id="address" class="form-control" name="address" value="<?= $address ?>"><br>
                                            <span style="color:red"><?= @$err['address'] ?></span><br>
                                        </div>
                                        <div class="col-md-auto">
                                            <p>建物名 部屋番号（任意）</p>
                                        </div>
                                        <div class="col-md-15">
                                            <input type="textbox" class="form-control" name="any" value="<?= $any?>">
                                        </div>
                                    </div>
                                </p>
                            </div>
                        </div>
                    <h1>支払い方法</h1>
                        <div>
                            <input type="radio" name="payment" value="ccPayment"><label>クレジット支払いへ</label>
                            <input type="radio" name="payment" value="csPayment"><label>コンビニ支払いへ</label><br>
                            <span style="color:red"><?=@$errs['payment'] ?></span><br>
                        </div>
                    <div class="container text-center">
                        <div class="row row-cols-2">
                            <p class="bacgo">
                                <input type="submit" class="btn btn-secondary" name="back" value="戻る">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-primary" name="next" value="次へ進む">
                            </div>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <script>
        $(function () {
            $('#load').click(function(){
                $('#address').load("zipcodeSerch.php",
                {
                    userPostcode: $('#number').val()
                },
                function(result){
                    
                    if(result !== null){

                    $('#address').val(result);

                    }
                    
                }
                );
            });
        });
    </script>
    <?php include "footer.php"; ?>
</body>
</html>
