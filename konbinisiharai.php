<?php
    
    require_once './helpers/MemberDAO.php';
    
    session_start();
    
    if(empty($_SESSION['member'])){
        
        header('Location: login.php');
        exit;
        
    }
        
    $member = $_SESSION['member'];
        
    

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(isset($_POST['konbini'])){
        
            if(isset($_POST['next'])){

            $_SESSION['konbini'] = $_POST['konbini'];
            $_SESSION['card_number'] = 0;
            
            header('Location: kounyusaisyuukakuninn.php');
            exit;
            
            }

            

        }else if(isset($_POST['next'])) {
            $errs['konbini'] = 'いずれかのコンビニを選択してください';
        }



        if(isset($_POST['back2'])){
            $_SESSION['back2'] = $_POST['back2'];
            

            header('Location: haisousiharaisentaku.php');
            exit;

        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>コンビニ支払い</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/konbinisiharai.css">
</head>
<body>
    <?php include "header.php"; ?>
        <form action="" method="POST">
            <div class="konbini_center">
                <h2>コンビニ選択</h2><br>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="konbini" value="ローソン" ><label class="form-check-label">ローソン</label><br>
                        <input class="form-check-input" type="radio" name="konbini" value="ファミリーマート"> <label>ファミリーマート</label><br>
                        <input class="form-check-input" type="radio" name="konbini" value="ミニストップ"><label>ミニストップ</label><br>
                        <input class="form-check-input" type="radio" name="konbini" value="デイリーヤマザキ"><label>デイリーヤマザキ</label><br>
                        <input class="form-check-input" type="radio" name="konbini" value="セブンイレブン"><label>セブンイレブン</label><br>
                    </div>
                    <span style="color:red"><?=@$errs['konbini'] ?></span><br>
                    <p>
                    <div class="row row-cols-2">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-primary" name="back2" value="戻る">
                        </div>
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-primary" name="next" value="次へ進む">
                        </div>
                    </div>
                </p>
            </div>
        </form>
    <?php include "footer.php"; ?>
</body>
</html>
