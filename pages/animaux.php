<?php require_once __DIR__ . '../template/header.php'; ?>

<script src="../js/script.js" defer></script>

<fieldset>
    <label for="animalSearchBar">Rechercher un animal
        <input type="search" placeholder="Ex:Girafe" id="animalSearchBar" name="animalSearchBar" onkeyup="animalSearch()">
    </label>
</fieldset>

<div class="resultatSearch" id="resultatSearch"></div>

<?php require_once __DIR__ . '../template/footer.php'; ?>

