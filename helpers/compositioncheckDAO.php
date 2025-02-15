<?php
require_once 'DAO.php';

class Composition
{
    public int    $member_id;
    public int    $goods_code;
    public int    $group_code;
    public string $goods_name;
    public int    $price;
    public string $goods_image;
}
class Composition_goodscode
{
    public int $goods_code;
}

class CompositioncheckDAO
{
    public function composition_exists(int $member_id, int $group_code)
    {
        $dbh=DAO::get_db_connect();
        $sql="select * from composition where member_id=:member_id and group_code=:group_code";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':group_code',$group_code,PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->fetch() !== false){
            return true;
        }
        else{
            return false;
        }
    }

    public function composition_exists_storage(int $member_id, string $goods_code, int $group_code) {
        $dbh=DAO::get_db_connect();
        $sql="select * from composition where member_id=:member_id and goods_code = :goods_code AND group_code=:group_code";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
        $stmt->bindValue(':group_code',$group_code,PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->fetch() !== false){
            return true;
        }
        else{
            return false;
        }
    }

    public function insert(int $member_id, string $goods_code, int $group_code)
    {
        $dbh=DAO::get_db_connect();
       
            
        //var_dump($group_code);
        $sql = "insert into composition(member_id,goods_code,group_code) values(:member_id,:goods_code,:group_code)";
            
        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
        $stmt->bindValue(':group_code',$group_code,PDO::PARAM_INT);
        $stmt->execute();
    }

    public function update(int $member_id, string $goods_code, int $group_code) {
        $dbh=DAO::get_db_connect();
        $sql = "update composition set goods_code=:goods_code where member_id=:member_id and group_code=:group_code";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
        $stmt->bindValue(':group_code',$group_code,PDO::PARAM_INT);
        $stmt->execute();
    }

    public function reset(int $member_id) {
        $dbh=DAO::get_db_connect();
        $sql = "delete from composition where member_id=:member_id ";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->execute();
    }

    public function get_composition(int $member_id)
    {
        $dbh=DAO::get_db_connect();
        $sql="select member_id,goods.goods_code,goods_name,price,goods_image,goods.group_code
              from composition 
              inner join goods 
              on composition.goods_code = goods.goods_code 
              where member_id=:member_id";
        $stmt=$dbh->prepare($sql);
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->execute();

        $data=[];
        while($row=$stmt->fetchObject('Composition')){
            $data[]=$row;
        }

        return $data;
    }

    public function get_composition_goodscode(int $member_id)
    {
        $dbh=DAO::get_db_connect();
        $sql="select goods_code from composition where member_id=:member_id";
        $stmt=$dbh->prepare($sql);
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->execute();

        $data=[];
        while($row=$stmt->fetchObject('Composition_goodscode')){
            $data[]=$row;
        }

        return $data;
    }

    public function get_composition_category(int $member_id,int $group_code)
    {
        $dbh=DAO::get_db_connect();
        $sql="select member_id,goods.goods_code,goods_name,price,goods_image,goods.group_code
              from composition 
              inner join goods 
              on composition.goods_code = goods.goods_code 
              where member_id=:member_id AND goods.group_code=:groupcode";
        $stmt=$dbh->prepare($sql);
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->bindValue(':groupcode',$group_code,PDO::PARAM_INT);
        $stmt->execute();

        $data=[];
        while($row=$stmt->fetchObject('Composition')){
            $data[]=$row;
        }

        return $data;
    }
    

    public function delete(int $member_id, string $goods_code)
    {
        $dbh=DAO::get_db_connect();

            $sql = "delete from composition where member_id=:member_id and goods_code=:goods_code";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
            $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
            $stmt->execute();
        
    }

}