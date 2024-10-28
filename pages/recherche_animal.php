<?php
require_once  '../configuration/env.php';

header('Content-Type: application/json');

$resultat_recherche = [];

try {
    if (!isset($_GET['q']) || empty($_GET['q'])) {
        $statement = $bdd->prepare('SELECT prenom, age, image_data, label, animaux.animal_id FROM animaux INNER JOIN races ON animaux.race_id = races.race_id INNER JOIN images ON animaux.animal_id = images.animal_id');
        $statement->execute();
        $resultat_recherche = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $search = htmlspecialchars($_GET['q']);
        $statement = $bdd->prepare('SELECT prenom, age, image_data, label, animaux.animal_id FROM animaux INNER JOIN races ON animaux.race_id = races.race_id INNER JOIN images ON animaux.animal_id = images.animal_id WHERE label LIKE :label');
        $statement->bindValue(':label', '%' . $search . '%', PDO::PARAM_STR);
        $statement->execute();
        $resultat_recherche = $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    foreach ($resultat_recherche as &$animal) {
        if (!empty($animal['image_data'])) {
            $animal['image_data'] = base64_encode($animal['image_data']);
        }
    }
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit();
}

echo json_encode($resultat_recherche);
