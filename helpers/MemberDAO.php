<?php 
require_once 'DAO.php';

class Member
{
    public int    $member_id;
    public string $email;
    public string $member_name;
    public string $zip_code;
    public string $address;
    public string $tel;
    public string $password;
    public int    $credit_card;
    public int    $credit_expiration_date;
}

class MemberDAO
{
    public function get_member(string $userEmail,string $userPassword)
    {
        $dbh=DAO::get_db_connect();
        $sql="select * from member where email=:userEmail";
        $stmt=$dbh->prepare($sql);
        $stmt->bindValue(':userEmail',$userEmail,PDO::PARAM_STR);
        $stmt->execute();

        $member=$stmt->fetchObject('Member');
        if($member !== false){
            if(password_verify($userPassword,$member->password)){
                return $member;
            }
        }

        return false;

    }

    public function insert(Member $member)
    {
        $dbh=DAO::get_db_connect();
        $sql = "insert into Member(email,member_name,zip_code,address,tel,password,credit_card,credit_expiration_date) values(:userEmail,:userName,:zipcode,:address,:tel,:userPassword,:cardNumber,:cTerm)";

        $stmt=$dbh->prepare($sql);
        $password = password_hash($member->password,PASSWORD_DEFAULT);

        $stmt->bindValue(':userEmail',$member->email,PDO::PARAM_STR);
        $stmt->bindValue(':userName',$member->member_name,PDO::PARAM_STR);
        $stmt->bindValue(':zipcode',$member->zip_code,PDO::PARAM_STR);
        $stmt->bindValue(':address',$member->address,PDO::PARAM_STR);
        $stmt->bindValue(':tel',$member->tel,PDO::PARAM_STR);
        $stmt->bindValue(':userPassword',$password,PDO::PARAM_STR);
        $stmt->bindValue(':cardNumber',$member->credit_card,PDO::PARAM_STR);
        $stmt->bindValue(':cTerm',$member->credit_expiration_date,PDO::PARAM_STR);

        $stmt->execute();
    }

    public function update(Member $member)
    {
        $dbh=DAO::get_db_connect();
        $sql = "update member set email=:userEmail, member_name=:userName, zip_code=:zipcode, address=:address, 
                tel=:tel, credit_card=:cardNumber, credit_expiration_date=:cDate 
                where member_id=:memberid";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':memberid',$member->member_id,PDO::PARAM_INT);
        $stmt->bindValue(':userEmail',$member->email,PDO::PARAM_STR);
        $stmt->bindValue(':userName',$member->member_name,PDO::PARAM_STR);
        $stmt->bindValue(':zipcode',$member->zip_code,PDO::PARAM_STR);
        $stmt->bindValue(':address',$member->address,PDO::PARAM_STR);
        $stmt->bindValue(':tel',$member->tel,PDO::PARAM_STR);
        $stmt->bindValue(':cardNumber',$member->credit_card,PDO::PARAM_STR);
        $stmt->bindValue(':cDate',$member->credit_expiration_date,PDO::PARAM_STR);

        $stmt->execute();
    }

    public function newpassword(Member $member)
    {
        $dbh=DAO::get_db_connect();
        $sql="update member set password=:newpassword where member_id=:memberid";

        $stmt=$dbh->prepare($sql);
        $password = password_hash($member->password,PASSWORD_DEFAULT);

        $stmt->bindValue(':memberid',$member->member_id,PDO::PARAM_INT);
        $stmt->bindValue(':newpassword',$password,PDO::PARAM_STR);
        $stmt->execute();

    }
    public function newpassword2(string $email, string $newpassword)
    {
        $dbh=DAO::get_db_connect();
        $sql="update member set password=:newpassword where email=:email";

        $stmt=$dbh->prepare($sql);
        $password = password_hash($newpassword,PASSWORD_DEFAULT);

        $stmt->bindValue(':email',$email,PDO::PARAM_STR);
        $stmt->bindValue(':newpassword',$password,PDO::PARAM_STR);
        $stmt->execute();

    }
    public function get_member_id(Member $member)
    {
        $dbh=DAO::get_db_connect();
        $sql="select * from member where member_id=:memberid";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':memberid',$member->member_id,PDO::PARAM_INT);
        $stmt->execute();

    }

    public function email_exists(String $userEmail)
    {
        $dbh=DAO::get_db_connect();
        $sql="select * from Member where email=:userEmail";
        
        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':userEmail',$userEmail,PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->fetch() !== false){
            return true;
        }
        else{
            return false;
        }
    }
   
    public function delete_member(string $member_id)
    {
        $dbh=DAO::get_db_connect();

            $sql = "delete from member where member_id=:member_id ";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_STR);
            $stmt->execute();
        
    }

    public function delete_review(string $member_id)
    {
        $dbh=DAO::get_db_connect();

            $sql = "delete from review where member_id=:member_id ";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_STR);
            $stmt->execute();
        
    }

    public function delete_cart(string $member_id)
    {
        $dbh=DAO::get_db_connect();

            $sql = "delete from cart where member_id=:member_id ";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_STR);
            $stmt->execute();
        
    }

    public function delete_bookmark(string $member_id)
    {
        $dbh=DAO::get_db_connect();

            $sql = "delete from bookmark where member_id=:member_id ";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_STR);
            $stmt->execute();
        
    }

    public function delete_goods_order(string $member_id)
    {
        $dbh=DAO::get_db_connect();

            $sql = "delete from goods_order where member_id=:member_id ";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_STR);
            $stmt->execute();
        
    }
    public function delete_composition(string $member_id)
    {
        $dbh=DAO::get_db_connect();

            $sql = "delete from Composition where member_id=:member_id ";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':member_id',$member_id,PDO::PARAM_STR);
            $stmt->execute();
        
    }
    public function delete_order(int $order_id)
    {
        $dbh=DAO::get_db_connect();

            $sql = "delete from Order_Detail where order_id=:order_id ";

            $stmt=$dbh->prepare($sql);

            $stmt->bindValue(':order_id',$order_id,PDO::PARAM_STR);
            $stmt->execute();
        
    }
    
    public function member_id_exists(int $member_id)
    {
        $dbh=DAO::get_db_connect();
        $sql="select * from Member where member_id=:memberid";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':memberid',$member_id,PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->fetch() !== false){
            return true;
        }
        else{
            return false;
        }
    }
    public function get_passmember(string $userEmail)
    {
        $dbh=DAO::get_db_connect();
        $sql="select * from member where email=:userEmail";
        $stmt=$dbh->prepare($sql);
        $stmt->bindValue(':userEmail',$userEmail,PDO::PARAM_STR);
        $stmt->execute();

        $member=$stmt->fetchObject('Member');
        if($member !== false){
            if(password_verify($userPassword,$member->password)){
                return $member;
            }
        }

        return false;

    }
    
    
}