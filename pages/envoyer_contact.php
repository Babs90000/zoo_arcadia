<?php

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $message = htmlspecialchars($_POST['message']);

  // Initialiser PHPMailer
  $phpmailer = new PHPMailer(true);

  try {
    // Configurer SMTP
    $phpmailer->isSMTP();
    $phpmailer->SMTPAuth = true;
    $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    // Crédentials ENV
    $phpmailer->Host = getenv("MAILERTOGO_SMTP_HOST", true);
    $phpmailer->Port = intval(getenv("MAILERTOGO_SMTP_PORT", true));
    $phpmailer->Username = getenv("MAILERTOGO_SMTP_USER", true);
    $phpmailer->Password = getenv("MAILERTOGO_SMTP_PASSWORD", true);

    // En-têtes de mail
    $phpmailer->setFrom("noreply@votredomaine.com", "Mailer");
    $phpmailer->addAddress("camara.enc@gmail.com", "Recipient"); // Adresse email de destination

    // Message
    $phpmailer->isHTML(true);
    $phpmailer->Subject = "Nouveau message de contact de " . $name;
    $phpmailer->Body    = "Nom: " . $name . "<br>Email: " . $email . "<br>Message: <br>" . nl2br($message);
    $phpmailer->AltBody = "Nom: " . $name . "\nEmail: " . $email . "\nMessage: \n" . $message;

    // Envoyer l'email
    $phpmailer->send();
    echo "Votre message a bien été envoyé.";
  } catch (Exception $e) {
    echo "Votre message n'a pas été envoyé: {$phpmailer->ErrorInfo}";
  }
}
