<?php
require_once 'DAO.php';

class Order_Detail{

    public int $member_id;
    public int $order_id;
    public string $goods_code;
    public int $num;


}

Class Order_DetailDAO{

    public function Get_order_id(int $member_id){

        $dbh = DAO::get_db_connect();

        $sql = "SELECT IDENT_CURRENT('Goods_Order') AS order_id";

        $stmt = $dbh->query($sql);

        $row = $stmt-> fetchObject();
        return $row->order_id;



    }
    

    public function insert(int $order_id,int $goods_code,int $num){

        $dbh = DAO::get_db_connect();
        
        $sql = "INSERT INTO Order_Detail(order_id,goods_code,num) VALUES(:order_id,:goods_code,:num)";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':order_id',$order_id,PDO::PARAM_INT);
        $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_INT);
        $stmt->bindValue(':num',$num,PDO::PARAM_INT);

        $stmt->execute();




        

    }

}


?>