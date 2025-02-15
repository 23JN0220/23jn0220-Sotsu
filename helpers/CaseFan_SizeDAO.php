<?php
require_once 'DAO.php';

class CaseFan_Size
{
    public int $size_id;
    public string $size_name;
}
class CaseFan_SizeDAO
{
    public function get_CaseFan_Size()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM CaseFan_Size";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('CaseFan_Size')){
            $data[] = $row;
        }
        return $data;
    }
}