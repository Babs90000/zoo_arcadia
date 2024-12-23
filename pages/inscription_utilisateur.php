session_start();
require_once '../configuration/env.php';
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SESSION['role'] != 1) {
    $_SESSION['message'] = 'Accès refusé. Vous devez être administrateur pour accéder à cette page.';
    $_SESSION['message_type'] = 'danger';
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'creer') {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Code pour insérer l'utilisateur dans la base de données
        // ...

        // Envoi de l'email de confirmation avec PHPMailer
        $phpmailer = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.gmail.com'; // Adresse du serveur SMTP de Gmail
            $phpmailer->SMTPAuth = true;
            $phpmailer->Username = 'votre-email@gmail.com'; // Votre adresse e-mail Gmail
            $phpmailer->Password = 'votre-mot-de-passe'; // Votre mot de passe Gmail
            $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $phpmailer->Port = 587;

            // Désactiver le débogage SMTP
            $phpmailer->SMTPDebug = 0; // 0 = off (pour la production), 1 = messages client, 2 = messages client et serveur

            // Configurer l'encodage
            $phpmailer->CharSet = 'UTF-8';

            // En-têtes de l'e-mail
            $phpmailer->setFrom('votre-email@gmail.com', 'Votre Nom'); // Utiliser votre adresse e-mail comme expéditeur
            $phpmailer->addAddress($email); // Ajouter le destinataire
            $phpmailer->addReplyTo('votre-email@gmail.com', 'Votre Nom'); // Ajouter l'adresse e-mail de réponse

            // Contenu de l'e-mail
            $phpmailer->isHTML(false); // Envoyer l'e-mail en texte brut
            $phpmailer->Subject = 'Confirmation d\'inscription';
            $phpmailer->Body    = "Bonjour $username,\n\nVotre inscription a été réalisée avec succès.\n\nCordialement,\nL'équipe Arcadia";

            // Envoyer l'e-mail
            $phpmailer->send();

            $_SESSION['message'] = 'Utilisateur créé avec succès et email de confirmation envoyé.';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Erreur lors de l\'envoi de l\'email : ' . $phpmailer->ErrorInfo;
            $_SESSION['message_type'] = 'danger';
        }

        header('Location: inscription_utilisateur.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <header>
        <nav>
            <img src="../assets/Logo/logo arcadia sans fond.png" alt="Logo du zoo Arcadia" class="logo_arcadia">
            <ul>
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="page_services.php">Services</a></li>
                <li><a href="page_habitats.php">Habitats</a></li>
                <li><a href="avis.php">Vos avis</a></li>
            </ul>
            <?php if (isset($_SESSION['role'])): ?>
                <form method="POST" action="deconnexion.php">
                    <button type="submit" class="btn_deconnexion">Déconnexion</button>
                </form>
            <?php else: ?>
                <a href="connexion_utilisateur.php" class="btn_connexion">
                    <i class="fa-solid fa-right-to-bracket"></i> Espace employé
                </a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="container mt-5">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="inscription_utilisateur.php">
            <input type="hidden" name="action" value="creer">
            <div class="form-group">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>
</body>
</html>