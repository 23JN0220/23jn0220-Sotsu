<?php
require_once 'DAO.php';

class OS_Version
{
    public int $version_id;
    public string $varsion_name;
}
class OS_VersionDAO
{
    public function get_OS_Version()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM OS_Version";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('OS_Version')){
            $data[] = $row;
        }
        return $data;
    }
}