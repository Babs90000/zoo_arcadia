<?php

require_once '../classes/admin.php';
require_once '../classes/employe.php';
require_once '../classes/veterinaire.php';
require_once '../template/header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    echo 'Vous ne pouvez pas accéder à cette page';
    exit();
}
if (isset($_POST['Creer'])) {
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['role'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $role_id = htmlspecialchars($_POST['role']);
        $label = 'Label par défaut';

       
        $message = Admin::creerUtilisateur($bdd, $username, $password, $nom, $prenom, $role_id, $label);
        echo $message;
    } else {
        echo 'Veuillez remplir correctement tous les champs';
    }
}
?>

<!-- Formulaire de création d'utilisateur -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de création d'utilisateur</title>
</head>
<body>
    <h2 class="titre_formulaire_inscription">Formulaire de création d'utilisateur</h2>
    <form action="" method="post" class="champs_formulaire_inscription">
        <label for="username">Nom d'utilisateur:</label>
        <input type="email" id="username" name="username" required autocomplete="off">
        
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required autocomplete="off">
        
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required autocomplete="off">
        
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required autocomplete="off">

        <label for="role">Rôle:</label>
        <select id="role" name="role" required>
            <option value="2">Employé</option>
            <option value="3">Vétérinaire</option>
        </select><br>
    
        <input type="submit" name="Creer" value="Créer"><br>
    </form>
    <button onclick="goBack()" class="btn btn-secondary" style="margin: auto auto;">Retour</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
