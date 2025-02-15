<?php
require_once 'DAO.php';

class Motherboard_size
{
    public int $size_id;
    public string $size_name;
}
class Motherboard_sizeDAO
{
    public function get_Motherboard_size()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Motherboard_size";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Motherboard_size')){
            $data[] = $row;
        }
        return $data;
    }
}