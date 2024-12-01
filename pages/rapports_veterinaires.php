<?php require_once '../template/header.php'; ?>
<link rel="stylesheet" href="../style/style.css" />
<link rel="stylesheet" href="../style/style_rapports_veterinaires.css" />

<?php if (!isset($_SESSION['role']) || ($_SESSION['role'] != 3 && $_SESSION['role'] != 1)) {
    Header('Location: ../deconnexion.php');
} 
?>
    <h1 class="titre_rapports_veterinaires">Rapports Vétérinaires</h1>
    <div class="rapports_veterinaires">

    <form method="GET" action="rapports_veterinaires.php">
        <label for="search">Rechercher par prénom de l'animal :</label>
        <input type="text" id="search" name="search" placeholder="Entrez le prénom de l'animal">
        <button type="submit">Rechercher</button>
    </form>

  
        <?php

        $search = isset($_GET['search']) ? $_GET['search'] : '';

        $sql = "SELECT rapports_veterinaires.*, animaux.prenom 
                FROM rapports_veterinaires
                JOIN animaux ON rapports_veterinaires.animal_id = animaux.animal_id";
        if ($search) {
            $sql .= " WHERE animaux.prenom LIKE :search";
        }

        $stmt = $bdd->prepare($sql);
        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        $stmt->execute();
        $rapports = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rapports) > 0) {
            foreach ($rapports as $rapport) {
                echo "<div class='rapport_item'>";
                echo "<p><strong>Prénom de l'animal :</strong> " . htmlspecialchar($rapport['prenom']) . "</p>";
                echo "<p><strong>Date de passage :</strong> " . htmlspecialchar($rapport['date_passage']) . "</p>";
                echo "<p><strong>État de l'animal :</strong> " . htmlspecialchar($rapport['etat_animal']) . "</p>";
                echo "<p><strong>Nourriture proposée :</strong> " . htmlspecialchar($rapport['nourriture_proposee']) . "</p>";
                echo "<p><strong>Grammage de la nourriture :</strong> " . htmlspecialchar($rapport['grammage_nourriture']) . "</p>";
                echo "<p><strong>Détails de l'état de l'animal :</strong> " . htmlspecialchar($rapport['detail_etat_animal']) . "</p>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>Aucun rapport vétérinaire disponible.</p>";
        }
        ?>
    </div>
    <button class="btn btn-secondary btn-retour" onclick="goBack()">Retour</button>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
