<?php require_once '../template/header.php';
<<<<<<< HEAD
=======
ini_set('memory_limit', '1G');
>>>>>>> 9f9c0c573ce0135f9bdefdb57e5159c2e1483a67
 ?>

<div class="searchContainer">
    <label for="animalSearchBar">Rechercher un animal
        <input type="search" placeholder="Ex:Girafe" id="animalSearchBar" name="animalSearchBar" onkeyup="animalSearch()">
    </label>
</div>

    <div class="resultatSearch" id="resultatSearch"></div>

<?php require_once  '../template/footer.php'; ?>

