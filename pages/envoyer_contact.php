<?php
require '../vendor/autoload.php';

use Mailgun\Mailgun;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $message = htmlspecialchars($_POST['message']);

  // Initialiser Mailgun
  $apiKey = getenv('MAILGUN_API_KEY');
  $domain = getenv('MAILGUN_DOMAIN');
  $mgClient = Mailgun::create($apiKey);

  try {
    // Envoyer l'email
    $mgClient->messages()->send($domain, [
      'from'    => 'noreply@votredomaine.com',
      'to'      => 'camara.enc@gmail.com', // Adresse email de destination
      'subject' => "Nouveau message de contact de " . $name,
      'text'    => "Nom: " . $name . "\nEmail: " . $email . "\nMessage: \n" . $message,
      'html'    => "Nom: " . $name . "<br>Email: " . $email . "<br>Message: <br>" . nl2br($message)
    ]);
    echo "Votre message a bien été envoyé.</br>";
  } catch (Exception $e) {
    echo "Votre message n'a pas été envoyé: {$e->getMessage()}</br>";
  }

  echo "Tu seras redirigé à la page précédente dans 5 secondes...";
  header("refresh:5;url=" . $_SERVER['HTTP_REFERER']);
  exit();
}
