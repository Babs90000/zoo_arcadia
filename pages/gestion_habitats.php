<?php
session_start();
require_once '../configuration/env.php';

<<<<<<< HEAD
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 1 && $_SESSION['role'] != 3)) {
    echo 'Accès refusé. Seuls les administrateurs et les vétérinaires ont accès à cette page.';
    header("refresh: 3; url=connexion_utilisateur.php");
    exit();
}

$isAdmin = $_SESSION['role'] == 1;

$sql = "SELECT habitats.*, images.image_data FROM habitats LEFT JOIN images ON habitats.habitat_id = images.habitat_id";
$habitats = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'creer') {
        if (!empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['commentaire_habitat'])) {
            $nom = htmlspecialchars($_POST['nom']);
            $description = htmlspecialchars($_POST['description']);
            $commentaire_habitat = htmlspecialchars($_POST['commentaire_habitat']);
            $image_data = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image_tmp_name = $_FILES['image']['tmp_name'];
                $image_data = file_get_contents($image_tmp_name);
=======
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 1 && $_SESSION['role'] != 2)) {
    echo 'Accès refusé. Seuls les administrateurs et les employés peuvent accéder à cette page.';
    exit();
}

$sql = "SELECT habitats.*, images.image_data FROM habitats LEFT JOIN images ON habitats.habitat_id = images.habitat_id";
$habitats = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$alert_message = '';
$alert_class = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['creer_habitat'])) {
        if (!empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['commentaire_habitat'])) {
            $nom = htmlspecialcharss($_POST['nom']);
            $description = htmlspecialcharss($_POST['description']);
            $commentaire_habitat = htmlspecialcharss($_POST['commentaire_habitat']);
            $image = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
>>>>>>> 9f9c0c573ce0135f9bdefdb57e5159c2e1483a67
            }

            $sql = "INSERT INTO habitats (nom, description, commentaire_habitat) VALUES (:nom, :description, :commentaire_habitat)";
            $statement = $bdd->prepare($sql);
            $statement->execute([
                ':nom' => $nom,
                ':description' => $description,
                ':commentaire_habitat' => $commentaire_habitat
            ]);

<<<<<<< HEAD
            $habitat_id = $bdd->lastInsertId();

            if ($image_data) {
=======
            if ($image) {
                $habitat_id = $bdd->lastInsertId();
>>>>>>> 9f9c0c573ce0135f9bdefdb57e5159c2e1483a67
                $sql = "INSERT INTO images (habitat_id, image_data) VALUES (:habitat_id, :image_data)";
                $statement = $bdd->prepare($sql);
                $statement->execute([
                    ':habitat_id' => $habitat_id,
<<<<<<< HEAD
                    ':image_data' => $image_data
                ]);
            }

            echo '<script>alert("Habitat créé avec succès.");</script>';
        } else {
            echo '<script>alert("Veuillez remplir tous les champs obligatoires.");</script>';
        }
    } elseif ($action === 'modifier') {
        if (!empty($_POST['habitat_id']) && !empty($_POST['nom']) && !empty($_POST['description']) && !empty($_POST['commentaire_habitat'])) {
            $habitat_id = (int)$_POST['habitat_id'];
            $nom = htmlspecialchars($_POST['nom']);
            $description = htmlspecialchars($_POST['description']);
            $commentaire_habitat = htmlspecialchars($_POST['commentaire_habitat']);
            $image_data = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image_tmp_name = $_FILES['image']['tmp_name'];
                $image_data = file_get_contents($image_tmp_name);
            }

            $sql = "UPDATE habitats SET nom = :nom, description = :description, commentaire_habitat = :commentaire_habitat WHERE habitat_id = :habitat_id";
            $statement = $bdd->prepare($sql);
            $statement->execute([
                ':nom' => $nom,
                ':description' => $description,
                ':commentaire_habitat' => $commentaire_habitat,
                ':habitat_id' => $habitat_id
            ]);

            if ($image_data) {
                $sql = "UPDATE images SET image_data = :image_data WHERE habitat_id = :habitat_id";
                $statement = $bdd->prepare($sql);
                $statement->execute([
                    ':habitat_id' => $habitat_id,
                    ':image_data' => $image_data
                ]);
            }

            echo '<script>alert("Habitat modifié avec succès.");</script>';
        } else {
            echo '<script>alert("Veuillez remplir tous les champs obligatoires.");</script>';
        }
    } elseif ($action === 'supprimer') {
        if (!empty($_POST['habitat_id'])) {
            $habitat_id = (int)$_POST['habitat_id'];

            $sql = "DELETE FROM habitats WHERE habitat_id = :habitat_id";
            $statement = $bdd->prepare($sql);
            $statement->execute([':habitat_id' => $habitat_id]);

            $sql = "DELETE FROM images WHERE habitat_id = :habitat_id";
            $statement = $bdd->prepare($sql);
            $statement->execute([':habitat_id' => $habitat_id]);

            echo '<script>alert("Habitat supprimé avec succès.");</script>';
        } else {
            echo '<script>alert("Erreur : L\'ID de l\'habitat est manquant.");</script>';
        }
    }

   
    header("refresh: 1; url={$_SERVER['PHP_SELF']}");
    exit();
}

=======
                    ':image_data' => $image
                ]);
            }

            $alert_message = 'Habitat créé avec succès.';
            $alert_class = 'alert-success';
        } else {
            $alert_message = 'Veuillez remplir tous les champs obligatoires.';
            $alert_class = 'alert-danger';
        }
    } elseif (isset($_POST['supprimer_habitat'])) {
        $habitat_id = htmlspecialcharss($_POST['habitat_id']);

        $sql = "DELETE FROM habitats WHERE habitat_id = :habitat_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([':habitat_id' => $habitat_id]);

        $sql = "DELETE FROM images WHERE habitat_id = :habitat_id";
        $statement = $bdd->prepare($sql);
        $statement->execute([':habitat_id' => $habitat_id]);

        $alert_message = 'Habitat supprimé avec succès.';
        $alert_class = 'alert-success';
    }
}
>>>>>>> 9f9c0c573ce0135f9bdefdb57e5159c2e1483a67
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
<<<<<<< HEAD
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css" />
    <title>Gestion des Habitats</title>
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
=======
   
 
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    
    
    <link
      href="https://fonts.googleapis.com/css2?family=Ga+Maamli&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://kit.fontawesome.com/70e8dd41e8.js"
      crossorigin="anonymous"
    ></script>
<!-- FIN POLICE D'ECRITURE -->

    <script defer href="../js/script.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
          <li><a href="../index.php">Accueil</a></li>
          <li><a href="page_services.php">Services</a></li>
          <li><a href="page_habitats.php">Habitats</a></li>
          <li><a href="avis.php">Vos avis</a></li>
        </ul>
        <?php if (isset($_SESSION['role'])): ?>
              
                <form method="POST" action="deconnexion.php" >
                    <button type="submit"class="btn_deconnexion">Déconnexion</button>
                </form>
            <?php else: ?>
                
>>>>>>> 9f9c0c573ce0135f9bdefdb57e5159c2e1483a67
                <a href="connexion_utilisateur.php" class="btn_connexion">
                    <i class="fa-solid fa-right-to-bracket"></i> Espace employé
                </a>
            <?php endif; ?>
<<<<<<< HEAD
        </nav>
    </header>
=======
      </nav>
    </header> 

<body>
>>>>>>> 9f9c0c573ce0135f9bdefdb57e5159c2e1483a67
    <style>
        .mt-150 {
            margin-top: 150px;
        }
    </style>
<<<<<<< HEAD
    <div class="container mt-150">
        <h2 class="text-center mb-4">Gestion des Habitats</h2>
        <h3 class="choix_gestion_habitat">Créer un nouvel habitat</h3>
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
                <label for="commentaire_habitat">Commentaire:</label>
                <textarea class="form-control" id="commentaire_habitat" name="commentaire_habitat" placeholder="Commentaire" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Créer</button>
        </form>
        <hr>

        <h3 class="choix_gestion_habitat">Liste des habitats</h3><br>
        <?php if (!empty($habitats)): ?>
            <?php foreach ($habitats as $habitat): ?>
                <div class="habitat-card">
                    <h4><?php echo htmlspecialchars($habitat['nom']); ?></h4>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($habitat['description']); ?></p>
                    <p><strong>Commentaire:</strong> <?php echo htmlspecialchars($habitat['commentaire_habitat']); ?></p>
                    <?php if ($habitat['image_data']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($habitat['image_data']); ?>" alt="Image de l'habitat">
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data" class="mt-3">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="habitat_id" value="<?php echo htmlspecialchars($habitat['habitat_id']); ?>">
                        <div class="form-group">
                            <label for="nom_<?php echo htmlspecialchars($habitat['habitat_id']); ?>">Nom:</label>
                            <input type="text" class="form-control" id="nom_<?php echo htmlspecialchars($habitat['habitat_id']); ?>" name="nom" value="<?php echo htmlspecialchars($habitat['nom']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description_<?php echo htmlspecialchars($habitat['habitat_id']); ?>">Description:</label>
                            <textarea class="form-control" id="description_<?php echo htmlspecialchars($habitat['habitat_id']); ?>" name="description" required><?php echo htmlspecialchars($habitat['description']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="commentaire_habitat_<?php echo htmlspecialchars($habitat['habitat_id']); ?>">Commentaire:</label>
                            <textarea class="form-control" id="commentaire_habitat_<?php echo htmlspecialchars($habitat['habitat_id']); ?>" name="commentaire_habitat" required><?php echo htmlspecialchars($habitat['commentaire_habitat']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image_<?php echo htmlspecialchars($habitat['habitat_id']); ?>">Image:</label>
                            <input type="file" class="form-control-file" id="image_<?php echo htmlspecialchars($habitat['habitat_id']); ?>" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>

                    <form method="POST" class="mt-2">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="habitat_id" value="<?php echo htmlspecialchars($habitat['habitat_id']); ?>">
                        <?php if ($isAdmin) { ?>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                        <?php } ?>
                    </form>
=======
    <div class="container mt-150 mb-5">
        <h2 class="text-success text-center mb-5">Gestion des habitats</h2>
        <?php if ($alert_message): ?>
            <div class="alert <?php echo $alert_class; ?>" role="alert">
                <?php echo htmlspecialcharst($alert_message); ?>
            </div>
        <?php endif; ?>

        
        <?php if ($_SESSION['role'] == 1): ?>
            <h3>Créer un nouvel habitat</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="creer_habitat" value="1">
                <div class="form-group">
                    <label for="nom_nouveau">Nom:</label>
                    <input type="text" class="form-control" id="nom_nouveau" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="description_nouveau">Description:</label>
                    <textarea class="form-control" id="description_nouveau" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="commentaire_habitat_nouveau">Commentaire:</label>
                    <textarea class="form-control" id="commentaire_habitat_nouveau" name="commentaire_habitat" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image_nouveau">Image:</label>
                    <input type="file" class="form-control-file" id="image_nouveau" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-success">Créer Habitat</button>
            </form>
        <?php endif; ?>

        <hr>

        <h3>Liste des habitats existants</h3>
        <?php if (count($habitats) > 0): ?>
            <?php foreach ($habitats as $habitat): ?>
                <div class="habitat-card">
                    <p><strong>Nom:</strong> <?php echo specialchart($habitat['nom']); ?></p>
                    <p><strong>Description:</strong> <?php echo specialchar($habitat['description']); ?></p>
                    <p><strong>Commentaire:</strong> <?php echo specialchar($habitat['commentaire_habitat']); ?></p>
                    <?php if ($habitat['image_data']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($habitat['image_data']); ?>" alt="Image de l'habitat">
                    <?php endif; ?>
                    <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 3): ?>
                        <h4>Modifier l'habitat</h4>
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="modifier_habitat" value="1">
                            <input type="hidden" name="habitat_id" value="<?php echo $habitat['habitat_id']; ?>">

                            <?php if ($_SESSION['role'] == 1): ?>
                                <div class="form-group">
                                    <label for="nom_<?php echo htmlspecialchars($habitat['habitat_id']); ?>">Nom:</label>
                                    <input type="text" class="form-control" id="nom_<?php echo $habitat['habitat_id']; ?>" name="nom" value="<?php echo $habitat['nom']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="description_<?php echo htmlspecialchars($habitat['habitat_id']); ?>">Description:</label>
                                    <textarea class="form-control" id="description_<?php echo htmlspecialchars($habitat['habitat_id']); ?>" name="description" required><?php echo $habitat['description']; ?></textarea>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="commentaire_habitat_<?php echo htmlspecialchars($habitat['habitat_id']); ?>">Commentaire:</label>
                                <textarea class="form-control" id="commentaire_habitat_<?php echo htmlspecialchars($habitat['habitat_id']); ?>" name="commentaire_habitat" required><?php echo $habitat['commentaire_habitat']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image_<?php echo htmlspecialchars($habitat['habitat_id']); ?>">Image:</label>
                                <input type="file" class="form-control-file" id="image_<?php echo htmlspecialchars($habitat['habitat_id']); ?>" name="image" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Modifier Habitat</button>
                        </form>
                        <form action="" method="post" class="mt-2">
                            <input type="hidden" name="supprimer_habitat" value="1">
                            <input type="hidden" name="habitat_id" value="<?php echo htmlspecialchars($habitat['habitat_id']); ?>">
                            <button type="submit" class="btn btn-danger">Supprimer Habitat</button>
                        </form>
                    <?php endif; ?>
>>>>>>> 9f9c0c573ce0135f9bdefdb57e5159c2e1483a67
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun habitat trouvé.</p>
        <?php endif; ?>
<<<<<<< HEAD
    </div>
    <button class="btn btn-secondary btn-retour" onclick="goBack()">Retour</button>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
=======

        <button class="btn btn-secondary btn-retour" onclick="goBack()">Retour</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
>>>>>>> 9f9c0c573ce0135f9bdefdb57e5159c2e1483a67
