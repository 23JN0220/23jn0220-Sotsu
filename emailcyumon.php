<?php
require_once './helpers/MemberDAO.php';
require_once './helpers/CartDAO.php';
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
if(empty($_SESSION['member'])){
    header('Location: top.php');
    exit;
}
if (isset($_SESSION['email'])) {
        $email=$_SESSION['email'];
        //var_dump($email);
    }
   
    else  {
    $member=$_SESSION['member'];
    $email=$member->email;
    }
    if(isset($_SESSION['konbini'])){

        $konbini = $_SESSION['konbini'];

    }else{
        $konbini = NULL;
    }
    
    if(isset($_SESSION['credit_card'])){


        $credit_card = $_SESSION['credit_card'];

    }
// PHPでメールを送信するサンプルプログラムです。
// PHPMailerというライブラリを使用します。
// ★の部分を適宜変更して下さい。
//
// 参考：PHPMailerでメールをSTMP送信する： https://qiita.com/e__ri/items/857b12e73080019e00b5

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// PHPMailerの読み込みパス
require('src/PHPMailer.php');
require('src/Exception.php');
require('src/SMTP.php');

// 文字エンコードを指定
mb_language('uni');
mb_internal_encoding('UTF-8');

// インスタンスを生成（true指定で例外を有効化）
$mail = new PHPMailer(true);

// 文字エンコードを指定
$mail->CharSet = 'utf-8';
$min =10000;
$max =99999;
$key=rand($min,$max);
$_SESSION['key']=$key;
$member = $_SESSION['member'];


    $memberId = $member->member_id;
    $memberName = $member->member_name;
    $email = $member->email;
    $zipcode = $member->zip_code;
    $address = $member->address;
    $tel = $member->tel; 
    $member = $_SESSION['member'];
    $zipcode = $_SESSION['zip_code'];
    $address = $_SESSION['address'];
    $any = $_SESSION['any'];
    $convinience_store=$_SESSION['convinience_store'];
    $cartDAO=new CartDAO();
    $cart_list = $cartDAO->get_cart_by_memberid($member->member_id);

    //var_dump($cart_list);
 
try {
    // SMTPサーバの設定
    $mail->isSMTP();                          // SMTPの使用宣言
    $mail->Host       = 'smtp.gmail.com';     // SMTPサーバーを指定
    $mail->SMTPAuth   = true;                 // SMTP authenticationを有効化
    $mail->Username   = 'emailsotsuweb0220@gmail.com';   // 自分の学校メールアドレス★
    $mail->Password   = 'dfkmfcdrvcbliams';           // Gmailパスワード★
    $mail->SMTPSecure = 'ssl';                // 暗号化を有効（tls or ssl）無効の場合はfalse
    $mail->Port       = 465;                  // TCPポートを指定（tlsの場合は465や587）

    // 送受信先設定（第2引数は省略可）
    $mail->setFrom('emailsotsuweb0220@gmail.com', 'ぱーつたろう');              // 送信者（省略可）★
    $mail->addAddress($email, '');         // 宛先1★
    // $mail->addAddress('XXXXXX@example.com', '受信者名');      // 宛先2
    // $mail->addReplyTo('replay@example.com', 'お問い合わせ');  // 返信先
    // $mail->addCC('cc@example.com', '受信者名');               // CC宛先
    // $mail->addBCC('bcc@example.com');                        // BCC宛先

    // 送信内容設定（プレーンテキスト用）

    $price = 0;
    $number_total=0;
    $postage = 360;
    $mail->Subject = 'ご注文ありがとうございます';
    $mail->Body    =  $memberName .'様ご購入ありがとうございます'."\n".
                     '注文内容の確認'."\n";

                     foreach($cart_list as $cart) {

                            $mail->Body.= $cart->goods_name.
                            ' 数量' .$cart->number."\n".
                            ' 値段￥'.number_format($cart->price)."\n";
                    
                        $number_total += $cart->number;
                        $total = $cart->price * $cart->number;
                        $price += $total;
                    }
    $mail->Body   .=        '商品合計'.$number_total.'個'."\n".
                            '送料 ￥ '.$postage."\n".
                            '合計 ￥ ' . $price + $postage ."\n".
                            'お届け先'."\n".
       
                            'お名前 :'.  $member->member_name.'様'."\n".
                            '住所 :'. $zipcode .$address. " " .$any."\n". 
                            '電話番号 :' .$tel."\n".
                            '支払い方法:';
    if(!isset($konbini)){
        $mail->Body   .= $credit_card;
    }else{
        $mail->Body   .=$konbini;
    };
               

    // HTMLメール用
    // $mail->isHTML(true);                 // HTMLメール
    // $mail->Subject = '件名';
    // $mail->Body    = ' HTML形式の本文 <b>太字</b>';

    // 添付ファイル
  

    // 送信
    $mail->send();
    if(empty($_SESSION['member'])){
        
        
        header('Location: kounyuukanryou.php');
      
              exit;
        
    }
    else{
        header('Location: kounyuukanryou.php');
              exit;   
    }
       
}
catch (Exception $e) {
    // エラーの場合
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}