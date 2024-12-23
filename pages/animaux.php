<?php require_once '../template/header.php';
 ?>

<div class="searchContainer">
    <label for="animalSearchBar">Rechercher un animal
        <input type="search" placeholder="Ex:Girafe" id="animalSearchBar" name="animalSearchBar" onkeyup="animalSearch()">
    </label>
</div>

    <div class="resultatSearch" id="resultatSearch"></div>

<?php require_once  '../template/footer.php'; ?>

