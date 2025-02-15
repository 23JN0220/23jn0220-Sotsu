<?php
require_once 'DAO.php';
require_once 'email.php';
require_once 'member.php';
class Authentication_Code
{
    public int $management_id;
    public int $member_id;
    public string $mail_address;
    public int $code;

public function get_ninshou()
        {
            $dbh = DAO::get_db_connect();
    
            $sql = "SELECT * FROM Authentication_Code";
            $stmt = $dbh->prepare($sql);
    
            $stmt->execute();
    
            $data = [];
            while($row = $stmt->fetchObject('Authentication_Code')){
                $data[] = $row;
            }
            return $data;
        }
    
    public function insert(int $member_id, string $goods_code, int $management_id, int $code)
    {
        $dbh=DAO::get_db_connect();

        if(!$this->cart_exists($member_id, $goods_code)){
            $sql = "insert into cart(member_id,goods_code,code,management_id) values(:member_id,:goods_code,:code,:management_id)";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
            $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
            $stmt->bindValue(':code',$code,PDO::PARAM_INT);
            $stmt->bindValue(':management_id',$management_id,PDO::PARAM_INT);
            $stmt->execute();
        }
        else{
            $sql = "update cart set number=number + :number where member_id=:member_id and goods_code=:goods_code";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
            $stmt->bindValue(':goods_code',$goods_code,PDO::PARAM_STR);
            $stmt->bindValue(':code',$code,PDO::PARAM_INT);
            $stmt->bindValue(':management_id',$member_id,PDO::PARAM_INT);
            $stmt->execute();
        }
        
    }
}