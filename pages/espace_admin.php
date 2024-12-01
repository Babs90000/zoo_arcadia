<?php

require_once '../template/header.php';



if (!isset($_SESSION['role']) || $_SESSION['role'] !== 1) {
 
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
            <h1>Bienvenue dans l'Espace Admin</h1>
            <p>Bonjour <?php echo htmlspecialchars($prenom); ?>, vous êtes connecté !</p>
        <a href="gestion_services.php">Gestion des services</a><br>
        <a href="inscription_utilisateur.php">Gestion des utilisateurs</a><br>
        <a href="gestion_animaux.php">Gestion des animaux</a><br>
        <a href="gestion_habitats.php">Gestion des habitats</a><br>
        <a href="modification_horaire.php">Modification des horaires</a><br>
        <a href="rapports_veterinaires.php">Rapports vétérinaires</a><br>
        <a href="decompte_visite_animaux.php">Décompte des visites des animaux</a><br>
        <a href="valider_avis.php">Valider un avis</a><br>
        
        </div>
    </main>

   
</body>
</html>
