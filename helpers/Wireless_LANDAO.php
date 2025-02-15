<?php
require_once 'DAO.php';

class Wireless_LAN
{
    public int $lan_id;
    public string $lan_name;
}
class Wireless_LANDAO
{
    public function get_Wireless_LAN()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Wireless_LAN";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Wireless_LAN')){
            $data[] = $row;
        }
        return $data;
    }
}