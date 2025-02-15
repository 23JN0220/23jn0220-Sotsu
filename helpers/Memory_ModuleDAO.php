<?php
require_once 'DAO.php';

class Memory_Module
{
    public int $module_id;
    public string $module_name;
}
class Memory_ModuleDAO
{
    public function get_Memory_Module()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Memory_Module";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Memory_Module')){
            $data[] = $row;
        }
        return $data;
    }
}