<?php
$hostname = $_ENV['DB_HOST']      ?? getenv('DB_HOST')      ?? 'mariadb-cscko4wogso40owksk48o08o';
$database = $_ENV['DB_NAME']      ?? getenv('DB_NAME')      
         ?? $_ENV['MARIADB_DATABASE'] ?? getenv('MARIADB_DATABASE') ?? 'asiria';
$username = $_ENV['DB_USER']      ?? getenv('DB_USER')      
         ?? $_ENV['MARIADB_USER']     ?? getenv('MARIADB_USER')     ?? 'root';
$password = $_ENV['DB_PASSWORD']  ?? getenv('DB_PASSWORD')  
         ?? $_ENV['MARIADB_PASSWORD'] ?? getenv('MARIADB_PASSWORD') ?? '';

try {
    $bdd = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit();
}