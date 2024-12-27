<?php
require_once '../template/header.php';

$sql = "SELECT * FROM avis WHERE isVisible = TRUE";
$avis = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../style/style_page_avis.css" />

    <h2 class= "titre_page" >L'avis de nos visiteurs</h2>
<div class="container">

    <?php if (count($avis) > 0): ?>
        <?php foreach ($avis as $un_avis): ?>
            <div class= "avis">
                <p><strong><i class="bi bi-person-hearts"></i>  <?php echo htmlspecialchars($un_avis['pseudo']); ?></strong></p>
                <p><?php echo htmlspecialchars($un_avis['commentaire']); ?></p>
            
            </div>
            
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun avis validé.</p>
    <?php endif; ?>

  
    <div class="container mt-5">
        <h2 class="text-success text-center mb-4">Laissez votre avis</h2>
        <?php  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['laisser_avis'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $commentaire = htmlspecialchars($_POST['commentaire']);

    if (!empty($pseudo) && !empty($commentaire)) {
        $sql = "INSERT INTO avis (pseudo, commentaire, isVisible) VALUES (:pseudo, :commentaire, FALSE)";
        $statement = $bdd->prepare($sql);
        $statement->execute([
            ':pseudo' => $pseudo,
            ':commentaire' => $commentaire
        ]);
echo '<div class="alert alert-success" role="alert">Avis soumis avec succès. Il sera visible après validation.</div>';
    } else {
        echo "Veuillez remplir correctement tous les champs.";
    }
}
?>
        <form action="" method="post">
            <input type="hidden" name="laisser_avis" value="1">
            <div class="form-group">
                <label for="pseudo" class="pseudo">Pseudo:</label><br>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
            <div class="form-group">
                <label for="commentaire">Commentaire:</label>
                <textarea class="form-control" id="commentaire" name="commentaire" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Soumettre</button>
        </form>
    </div>

</div>

<?php require_once '../template/footer.php'; ?>
