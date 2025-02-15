<?php
require_once 'DAO.php';

class Goods_GPU
{
    public int $goods_code;
    public int $series_id;
    public int $memory_size;
    public int $cuda;
    public int $width;
    public int $interface_id;
    public int $hdmi_port;
    public int $dp_port;
    public bool $lowpro;
    public int $max_output;
    public int $resolution_id;
    public bool $auxiliary;
    public int $slot;
}
class Goods_GPUDAO
{
    public function get_Goods_GPU()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Goods_GPU";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Goods_GPU')){
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
    public function get_GPU_Series()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM GPU_Series";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('GPU_Series')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_gpu_series_by_gpu_series_id(int $gpu_series_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM GPU_Series  WHERE gpu_series_id = :gpu_series_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('gpu_series_id',$gpu_series_id,PDO::PARAM_INT);

        $stmt->execute();

        $gpu_series = $stmt->fetchObject('GPU_Series');
        return $gpu_series;
    }
    public function get_GPU_Interface()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM GPU_Interface";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('GPU_Interface')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_gpu_interface_by_interface_id(int $interface_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM GPU_Interface  WHERE interface_id = :interface_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('interface_id',$interface_id,PDO::PARAM_INT);

        $stmt->execute();

        $gpu_interface = $stmt->fetchObject('GPU_Interface');
        return $gpu_interface;
    }
    public function get_GPU_Resolution()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM GPU_Resolution";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('GPU_Resolution')){
            $data[] = $row;
        }
        return $data;
    }
    public function get_gpu_resolution_by_resolution_id(int $resolution_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM GPU_Resolution  WHERE resolution_id = :resolution_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue('resolution_id',$resolution_id,PDO::PARAM_INT);

        $stmt->execute();

        $gpu_resolution = $stmt->fetchObject('GPU_Resolution');
        return $gpu_interface;
    }
    public function get_Goods_GPU_By_Composition(int $member_id) {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT Goods_GPU.goods_code, series_id, memory_size, cuda, width, interface_id, hdmi_port, dp_port, lowpro, max_output, resolution_id, auxiliary, slot 
                FROM Goods_GPU INNER JOIN Composition ON Composition.goods_code = Goods_GPU.goods_code WHERE member_id = :member_id";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchObject('Goods_GPU');
        return $data;

    }
}