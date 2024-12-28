<?php
session_start();
require_once '../configuration/env.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $avis_id = $_POST['avis_id'];
    if (isset($_POST['valider'])) {
        $sql = "UPDATE avis SET isVisible = TRUE WHERE avis_id = :avis_id";
        $stmt = $bdd->prepare($sql);
        if ($stmt->execute([':avis_id' => $avis_id])) {
            $message = "<div class='alert alert-success'>Avis validé avec succès.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Erreur lors de la validation de l'avis.</div>";
        }
    } elseif (isset($_POST['refuser'])) {
        $sql = "DELETE FROM avis WHERE avis_id = :avis_id";
        $stmt = $bdd->prepare($sql);
        if ($stmt->execute([':avis_id' => $avis_id])) {
            $message = "<div class='alert alert-success'>Avis refusé et supprimé avec succès.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Erreur lors du refus de l'avis.</div>";
        }
    }
}

$sql = "SELECT * FROM avis WHERE isVisible = FALSE";
$avis = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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
          <li><a href="../pages/page_services.php">Services</a></li>
          <li><a href="../pages/page_habitat.php">Habitats</a></li>
          <li><a href="../pages/avis.php">Vos avis</a></li>
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

    <style>
.mt-200 {
            margin-top: 200px;
        }
        </style>
    <div class="container mt-200">
        <h2 class="text-center">Valider les avis</h2>
        <?php echo $message; ?>
        <?php if (count($avis) > 0): ?>
            <?php foreach ($avis as $un_avis): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pseudo: <?php echo htmlspecialchars($un_avis['pseudo']); ?></h5>
                        <p class="card-text">Commentaire: <?php echo htmlspecialchars($un_avis['commentaire']); ?></p>
                        <form action="" method="post" class="d-inline">
                            <input type="hidden" name="avis_id" value="<?php echo htmlspecialchars($un_avis['avis_id']); ?>">
                            <button type="submit" name="valider" class="btn btn-success">Valider</button>
                            <button type="submit" name="refuser" class="btn btn-danger">Refuser</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">Aucun avis à valider.</div>
        <?php endif; ?>
        <button class="btn btn-secondary btn-retour" onclick="goBack()">Retour</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
