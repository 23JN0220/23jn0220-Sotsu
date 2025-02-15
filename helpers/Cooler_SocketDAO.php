<?php
require_once 'DAO.php';

class Cooler_Socket
{
    public int $socket_id;
}
class Cooler_SocketDAO
{
    
    public function getCooler_sockt(int $goods_code){
        $dbh = DAO::get_db_connect();

        $sql = "SELECT socket_id FROM Cooler_Socket WHERE goods_code = :goods_code";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('goods_code',$goods_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Cooler_Socket')){
            $data[] = $row;
        }
        return $data;
    }
   
}