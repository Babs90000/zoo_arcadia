<?php
session_start();
require_once '../configuration/env.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != '1') {
    echo 'Accès refusé. Seuls les administrateurs peuvent accéder à cette page.';
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['type_jour']) && !empty($_POST['heure_ouverture']) && !empty($_POST['heure_fermeture'])) {
        $type_jour = htmlspecialchars($_POST['type_jour']);
        $heure_ouverture = htmlspecialchars($_POST['heure_ouverture']);
        $heure_fermeture = htmlspecialchars($_POST['heure_fermeture']);

        $sql = "UPDATE horaires_ouverture SET heure_ouverture = :heure_ouverture, heure_fermeture = :heure_fermeture WHERE type_jour = :type_jour";
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':type_jour' => $type_jour,
            ':heure_ouverture' => $heure_ouverture,
            ':heure_fermeture' => $heure_fermeture
        ]);

        $_SESSION['message'] = "Horaire modifié avec succès";
    } else {
        $_SESSION['message'] = "Veuillez remplir tous les champs";
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$query = 'SELECT * FROM horaires_ouverture';
$horaires = $bdd->query($query)->fetchAll(PDO::FETCH_ASSOC);
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
    <!-- FIN POLICE D'ECRITURE -->

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
                <li><a href="page_services.php">Services</a></li>
                <li><a href="page_habitat.php">Habitats</a></li>
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

    <body>
        <style>
            .mt-150 {
                margin-top: 150px;
            }
        </style>
        <div class="container mt-150 mb-5">
            <h2 class="text-success text-center mb-5">Modification des Horaires</h2>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo ($_SESSION['message']); ?>
                    <?php unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="type_jour">Type de jour:</label>
                    <select class="form-control" id="type_jour" name="type_jour" required>
                        <option value="">-- Veuillez choisir un type de jour --</option>
                        <?php foreach ($horaires as $horaire): ?>
                            <option value="<?php echo $horaire['type_jour']; ?>"><?php echo $horaire['type_jour']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="heure_ouverture">Heure d'ouverture:</label>
                    <input type="time" class="form-control" id="heure_ouverture" name="heure_ouverture" required>
                </div>
                <div class="form-group">
                    <label for="heure_fermeture">Heure de fermeture:</label>
                    <input type="time" class="form-control" id="heure_fermeture" name="heure_fermeture" required>
                </div>
                <button type="submit" class="btn btn-success">Modifier</button>
            </form>

            <hr>
            <h3 class="titre_modification_horaires">Horaires d'ouverture</h3>

            <?php if (!empty($horaires)): ?>
                <?php foreach ($horaires as $horaire): ?>
                    <div class="horaire-card">
                        <h4><?php echo htmlspecialchars($horaire['type_jour']); ?></h4>
                        <p><strong>Heure d'ouverture:</strong> <?php echo $horaire['heure_ouverture']; ?></p>
                        <p><strong>Heure de fermeture:</strong> <?php echo $horaire['heure_fermeture']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun horaire trouvé.</p>
            <?php endif; ?>

            <button class="btn btn-secondary btn-retour" onclick="goBack()">Retour</button>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </body>

</html>