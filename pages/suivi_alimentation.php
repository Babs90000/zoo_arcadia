<?php
require_once '../template/header.php';

$sql = "SELECT animaux.prenom, alimentation.date, alimentation.type_nourriture, alimentation.quantite_grammes, alimentation.heure 
        FROM alimentation 
        JOIN animaux ON alimentation.animal_id = animaux.animal_id 
        ORDER BY alimentation.date DESC";
$alimentation = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de la Nourriture des Animaux</title>
    <link rel="stylesheet" href="../style/styles.css">
</head>
<body>
    <main>
        <div class="container">
            <h1 class="suivi_nourriture_animaux">Suivi de la Nourriture des Animaux</h1>
            <?php if (count($alimentation) > 0): ?>
                <table class="table_alimentation">
                    <thead>
                        <tr>
                            <th>Animal</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Type de Nourriture</th>
                            <th>Quantité (grammes)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alimentation as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['heure']); ?></td>
                                <td><?php echo htmlspecialchars($row['type_nourriture']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantite_grammes']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune donnée disponible.</p>
            <?php endif; ?>
            <button class="btn btn-secondary btn-retour" onclick="goBack()">Retour</button>
        </div>
    </main>
   
</body>
</html>
