<?php
    
    require_once './helpers/MemberDAO.php';
    
    session_start();
    
    if(empty($_SESSION['member'])){
        
        header('Location: login.php');
        exit;
        
    }
        
    $member = $_SESSION['member'];

    if (isset($_SESSION['cardDate'])){

        $card_number = $_SESSION['cnumber'];
        $card_date = $_SESSION['cardDate'];
        
    } else {
        $card_number = $member->credit_card;
        $card_date = $member->credit_expiration_date;
    }

    if (isset($card_date)) {
        $card_date_str =strval($card_date);

        if(strlen($card_date_str) == 5) {
            $card_date_m = substr($card_date_str,0,1);
            $card_date_y = substr($card_date_str,1);
        }
        else {
            $card_date_m = substr($card_date_str,0,2);
            $card_date_y = substr($card_date_str,2);
        }
    }

    if(isset($_SESSION['cTerm'])){

        $cTerm = $_SESSION['cTerm'];

    }else{

        $cTerm = "";

    }
    

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        

        if($_POST['card_number'] !== ""){
            
            
            if($_POST['cTerm'] !== ""){


                if(preg_match('/\A(\d{14,16})?\z/',$_POST['card_number'])){

                        if(preg_match('/\A(\d{3,4})?\z/',$_POST['cTerm'])){

                        if(isset($_POST['next4'])){
                            
                            $_SESSION['credit_card'] = $_POST['credit_card'];
                            $_SESSION['cnumber'] = $_POST['card_number'];
                            $_SESSION['cardDate'] = $_POST['cTermMonth'].$_POST['cTermYear'];
                            $_SESSION['konbini'] = NULL;
                            $_SESSION['cTerm'] = $_POST['cTerm'];
                           
                            header('Location: kounyusaisyuukakuninn.php');
                            exit;

                        }

                    }elseif(isset($_POST['next4'])){

                        $errs['cTerm'] = "cscは3桁～4桁の半角数字で入力してください";
                        
                      

        
                    }
                
                }else if(isset($_POST['next4'])){

                    $errs['card_number'] = "カード番号は14桁～16桁の半角数字で入力してください";
                    
                    


        
                }

            }elseif(isset($_POST['next4'])){

                $errs['cTerm'] = "cscを入力してください";

                

            }

        }elseif(isset($_POST['next4'])){

            $errs['card_number'] = 'カード番号を入力してください';   
            

        }


    if(isset($_POST['back3'])){
        $_SESSION['back3'] = $_POST['back3'];
        //var_dump($_SESSION['zip_code']);

        header('Location: haisousiharaisentaku.php');
        exit;

    }


        
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>クレジットカード</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/kurezittosiharai.css">
</head>
<body>
    <?php include "header.php"; ?>
    <form action="" method="POST">
        <h1 class="kure_text">クレジットカード</h1>
            <div class="container">
                <label>カード番号</label>
                    <input type="text" maxlength="16"class="form-control" name="card_number" value="<?php if ($card_number != 0 ) { echo $card_number; }?>"><br>
                    <span style="color:red"><?=@$errs['card_number'] ?></span><br>
                        <div class="row">
                            <label>有効期限</label>
                            <div class="w-25 p-3">
                                <select class="form-select" aria-label="Default select example" name="cTermMonth">
                                    <option value="1"<?php if ($card_date_m === '1' ) { echo ' selected'; } ?>>01</option>
                                    <option value="2"<?php if ($card_date_m === '2' ) { echo ' selected'; } ?>>02</option>
                                    <option value="3"<?php if ($card_date_m === '3' ) { echo ' selected'; } ?>>03</option>
                                    <option value="4"<?php if ($card_date_m === '4' ) { echo ' selected'; } ?>>04</option>
                                    <option value="5"<?php if ($card_date_m === '5' ) { echo ' selected'; } ?>>05</option>
                                    <option value="6"<?php if ($card_date_m === '6' ) { echo ' selected'; } ?>>06</option>
                                    <option value="7"<?php if ($card_date_m === '7' ) { echo ' selected'; } ?>>07</option>
                                    <option value="8"<?php if ($card_date_m === '8' ) { echo ' selected'; } ?>>08</option>
                                    <option value="9"<?php if ($card_date_m === '9' ) { echo ' selected'; } ?>>09</option>
                                    <option value="10"<?php if ($card_date_m === '10' ) { echo ' selected'; } ?>>10</option>
                                    <option value="11"<?php if ($card_date_m === '11' ) { echo ' selected'; } ?>>11</option>
                                    <option value="12"<?php if ($card_date_m === '12' ) { echo ' selected'; } ?>>12</option>
                        </select>
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
                                </select>
                            </div>
                            <div class="w-25 p-3">
                                <div class="col-md-auto">
                                    CSC
                                </div>
                                <div class="col-6">
                                    <input type="text" maxlength="4" class="form-control" id="csc" size="1"name="cTerm" value="<?php if ($cTerm != 0) {echo $cTerm;}?>" ><br>
                                    <span style="color:red"><?=@$errs['cTerm'] ?></span><br>
                                </div>
                            </div>
                            <input type="hidden" name="credit_card" value="クレジットカード">
                            <input type="submit" id="btn1" name="back3" value="戻る">
                            <input type="submit" id="btn2" name="next4" value="次へ進む">
                        </div>
                    </div>
                </form>
    <?php include "footer.php"; ?>
</body>
</html>