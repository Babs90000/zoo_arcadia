<?php
session_start();

require_once '../configuration/env.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'creer') {
        try {
            if (!empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['prix'])) {
                $nom = htmlspecialchars($_POST['nom']);
                $description = htmlspecialchars($_POST['description']);
                $prix = htmlspecialchars($_POST['prix']);
                $image_data = null;

                // Traitement de l'image téléchargée
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image_tmp_name = $_FILES['image']['tmp_name'];
                    $image_data = file_get_contents($image_tmp_name);
                }

                $stmt = $bdd->prepare('INSERT INTO services (nom, description, prix) VALUES (:nom, :description, :prix)');
                $stmt->execute([
                    ':nom' => $nom,
                    ':description' => $description,
                    ':prix' => $prix
                ]);

                $service_id = $bdd->lastInsertId();

                if ($image_data) {
                    $stmt = $bdd->prepare('INSERT INTO images (service_id, image_data) VALUES (:service_id, :image_data)');
                    $stmt->execute([
                        ':service_id' => $service_id,
                        ':image_data' => $image_data
                    ]);
                }

                echo '<script>alert("Service créé avec succès."); window.location.href="' . $_SERVER['PHP_SELF'] . '";</script>';
            } else {
                echo '<script>alert("Erreur : Tous les champs ne sont pas remplis."); window.location.href="' . $_SERVER['PHP_SELF'] . '";</script>';
            }
        } catch (Exception $e) {
            echo '<script>alert("Erreur : ' . $e->getMessage() . '"); window.location.href="' . $_SERVER['PHP_SELF'] . '";</script>';
        }
    } elseif ($action === 'modifier') {
        try {
            if (!empty($_POST['service_id']) && !empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['prix'])) {
                $service_id = (int)$_POST['service_id'];
                $nom = htmlspecialchars($_POST['nom']);
                $description = htmlspecialchars($_POST['description']);
                $prix = htmlspecialchars($_POST['prix']);
                $image_data = null;

                // Traitement de l'image téléchargée
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image_tmp_name = $_FILES['image']['tmp_name'];
                    $image_data = file_get_contents($image_tmp_name);
                }

                $stmt = $bdd->prepare('UPDATE services SET nom = :nom, description = :description, prix = :prix WHERE service_id = :service_id');
                $stmt->execute([
                    ':nom' => $nom,
                    ':description' => $description,
                    ':prix' => $prix,
                    ':service_id' => $service_id
                ]);

                if ($image_data) {
                    $stmt = $bdd->prepare('UPDATE images SET image_data = :image_data WHERE service_id = :service_id');
                    $stmt->execute([
                        ':service_id' => $service_id,
                        ':image_data' => $image_data
                    ]);
                }

                echo '<script>alert("Service modifié avec succès."); window.location.href="' . $_SERVER['PHP_SELF'] . '";</script>';
            } else {
                echo '<script>alert("Erreur : Tous les champs ne sont pas remplis."); window.location.href="' . $_SERVER['PHP_SELF'] . '";</script>';
            }
        } catch (Exception $e) {
            echo '<script>alert("Erreur : ' . $e->getMessage() . '"); window.location.href="' . $_SERVER['PHP_SELF'] . '";</script>';
        }
    } elseif ($action === 'supprimer') {
        try {
            if (!empty($_POST['service_id'])) {
                $service_id = (int)$_POST['service_id'];

                $stmt = $bdd->prepare('DELETE FROM services WHERE service_id = :service_id');
                $stmt->execute([':service_id' => $service_id]);

                $stmt = $bdd->prepare('DELETE FROM images WHERE service_id = :service_id');
                $stmt->execute([':service_id' => $service_id]);

                echo '<script>alert("Service supprimé avec succès."); window.location.href="' . $_SERVER['PHP_SELF'] . '";</script>';
            } else {
                echo '<script>alert("Erreur : L\'ID du service est manquant."); window.location.href="' . $_SERVER['PHP_SELF'] . '";</script>';
            }
        } catch (Exception $e) {
            echo '<script>alert("Erreur : ' . $e->getMessage() . '"); window.location.href="' . $_SERVER['PHP_SELF'] . '";</script>';
        }
    }

    exit();
}

$query = 'SELECT services.*, images.image_data FROM services LEFT JOIN images ON services.service_id = images.service_id';
$services = $bdd->query($query)->fetchAll(PDO::FETCH_ASSOC);
$isAdmin = $_SESSION['role'] == 1;

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
      crossorigin="anonymous"
    />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css" />
    <title>Gestion des Services</title>
</head>
<body>
    <header>
        <nav>
            <img src="../assets/Logo/logo arcadia sans fond.png" alt="Logo du zoo Arcadia" class="logo_arcadia">
            <ul>
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="page_services.php">Services</a></li>
                <li><a href="page_habitats.php">Habitats</a></li>
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
    <style>
        .mt-150 {
            margin-top: 150px;
        }
    </style>
    <div class="container mt-150">
        <h2 class="text-center mb-4">Gestion des Services</h2>
        <?php if ($isAdmin) { ?>
        <h3 class="choix_gestion_service">Créer un nouveau service</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="creer">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description" required></textarea>
            </div>
            <div class="form-group">
                <label for="prix">Prix:</label>
                <input type="text" class="form-control" id="prix" name="prix" placeholder="Prix" required>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Créer</button>
        </form>
        <?php }; ?>
        <hr>

        <h3 class="choix_gestion_service">Liste des services</h3><br>
        <?php if (!empty($services)): ?>
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <h4><?php echo htmlspecialchars($service['nom']); ?></h4>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($service['description']); ?></p>
                    <p><strong>Prix:</strong> <?php echo htmlspecialchars($service['prix']); ?></p>
                    <?php if ($service['image_data']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($service['image_data']); ?>" alt="Image du service" style="max-width: 300px;">
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data" class="mt-3">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($service['service_id']); ?>">
                        <div class="form-group">
                            <label for="nom_<?php echo htmlspecialchars($service['service_id']); ?>">Nom:</label>
                            <input type="text" class="form-control" id="nom_<?php echo htmlspecialchars($service['service_id']); ?>" name="nom" value="<?php echo htmlspecialchars($service['nom']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description_<?php echo htmlspecialchars($service['service_id']); ?>">Description:</label>
                            <textarea class="form-control" id="description_<?php echo htmlspecialchars($service['service_id']); ?>" name="description" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="prix_<?php echo htmlspecialchars($service['service_id']); ?>">Prix:</label>
                            <input type="text" class="form-control" id="prix_<?php echo htmlspecialchars($service['service_id']); ?>" name="prix" value="<?php echo htmlspecialchars($service['prix']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="image_<?php echo htmlspecialchars($service['service_id']); ?>">Image:</label>
                            <input type="file" class="form-control-file" id="image_<?php echo htmlspecialchars($service['service_id']); ?>" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>

                    <form method="POST" class="mt-2">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($service['service_id']); ?>">
                        <?php if ($isAdmin) { ?>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                        <?php } ?>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun service trouvé.</p>
        <?php endif; ?>
    </div>
    <button class="btn btn-secondary btn-retour" onclick="goBack()">Retour</button>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>