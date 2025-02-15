<?php
require_once './helpers/MemberDAO.php';

session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/category.css">
    <title>category</title>
</head>
<body>
<?php include "header.php"; ?>
 <div class=category_center >
    <div class="solid" >
        <h1 class="center">カテゴリー</h1>
    </div>
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=1'" value="CPU">
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=2'" value="CPUクーラー">
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=3'" value="マザーボード">
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=4'" value="メモリ">
    <br>
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=5'" value="グラフィックボード">
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=6'" value="SSD">
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=7'" value="HDD">
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=8'" value="電源ユニット">
    <br>
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=9'" value="PCケース">
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=10'" value="ケースファン">
        <input class=category_btn type="submit" onclick="location.href='list.php?cate=11'" value="OS">
</div>
    <?php include "footer.php"; ?>
</body>
</html>
