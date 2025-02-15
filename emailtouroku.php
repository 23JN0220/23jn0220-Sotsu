<?php
ob_start();
require_once './helpers/MemberDAO.php';

if(session_status() === PHP_SESSION_NONE){
    session_start();
}
if (isset($_SESSION['email'])) {
        $email=$_SESSION['email'];
        //var_dump($email);
    }
   
    else  {
    $member=$_SESSION['member'];
    $email=$member->email;
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
if(empty($_SESSION['email'])){
    header('Location: top.php');
    exit;
}
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
    $mail->Subject = '認証コード';
    $mail->Body    =  $key;
    

    // HTMLメール用
    // $mail->isHTML(true);                 // HTMLメール
    // $mail->Subject = '件名';
    // $mail->Body    = ' HTML形式の本文 <b>太字</b>';

    // 添付ファイル
  

    // 送信
    $mail->send();
  
        ob_end_clean();
        header('Location:ninnsyoucodenyuuryokutouroku.php');
        $email=$_POST['userEmail'];
      
              exit;
        
}
catch (Exception $e) {
    // エラーの場合
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
