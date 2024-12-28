<?php

require_once '../template/header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 2) {

    header('Location: connexion_utilisateur.php');
    exit();
}

$role_utilisateur = $_SESSION['role'];
$prenom = $_SESSION['prenom'];
$role_label = '';
switch ($role_utilisateur) {
    case 1:
        $role_label = 'Administrateur';
        break;
    case 2:
        $role_label = 'Employé';
        break;
    case 3:
        $role_label = 'Vétérinaire';
        break;
    default:
        $role_label = 'Utilisateur';
        break;
}
?>

<link rel=stylesheet href="../style/style_espace_utilisateur.css">
<main>
    <div class="container">
        <h1>Bienvenue dans l'espace employé </h1>
        <p>Bonjour <?php echo htmlspecialchars($prenom); ?>, vous êtes connecté !</p>
        <a href="ajout_alimentation_animaux.php">Renseigner l'alimentation d'un animal</a><br>
        <a href="gestion_services.php">Modifier les services du zoo</a><br>
        <a href="valider_avis.php">Valider un avis </a>

    </div>
</main>
</body>

</html>