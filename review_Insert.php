<?php
#レビュー登録
    require_once './helpers/ReviewDAO.php';
    require_once './helpers/GoodsDAO.php';
    require_once './helpers/MemberDAO.php';

        
        $dbh = DAO::get_db_connect();

        $member_id=$_POST['member_id'];
        $goods_code=$_POST['goods_code'];
        $star_quantity=$_POST['star_quantity'];

        if($member_id === '0'){
            header("Location:login.php");
            exit;
        }
        
        $sql = "INSERT INTO Review values(:member_id,:goods_code,:star_quantity)";
    
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_INT);
        $stmt->bindValue(':star_quantity',$star_quantity,PDO::PARAM_INT);
    
        
        $stmt->execute();
        $result = $stmt->result();
        
        header("Location:goodsreview.php?goods_code=" . $goods_code );
        exit;

?>