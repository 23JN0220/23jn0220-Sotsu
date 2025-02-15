<?php
require_once 'DAO.php';

class Goods_SSD
{
    public int $goods_code;
    public int $standard_id;
    public int $connection_id;
    public int $type_id;
    public int $capacity;
}
class Goods_SSDDAO
{
    public function get_Goods_SSD()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_SSD";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_SSD')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_SSD_by_goodscode(int $goods_code)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_SSD WHERE goods_code = :goods_code";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('goods_code',$goods_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_SSD')){
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
    public function get_SSD_Standard()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM SSD_Standard";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('SSD_Standard')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_ssd_standard_by_standard_id(int $standard_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM SSD_Standard  WHERE standard_id = :standard_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('standard_id',$standard_id,PDO::PARAM_INT);

        $stmt->execute();

        $ssd = $stmt->fetchObject('SSD_Standard');
        return $ssd;
    }
    public function get_SSD_Connection()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM SSD_Connection";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('SSD_Connection')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_ssd_connection_by_standard_id(int $standard_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM SSD_Connection  WHERE standard_id = :standard_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('standard_id',$standard_id,PDO::PARAM_INT);

        $stmt->execute();

        $ssd = $stmt->fetchObject('SSD_Connection');
        return $ssd;
    }
    public function get_SSD_Type()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM SSD_Connection";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('SSD_Connection')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_ssd_type_by_type_id(int $type_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM SSD_Type  WHERE type_id = :type_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('type_id',$type_id,PDO::PARAM_INT);

        $stmt->execute();

        $ssd = $stmt->fetchObject('type_id');
        return $ssd;
    }
}