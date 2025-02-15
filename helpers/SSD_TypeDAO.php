<?php
require_once 'DAO.php';

class SSD_Type
{
    public int $type_id;
    public string $type_name;
}
class SSD_TypeDAO
{
    public function get_SSD_Type()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM SSD_Type";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('SSD_Type')){
            $data[] = $row;
        }
        return $data;
    }
}