<?php
require_once 'DAO.php';

class CPU_Socket
{
    public int $socket_id;
    public string $socket_name;
}
class CPU_SocketDAO
{
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
}