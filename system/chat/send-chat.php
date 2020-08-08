<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once('../../connect.php');
$chat_to = $_POST['chat-from'];
$chat = $_POST['chat-edit'];

function fungsi($to = null, $chat = null)
{
    require_once('../../connect.php');
    $query = $con->prepare("INSERT into chat_detail(id_chat_from,id_chat_to,chat) values('admin','$to','$chat')");
    $query->execute();
    $query = $con->prepare("UPDATE chat set is_baca_admin = 0, created_at=date('Y-m-d H:i:s') where username = '$to' ");
    $query->execute();
    $query = $con->prepare("UPDATE chat set is_baca_user = 1, created_at=date('Y-m-d H:i:s') where username = '$to'");
    $query->execute();
}



// require '../../vendor/autoload.php';
require '../../vendor/autoload.php';

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;


//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();
$mail->isHTML(true);

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
// $mail->Host = 'smtp.gmail.com';
$mail->Host = 'smtp.mail.yahoo.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 465;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "csababil@yahoo.com";

//Password to use for SMTP authentication
$mail->Password = "bojongbogo2013";

//Set who the message is to be sent from
$mail->setFrom('csababil@yahoo.com', 'Admin PO Ababil Travel');

//Set an alternative reply-to address
// $mail->addReplyTo('mzq100m@gmail.com', 'First Last');

$query = $con->query("select * from pelanggan where pelanggan='$chat_to' ");
$data = $query->fetch_assoc();
//Set who the message is to be sent to
$mail->addAddress($data['email']);

//Set the subject line
$mail->Subject = 'Chat';

// Mail Body


$root  = "http://" . $_SERVER['HTTP_HOST'];
$root .= str_replace('chat/' . basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$mail->Body = 'chat : ' . $chat . '<br><a href="' . $root . '">Klik disini untuk membalas chat</a>';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

//Replace the plain text body with one created manually
$mail->AltBody = '';

//Attach an image file
// $mail->addAttachment('images/phpmailer_mini.png');

echo $root;

//send the message, check for errors
if (!$mail->send()) {
    echo json_encode($mail->ErrorInfo);
} else {
    fungsi($chat_to, $chat);
    echo json_encode(['message' => "Message sent!"]);
}
