<?php
require_once 'DAO.php';

class Goods_CPU
{
    public int $goods_code;
    public int $series_id;
    public int $generation_id;
    public int $socket_id;
    public int $core;
    public int $thread;
    public float $clock;
}
class Goods_CPUDAO
{
    public function get_Goods_CPU()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_CPU";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_CPU')){
            $data[] = $row;
        }
        return $data;
    }
    public function getCPU_by_goodscode(int $goods_code)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_CPU WHERE goods_code = :goods_code";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('goods_code',$goods_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_CPU')){
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
    public function get_CPU_Series()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CPU_Series";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('CPU_Series')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_cpu_series_by_series_id(int $series_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CPU_Series  WHERE series_id = :series_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('series_id',$series_id,PDO::PARAM_INT);

        $stmt->execute();

        $cpu_series = $stmt->fetchObject('CPU_Series');
        return $cpu_series;
    }
    public function get_CPU_Generation()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CPU_Generation";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('CPU_Generation')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_cpu_generation_by_generation_id(int $generation_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CPU_Generation  WHERE generation_id = :generation_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('series_id',$series_id,PDO::PARAM_INT);

        $stmt->execute();

        $cpu_generation = $stmt->fetchObject('CPU_Generation');
        return $cpu_generation;
    }
    public function get_CPU_Socket()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CPU_Socket";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('CPU_Socket')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_cpu_socket_by_socket_id(int $socket_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CPU_Socket  WHERE socket_id = :socket_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('socket_id',$socket_id,PDO::PARAM_INT);

        $stmt->execute();

        $cpu_socket = $stmt->fetchObject('CPU_Socket');
        return $cpu_generation;
    }
}