<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $phpmailer = new PHPMailer(true);

    try {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com'; 
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = 'camara.enc@gmail.com'; 
        $phpmailer->Password = 'xrkq tbyu auoe ngot'; 
        $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $phpmailer->Port = 587;

       
        $phpmailer->CharSet = 'UTF-8';

       
        $phpmailer->setFrom($email, $name);
        $phpmailer->addAddress('employearcadia@gmail.com');

     
        $phpmailer->isHTML(true);
        $phpmailer->Subject = "Nouveau message de contact de " . $name;
        $phpmailer->Body    = "Nom: " . $name . "<br>Email: " . $email 
        . "<br>Message: <br>" . nl2br($message);
        $phpmailer->AltBody = "Nom: " . $name . "\nEmail: " . $email . "\nMessage: \n" . $message;

        $phpmailer->send();
        echo "Votre message a bien été envoyé.</br>";
    } catch (Exception $e) {
        echo "Votre message n'a pas été envoyé: {$phpmailer->ErrorInfo}</br>";
    }

    echo "Tu seras redirigé à la page précédente dans 5 secondes...";
    header("refresh:5;url=" . $_SERVER['HTTP_REFERER']);
    exit();
}
?>

