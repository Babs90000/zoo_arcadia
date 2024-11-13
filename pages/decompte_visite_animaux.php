<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../configuration/mongodb_config.php';

    try {
        $collection = $database->selectCollection('decompte_animaux');
        $documents = $collection->find();

        foreach ($documents as $document) {
            echo '
        <div class="card">
            <h2>' . htmlspecialchars($document['prenom']) . '</h2>
            <p>Race: ' . htmlspecialchars($document['race']) . '</p>
            <p>Nombre de visites: ' . htmlspecialchars($document['decompte_visiteurs']) . '</p>
        </div>';
        }
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }

echo '<button onclick="window.history.back()">Retour</button>';

require_once '../template/header.php';

