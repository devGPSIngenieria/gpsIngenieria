<?php
require '../../vendor/autoload.php';

// Crea una instancia de PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'sandbox.smtp.mailtrap.io'; // Cambia esto al servidor SMTP que estés utilizando
    $mail->Username = '54932afb 81a73d'; // Tu dirección de correo electrónico
    $mail->Password = '3474a7accd460e'; // Tu contraseña de correo electrónico
    $mail->SMTPSecure = 'tls'; // Puedes usar 'ssl' o 'tls'
    $mail->Port = 2525; // Puerto SMTP

    // Configuración del correo electrónico
    $mail->setFrom('kvnmisael@gmail.com', 'elkevin');
    $mail->addAddress('kvnmisael@gmail.com', 'el otro');
    $mail->Subject = 'Asunto del Correo';
    $mail->Body = 'Contenido del Correo';
 
   
    // Enviar el correo
    if($mail->send()){
        echo 'El correo ha sido enviado con éxito.';
    }else{
        echo 'El correo no se envio.';
        echo 'Hubo un error al enviar el correo: ', $mail->ErrorInfo;
    }
    
} catch (Exception $e) {
    echo 'Hubo un error al enviar el correo: ', $mail->ErrorInfo;
}
?>



