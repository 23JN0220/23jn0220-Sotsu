<?php

    $no=$_POST['userPostcode'];

    if(!empty($no)){
    $url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=".$no;    // WebAPIのURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data=curl_exec($ch);
    $json=json_decode($data);
    curl_close($ch);

    //var_dump($json);
    
    if(!is_null($json) and $json->results !== null){

        
            
            $from1=$json->results[0]->address1;
            $from2=$json->results[0]->address2;
            $from3=$json->results[0]->address3;
        

        echo $from1.$from2.$from3;

        
            
    }

    }
?>