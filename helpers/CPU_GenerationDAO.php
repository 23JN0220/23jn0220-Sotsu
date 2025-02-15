<?php
require_once 'DAO.php';

class CPU_Generation
{
    public int $generation_id;
    public string $generation_name;
}
class CPU_GenerationDAO
{
    public function get_CPU_Generation()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CPU_Generation";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('CPU_Generation')){
            $data[] = $row;
        }
        return $data;
    }
}