<?php

require '../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);


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
  $phpmailer->Subject = "Nouveau message de contact de"  . $name;
  $phpmailer->Body    = "Nom: " . $name . "\nEmail: " . $email . "\nMessage: \n" . $message;
  $phpmailer->AltBody = "Nom: " . $name . "\nEmail: " . $email . "\nMessage: \n" . $message;

  // Send the Email
  $phpmailer->send();
  echo "Votre message a bien été envoyé.";
} catch (Exception $e) {
  echo "Votre message n'a pas été envoyé: {$phpmailer->ErrorInfo}";
}
}
