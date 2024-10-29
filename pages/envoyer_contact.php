<?php

require '../vendor/autoload.php';

use Mailgun\Mailgun;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    
    $apiKey = getenv('MAILGUN_API_KEY');
    $domain = getenv('MAILGUN_DOMAIN');
    $mgClient = Mailgun::create($apiKey);

    try {
        
        $mgClient->messages()->send($domain, [
            'from'    => 'noreply@arcadia.com',
            'to'      => 'employearcadia.com', 
            'subject' => "Nouveau message de contact de " . $name,
            'text'    => "Nom: " . $name . "\nEmail: " . $email . "\nMessage: \n" . $message,
            'html'    => "Nom: " . $name . "<br>Email: " . $email . "<br>Message: <br>" . nl2br($message)
        ]);

        echo "Votre message a bien été envoyé.";
    } catch (Exception $e) {
        echo "Votre message n'a pas été envoyé: {$e->getMessage()}";
    }
}

echo "Tu seras redirigé à la page précédente dans 5 secondes...";
header("refresh:5;url=" . $_SERVER['HTTP_REFERER']);
exit();