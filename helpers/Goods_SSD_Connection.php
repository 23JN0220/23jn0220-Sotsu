<?php
require_once 'DAO.php';

class SSD_Connection
{
    public int $standard_id;
    public string $standard_name;
}
class SSD_ConnectionDAO
{
    public function get_SSD_Connection()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM SSD_Connection";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('SSD_Connection')){
            $data[] = $row;
        }
        return $data;
    }
}