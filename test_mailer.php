<?php
//include_once('config.php');
require('library/PHPMailerV2/PHPMailer.php');
require('library/PHPMailerV2/SMTP.php');
require('library/PHPMailerV2/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

define("mail_server","smtp.gmail.com");
define("mail_login_name","bloomami2022@gmail.com");
define("mail_login_pass", "owectxuwfbapejsn");
define("smtp_port","465");
define("config_mailFrom","bloomami2022@gmail.com");
define("config_mailFromName","Babyin 印鑑工坊");


$mail= new PHPMailer(true);
$mail->IsSMTP();
$mail->SMTPAuth = SMTP::DEBUG_SERVER;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Encoding  = "base64";
$mail->Host = mail_server;
$mail->Port = smtp_port;
$mail->CharSet = "UTF-8";
$mail->Username = mail_login_name;
$mail->Password = mail_login_pass;
$mail->From = config_mailFrom;
$mail->FromName = config_mailFromName;
$mail->IsHTML(true);

$to = 'renfu.her@gmail.com';
$cc = '';
$bcc = '';
$subject = 'Test';
// $mail             = new PHPMailer(); // defaults to using php "mail()"
// $mail->IsSMTP(); // telling the class to use SMTP
// $mail->SetLanguage("zh");
// $mail->Host     = mail_server;
// $mail->Mailer   = "SMTP";
// $mail->CharSet = "UTF-8";
// $mail->Encoding  = "base64";
// $mail->SMTPAuth   = false;                  // enable SMTP authentication
// $mail->Username   = mail_login_name;  // GMAIL username
// $mail->Password   = mail_login_pass;            // GMAIL password
// $mail->Port       = smtp_port;
// $mail->From       = mail_login_name;
// $mail->FromName   = mail_login_name;

$mail->Subject    = "=?UTF-8?B?" . base64_encode($subject) . "?=";
$mail->SMTPDebug = 1;
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->MsgHTML('test');
//$mail->AddAttachment($path, $name);

var_dump($mail);
exit;
$toemail = explode (";", $to.";");
foreach($toemail as $email){
    if(strlen($email)>1)
        $mail->AddAddress($email,$email);
}

$bccemail = explode (";", $bcc.";");
foreach($bccemail as $email){
    if(strlen($email)>1)
        // $mail->addCustomHeader("BCC: ".$email);
        $mail->AddBCC($email,$email);
}

$ccemail = explode (";", $cc.";");
foreach($ccemail as $email){
    if(strlen($email)>1)
        $mail->AddCC($email,$email);
}


$mail->IsHTML(true); // send as HTML

//$mail->AddAttachment("images/phpmailer.gif");             // attachment
//
var_dump($mail->Send());
exit;
