<?php
require_once 'DAO.php';

class CPU_Cooler
{
    public int $goods_code;
    public int $cooler_type_id;
    public int $height;
    
}
class CPU_CoolerDAO
{
    public function get_CPU_Cooler()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CPU_Cooler";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('CPU_Cooler')){
            $data[] = $row;
        }
        return $data;
    }
    public function getCPUCooler_by_goodscode(int $goods_code)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_Cooler WHERE goods_code = :goods_code";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('goods_code',$goods_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('CPU_Cooler')){
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
    public function get_Cooler_Type()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Cooler_Type";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Cooler_Type')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_goods_cooler_by_cooler_type_id(int $cooler_type_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Cooler_type  WHERE cooler_type_id = :cooler_type_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('cooler_type_id',$cooler_type_id,PDO::PARAM_INT);

        $stmt->execute();

        $cooler_type = $stmt->fetchObject('Cooler_Type');
        return $cooler_type;
    }
}