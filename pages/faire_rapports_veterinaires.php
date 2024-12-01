<?php
session_start();
require_once '../configuration/env.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 3 && $_SESSION['role'] != 1)) {
    echo 'Accès refusé. Seuls les vétérinaires peuvent accéder à cette page.';
    exit();
}

$sql = "SELECT animal_id, prenom FROM animaux";
$statement = $bdd->prepare($sql);
$statement->execute();
$animaux = $statement->fetchAll(PDO::FETCH_ASSOC);

$alert_message = '';
$alert_class = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['animal_id']) && !empty($_POST['etat_animal']) && !empty($_POST['nourriture_proposee']) 
    && !empty($_POST['grammage_nourriture']) && !empty($_POST['date_passage'])) {
        $animal_id = htmlspecialcharss($_POST['animal_id']);
        $etat_animal = htmlspecialcharss($_POST['etat_animal']);
        $nourriture_proposee = htmlspecialcharss($_POST['nourriture_proposee']);
        $grammage_nourriture = htmlspecialcharss($_POST['grammage_nourriture']);
        $date_passage = htmlspecialcharss($_POST['date_passage']);
        $detail_etat_animal = !empty($_POST['detail_etat_animal']) ? htmlspecialcharss($_POST['detail_etat_animal']) : null;
        $username = $_SESSION['username'];

        $sql = "INSERT INTO rapports_veterinaires (animal_id, etat_animal, nourriture_proposee, 
        grammage_nourriture, date_passage, detail_etat_animal, username) VALUES (:animal_id, :etat_animal,
         :nourriture_proposee, :grammage_nourriture, :date_passage, :detail_etat_animal, :username)";
         
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':animal_id' => $animal_id,
            ':etat_animal' => $etat_animal,
            ':nourriture_proposee' => $nourriture_proposee,
            ':grammage_nourriture' => $grammage_nourriture,
            ':date_passage' => $date_passage,
            ':detail_etat_animal' => $detail_etat_animal,
            ':username' => $username
        ]);

        $alert_message = 'Rapport vétérinaire créé avec succès.';
        $alert_class = 'alert-success';
    } else {
        $alert_message = 'Veuillez remplir tous les champs obligatoires.';
        $alert_class = 'alert-danger';
    }
}
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
        .mt-200 {
            margin-top: 200px;
        }
    </style>
    <div class="container mt-200">
        <h2 class="text-success text-center mb-4">Créer un rapport vétérinaire</h2>
        <?php if ($alert_message): ?>
            <div class="alert <?php echo $alert_class; ?>" role="alert">
                <?php echo htmlspecialchars($alert_message); ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="animal_id">Sélectionner un animal:</label>
                <select class="form-control" id="animal_id" name="animal_id" required>
                    <option value="">--Sélectionner un animal--</option>
                    <?php foreach ($animaux as $animal): ?>
                        <option value="<?php echo htmlspecialchars($animal['animal_id']); ?>"><?php echo htmlspecialchars($animal['prenom']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="etat_animal">État de l'animal:</label>
                <select class="form-control" id="etat_animal" name="etat_animal" required>
                    <option value="">--Sélectionner l'état de l'animal--</option>
                    <option value="En très bonne forme">En très bonne forme</option>
                    <option value="En forme">En forme</option>
                    <option value="En mauvaise forme">En mauvaise forme</option>
                    <option value="Malade">Malade</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nourriture_proposee">Nourriture proposée:</label>
                <input type="text" class="form-control" id="nourriture_proposee" name="nourriture_proposee" required>
            </div>
            <div class="form-group">
                <label for="grammage_nourriture">Grammage de la nourriture:</label>
                <input type="number" class="form-control" id="grammage_nourriture" name="grammage_nourriture" required>
            </div>
            <div class="form-group">
                <label for="date_passage">Date de passage:</label>
                <input type="date" class="form-control" id="date_passage" name="date_passage" required>
            </div>
            <div class="form-group">
                <label for="detail_etat_animal">Détail de l'état de l'animal (facultatif):</label>
                <textarea class="form-control" id="detail_etat_animal" name="detail_etat_animal" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Créer Rapport</button>
        </form>
        <button class="btn btn-secondary btn-retour" onclick="goBack()">Retour</button>
    </div>

   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
