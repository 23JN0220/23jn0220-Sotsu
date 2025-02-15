<?php
require_once 'DAO.php';

class Motherboard_Chipset
{
    public int $chipset_id;
    public string $chipset_name;
}
class Motherboard_ChipsetDAO
{
    public function get_Motherboard_Chipset()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Motherboard_Chipset";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Motherboard_Chipset')){
            $data[] = $row;
        }
        return $data;
    }
}