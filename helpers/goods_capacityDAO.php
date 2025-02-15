<?php
require_once 'DAO.php';
require_once 'GoodsDAO.php';

class goods_capacity{

    public int $member_id;
    /*public int $goods_code;
    public string $goods_name;
    public string $maker_id;
    public int $price;
    public int $group_code;
    public int $power_consumption;
    public string $goods_image;
    public string $group_name;*/



}


class goods_capacityDAO{

    public function get_power_capacity(int $member_id){

        $dbh = DAO::get_db_connect();

        $sql = "SELECT Goods.goods_code, goods_name, maker_id, price, Goods.group_code, power_consumption, goods_image 
                FROM Goods INNER JOIN Composition ON Goods.goods_code = Composition.goods_code WHERE member_id = :member_id";

        $stmt = $dbh->prepare($sql);
        
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        
        $stmt->execute();
        
        $data = [];
        while($row = $stmt->fetchObject('Goods')){
            $data[] = $row;
        }
        return $data;


    }

    

    


}


?>