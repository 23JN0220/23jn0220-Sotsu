<?php

require_once './helpers/MemberDAO.php';

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(empty($_SESSION['member'])){
    header('Location: login.php');
    exit;
}
$member = $_SESSION['member'];


    $memberId = $member->member_id;
    $memberName = $member->member_name;
    $email = $member->email;
    $zipcode = $member->zip_code;
    $address = $member->address;
    $tel = $member->tel;

    /*header("Location:" .$_SERVER['PHP_SELF']);
    exit;*/
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <title>マイページ</title>
</head>
<body>
<?php include "header.php"; ?>
<div class="mypage_center">
    <div class="row">
        <div class="col-md-auto">
            <h1>マイページ</h1>
        </div>
    <div class="col-md-auto"> 
            <h1><?= $memberName?>さん</h1>
    </div>
        <div class="col-md-auto">
            <div class="grid gap-0 row-gap-3">
                <div class="p-2 g-col-6">
                    <input type="submit" onclick="location.href='bookmark.php'" class="btn btn-primary" value="ブックマーク">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h2>会員情報</h2>
    <table  border="1">
        <tr>
            <td>会員番号</td>
            <td><?= $memberId?></td>
        </tr>
        <tr>
            <td>お名前</td>
            <td><?= $memberName?></td>
        </tr>
        <tr>
            <td>メールアドレス</td>
            <td><?= $email?></td>
        </tr>
        <tr>
            <td>郵便番号</td>
            <td><?= $zipcode ?></td>
        </tr>
        <tr>
            <td>住所</td>
            <td><?=$address?></td>
        </tr>
        <tr>
            <td>電話番号</td>
            <td><?= $tel?></td>
        </tr>
    </table>
        <div class="grid gap-0 row-gap-3">
            <div class="p-2 g-col-6">
                <input type="submit" onclick="location.href='jouhouhenkou.php'" class="btn btn-primary" value="会員情報内容変更"><br>
            </div>
            <div class="p-2 g-col-6">
                <input type="submit" onclick="location.href='taikai.php'" class="btn btn-primary" value="会員退会">
            </div>
        </div>
</div class="mypage_center">
<?php include "footer.php"; ?>
</body>
</html>
