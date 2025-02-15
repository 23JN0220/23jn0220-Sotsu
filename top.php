<?php
session_start();

require_once './helpers/GoodsDAO.php';
require_once './helpers/Category_GroupDAO.php';



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/top.css">
    <title>トップページ</title>
</head>
<body>
    <?php include "header.php"; ?>
<div class="top_center">
   

    <h2><input class="top_btn1" onclick="location.href='koseicheck.php'" type="submit" value="構成チェック"></h2><hr>

    <h1>カテゴリ</h1>

    
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=1'" value="CPU">
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=2'" value="CPUクーラー">
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=3'" value="マザーボード">
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=4'" value="メモリ"><br>
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=5'" value="グラフィックボード">
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=6'" value="SSD">
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=7'" value="HDD">
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=8'" value="電源ユニット"><br>
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=9'" value="PCケース">
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=10'" value="ケースファン">
            <input class="top_btn" name="cate" type="submit" onclick="location.href='list.php?cate=11'" value="OS">
          
    
</div>
    <?php include "footer.php"; ?>
</body>
</html>
