<?php
header("Content-type: application/json; charset=utf-8");
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$mail->CharSet = 'utf-8';

//Server settings
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host = 'smtp.mail.ru';                  //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'alekseitest@mail.ru';                     //SMTP username
$mail->Password = '123123test';                                //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above


$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$textarea = $_POST['textarea'];

//Recipients
$mail->setFrom('alekseitest@mail.ru');
$mail->addAddress('dm-grig@mail.ru');    // Кому будет уходить письмо 


//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Письмо от ' .$name;
$mail->Body    = `имя:` .$name. '<br> телефон: ' .$phone. '<br> E-mail: ' .$email. '<br> Сообщение: ' .$textarea;


if (!$mail->send()) {
	$message = 'ваше письмо НЕ было отправленно';  
} else {
 	$message = 'ваше письмо отправленно';
};

$response = ['message' => $message];
echo json_encode($response);

