<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail de l'Animal - Zoo Arcadia</title>
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css" />
</head>
<body> 
 
 
 <div class="container mt-5">
        <h2 class="text-success text-center mb-4">Détail de l'Animal</h2>
        <div class="card mb-4">
            <div class="card-body text-center">
                <?php
              require_once '../configuration/env.php';
              require_once 'incrementation_compteur_visite.php';

                if (isset($_GET['animal_id'])) {
                    $animal_id = $_GET['animal_id'];

                    $sql = "SELECT animaux.*, races.label AS race_label FROM animaux 
                            LEFT JOIN races ON animaux.race_id = races.race_id 
                            WHERE animaux.animal_id = :animal_id";
                    $statement = $bdd->prepare($sql);
                    $statement->execute([':animal_id' => $animal_id]);
                    $animal = $statement->fetch(PDO::FETCH_ASSOC);

                    if ($animal) {
                        echo "<h3 class='text-success'>" . $animal['prenom'] . "</h3>";
                        echo "<p><strong>Race:</strong> " . $animal['race_label'] . "</p>";
                        echo "<p><strong>Âge:</strong> " . $animal['age'] . " ans</p>";
                        echo "<p><strong>Description:</strong> " . $animal['description'] . "</p>";

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
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($image['image_data']) . '" alt="Photo de l\'animal" class="img-fluid" style="max-width: 600px;">';
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
                                echo "<p><strong>État de l'animal:</strong> " . $rapport['etat_animal'] . "</p>";
                                echo "<p><strong>Nourriture proposée:</strong> " . $rapport['nourriture_proposee'] . "</p>";
                                echo "<p><strong>Grammage de la nourriture:</strong> " . $rapport['grammage_nourriture'] . "</p>";
                                echo "<p><strong>Date de passage:</strong> " . $rapport['date_passage'] . "</p>";
                                if (!empty($rapport['detail_etat_animal'])) {
                                    echo "<p><strong>Détail de l'état de l'animal:</strong> " . $rapport['detail_etat_animal'] . "</p>";
                                }
                                echo "<hr>";
                            }
                        } else {
                            echo "<p>Aucun rapport vétérinaire trouvé pour cet animal.</p>";
                        }
                    } else {
                        echo "<p>Animal non trouvé.</p>";
                    }
                } else {
                    echo "<p>ID de l'animal manquant.</p>";
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
