
<!-- Script PHPMailer que vai possibilitar o envio de um email de confirmação sempre que necessário -->

<?php

$op = $_GET['op'];
$mailDestino = $_GET['email'];

if($op=='inserido'){
    $sms = "Informamos que a sua consulta foi marcada com sucesso!<br>Muito obrigado.";
}else if($op=='eliminado'){
    $sms = "Informamos que a sua consulta foi eliminada com sucesso!<br>Esperamos que volte em breve.";
}else if($op=='atualizado'){
    $sms = "Informamos que a sua consulta foi alterada com sucesso!<br>Muito obrigado.";
}

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Username = 'spranger10@gmail.com';
$mail->Password = 'ssguwmuntpfallfo';
$mail->Port= 587;

$mail->setFrom('spranger10@gmail.com','MediTech');
$mail->addAddress($mailDestino);
$mail->isHTML(true);
$mail->Subject="Marcação de Consulta";
$mail->Body = nl2br($sms);

$mail->send();

echo"<script>window.location.href='proximas_consultas.php' </script>";

?>