<?php
require_once 'DAO.php';

class Category_Group
{
    public int $group_code;
    public string $group_name;
}
class Category_GroupDAO
{
    public function get_Category_Group()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM Category_Group";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Category_Group')){
            $data[] = $row;
        }
        return $data;
    }
}