<?php
require_once 'DAO.php';

class SSD_Standard
{
    public int $standard_id;
    public string $standard_name;
}
class SSD_StandardDAO
{
    public function get_SSD_Standard()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM SSD_Standard";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('SSD_Standard')){
            $data[] = $row;
        }
        return $data;
    }
}