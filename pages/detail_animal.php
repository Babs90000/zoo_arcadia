
<?php
require_once 'incrementation_compteur_visite.php';
require_once '../template/header.php';
?>
 
 
 <div class="container detail_animal_container">
        <h2 class="text-success text-center mb-4">Détail de l'Animal</h2>
        <div class="card mb-4">
            <div class="card-body text-center">
                <?php

                if (isset($_GET['animal_id'])) {
                    $animal_id = $_GET['animal_id'];

                    $sql = "SELECT animaux.*, races.label AS race_label FROM animaux 
                            LEFT JOIN races ON animaux.race_id = races.race_id 
                            WHERE animaux.animal_id = :animal_id";
                    $statement = $bdd->prepare($sql);
                    $statement->execute([':animal_id' => $animal_id]);
                    $animal = $statement->fetch(PDO::FETCH_ASSOC);

                    if ($animal) {
                        echo "<h3 class='text-success'>" . htmlspecialchars($animal['prenom']) . "</h3>";
                        echo "<p><strong>Race:</strong> " . htmlspecialchars($animal['race_label']) . "</p>";
                        echo "<p><strong>Âge:</strong> " . htmlspecialchars($animal['age']) . " ans</p>";
                        echo "<p><strong>Description:</strong> " . htmlspecialchars($animal['description']) . "</p>";


                        $sql = "SELECT image_data FROM images WHERE animal_id = :animal_id";
                        $statement = $bdd->prepare($sql);
                        $statement->execute([':animal_id' => $animal_id]);
                        $images = $statement->fetchAll(PDO::FETCH_ASSOC);

                        if ($images) {
                            echo "<h3 class='text-success'>Photos de l'animal</h3>";
                            echo "<div class='row'>";
                            foreach ($images as $image) {
                                if (!empty($image['image_data'])) {
                                    echo '<div class="detailAnimal col-md-4 mb-3" >';
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($image['image_data']) 
                                    . '" alt="Photo de l\'animal" class="img-fluid" style="max-width: 600px;">';
                                    echo '</div>';
                                }
                            }
                            echo "</div>";
                        }

                        $sql = "SELECT etat_animal, nourriture_proposee, grammage_nourriture, date_passage, detail_etat_animal 
                                FROM rapports_veterinaires 
                                WHERE animal_id = :animal_id";
                        $statement = $bdd->prepare($sql);
                        $statement->execute([':animal_id' => $animal_id]);
                        $rapports = $statement->fetchAll(PDO::FETCH_ASSOC);

                        if ($rapports) {
                            echo "<h3 class='text-success'>Rapports Vétérinaires</h3>";
                            foreach ($rapports as $rapport) {
                                echo "<p><strong>État de l'animal:</strong> " . htmlspecialchars($rapport['etat_animal']) . "</p>";
                                echo "<p><strong>Nourriture proposée:</strong> " . htmlspecialchars($rapport['nourriture_proposee']) . "</p>";
                                echo "<p><strong>Grammage de la nourriture:</strong> " . htmlspecialchars($rapport['grammage_nourriture']) . "</p>";
                                echo "<p><strong>Date de passage:</strong> " . htmlspecialchars($rapport['date_passage']) . "</p>";
                                if (!empty($rapport['detail_etat_animal'])) {
                                    echo "<p><strong>Détail de l'état de l'animal:</strong> " . htmlspecialchars($rapport['detail_etat_animal']) . "</p>";
                                }
                                echo "<hr>";
                            }
                        } else {
                            echo "<p>" . htmlspecialchars("Aucun rapport vétérinaire trouvé pour cet animal.") . "</p>";
                        }
                    } else {
                        echo "<p>" . htmlspecialchars("Animal non trouvé.") . "</p>";
                    }
                } else {
                    echo "<p>" . htmlspecialchars("ID de l'animal manquant.") . "</p>";
                }

                $animal_id = $_GET['animal_id'];
                incrementationCompteurVisite($animal_id);
                ?>
            </div>
        </div>
        <p class="text-center"><a onclick="window.history.back()" class="btn btn-success">Retour à la liste des habitats</a></p>
    </div>
</body>
</html>
