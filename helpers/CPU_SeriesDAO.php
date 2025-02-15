<?php
require_once 'DAO.php';

class CPU_Series
{
    public int $series_id;
    public string $series_name;
}
class CPU_SeriesDAO
{
    public function get_CPU_Series()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CPU_Series";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('CPU_Series')){
            $data[] = $row;
        }
        return $data;
    }
}