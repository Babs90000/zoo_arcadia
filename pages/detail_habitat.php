<?php require_once '../template/header.php'; ?>

<div class="containerDetailHabitat ">
        <h2 class="text-success text-center mb-4">Détail de l'Habitat</h2>
        <div class="card mb-4 text-center">
            <div class="card-body text-center">
                <?php
            

                if (isset($_GET['habitat_id'])) {
                    $habitat_id = $_GET['habitat_id'];

                    $sql = "SELECT habitats.*, images.image_data FROM habitats LEFT JOIN images ON habitats.habitat_id = images.habitat_id WHERE habitats.habitat_id = :habitat_id";
                    $statement = $bdd->prepare($sql);
                    $statement->execute([':habitat_id' => $habitat_id]);
                    $habitat = $statement->fetch(PDO::FETCH_ASSOC);

                    if ($habitat) {
                        echo "<p><strong>Nom:</strong> " . $habitat['nom'] . "</p>";
                        echo "<p><strong>Description:</strong> " . $habitat['description'] . "</p>";
                        echo "<p><strong>Commentaire:</strong> " . $habitat['commentaire_habitat'] . "</p>";

                        if ($habitat['image_data']) {
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($habitat['image_data']) . '" alt="Image de l\'habitat" class="img-fluid mb-3" style="max-width: 600px;">';
                        }

                        $sql_animaux = "SELECT animaux.animal_id, animaux.prenom, races.label 
                                        FROM animaux 
                                        LEFT JOIN races ON animaux.race_id = races.race_id 
                                        WHERE animaux.habitat_id = :habitat_id";
                        $statement_animaux = $bdd->prepare($sql_animaux);
                        $statement_animaux->execute([':habitat_id' => $habitat_id]);
                        $animaux = $statement_animaux->fetchAll(PDO::FETCH_ASSOC);

                        if (count($animaux) > 0) {
                            echo "<h3>Animaux dans cet habitat :</h3>";
                            echo "<ul class='list-groupAnimaux '>";
                            foreach ($animaux as $animal) {
                                echo "<li class='list-group-item'><a href='detail_animal.php?animal_id=" . $animal['animal_id'] . "'>" . $animal['prenom'] . " - " . $animal['label'] . "</a></li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>Aucun animal dans cet habitat.</p>";
                        }
                    } else {
                        echo "<p>Habitat non trouvé.</p>";
                    }
                } else {
                    echo "<p>ID de l'habitat manquant.</p>";
                }
                ?>
            </div>
        </div>
        <p class="text-center"><a href="page_habitat.php" class="btn btn-success">Retour à la liste des habitats</a></p>
    </div>

<?require_once '../template/footer.php'; ?>
    
