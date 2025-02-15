<?php
require_once 'DAO.php';

class GPU_Series
{
    public int $gpu_series_id;
    public string $gpu_series_name;
}
class GPU_SeriesDAO
{
    public function get_GPU_Series()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM GPU_Series";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('GPU_Series')){
            $data[] = $row;
        }
        return $data;
    }
}