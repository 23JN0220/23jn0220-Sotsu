<?php
require_once 'DAO.php';

class CPU_ChipsetSeries
{
    public int $goods_code;
    public int $chipset_id;
}

class CPU_ChipsetSeriesDAO {
    public function get_ChipsetSeries_By_Composition(int $member_id)
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT CPU_ChipsetSeries.goods_code, chipset_id FROM CPU_ChipsetSeries INNER JOIN Composition ON CPU_ChipsetSeries.goods_code = Composition.goods_code WHERE member_id = :member_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('CPU_ChipsetSeries')){
            $data[] = $row;
        }
        return $data;
    }
}
?>