<?php
require_once 'DAO.php';


class Goods_Order
{
    
    public int    $member_id;
    public int    $order_id;
    public int    $price;
    public int    $creditcard_number;
    public string $convenience_store;
    public int    $paymented;
    public string $order_date;
}


class Goods_OrderDAO{

    public function insert(string $member_id,int $price,int $creditcard_number,string $convenience_store,int $paymented){

        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO Goods_Order(order_date,member_id,price,creditcard_number,convenience_store,paymented) VALUES(:order_date,:member_id,:price,:creditcard_number,:convenience_store,:paymented)";

        $stmt = $dbh->prepare($sql);

        $order_date = date('Y-m-d H:i:s');

        $stmt->bindValue(':order_date',$order_date,PDO::PARAM_STR);
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':price',$price,PDO::PARAM_INT);
        $stmt->bindValue(':creditcard_number',$creditcard_number,PDO::PARAM_INT);
        $stmt->bindValue(':convenience_store',$convenience_store,PDO::PARAM_STR);
        $stmt->bindValue(':paymented',$paymented,PDO::PARAM_INT);

        $stmt->execute();
        
    }

    
    public function get_order_id_bymember_id(string $member_id)
    {
        $dbh=DAO::get_db_connect();
        $sql="select * from Goods_Order where member_id=:member_id";

        $stmt=$dbh->prepare($sql);
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_STR);
        $stmt->execute();

        $data=[];
        while($row=$stmt->fetchObject('Goods_Order')){
            $data[]=$row;
        }

        return $data;
    }





}


?>