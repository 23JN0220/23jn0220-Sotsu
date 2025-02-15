<?php
require_once 'DAO.php';

class Maker
{
    public int $maker_id;
    public string $maker_name;
}
class MakerDAO
{
    public function get_Maker()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Maker";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Maker')){
            $data[] = $row;
        }
        return $data;
    }
}