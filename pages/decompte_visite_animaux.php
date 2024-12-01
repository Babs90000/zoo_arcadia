<?php
require_once '../template/header.php';
require_once '../configuration/mongodb_config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    $collection = $database->selectCollection('decompte_animaux');
    $query = [];
    if ($search) {
        $query = ['prenom' => new MongoDB\BSON\Regex($search, 'i')];
    }
    $documents = $collection->find($query);
?>
    <link rel="stylesheet" href="../style/style_decompte_visite_animaux.css">
    <div class="container">
        <form method="GET" action="decompte_visite_animaux.php" class="search-form">
            <input type="text" name="search" placeholder="Rechercher par prénom" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Rechercher</button>
        </form>
    <div class="ensemble_card">
    <?php
    foreach ($documents as $document) {
        echo '
            <div class="card">
                <h2>' . htmlspecialchars($document['prenom']) . '</h2>
                <p>Race: ' . htmlspecialchars($document['race']) . '</p>
                <p>Nombre de visites: ' . htmlspecialchars($document['decompte_visiteurs']) . '</p>
            </div>';
    }
} catch (Exception $e) {
    echo 'Erreur : ' . htmlspecialchars($e->getMessage());
}
    ?>
    </div>
    </div>
    <button onclick="window.history.back()">Retour</button>