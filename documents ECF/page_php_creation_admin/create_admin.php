<?php

require_once '../env.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];


    $password_hache = password_hash($password, PASSWORD_BCRYPT);

    // Insérer l'utilisateur administrateur avec le mot de passe haché
    $sql = "INSERT INTO utilisateurs (username, role_id, password, nom, prenom) VALUES (:username, :role_id, :password, :nom, :prenom)";
    $statement = $base_de_donnees->prepare($sql);
    $statement->execute([
        ':username' => $username,
        ':role_id' => 1, // 1 pour le rôle d'administrateur
        ':password' => $password_hache,
        ':nom' => $nom,
        ':prenom' => $prenom
    ]);

    echo "Utilisateur administrateur créé avec succès.";
}
?>
