<?php
require_once 'DAO.php';

class Memory_Standard
{
    public int $standard_id;
    public string $standard_name;
}
class Memory_StandardDAO
{
    public function get_Memory_Standard()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Memory_Standard";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Memory_Standard')){
            $data[] = $row;
        }
        return $data;
    }
}