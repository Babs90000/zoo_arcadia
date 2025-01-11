<?php
session_start();
require_once '../configuration/env.php';
require_once '../configuration/mongodb_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'creer') {
        try {
            if (!empty($_POST['prenom']) && !empty($_POST['race']) && !empty($_POST['age']) && !empty($_POST['description']) && !empty($_POST['etat']) && !empty($_POST['habitat_id'])) {
                $prenom = htmlspecialchars(($_POST['prenom']));
                $race = htmlspecialchars(($_POST['race']));
                $age = htmlspecialchars((int)$_POST['age']);
                $description = htmlspecialchars(($_POST['description']));
                $etat = htmlspecialchars(($_POST['etat']));
                $habitat_id = htmlspecialchars((int)$_POST['habitat_id']);
                $image_data = null;

                if (!empty($_FILES['image_data']['tmp_name'])) {
                    $image_data = file_get_contents($_FILES['image_data']['tmp_name']);
                }

                $stmt = $bdd->prepare('SELECT race_id FROM races WHERE label = :race');
                $stmt->execute([':race' => $race]);
                $race_id = $stmt->fetchColumn();

                if ($race_id === false) {
                    $stmt = $bdd->prepare('INSERT INTO races (label) VALUES (:race)');
                    $stmt->execute([':race' => $race]);
                    $race_id = $bdd->lastInsertId();
                }

                $stmt = $bdd->prepare('INSERT INTO animaux (prenom, race_id, age, description, etat, habitat_id) VALUES (:prenom, :race_id, :age, :description, :etat, :habitat_id)');
                $stmt->execute([
                    ':prenom' => $prenom,
                    ':race_id' => $race_id,
                    ':age' => $age,
                    ':description' => $description,
                    ':etat' => $etat,
                    ':habitat_id' => $habitat_id
                ]);

                $animal_id = $bdd->lastInsertId();

                if ($image_data) {
                    $stmt = $bdd->prepare('INSERT INTO images (animal_id, image_data) VALUES (:animal_id, :image_data)');
                    $stmt->execute([
                        ':animal_id' => $animal_id,
                        ':image_data' => $image_data
                    ]);
                }

                $_SESSION['message'] = "Ajout de l'animal confirmé";
            } else {
                echo 'Erreur : Tous les champs ne sont pas remplis.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }

        /*  Début insersion un document dans la collection decomppte_animaux  */

        if($_SESSION['message'] = "Ajout de l'animal confirmé")
        {

            $animalId = $bdd->lastInsertId();
    
            
            $stmt = $bdd->prepare('SELECT races.label 
                                                    FROM races 
                                                    INNER JOIN animaux ON animaux.race_id = races.race_id 
                                                    WHERE animaux.animal_id = :animal_id');
            $stmt->execute([':animal_id' => $animalId]);
            $race_label = $stmt->fetchColumn();
    
      
            $document = [
                'Prenom' => $prenom,
                'animal_id' => $animalId,
                'race' => $race_label,
                'decompte_visiteurs' => 0
            ];
    
            $collection = $database->selectCollection('decompte_animaux');
            $collection->insertOne($document);
        }
             
    /*  Fin insersion un document dans la collection decompte_animaux  */

    } elseif ($action === 'modifier') {
        try {
            if (!empty($_POST['animal_id']) && !empty($_POST['prenom']) && !empty($_POST['race']) && !empty($_POST['age']) && !empty($_POST['description']) && !empty($_POST['etat']) && !empty($_POST['habitat_id'])) {
                $prenom = htmlspecialchars(($_POST['prenom']));
                $race = htmlspecialchars(($_POST['race']));
                $age = htmlspecialchars((int)$_POST['age']);
                $description = htmlspecialchars(($_POST['description']));
                $etat = htmlspecialchars(($_POST['etat']));
                $habitat_id = htmlspecialchars((int)$_POST['habitat_id']);
                $image_data = null;

                if (!empty($_FILES['image_data']['tmp_name'])) {
                    $image_data = file_get_contents($_FILES['image_data']['tmp_name']);
                }

                $stmt = $bdd->prepare('SELECT race_id FROM races WHERE label = :race');
                $stmt->execute([':race' => $race]);
                $race_id = $stmt->fetchColumn();

                if ($race_id === false) {
                    $stmt = $bdd->prepare('INSERT INTO races (label) VALUES (:race)');
                    $stmt->execute([':race' => $race]);
                    $race_id = $bdd->lastInsertId();
                }

                $stmt = $bdd->prepare('UPDATE animaux SET prenom = :prenom, race_id = :race_id, age = :age, description = :description, etat = :etat, habitat_id = :habitat_id WHERE animal_id = :animal_id');
                $stmt->execute([
                    ':prenom' => $prenom,
                    ':race_id' => $race_id,
                    ':age' => $age,
                    ':description' => $description,
                    ':etat' => $etat,
                    ':habitat_id' => $habitat_id,
                    ':animal_id' => $animal_id
                ]);

                if ($image_data) {
                    $stmt = $bdd->prepare('UPDATE images SET image_data = :image_data WHERE animal_id = :animal_id');
                    $stmt->execute([
                        ':image_data' => $image_data,
                        ':animal_id' => $animal_id
                    ]);
                }

                $_SESSION['message'] = "Animal modifié avec succès";
            } else {
                echo 'Erreur : Tous les champs ne sont pas remplis.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    } elseif ($action === 'supprimer') {
        try {
            if (!empty($_POST['animal_id'])) {
                $animal_id = (int)$_POST['animal_id'];

                $stmt = $bdd->prepare('DELETE FROM animaux WHERE animal_id = :animal_id');
                $stmt->execute([':animal_id' => $animal_id]);

                $stmt = $bdd->prepare('DELETE FROM images WHERE animal_id = :animal_id');
                $stmt->execute([':animal_id' => $animal_id]);

                $_SESSION['message'] = "Animal supprimé";
            } else {
                echo 'Erreur : L\'ID de l\'animal est manquant.';
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }

        /*  Début suppression d'un document dans la collection decomppte_animaux  */

        if($_SESSION['message'] = "Animal supprimé") {

$collection = $database->selectCollection('decompte_animaux');  
$collection->deleteOne(['animal_id' => $animal_id]);

        }
        /*  Fin suppression d'un document dans la collection decompte_animaux  */
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$query = '
    SELECT animaux.animal_id, animaux.prenom, races.label, animaux.age, animaux.description, animaux.etat, habitats.nom, images.image_data
    FROM animaux
    INNER JOIN images ON animaux.animal_id = images.animal_id
    INNER JOIN races ON animaux.race_id = races.race_id
    INNER JOIN habitats ON animaux.habitat_id = habitats.habitat_id
';
$animaux = $bdd->query($query)->fetchAll(PDO::FETCH_ASSOC);

$habitats = $bdd->query('SELECT habitat_id, nom FROM habitats')->fetchAll(PDO::FETCH_ASSOC);
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
        <h2 class="text-success text-center mb-5">Gestion des Animaux</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <h3>Créer un nouvel animal</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="creer">
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <label for="race">Race:</label>
                <input type="text" class="form-control" id="race" name="race" placeholder="Race" required>
            </div>
            <div class="form-group">
                <label for="age">Âge:</label>
                <input type="number" class="form-control" id="age" name="age" placeholder="Âge" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description" required></textarea>
            </div>
            <div class="form-group">
                <label for="etat">État:</label>
                <input type="text" class="form-control" id="etat" name="etat" placeholder="État" required>
            </div>
            <div class="form-group">
                <label for="habitat_id">Habitat:</label>
                <select class="form-control" id="habitat_id" name="habitat_id" required>
                    <option value="">-- Veuillez choisir un habitat --</option>
                    <?php foreach ($habitats as $habitat): ?>
                        <option value="<?php echo htmlspecialchars($habitat['habitat_id']); ?>"><?php echo htmlspecialchars($habitat['nom']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image_data">Image:</label>
                <input type="file" class="form-control-file" id="image_data" name="image_data">
            </div>
            <button type="submit" class="btn btn-success">Créer</button>
        </form>

        <hr>

        <h3>Liste des animaux</h3>
        <?php if (!empty($animaux)): ?>
            <?php foreach ($animaux as $animal): ?>
                <div class="animal-card">
                    <h4><?php echo $animal['prenom']; ?></h4>
                    <p><strong>Race:</strong> <?php echo htmlspecialchars($animal['label']); ?></p>
                    <p><strong>Âge:</strong> <?php echo htmlspecialchars($animal['age']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($animal['description']); ?></p>
                    <p><strong>État:</strong> <?php echo htmlspecialchars($animal['etat']); ?></p>
                    <p><strong>Habitat:</strong> <?php echo htmlspecialchars($animal['nom']); ?></p>
                    <?php if ($animal['image_data']): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($animal['image_data']); ?>" alt="Photo de <?php echo htmlspecialchar($animal['prenom']); ?>" style="width: 600px;">
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data" class="mt-3">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="animal_id" value="<?php echo $animal['animal_id']; ?>">
                        <div class="form-group">
                            <label for="prenom_<?php echo $animal['animal_id']; ?>">Prénom:</label>
                            <input type="text" class="form-control" id="prenom_<?php echo $animal['animal_id']; ?>" name="prenom" value="<?php echo $animal['prenom']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="race_<?php echo $animal['animal_id']; ?>">Race:</label>
                            <input type="text" class="form-control" id="race_<?php echo $animal['animal_id']; ?>" name="race" value="<?php echo $animal['label']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="age_<?php echo $animal['animal_id']; ?>">Âge:</label>
                            <input type="number" class="form-control" id="age_<?php echo $animal['animal_id']; ?>" name="age" value="<?php echo $animal['age']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description_<?php echo $animal['animal_id']; ?>">Description:</label>
                            <textarea class="form-control" id="description_<?php echo $animal['animal_id']; ?>" name="description" required><?php echo $animal['description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="etat_<?php echo $animal['animal_id']; ?>">État:</label>
                            <input type="text" class="form-control" id="etat_<?php echo $animal['animal_id']; ?>" name="etat" value="<?php echo $animal['etat']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="habitat_id_<?php echo $animal['animal_id']; ?>">Habitat:</label>
                            <select class="form-control" id="habitat_id_<?php echo $animal['animal_id']; ?>" name="habitat_id" required>
                                <option value="">-- Veuillez choisir un habitat --</option>
                                <?php foreach ($habitats as $habitat): ?>
                                    <option value="<?php echo $habitat['habitat_id']; ?>" <?php if (isset($animal['habitat_id']) && $habitat['habitat_id'] == $animal['habitat_id']) echo 'selected'; ?>>
                                        <?php echo $habitat['nom']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image_data_<?php echo $animal['animal_id']; ?>">Image:</label>
                            <input type="file" class="form-control-file" id="image_data_<?php echo htmlspecialchars($animal['animal_id']); ?>" name="image_data">
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>

                    <form method="POST" class="mt-2">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="animal_id" value="<?php echo htmlspecialchars($animal['animal_id']); ?>">
                        <button type="submit" class="btn btn-danger">Supprimer</button><br><br>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun animal trouvé.</p>
        <?php endif; ?>

        <button class="btn btn-secondary btn-retour" onclick="goBack()">Retour</button>

 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
</body>
</html>
