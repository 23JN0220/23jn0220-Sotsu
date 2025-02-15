<?php
require_once 'DAO.php';

class ChipsetSeries
{
    public int $series_id;
    public string $series_name;
}
class ChipsetSeriesDAO
{
    public function get_ChipsetSeries()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM ChipsetSeries";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('ChipsetSeriese')){
            $data[] = $row;
        }
        return $data;
    }
}