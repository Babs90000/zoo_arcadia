<?php
require_once '../configuration/mongodb_config.php';

function incrementationCompteurVisite($animalId)
{
    global $database;

    $collection = $database->selectCollection('decompte_animaux');

    
    $collection->updateOne(
        ['animal_id' => $animalId],
        ['$inc' => ['decompte_visiteurs' => 1]]
    );
}
