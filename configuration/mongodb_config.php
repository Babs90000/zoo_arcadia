<?php
require 'vendor/autoload.php'; 

$client = new MongoDB\Client("mongodb+srv://bcamaradiaby:Ordinateur94370@cluster.c9bmy.mongodb.net/arcadia?retryWrites=true");
$database = $client->selectDatabase('arcadia'); 
