<?php
require_once 'DAO.php';

class Goods{
   public int $goods_code;
   public string $goods_name;
   public string $maker_id;
   public int $price;
   public int $group_code;
   public int $power_consumption;
   public string $goods_image;
   public int $member_id;
   public string $group_name;
}

class GoodsDAO{
    public function get_Goods(){
        $dbh = DAO::get_db_connect();
    
        $sql = "SELECT * FROM Goods";
        $stmt = $dbh->prepare($sql);
    
        $stmt->execute();
    
        $data = [];
        while($row = $stmt->fetchObject('Goods')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_goods_by_goodscode(int $goodscode)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods  WHERE goods_code = :goods_code";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('goods_code',$goodscode,PDO::PARAM_INT);

        $stmt->execute();

        $goods = $stmt->fetchObject('Goods');
        return $goods;
    }
    public function get_goods_by_maker_id(int $maker_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods  WHERE maker_id = :maker_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('maker_id',$maker_id,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods')){
            $data[] = $row;
        }
        return $data;

    }
    public function get_goods_by_group_code(int $group_code)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods  WHERE group_code = :group_code";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('group_code',$group_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_goods_by_keyword(string $keyword)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods
        INNER JOIN Category_Group
        ON Goods.group_code = Category_Group.group_code
        WHERE goods_name LIKE :keyword OR group_name = :keyword2";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->bindValue(':keyword2', $keyword , PDO::PARAM_STR);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods')){
            $data[] = $row;
        }
        return $data;
    }
    public function goods_code_exists(int $goods_code)
    {
        $dbh=DAO::get_db_connect();
        $sql="select * from Goods where goods_code=:goods_code";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->fetch() !== false){
            return true;
        }
        else{
            return false;
        }
    }
    public function goods_all_get(int $member_id){

        $dbh=DAO::get_db_connect();
        $sql="select * from Goods where where=:goods_code";

        $stmt=$dbh->prepare($sql);


    }
}