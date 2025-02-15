<?php
require_once 'DAO.php';

class Case_mbsize
{
    public int $mother_size_id;
}
class Case_mbsizeDAO
{
    public function get_Case_Mbsize(int $goods_code)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT mother_size_id FROM Case_Motherboard_Size WHERE goods_code = :goods_code";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('goods_code',$goods_code,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Case_mbsize')){
            $data[] = $row;
        }
        return $data;
    }
}