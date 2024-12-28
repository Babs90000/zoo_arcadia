<?php
require_once '../template/header.php'; 


$sql = "SELECT services.*, images.image_data 
        FROM services 
        LEFT JOIN images 
        ON services.service_id = images.service_id";
$services = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<div class="containerServices ">
        <h2 class="text-success text-center mb-4">Nos Services</h2>
        <div class="row">
            <?php

            $sql = "SELECT services.*, images.image_data 
                    FROM services 
                    LEFT JOIN images ON services.service_id = images.service_id";
            $services = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            if (count($services) > 0) {
                foreach ($services as $service) {
                    echo "<div class='col-md-6 col-lg-4 mb-4'>";
                    echo "<div class='card h-100'>";
                    if ($service['image_data']) {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($service['image_data']) . '" alt="Image du service" class="card-img-top style="height= 400px"">';
                    }
                    echo "<div class='card-body d-flex flex-column'>";
                    echo "<h5 class='card-title text-success'>" . htmlspecialchars($service['nom']) . "</h5>";
                    echo "<p class='card-text flex-grow-1'>" . htmlspecialchars($service['description']) . "</p>";
                    echo "<p class='card-text'><strong>Prix:</strong> " . htmlspecialchars($service['prix']) . " </p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center'>" . htmlspecialchars("Aucun service disponible.") . "</p>";
        }
            ?>
        </div>
    </div>

<?php require_once '../template/footer.php'; ?>
<link rel="stylesheet" href="../style/style_page_services.css" />
