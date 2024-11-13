<?php
session_start();

require_once '../configuration/env.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'creer') {
        try {
            if (!empty($_POST['nom']) && !empty($_POST['description'])) {
                $nom = htmlspecialchars($_POST['nom']);
                $description = htmlspecialchars($_POST['description']);

                $stmt = $bdd->prepare('INSERT INTO services (nom, description) VALUES (:nom, :description)');
                $stmt->execute([
                    ':nom' => $nom,
                    ':description' => $description
                ]);

                $_SESSION['message'] = "Service créé avec succès";
            } else {
                echo 'Erreur : Tous les champs ne sont pas remplis.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    } elseif ($action === 'modifier') {
        try {
            if (!empty($_POST['service_id']) && !empty($_POST['nom']) && !empty($_POST['description'])) {
                $service_id = (int)$_POST['service_id'];
                $nom = htmlspecialchars($_POST['nom']);
                $description = htmlspecialchars($_POST['description']);

                $stmt = $bdd->prepare('UPDATE services SET nom = :nom, description = :description WHERE service_id = :service_id');
                $stmt->execute([
                    ':nom' => $nom,
                    ':description' => $description,
                    ':service_id' => $service_id
                ]);

                $_SESSION['message'] = "Service modifié avec succès";
            } else {
                echo 'Erreur : Tous les champs ne sont pas remplis.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    } elseif ($action === 'supprimer') {
        try {
            if (!empty($_POST['service_id'])) {
                $service_id = (int)$_POST['service_id'];

                $stmt = $bdd->prepare('DELETE FROM services WHERE service_id = :service_id');
                $stmt->execute([':service_id' => $service_id]);

                $_SESSION['message'] = "Service supprimé avec succès";
            } else {
                echo 'Erreur : L\'ID du service est manquant.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$query = 'SELECT * FROM services';
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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    
  
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://kit.fontawesome.com/70e8dd41e8.js"
      crossorigin="anonymous"
    ></script>


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
          class="logo_arcadia"
        />
        <ul>
          <li><a href="../public/index.php">Accueil</a></li>
          <li><a href="page_services.php">Services</a></li>
          <li><a href="page_habitat.php">Habitats</a></li>
          <li><a href="avis.php">Vos avis</a></li>
        </ul>
        <?php if (isset($_SESSION['role'])): ?>
              
                <form method="POST" action="deconnexion.php" >
                    <button type="submit"class="btn_deconnexion">Déconnexion</button>
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
        <h2 class="text-success text-center mb-5">Gestion des Services</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo ($_SESSION['message']); ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <?php if ($isAdmin) { ?>
        <h3 class="choix_gestion_service">Créer un nouveau service</h3>
        <form method="POST">
            <input type="hidden" name="action" value="creer">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Créer</button>
        </form>
        <?php }; ?>
        <hr>

        <h3 class="choix_gestion_service">Liste des services</h3><br>
        <?php if (!empty($services)): ?>
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <h4><?php echo $service['nom']; ?></h4>
                    <p><strong>Description:</strong> <?php echo $service['description']; ?></p>

                    <form method="POST" class="mt-3">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                        <div class="form-group">
                            <label for="nom_<?php echo $service['service_id']; ?>">Nom:</label>
                            <input type="text" class="form-control" id="nom_<?php echo $service['service_id']; ?>" name="nom" value="<?php echo $service['nom']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description_<?php echo $service['service_id']; ?>">Description:</label>
                            <textarea class="form-control" id="description_<?php echo $service['service_id']; ?>" name="description" required><?php echo $service['description']; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>

                    <form method="POST" class="mt-2">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                      <?php  if ($isAdmin) { ?>
                        <button type="submit" class="btn btn-danger">Supprimer</button><?php } ?> <br><br>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun service trouvé.</p>
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
