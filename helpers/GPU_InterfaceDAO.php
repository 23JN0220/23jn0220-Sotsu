<?php
require_once 'DAO.php';

class GPU_Interface
{
    public int $interface_id;
    public string $interface_name;
}
class GPU_InterfaceDAO
{
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
}