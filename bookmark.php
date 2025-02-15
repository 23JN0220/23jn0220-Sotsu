<?php

require_once './helpers/MemberDAO.php';
require_once './helpers/BookmarkDAO.php';

session_start();

$goodscode;

if(empty($_SESSION['member'])){
    header('Location: login.php');
    exit;
}
$member = $_SESSION['member'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['add'])){
        $goodscode=$_POST['goods_code'];
        $bookmarkDAO=new bookmarkDAO();
        $bookmarkDAO->insert($member->member_id,$goodscode);
    }
    else if(isset($_POST['bookmark_delete'])){
        $goodscode=$_POST['goodscode'];
        $bookmarkDAO=new BookmarkDAO();
        $bookmarkDAO->delete($member->member_id, $goodscode);
    }
}
if(empty($_SESSION['member'])){
    header('Location: login.php');
    exit;
}

$bookmarkDAO=new bookmarkDAO();
    $bookmark_list = $bookmarkDAO->get_bookmark_by_memberid($member->member_id);
?>

<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="css/bookmark.css">
 <title>ブックマーク</title>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="bookmark_center">
<?php if(empty($bookmark_list)) : ?>
        <p>ブックマークに商品はありません</p>
        <?php else: ?>
            <?php foreach($bookmark_list as $bookmark) : ?>
                <table border="1">
            <tr>
                <th class="bookmark_name"></th>
                <th class="bookmark_godsdetail">商品情報</th>
                <th class="bookmark_goodsprice">値段</th>
            </tr>
            <tr>        
                <td class="bookmark_img">
                    <a href="goodsreview.php?goods_code=<?=$bookmark->goods_code ?>">
                        <p><img src="images/goods/<?=$bookmark->goods_image?>" width="128px"></p>
                    </a>
                </td>
                <form action="" method="POST">    
                <td class="bookmark_detail">
                    <a href="goodsreview.php?goods_code=<?=$bookmark->goods_code ?>">
                        <p><?=$bookmark->goods_name?></p>
                        <td class="bookmark_price">
                            <p>￥<?=number_format($bookmark->price)?></p>
                        </td>
                    </a>
                    </td>
              
                </tr>
                <td class="bookmark_button">
                        <input type="hidden" name="goodscode" value="<?= $bookmark->goods_code?>">
                       
                        <input type="submit" name="bookmark_delete" value="削除">
                    </td>
            </form>
        </tr>
    </table>
    <?php endforeach?>
        </div>
   
    <?php include "footer.php"; ?>
    <?php endif; ?>
</body>
</html>