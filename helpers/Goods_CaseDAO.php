<?php
require_once 'DAO.php';


class Goods_Case
{
    public int $goods_code;
    public int $bay_number;
    public int $shadowbay3_number;
    public int $shadowbay2_number;
    public int $gpu_size;
    public int $fan_size_id;
    public int $fan_number;
    public int $slot_number;
    public int $power_size_id;
    public int $cooler_size;
    public int $width;
    public int $Depth;
    public int $height;
    public string $color;
    public int $lowpro;
    public int $water_cooling;
    public int $member_id;
    public int $group_code;
    
}
class Goods_CaseDAO
{
    public function get_Goods_Case()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_Case";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_Case')){
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

        $sql = "SELECT * FROM Goods_Case  WHERE goods_code = :goods_code";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('goods_code',$goodscode,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_Case')){
            $data[] = $row;
        }
        return $data;
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
    public function get_Power_Size()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Power_Size";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Power_Size')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_power_size_by_size_id(int $size_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Power_Size  WHERE size_id = :size_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('size_id',$size_id,PDO::PARAM_INT);

        $stmt->execute();

        $power = $stmt->fetchObject('Power_Size');
        return $power;
    }
    public function get_power_size_by_size_id2(int $power_size_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_Case WHERE power_size_id = :power_size_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':power_size_id',$power_size_id,PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchObject('Goods_Case');
        return $data;
    }
    public function get_power_Size_goods(int $member_id,int $group_code){

        $dbh = DAO::get_db_connect();
        
        $sql = "SELECT * FROM Composition INNER JOIN Goods_Case ON Composition.goods_code = Goods_Case.goods_code WHERE member_id = :member_id AND group_code = :group_code";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':group_code',$group_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchObject('Goods_Case');
        return $data;

    }

    public function get_Goods_Case_By_Composition(int $member_id) {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_Case INNER JOIN Composition ON Composition.goods_code = Goods_Case.goods_code WHERE member_id = :member_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchObject('Goods_Case');
        return $data;

    }
}