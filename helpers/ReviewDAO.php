<?php
require_once 'DAO.php';

class Review
{
    public int $member_id;
    public int $goods_code;
    public int $star_quantity;
}
class ReviewDAO
{#レビュー全取得
    public function get_Review()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Review";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Review')){
            $data[] = $row;
        }
        return $data;
    }
    public function review_insert(int $member_id, string $goods_code, int $star_quantity)
    {
        $dbh=DAO::get_db_connect();

       
        $sql = "insert into Review values(:member_id,:goods_code,:star_quantity)";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_INT);
        $stmt->bindValue(':star_quantity',$star_quantity,PDO::PARAM_INT);
        $stmt->execute();
        
    }
    public function review_exists(int $member_id,$goods_code)
    {
        $dbh=DAO::get_db_connect();
        $sql="select * from Review where member_id=:memberid AND goods_code=:goodscode ";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':memberid',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':goodscode',$goods_code,PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->fetch() !== false){
            return true;
        }
        else{
            return false;
        }
    }
    public function review_result(int $goods_code)
    {
        $dbh=DAO::get_db_connect();

       
        $sql = "select * from Review WHERE goods_code = :goods_code";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_INT);
        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Review')){
            $data[] = $row;
        }
        return $data;
        
    }
}