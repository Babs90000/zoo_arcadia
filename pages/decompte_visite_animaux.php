<?php
session_start();
require_once '../configuration/vendor/autoload.php';
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />


    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script
        src="https://kit.fontawesome.com/70e8dd41e8.js"
        crossorigin="anonymous"></script>


    <script defer href="../js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>Zoo Arcadia</title>
</head>

<body>
    <header>
        <nav>
            <img
                src="../assets/Logo/logo arcadia sans fond.png"
                alt="Logo du zoo Arcadia"
                class="logo_arcadia" />
            <ul>
                <li><a href="../public/index.php">Accueil</a></li>
                <li><a href="../pages/page_services.php">Services</a></li>
                <li><a href="../pages/page_habitat.php">Habitats</a></li>
                <li><a href="../pages/animaux.php">Animaux</a></li>
                <li><a href="../pages/avis.php">Vos avis</a></li>
            </ul>
            <?php if (isset($_SESSION['role'])): ?>

                <form method="POST" action="../pages/deconnexion.php">
                    <button type="submit" class="btn_deconnexion">Déconnexion</button>
                </form>
            <?php else: ?>

                <a href="../pages/connexion_utilisateur.php" class="btn_connexion">
                    <i class="fa-solid fa-right-to-bracket"></i> Espace employé
                </a>
            <?php endif; ?>
        </nav>
    </header>