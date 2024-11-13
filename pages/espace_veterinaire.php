<?php

require_once '../template/header.php';

if (isset($_SESSION['message_connexion'])) {
    echo $_SESSION['message_connexion'];
}
unset($_SESSION['message_connexion']);


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 3) {

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
        <h1>Bienvenue dans l'espace vétérinaires</h1>
        <p>Bonjour <?php echo $prenom; ?>, vous êtes connecté !</p>
        <a href="gestion_habitat.php">Laisser un commentaire sur un habitat</a><br>
        <a href="faire_rapports_veterinaires.php">faire un rapport vétérinaire</a><br>
        <a href="suivi_alimentation.php">Suivi alimentation animaux</a>

    </div>
</main>
</body>
</html>


