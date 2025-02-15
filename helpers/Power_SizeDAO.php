<?php
require_once 'DAO.php';

class Power_Size
{
    public int $size_id;
    public string $size_name;
}
class Power_SizeDAO
{
    public function get_Power_Size()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Power_Size";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Power_Size')){
            $data[] = $row;
        }
        return $data;
    }
}