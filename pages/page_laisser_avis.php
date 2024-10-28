<?php

require_once '../template/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['laisser_avis'])) {
    $pseudo = $_POST['pseudo'];
    $commentaire = $_POST['commentaire'];

    if (!empty($pseudo) && !empty($commentaire)) {
        $sql = "INSERT INTO avis (pseudo, commentaire, isVisible) VALUES (:pseudo, :commentaire, FALSE)";
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':pseudo' => $pseudo,
            ':commentaire' => $commentaire
        ]);
        echo "Avis soumis avec succès. Il sera visible après validation.";
    } else {
        echo "Veuillez remplir correctement tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laisser un avis</title>
</head>
<body>
    <h2>Laisser un avis</h2>
    <form action="" method="post">
        <input type="hidden" name="laisser_avis" value="1">
        <label>Pseudo:</label><br>
        <input type="text" name="pseudo" required><br><br>
        
        <label>Commentaire:</label><br>
        <textarea name="commentaire" required></textarea><br><br>
        
        <input type="submit" value="Soumettre">
    </form>
</body>
</html>
