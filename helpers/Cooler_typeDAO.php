<?php
require_once 'DAO.php';

class Cooler_Type
{
    public int $cooler_type_id;
    public string $cooler_type_name;
}
class Cooler_TypeDAO
{
    public function get_Cooler_Type()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Cooler_Type";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Cooler_Type')){
            $data[] = $row;
        }
        return $data;
    }
}