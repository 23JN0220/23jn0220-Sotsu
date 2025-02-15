<?php
require_once './helpers/MemberDAO.php';

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(empty($_SESSION['member'])){
    header('Location: top.php');
    exit;
}

if (isset($_SESSION['auth'])) {

    $member=$_SESSION['member'];
    $member_id=$member->member_id;
    $email=$member->email;
    $password=$member->password;
    $username=$member->member_name;
    $zipcode=$member->zip_code;
    $address=$member->address;
    $tel=$member->tel;
    $cnumber=$member->credit_card;
    $cDate=$member->credit_expiration_date;

    $memberDAO=new MemberDAO();
    $member=new Member();
    $member->member_id=$member_id;
    $member->email      =$email;
    $member->password   =$password;
    $member->member_name =$username;
    $member->zip_code    =$zipcode;
    $member->address    =$address;
    $member->tel=$tel;
    $member->credit_card=$cnumber;
    $member->credit_expiration_date=$cDate;

    $memberDAO->update($member);

    if($password !==''){
        $memberDAO->newpassword($member);
    }

    $_SESSION['member']=$member;

    unset($_SESSION['auth']);
}else {
    header('Location: mypage.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/henkoukanryou.css">
    <title>変更完了</title>
</head>
<body>
    <?php include "header.php"; ?>
    <h1 class="henkoukanryou">会員情報変更完了</h1>
        <p class="henkou_message">変更が完了しました。</p>
        <div class="henkou_button">
            <input type="button" class="btn btn-primary" onclick="location.href='mypage.php'" name="myPage" value="マイページ">
        </div>    
    <?php include "footer.php"; ?>
</body>
</html>
