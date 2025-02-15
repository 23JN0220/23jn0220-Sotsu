<?php
require_once 'DAO.php';

class Goods_OS
{
    public int $goods_code;
    public int $version_id;
}
class Goods_OSDAO
{
    public function get_Goods_OS()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_OS";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_OS')){
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
    public function get_OS_Version()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM OS_Version";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('OS_Version')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_os_version_by_version_id(int $version_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM OS_Version  WHERE version_id = :version_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('version_id',$version_id,PDO::PARAM_INT);

        $stmt->execute();

        $OS = $stmt->fetchObject('OS_Version');
        return $OS;
    }
}