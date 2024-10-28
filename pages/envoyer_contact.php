<?php

require '../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'employearcadia@gmail.com'; 
        $mail->Password = 'Arcadia2024'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        
        $mail->setFrom('employearcadia@gmail.com', 'Arcadia Contact'); 
        $mail->addAddress('employearcadia@gmail.com'); 

     
        $mail->isHTML(false);
        $mail->Subject = 'Nouveau message de contact de ' . $name;
        $mail->Body    = "Nom: " . $name . "\nEmail: " . $email . "\nMessage: \n" . $message;

       
        $mail->send();
        echo 'Message envoyé avec succès.';
    } catch (Exception $e) {
       
        echo "Échec de l'envoi du message. Erreur: {$mail->ErrorInfo}";
    }
} else {
    
    echo "Méthode de requête non valide.";
}



<?php

require("vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Passing true enables exceptions.
$phpmailer = new PHPMailer(true);

try {
  // Configure SMTP
  $phpmailer->isSMTP();
  $phpmailer->SMTPAuth = true;
  $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

  // ENV Credentials
  $phpmailer->Host = getenv("MAILERTOGO_SMTP_HOST", true);
  $phpmailer->Port = intval(getenv("MAILERTOGO_SMTP_PORT", true));
  $phpmailer->Username = getenv("MAILERTOGO_SMTP_USER", true);
  $phpmailer->Password = getenv("MAILERTOGO_SMTP_PASSWORD", true);
  $mailertogo_domain = getenv("MAILERTOGO_DOMAIN", true);

  // Mail Headers
  $phpmailer->setFrom("mailer@{$mailertogo_domain}", "Mailer");
  // Change to recipient email. Make sure to use a real email address in your tests to avoid hard bounces and protect your reputation as a sender.
  $phpmailer->addAddress("noreply@{$mailertogo_domain}", "Recipient");

  // Message
  $phpmailer->isHTML(true);
  $phpmailer->Subject = "Mailer To Go Test";
  $phpmailer->Body    = "<b>Hi</b>\nTest from Mailer To Go 😊\n";
  $phpmailer->AltBody = "Hi!\nTest from Mailer To Go 😊\n";

  // Send the Email
  $phpmailer->send();
  echo "Votre message a bien été envoyé.";
} catch (Exception $e) {
  echo "Votre message n'a pas été envoyé: {$phpmailer->ErrorInfo}";
}