<?php

require_once './helpers/compositioncheckDAO.php';
require_once './helpers/MemberDAO.php';
require_once './helpers/GoodsDAO.php';
require_once './helpers/Goods_MotherBoardDAO.php';
require_once './helpers/Goods_CPUDAO.php';
require_once './helpers/Goods_CoolerDAO.php';
require_once './helpers/Goods_PowerDAO.php';
require_once './helpers/Goods_CaseDAO.php';
require_once './helpers/Goods_FanDAO.php';
require_once './helpers/goods_capacityDAO.php';
require_once './helpers/Cooler_SocketDAO.php';
require_once './helpers/Case_MotherBoard_SizeDAO.php';
require_once './helpers/Goods_SSDDAO.php';
require_once './helpers/CPU_ChipsetSeriesDAO.php';
require_once './helpers/Goods_HDDDAO.php';
require_once './helpers/Goods_GPUDAO.php';
require_once './helpers/Goods_MemoryDAO.php';



if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(empty($_SESSION['member'])){
    header('Location: login.php');
    exit;
}

$member = $_SESSION['member'];
$goodsDAO=new GoodsDAO();
$compositioncheckDAO=new CompositioncheckDAO();
$goodsMotherBoardDAO = new Goods_MotherBoardDAO();
$goodsCPUDAO = new Goods_CPUDAO();
$goodsCoolerDAO=new CPU_CoolerDAO();
$goods_powerDAO=new Goods_PowerDAO();
$goodsFanDAO = new Goods_FanDAO();
#$power_sizeDAO=new Power_SizeDAO();
$goods_caseDAO=new Goods_CaseDAO();
$goods_capacityDAO=new goods_capacityDAO();
$cooler_socketDAO=new Cooler_SocketDAO();
$case_mbsizeDAO=new Case_mbsizeDAO();
$goods_ssdDAO=new Goods_SSDDAO();
$cpu_chipset_seriesDAO = new CPU_ChipsetSeriesDAO();
$goods_hddDAO=new Goods_HDDDAO();
$goods_gpuDAO=new Goods_GPUDAO();
$goods_memoryDAO=new Goods_MemoryDAO();


$composition_list = $compositioncheckDAO->get_composition($member->member_id);

$sum_capacity = 0;
$sum = 0;
foreach($composition_list as $com) : 
    $num = $com->price ;
    $sum += $num;
endforeach;


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['add'])){
        $goodscode=$_POST['goods_code'];
        
        $goods = $goodsDAO->get_goods_by_goodscode($goodscode);

        if ($goods->group_code === 6 OR $goods->group_code === 7) {
            if (!$compositioncheckDAO->composition_exists_storage($member->member_id,$goodscode,$goods->group_code)) {
                $compositioncheckDAO->insert($member->member_id, $goodscode, $goods->group_code);
            }
        }
        else {
            if (!$compositioncheckDAO->composition_exists($member->member_id,$goods->group_code)) {
                $compositioncheckDAO->insert($member->member_id, $goodscode, $goods->group_code);
            }
            else {
                $compositioncheckDAO->update($member->member_id, $goodscode, $goods->group_code);
            }
        }

        $composition_list = $compositioncheckDAO->get_composition($member->member_id);

        $sum = 0;
        foreach($composition_list as $com) : 
            
            $num = $com->price ;
            $sum += $num;
        endforeach;

    }
    else if(isset($_POST['delete'])){
        $goodscode=$_POST['goodscode'];

        $compositioncheckDAO->delete($member->member_id, $goodscode);

        $composition_list = $compositioncheckDAO->get_composition($member->member_id);

        $sum = 0;
        foreach($composition_list as $com) : 
            
            $num = $com->price ;
            $sum += $num;
        endforeach;
    }
    else if(isset($_POST['reset'])){
        $compositioncheckDAO->reset($member->member_id);

        $sum = 0;
    }
    else if(isset($_POST['cartadd'])){
        $composition_list_goodscode = $compositioncheckDAO->get_composition_goodscode($member->member_id);

        $_SESSION['goodscode']=$composition_list_goodscode;
        header('Location: cart.php');
        exit;
    }
    else if((isset($_POST['check']))){
        $composition_category = array_column($composition_list, 'group_code');

        $results=[];
        $errors=[];
        $cnt=0;
        $d=0;

        foreach($composition_category as $groupcode){
            if($groupcode==11 || $groupcode==1 || $groupcode==4 || $groupcode==3 || $groupcode==8 || $groupcode==9){
                $cnt+=1;
            }
            elseif($groupcode==6){
                $d+=1;
            }
            elseif($groupcode==7){
                $d+=1;
            }
        }
        if($cnt==6 && $d>0){
            $results['required']='最低限パソコンに必要なパーツを選択しているので問題ありません。';

            $composition_mb= $composition_list[array_search("3", array_column($composition_list, 'group_code'))];
            $mb_detail=$goodsMotherBoardDAO->getMotherBoard_by_goodscode($composition_mb->goods_code);

            $composition_cpu= $composition_list[array_search("1", array_column($composition_list, 'group_code'))];
            $cpu_detail=$goodsCPUDAO->getCPU_by_goodscode($composition_cpu->goods_code);

            if($mb_detail[0]->socket_id == $cpu_detail[0]->socket_id){
                $results['mbsocket']='CPUとマザーボードの対応しているソケットが一致しているので問題ありません。';
            }
            else{
                $errors['mbsocket']='CPUとマザーボードの対応しているソケットが一致していません。';
            }

            $composition_case= $composition_list[array_search("9", array_column($composition_list, 'group_code'))];

            if(!is_bool(array_search("2", array_column($composition_list, 'group_code')))){
                $composition_cpuCooler= $composition_list[array_search("2", array_column($composition_list, 'group_code'))];
                $cpuCooler_detail=$goodsCoolerDAO->getCPUCooler_by_goodscode($composition_cpuCooler->goods_code);

                $cooler_socket=$cooler_socketDAO->getCooler_sockt($composition_cpuCooler->goods_code);
                
                $ret = false;

                foreach ($cooler_socket as $socket ) {
                    if($socket->socket_id == $cpu_detail[0]->socket_id){
                        $ret = true;
                        break;
                    }
                }

                if ($ret) {
                    $results['clsocket']='CPUクーラーとCPUの対応しているソケットが一致しているので問題ありません。';
                }
                else {
                    $errors['clsocket']='CPUクーラーとCPUの対応しているソケットが一致していません。';
                }

                    
                    $case_detail=$goods_caseDAO->get_goods_by_goodscode($composition_case->goods_code);

                    if($cpuCooler_detail[0]-> cooler_type_id == 2){
                        if($case_detail->water_cooling==1){
                            $results['cltype']='PCケースが水冷対応しているので問題ありません。';
                        }
                        else{
                            $errors['cltype']='PCケースが水冷対応していません。';
                        }
                    }
                    if($cpuCooler_detail[0]->height<=$case_detail[0]->cooler_size){
                        $results['clcase']='PCケースがCPUクーラーのサイズに対応しているので問題ありません。';
                    }
                    else{
                        $errors['clcase']='PCケースのサイズよりCPUクーラーの高さのほうが大きいです。';
                    }
            }
            
            $mbsize=$case_mbsizeDAO->get_Case_Mbsize($composition_case->goods_code);
    
            $ret = false;

            foreach($mbsize as $mbs){
                if($mbs->mother_size_id == $mb_detail[0]->size){
                    $ret=true;
                    break;
                }

            }
            if($ret){
                $results['mbsize']='選択したマザーボードのサイズがPCケースに対応しているので問題ありません。';
            }
            else{
                $errors['mbsize']='選択したマザーボードのサイズがPCケースに対応していません。';
            }

            if(!empty($composition_list[array_search("6", array_column($composition_list, 'group_code'))])){
                $composition_ssd= $composition_list[array_search("6", array_column($composition_list, 'group_code'))];
                $ssd_detail=$goods_ssdDAO->get_SSD_by_goodscode($composition_ssd->goods_code);

                foreach($ssd_detail as $ssd){
                    if($ssd->standard_id == 2){
                        if($ssd->standard_id == $mb_detail[0]->m2ssd_standard_id){
                            $results['m2ssd_standard']='SSDの規格とマザーボードの規格が合っているので問題ありません。';
                        }
                        else{
                            $errors['m2ssd_standard']='SSDの規格とマザーボードの規格が合ってません。';
                            break;
                        }
                    }
                    
                }
                $m2cnt=0;
                $satacnt=0;
                foreach($ssd_detail as $ssd){
                    if($ssd->standard_id == 2){
                        $m2cnt+=1;
                    }
                    else{
                        $satacnt+=1;
                    }
                }
                if($m2cnt<=$mb_detail[0]->m2ssd_number){
                    $results['m2ssd_number']='M.2SSDの最大取り付け数に収まっているので問題ありません。';
                }
                else{
                    $errors['m2ssd_number']='M.2SSDの最大取り付け数に収まっていません。';
                }
            }

            if(!empty($composition_list[array_search("7", array_column($composition_list, 'group_code'))])){
                $composition_hdd= $composition_list[array_search("7", array_column($composition_list, 'group_code'))];
                $hdd_detail=$goods_hddDAO->get_HDD_by_goodscode($composition_hdd->goods_code);

                foreach($hdd_detail as $hdd){
                    $satacnt+=1;
                }
            }

            if($satacnt<=$mb_detail[0]->sata_number){
                $results['sata_number']='SATAの最大ポート数に収まっているので問題ありません。';
            }
            else{
                $errors['sata_number']='SATAの最大ポート数に収まっていません。';
            }

            $composition_memory= $composition_list[array_search("4", array_column($composition_list, 'group_code'))];
            $memory_detail=$goods_memoryDAO->get_memory_by_goodscode($composition_memory->goods_code);

            if($memory_detail[0]->standard_id == $mb_detail[0]->standerd_id){
                $results['m_standard']='メモリの規格とマザーボードの規格が合っているので問題ありません。';
            }
            else{
                $errors['m_standard']='メモリの規格とマザーボードの規格が合ってません。';
            }

            if($memory_detail[0]->number <= $mb_detail[0]->max_number){
                $results['m_number']='メモリの最大枚数を超えていないので問題ありません。';
            }
            else{
                $errors['m_number']='メモリの最大枚数を超えています。';
            }
            
        

            //goods_capacityDAOからmember_idを引数としてgroup_codeを持ってくる
            //$goods_capacity = $goods_capacityDAO->get_power_capacity($member->member_id);

            //var_dump($goods_capacity->group_code);

            //goods_powerDAOからmember_idとgroup_code(8固定)を引数として電源ユニットのサイズを持ってくる
            $goods_power = $goods_powerDAO->get_power_Size_goods($member->member_id,8);

             //goods_caseDAOからmember_idとgroup_code(9固定)を引数としてPCケースのサイズを持ってくる
            $goods_case = $goods_caseDAO->get_power_Size_goods($member->member_id,9);
            
            //電源ユニットとPCケースのサイズが合っていたら文字を表示する
            if($goods_case->power_size_id === $goods_power->size_id){
                $results['power_size'] = '電源のサイズがケースに対応しているので問題ありません。';                    
            }
            else{
                $errors['power_size'] = 'ケースが電源のサイズに合っていません';
            }

            //goods_capacityDAOからmember_idを引数として商品それぞれの電源容量を持ってくる
            $goods_capacity_list = $goods_capacityDAO->get_power_capacity($member->member_id);

            //電源ユニットのワットの値を２で割った数を入れる
            $power_capacity = $goods_power->power_capacity / 2;

            foreach($goods_capacity_list as $goods_capacity){
                $sum_capacity += $goods_capacity->power_consumption;
            }
                if($sum_capacity <= $power_capacity){

                    $results['capacity'] = '電源容量は足りているので問題ありません。';
                }
                else{

                    $errors['capacity'] = '電源容量は足りていません。';

                }
                
                //ここから下がケースファン関連のチェック
                $goods_case_data = $goods_caseDAO->get_Goods_Case_By_Composition($member->member_id);
                $goods_fan_data = $goodsFanDAO->get_casefan_by_composition($member->member_id);

                if(!is_bool($goods_fan_data)) {
                    if ($goods_case_data->fan_size_id === $goods_fan_data->size_id && $goods_case_data->fan_number > $goods_fan_data->quantity) {
                        $results['cfnumber'] = 'ケースファンのサイズ規格はPCケースに適合し、個数も問題ありません。';
                    }
                    else if ($goods_case_data->fan_size_id !== $goods_fan_data->size_id) {
                        $errors['cfnumber'] = 'ケースファンのサイズ規格がPCケースに適合しません。';
                    }
                    else {
                        $errors['cfnumber'] = 'ケースファンの個数がPCケースの最大取り付け数を上回っています。';
                    }
                }

                //ここから下がチップセットのチェック
                $goods_cpu_chipset_data = $cpu_chipset_seriesDAO->get_ChipsetSeries_By_Composition($member->member_id);
                $goods_motherboard_data = $goodsMotherBoardDAO->get_Motherboard_Chipset_By_Composition($member->member_id);
                
                $ret_chipset = false;
                foreach($goods_cpu_chipset_data as $chipset) {
                    if ($chipset->chipset_id === $goods_motherboard_data->chipset_series_id) {
                        $ret_chipset = true;
                        break;
                    }
                }

                if ($ret_chipset) {
                    $results['chipset'] = 'CPUとマザーボードのチップセットがそれぞれ対応しているので問題ありません。';
                }
                else {
                    $errors['chipset'] = 'CPUとマザーボードのチップセットがそれぞれ対応していません。';
                }

                //ここから下がGPU関係のチェック
                $goods_gpu_data = $goods_gpuDAO->get_Goods_GPU_By_Composition($member->member_id);

                if (!is_bool($goods_gpu_data)) {
                    if ($goods_case_data->slot_number >= $goods_gpu_data->slot) {
                        $results['slot'] = 'GPUの必要スロット数はPCケースのスロット数内なので問題ありません。';
                    }
                    else {
                        $errors['slot'] = 'GPUの必要スロット数がPCケースのスロット数を超過しています。';
                    }

                    if ($goods_case_data->gpu_size >= $goods_gpu_data->width) {
                        $results['gpusize'] = 'GPUの横幅サイズはPCケースのGPU最大サイズ内なので問題ありません。';
                    }
                    else {
                        $errors['gpusize'] = 'GPUの横幅サイズがPCケースのGPU最大サイズを超過しています。';
                    }
                }

                

        }
        else{
            $errors['required']='最低限パソコンに必要なパーツが選択されていません。';
        }

    }
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.0-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/koseicheck.css">
    <title>構成チェック</title>
</head>
<body>
<?php include "header.php"; ?>

   <h2>合計 : <?=number_format($sum) ?>円</h2>
   <form action="" method="POST">
   <div class="reset">
        <input type="submit" class="btn btn-primary" name=reset value="リセット">
    </div>
    </form>
   <hr>
   <form action="" method="POST">
   <table border="1">
    <?php $os_list = $compositioncheckDAO->get_composition_category($member->member_id,11); ?>
        <tr>
            <th class="img">
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=11'" value="OS"></p>
                <?php if(!empty($os_list)){ ?> 
                <p>商品画像</p>   
                <p><img src="images/goods/<?= $os_list[0]->goods_image ?>" width="128px" ></p> 
                <?php } ?>
            </th>    
            <th class="price">
                <?php if(!empty($os_list)){ ?>
                <p>価格</p>  
                <p>\<?=number_format($os_list[0]->price)?></p>  
                <?php } ?>
            </th>    
            <th class="detail">
                <?php if(!empty($os_list)){ ?>
                <p>商品詳細</p>
                <a href="goodsreview.php?goods_code=<?=$os_list[0]->goods_code ?>">
                <?=$os_list[0]->goods_name?></p> 
                </a>
                <?php } ?>
            </th>
            <th class="delete">
                <?php if(!empty($os_list)){ ?>
                <input type="hidden" name="goodscode" value="<?= $os_list[0]->goods_code?>">
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
                <?php } ?>
            </th> 
        </tr>
    </table>
    </form>
    <form action="" method="POST">
        <?php $cpu_list = $compositioncheckDAO->get_composition_category($member->member_id,1); ?>
        <table border="1">
        <tr>
            <th class="img">
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=1'" value="CPU"></p>
                <?php if(!empty($cpu_list)){ ?>
                <p>商品画像</p>
                <p><img src="images/goods/<?= $cpu_list[0]->goods_image ?>" width="128px" ></p>  
                <?php } ?>  
            </th>    
            <th class="price">
                <?php if(!empty($cpu_list)){ ?>
                <p>価格</p>
                <p>\<?=number_format($cpu_list[0]->price)?></p>
                <?php } ?>    
            </th>
            <th class="detail">
                <?php if(!empty($cpu_list)){ ?>
                <p>商品詳細</p>
                <a href="goodsreview.php?goods_code=<?=$cpu_list[0]->goods_code ?>">
                <p><?=$cpu_list[0]->goods_name?></p>   
                </a>
                <?php } ?> 
            </th>    
            <th class="delete">
                <?php if(!empty($cpu_list)){ ?>
                <input type="hidden" name="goodscode" value="<?= $cpu_list[0]->goods_code?>">
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
                <?php } ?>
            </th>    
        </tr>
    </table>
    </form>
    <form action="" method="POST">
    <table border="1">
    <?php $cpuCooler_list = $compositioncheckDAO->get_composition_category($member->member_id,2); ?>
        <tr>
            <th class="img">   
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=2'" value="CPUクーラー"></p>
                <?php if(!empty($cpuCooler_list)){ ?>
                <p>商品画像</p>    
                <p><img src="images/goods/<?= $cpuCooler_list[0]->goods_image ?>" width="128px" ></p> 
                <?php } ?>
            </th>    
            <th class="price">
                <?php if(!empty($cpuCooler_list)){ ?>
                <p>価格</p>    
                <p>\<?=number_format($cpuCooler_list[0]->price)?></p>
                <?php } ?>
            </th>   
            <th class="detail">
                <?php if(!empty($cpuCooler_list)){ ?>
                <p>商品詳細</p>  
                <a href="goodsreview.php?goods_code=<?=$cpuCooler_list[0]->goods_code ?>">
                <p><?=$cpuCooler_list[0]->goods_name?></p>  
                </a>
                <?php } ?>
            </th>
            <th class="delete">
                <?php if(!empty($cpuCooler_list)){ ?>
                <input type="hidden" name="goodscode" value="<?= $cpuCooler_list[0]->goods_code?>">
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
                <?php } ?>
            </th>    
        </tr>
    </table>
    </form>
    <form action="" method="POST">
    <?php $memory_list = $compositioncheckDAO->get_composition_category($member->member_id,4); ?>
    <table border="1">
        <tr>
            <th class="img">                
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=4'" value="メモリ"></p>
                <?php if(!empty($memory_list)){ ?>
                <p>商品画像</p> 
                <p><img src="images/goods/<?= $memory_list[0]->goods_image ?>" width="128px" ></p> 
                <?php } ?>
            </th>    
            <th class="price">
                <?php if(!empty($memory_list)){ ?>
                <p>価格</p>
                <p>\<?=number_format($memory_list[0]->price)?></p>
                <?php } ?>    
            </th>   
            <th class="detail">
                <?php if(!empty($memory_list)){ ?>
                <p>商品詳細</p>
                <a href="goodsreview.php?goods_code=<?=$memory_list[0]->goods_code ?>">
                <p><?=$memory_list[0]->goods_name?></p> 
                </a> 
                <?php } ?> 
            </th>
            <th class="delete">
                <?php if(!empty($memory_list)){ ?>
                <input type="hidden" name="goodscode" value="<?= $memory_list[0]->goods_code?>">
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
                <?php } ?>
            </th>    
        </tr>
    </table>
    </form>
    <form action="" method="POST">
    <table border="1">
    <?php $mb_list = $compositioncheckDAO->get_composition_category($member->member_id,3); ?>
        <tr>
            <th class="img">
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=3'" value="マザーボード"></p>
                <?php if(!empty($mb_list)){ ?> 
                <p>商品画像</p>
                <p><img src="images/goods/<?= $mb_list[0]->goods_image ?>" width="128px" ></p> 
                <?php } ?>
            </th>    
            <th class="price">
                <?php if(!empty($mb_list)){ ?>
                <p>価格</p> 
                <p>\<?=number_format($mb_list[0]->price)?></p>  
                <?php } ?>
            </th>    
            <th class="detail">
                <?php if(!empty($mb_list)){ ?>
                <p>商品詳細</p>
                <a href="goodsreview.php?goods_code=<?=$mb_list[0]->goods_code ?>">
                <?=$mb_list[0]->goods_name?></p> 
                </a>
                <?php } ?>
            </th>
            <th class="delete">
                <?php if(!empty($mb_list)){ ?>
                <input type="hidden" name="goodscode" value="<?= $mb_list[0]->goods_code?>">
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
                <?php } ?>
            </th> 
        </tr>
    </table>
    </form>
    <form action="" method="POST">
    <table border="1">
    <?php $gpu_list = $compositioncheckDAO->get_composition_category($member->member_id,5); ?>
        <tr>
            <th class="img">
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=5'" value="GPU"></p>
                <?php if(!empty($gpu_list)){ ?>
                <p>商品画像</p>
                <p><img src="images/goods/<?= $gpu_list[0]->goods_image ?>" width="128px" ></p> 
                <?php } ?>
            </th>    
            <th class="price">
                <?php if(!empty($gpu_list)){ ?>
                <p>価格</p>    
                <p>\<?=number_format($gpu_list[0]->price)?></p>
                <?php } ?>
            </th>    
            <th class="detail">
                <?php if(!empty($gpu_list)){ ?>
                <p>商品詳細</p>
                <a href="goodsreview.php?goods_code=<?=$gpu_list[0]->goods_code ?>">
                <p><?=$gpu_list[0]->goods_name?></p>
                </a>
                <?php } ?>
            </th>
            <th class="delete">
                <?php if(!empty($gpu_list)){ ?>
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
                <input type="hidden" name="goodscode" value="<?= $gpu_list[0]->goods_code?>">
                <?php } ?>
            </th>    
        </tr>
    </table>
    </form>
    <?php $ssd_list = $compositioncheckDAO->get_composition_category($member->member_id,6); ?>
    <?php if (count($ssd_list) === 0) :?>
    <form action="" method="POST">
    <table border="1">
        <tr>
            <th class="img">  
            <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=6'" value="SSD"></p>
            </th>    
            <th class="price">
            </th> 
            <th class="detail">
            </th>
            <th class="delete">
            </th>
        </tr>
    </table>
    </form>
    <?php else: ?>
    <?php foreach ($ssd_list as $ssd): ?>
    <form action="" method="POST">
    <table border="1">
        <tr>
            <th class="img">
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=6'" value="SSD"></p>
                <?php if(!empty($ssd)){ ?>
                <p>商品画像</p>   
                <p><img src="images/goods/<?= $ssd->goods_image ?>" width="128px" ></p> 
                <?php } ?>
            
            </th>    
            <th class="price">
                <?php if(!empty($ssd)){ ?>
                <p>価格</p>  
                <p>\<?=number_format($ssd->price)?></p>
                <?php } ?>  
            </th> 
            <th class="detail">
                <?php if(!empty($ssd)){ ?>
                <p>商品詳細</p>
                <a href="goodsreview.php?goods_code=<?=$ssd->goods_code ?>">
                <p><?=$ssd->goods_name?></p>
                </a>
                <?php } ?>
            </th>
            <th class="delete">
                <?php if(!empty($ssd)){ ?>
                <input type="hidden" name="goodscode" value="<?= $ssd->goods_code?>">
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
                <?php } ?>
            </th>
        </tr>
    </table>
    </form>
    <?php endforeach; ?>
    <?php endif ?>
    <?php $hdd_list = $compositioncheckDAO->get_composition_category($member->member_id,7); ?>
    <?php if (count($hdd_list) === 0) : ?>
        <form action="" method="POST">
        <table border="1">
        <tr>
            <th class="img">
            <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=7'" value="HDD"></p>
            </th>    
            <th class="price">
            </th> 
            <th class="detail">
            </th>
            <th class="delete">
            </th>    
        </tr>
    </table>
    </form>
    <?php else : ?>
    <?php foreach($hdd_list as $hdd):?>
    <form action="" method="POST">
    <table border="1">
        <tr>
            <th class="img">
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=7'" value="HDD"></p>
                <?php if(!empty($hdd)){ ?>
                <p>商品画像</p>     
                <p><img src="images/goods/<?= $hdd->goods_image ?>" width="128px" ></p> 
                <?php } ?>   
            </th>    
            <th class="price">
                <?php if(!empty($hdd)){ ?>
                <p>価格</p>    
                <p>\<?=number_format($hdd->price)?></p>
                <?php } ?>
            </th> 
            <th class="detail">
                <?php if(!empty($hdd)){ ?>
                <p>商品詳細</p>
                <a href="goodsreview.php?goods_code=<?=$hdd->goods_code ?>">
                <p><?=$hdd->goods_name?></p>
                </a>
                <?php } ?>
            </th>
            <th class="delete">
            <?php if(!empty($hdd)){ ?>
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
                <input type="hidden" name="goodscode" value="<?= $hdd->goods_code?>">
                <?php } ?>
            </th>    
        </tr>
    </table>
    </form>
    <?php endforeach;?>
    <?php endif ?>
    <form action="" method="POST">
    <table border="1">
    <?php $power_list = $compositioncheckDAO->get_composition_category($member->member_id,8); ?>
        <tr>
            <th class="img">
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=8'" value="電源"></p>
                <?php if(!empty($power_list)){ ?>
                <p>商品画像</p>  
                <p><img src="images/goods/<?= $power_list[0]->goods_image ?>" width="128px" ></p>  
                <?php } ?>
            </th>    
            <th class="price">
                <?php if(!empty($power_list)){ ?>    
                <p>価格</p>  
                <p>\<?=number_format($power_list[0]->price)?></p>  
                <?php } ?>
            </th>    
            <th class="detail">
                <?php if(!empty($power_list)){ ?>
                <p>商品詳細</p>
                <a href="goodsreview.php?goods_code=<?=$power_list[0]->goods_code ?>">
                <?=$power_list[0]->goods_name?></p> 
                </a>
                <?php } ?>
            </th>
            <th class="delete">
            <?php if(!empty($power_list)){ ?>
                <input type="hidden" name="goodscode" value="<?= $power_list[0]->goods_code?>">
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
            <?php } ?>
            </th>    
        </tr>
    </table>
    </form>
    <form action="" method="POST">
    <table border="1">
    <?php $pccase_list = $compositioncheckDAO->get_composition_category($member->member_id,9); ?>
        <tr>
            <th class="img">
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=9'" value="PCケース"></p>
                <?php if(!empty($pccase_list)){ ?>
                <p>商品画像</p>  
                <p><img src="images/goods/<?= $pccase_list[0]->goods_image ?>" width="128px" ></p>  
                <?php } ?>
            </th>    
            <th class="price">
                <?php if(!empty($pccase_list)){ ?>    
                <p>価格</p>  
                <p>\<?=number_format($pccase_list[0]->price)?></p>  
                <?php } ?>
            </th>    
            <th class="detail">
                <?php if(!empty($pccase_list)){ ?>
                <p>商品詳細</p>
                <a href="goodsreview.php?goods_code=<?=$pccase_list[0]->goods_code ?>">
                <?=$pccase_list[0]->goods_name?></p> 
                </a>
                <?php } ?>
            </th>
            <th class="delete">
            <?php if(!empty($pccase_list)){ ?>
                <input type="hidden" name="goodscode" value="<?= $pccase_list[0]->goods_code?>">
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
            <?php } ?>
            </th>    
        </tr>
    </table>
    </form>
    <form action="" method="POST">
    <table border="1">
    <?php $casefan_list = $compositioncheckDAO->get_composition_category($member->member_id,10); ?>
        <tr>
            <th class="img">
                <p><input type="button" class="btn btn-primary" onclick="location.href='list.php?cate=10'" value="ケースファン"></p>
                <?php if(!empty($casefan_list)){ ?>
                <p>商品画像</p>   
                <p><img src="images/goods/<?= $casefan_list[0]->goods_image ?>" width="128px" ></p>  
                <?php } ?> 
            </th>    
            <th class="price">
                <?php if(!empty($casefan_list)){ ?>
                <p>価格</p> 
                <p>\<?=number_format($casefan_list[0]->price)?></p>  
                <?php } ?>   
            </th>    
            <th class="detail">
                <?php if(!empty($casefan_list)){ ?>
                <p>商品詳細</p>
                <a href="goodsreview.php?goods_code=<?=$casefan_list[0]->goods_code ?>">
                <?=$casefan_list[0]->goods_name?></p> 
                </a>
                <?php } ?>
            </th>        
            <th class="delete">
                <?php if(!empty($casefan_list)){ ?>
                <input type="hidden" name="goodscode" value="<?= $casefan_list[0]->goods_code?>">
                <input type="submit" class="btn btn-primary" name="delete" value="削除">
                <?php } ?>
            </th>    
        </tr>
    </table>
    </form>

    <form action="" method="POST">
    <div class="buttons">
        <input type="submit" id="btn1" class="btn btn-primary" name="check" value="構成チェック">
        <input type="submit" id="btn2" class="btn btn-primary" name="cartadd"  value="まとめてカートに入れる">
    </div>
    <table height="300" class="result" border="1">
        <tr>
            <th>
                <p>構成チェック結果</p>
                <span style="color:black"><?= @$results['required'] ?></span><br>
                <span style="color:red"><?= @$errors['required'] ?></span><br>
                <span style="color:black"><?= @$results['mbsocket'] ?></span><br>
                <span style="color:red"><?= @$errors['mbsocket'] ?></span><br>
                <span style="color:black"><?= @$results['clsocket'] ?></span><br>
                <span style="color:red"><?= @$errors['clsocket'] ?></span><br>
                <span style="color:black"><?= @$results['cltype'] ?></span><br>
                <span style="color:red"><?= @$errors['cltype'] ?></span><br>
                <span style="color:black"><?= @$results['clcase'] ?></span><br>
                <span style="color:red"><?= @$errors['clcase'] ?></span><br>
                <span style="color:black"><?= @$results['mbsize'] ?></span><br>
                <span style="color:red"><?= @$errors['mbsize'] ?></span><br>
                <span style="color:black"><?= @$results['m2ssd_standard'] ?></span><br>
                <span style="color:red"><?= @$errors['m2ssd_standard'] ?></span><br>
                <span style="color:black"><?= @$results['m2ssd_number'] ?></span><br>
                <span style="color:red"><?= @$errors['m2ssd_number'] ?></span><br>
                <span style="color:black"><?= @$results['sata_number'] ?></span><br>
                <span style="color:red"><?= @$errors['sata_number'] ?></span><br>
                <span style="color:black"><?= @$results['m_standard'] ?></span><br>
                <span style="color:red"><?= @$errors['m_standard'] ?></span><br>
                <span style="color:black"><?= @$results['m_number'] ?></span><br>
                <span style="color:red"><?= @$errors['m_number'] ?></span><br>
                <span style="color:black"><?= @$results['power_size'] ?></span><br>
                <span style="color:red"><?= @$errors['power_size'] ?></span><br>
                <span style="color:black"><?= @$results['capacity'] ?></span><br>
                <span style="color:red"><?= @$errors['capacity'] ?></span><br>
                <span style="color:black"><?= @$results['cfnumber'] ?></span><br>
                <span style="color:red"><?= @$errors['cfnumber'] ?></span><br>
                <span style="color:black"><?= @$results['chipset'] ?></span><br>
                <span style="color:red"><?= @$errors['chipset'] ?></span><br>
                <span style="color:black"><?= @$results['slot'] ?></span><br>
                <span style="color:red"><?= @$errors['slot'] ?></span><br>
                <span style="color:black"><?= @$results['gpusize'] ?></span><br>
                <span style="color:red"><?= @$errors['gpusize'] ?></span><br>
                
            </th>
        </tr>
    </table>
    </form>
    <?php include "footer.php"; ?>
</body>
</html>