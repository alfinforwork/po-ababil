<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once('../../../connect.php');
session_start();

$email = $_SESSION['email'];
$query = $con->query("select * from pelanggan where email='$email' ");
$data = $query->fetch_assoc();

$chat_from = $data['pelanggan'];

$chat = $_POST['chat-edit'];
$query = $con->prepare("INSERT into chat_detail(id_chat_from,id_chat_to,chat) values('$chat_from','admin','$chat')");
$query->execute();
$query = $con->prepare("UPDATE chat set is_baca_admin = 1, created_at=date('Y-m-d H:i:s') where username = '$chat_from' ");
$query->execute();
$query = $con->prepare("UPDATE chat set is_baca_user = 0, created_at=date('Y-m-d H:i:s') where username = '$chat_from'");
$query->execute();





//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;

// require 'phpmailer/vendor/autoload.php';
require '../../../vendor/autoload.php';


//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();
$mail->isHTML(true);

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'mail.poababil.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 465;
// $mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'ssl';
// $mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
// $mail->Username = "ababil.transs@gmail.com";
$mail->Username = "ababiladmin@poababil.com";

//Password to use for SMTP authentication
// $mail->Password = "ababiltrans2013";
$mail->Password = "poababil2013";

//Set who the message is to be sent from
$mail->setFrom($email, $data['pelanggan']);

//Set an alternative reply-to address
// $mail->addReplyTo('mzq100m@gmail.com', 'First Last');

//Set who the message is to be sent to
$mail->addAddress('ababiladmin@poababil.com', 'Admin PO Ababil Travel');

//Set the subject line
$mail->Subject = 'Chat';

// Mail Body


$root  = "http://" . $_SERVER['HTTP_HOST'];
$root .= str_replace('chat/user/' . basename($_SERVER['SCRIPT_NAME']), "chat.php", $_SERVER['SCRIPT_NAME']);
$mail->Body = 'chat : ' . $chat . '<br><a href="' . $root . '">Klik disini untuk membalas chat</a>';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

//Replace the plain text body with one created manually
$mail->AltBody = '';

//Attach an image file
// $mail->addAttachment('images/phpmailer_mini.png');

// echo $root;

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
