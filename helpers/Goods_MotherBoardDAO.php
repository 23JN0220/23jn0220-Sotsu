<?php
require_once 'DAO.php';

class Goods_MotherBoard
{
    public int $goods_code;
    public int $size;
    public int $chipset_series_id;
    public int $chipset_id;
    public int $socket_id;
    public int $pci_number;
    public int $m2ssd_standard_id;
    public int $m2ssd_number;
    public int $sata_number;
    public int $lan_standerd_id;
    public int $max_number;
    public int $standerd_id;
}
class Goods_MotherBoardDAO
{
    public function get_Goods_MotherBoard()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_MotherBoard";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_MotherBoard')){
            $data[] = $row;
        }
        return $data;
    }

    public function getMotherBoard_by_goodscode(int $goods_code)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_MotherBoard WHERE goods_code = :goods_code";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('goods_code',$goods_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_MotherBoard')){
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

    public function get_Motherboard_size()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Motherboard_size";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Motherboard_size')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_Motherboard_size_by_size_id(int $size_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM  Motherboard_size WHERE size_id = :size_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('size_id',$size_id,PDO::PARAM_INT);

        $stmt->execute();

        $Motherboard_Size = $stmt->fetchObject('Motherboard_size');
        return $Motherboard_Size;
    }
    public function get_ChipsetSeries()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM ChipsetSeries";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('ChipsetSeriese')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_ChipsetSeries_by_series_id(int $series_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM  ChipsetSeriese WHERE series_id = :series_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('series_id',$series_id,PDO::PARAM_INT);

        $stmt->execute();

        $ChipsetSeries = $stmt->fetchObject('ChipsetSeriese');
        return $ChipsetSeries;
    }
    public function get_Motherboard_Chipset()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Motherboard_Chipset";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Motherboard_Chipset')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_Motherboard_Chipset_by_chipset_id(int $chipset_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM  Motherboard_Chipset WHERE chipset_id = :chipset_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('chipset_id',$chipset_id,PDO::PARAM_INT);

        $stmt->execute();

        $Motherboard_Chipset = $stmt->fetchObject('Motherboard_Chipset');
        return $Motherboard_Chipset;
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
    public function get_Wireless_LAN()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Wireless_LAN";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Wireless_LAN')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_wireless_lan_by_lan_id(int $lan_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Wireless_LAN  WHERE lan_id = :lan_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('lan_id',$lan_id,PDO::PARAM_INT);

        $stmt->execute();

        $lan = $stmt->fetchObject('Wireless_LAN');
        return $lan;
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

    public function get_Motherboard_Chipset_By_Composition(int $member_id) {

        $dbh = DAO::get_db_connect();

        $sql = "SELECT Goods_MotherBoard.goods_code, size, chipset_series_id, chipset_id, pci_number, m2ssd_standard_id, m2ssd_number, sata_number, lan_standerd_id, max_number, standerd_id 
                FROM Goods_MotherBoard INNER JOIN Composition ON Goods_MotherBoard.goods_code = Composition.goods_code WHERE member_id = :member_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchObject('Goods_MotherBoard');
        return $data;

    }
}