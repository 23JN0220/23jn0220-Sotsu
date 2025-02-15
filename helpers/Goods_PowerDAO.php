<?php
require_once 'DAO.php';


class Goods_Power
{
    public int $member_id;
    public int $group_code;
    public int $goods_code;
    public int $size_id;
    public int $power_capacity;
    public string $plus;
    public int $pciConnector;
    public int $sataConnector;
}
class Goods_PowerDAO
{
    public function get_Goods_Power()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_Power";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_Power')){
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
    #public function get_power_size_by_size_id(int $size_id)
    #{
        #$dbh = DAO::get_db_connect();

        #$sql = "SELECT * FROM Power_Size  WHERE size_id = :size_id";

        #$stmt = $dbh->prepare($sql);

        #$stmt->bindValue('size_id',$size_id,PDO::PARAM_INT);

        #$stmt->execute();

        #$power = $stmt->fetchObject('Power_Size');
        #return $power;
    #}
    /*public function get_power_size_by_size_id2(int $size_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_Power  WHERE size_id = :size_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('size_id',$size_id,PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchObject('Goods_Power');
        return $data;
    }*/
    public function get_power_Size_id(int $goods_code){

        $dbh = DAO::get_db_connect();
        
        $sql = "SELECT * FROM Goods_Power where goods_code = :goods_code";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchObject('Goods_Power');
        return $data;

    }

    public function get_power_Size_goods(int $member_id,int $group_code){

        $dbh = DAO::get_db_connect();
        
        $sql = "SELECT * FROM Composition INNER JOIN Goods_Power ON Composition.goods_code = Goods_Power.goods_code WHERE member_id = :member_id AND group_code = :group_code";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':group_code',$group_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchObject('Goods_Power');
        return $data;

    }

}