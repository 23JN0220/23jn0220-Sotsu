<?php
require_once 'DAO.php';

class Goods_Memory
{
    public int $goods_code;
    public int $standard_id;
    public int $module_id;
    public int $capacity;
    public int $number;
    public bool $ecc;
}
class Goods_MemoryDAO
{
    public function get_Goods_Memory()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_Memory";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_Memory')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_memory_by_goodscode(int $goods_code)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_Memory WHERE goods_code = :goods_code";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('goods_code',$goods_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_Memory')){
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
    public function get_Memory_Standard()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Memory_Standard";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Memory_Standard')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_memory_standard_by_standard_id(int $standard_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Memory_Standard  WHERE standard_id = :standard_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('standard_id',$standard_id,PDO::PARAM_INT);

        $stmt->execute();

        $memory_standard = $stmt->fetchObject('Memory_Standard');
        return $memory_standard;
    }
    public function get_Memory_Module()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Memory_Module";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Memory_Module')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_memory_module_by_module_id(int $module_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Memory_Module  WHERE module_id = :module_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('module_id',$module_id,PDO::PARAM_INT);

        $stmt->execute();

        $memory_module = $stmt->fetchObject('Memory_Module');
        return $memory_module;
    }
}