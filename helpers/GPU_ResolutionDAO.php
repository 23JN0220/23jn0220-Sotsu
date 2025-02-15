<?php
require_once 'DAO.php';

class GPU_Resolution
{
    public int $resolution_id;
    public string $resolution_name;
}
class GPU_ResolutionDAO
{
    public function get_GPU_Resolution()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM GPU_Resolution";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('GPU_Resolution')){
            $data[] = $row;
        }
        return $data;
    }
}