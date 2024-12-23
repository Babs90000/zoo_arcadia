<?php
session_start();
require_once '../configuration/env.php';
require_once '../vendor/autoload.php';

use Mailgun\Mailgun;
use Nyholm\Psr7\Factory\Psr17Factory;

if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    $_SESSION['message'] = 'Accès refusé. Vous devez être administrateur pour accéder à cette page.';
    $_SESSION['message_type'] = 'danger';
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'creer') {
        $username = htmlspecialchars($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $role_id = (int)$_POST['role_id'];

        try {
            $stmt = $bdd->prepare('INSERT INTO utilisateurs (username, password, nom, prenom, role_id) VALUES (:username, :password, :nom, :prenom, :role_id)');
            $stmt->execute([
                ':username' => $username,
                ':password' => $password,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':role_id' => $role_id
            ]);

            // Envoi de l'email de notification
            $apiKey = getenv('MAILGUN_API_KEY');
            $domain = getenv('MAILGUN_DOMAIN');
            $mgClient = Mailgun::create($apiKey, new Psr17Factory());

            $mgClient->messages()->send($domain, [
                'from'    => 'employearcadia@gmail.com',
                'to'      => $username,
                'subject' => 'Votre compte a été créé',
                'text'    => "Bonjour $prenom $nom,\n\nVotre compte a été créé avec succès. Veuillez contacter l'administrateur pour obtenir votre mot de passe.\n\nCordialement,\nL'équipe Arcadia"
            ]);

            $_SESSION['message'] = 'Utilisateur créé avec succès et email de notification envoyé.';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Erreur lors de la création de l\'utilisateur : ' . $e->getMessage();
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
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="role_id">Rôle:</label>
                <input type="number" class="form-control" id="role_id" name="role_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>