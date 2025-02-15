<?php
require_once 'DAO.php';

class Cart
{
    public int    $member_id;
    public string $goods_code;
    public string $goods_name;
    public int    $price;
    /*public string $detail;*/
    public string $goods_image;
    public int    $number;
}

class CartDAO
{
    public function get_cart_by_memberid(int $member_id)
    {
        $dbh=DAO::get_db_connect();
        $sql="select member_id,cart.goods_code,goods_name,price,goods_image,number
              from cart 
              inner join goods 
              on cart.goods_code = goods.goods_code 
              where member_id=:member_id";
        $stmt=$dbh->prepare($sql);
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->execute();

        $data=[];
        while($row=$stmt->fetchObject('Cart')){
            $data[]=$row;
        }

        return $data;

    }

    public function cart_exists(int $member_id, string $goods_code)
    {
        $dbh=DAO::get_db_connect();
        $sql="select * from cart where member_id=:member_id and goods_code=:goods_code";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->fetch() !== false){
            return true;
        }
        else{
            return false;
        }
    }

    public function insert(int $member_id, string $goods_code, int $number)
    {
        $dbh=DAO::get_db_connect();

        if(!$this->cart_exists($member_id, $goods_code)){
            $sql = "insert into cart(member_id,goods_code,number) values(:member_id,:goods_code,:number)";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
            $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
            $stmt->bindValue(':number',$number,PDO::PARAM_INT);
            $stmt->execute();
        }
        else{
            $sql = "update cart set number=number + :number where member_id=:member_id and goods_code=:goods_code";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
            $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
            $stmt->bindValue(':number',$number,PDO::PARAM_INT);
            $stmt->execute();
        }
        
    }

    public function update(int $member_id, string $goods_code, int $number)
    {
        $dbh=DAO::get_db_connect();

            $sql = "update cart set number=:number where member_id=:member_id and goods_code=:goods_code";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
            $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
            $stmt->bindValue(':number',$number,PDO::PARAM_INT);
            $stmt->execute();
        
    }

    public function delete(int $member_id, string $goods_code)
    {
        $dbh=DAO::get_db_connect();

            $sql = "delete from cart where member_id=:member_id and goods_code=:goods_code";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
            $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
            $stmt->execute();
        
    }

    public function delete_by_memberid(int $member_id)
    {
        $dbh=DAO::get_db_connect();

        $sql="delete from cart where member_id=:member_id";

        $stmt=$dbh->prepare($sql);
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->execute();
    }
}