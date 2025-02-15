<?php
require_once 'DAO.php';

class Goods_Fan
{
    public int $goods_code;
    public int $size_id;
    public int $quantity;
}
class Goods_FanDAO
{
    public function get_Goods_Fan()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_Fan";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_Fan')){
            $data[] = $row;
        }
        return $data;
    }
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
    public function get_CaseFan_Size()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CaseFan_Size";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('CaseFan_Size')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_casefan_size_by_size_id(int $size_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CaseFan_Size WHERE size_id = :size_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('size_id',$size_id,PDO::PARAM_INT);

        $stmt->execute();

        $goods = $stmt->fetchObject('CaseFan_Size');
        return $goods;
    }

    public function get_casefan_by_composition(int $member_id) {

        $dbh = DAO::get_db_connect();

        $sql = "SELECT Goods_Fan.goods_code, size_id, quantity FROM Goods_Fan INNER JOIN Composition ON Goods_Fan.goods_code = Composition.goods_code WHERE member_id = :member_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);

        $stmt->execute();

        $goods = $stmt->fetchObject('Goods_Fan');
        return $goods;

    }
}