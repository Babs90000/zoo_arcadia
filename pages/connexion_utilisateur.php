<?php
session_start();

require_once '../configuration/env.php';

if (isset($_POST['Se_connecter'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];

     
   
        $statement = $bdd->prepare('SELECT* FROM utilisateurs WHERE username = :username');
        $statement->bindValue(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        
        if (($user && password_verify($password, $user['password']))=== true) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['role'] = $user['role_id'];
            $_SESSION['message_connexion'] = 'Bonjour '. $user['prenom'].' '. $user['nom'].' Vous êtes connecté ! ';
           
            if ($_SESSION['role'] == 1) {
                header('Location: espace_admin.php');
            } elseif ($_SESSION['role'] == 2) {
                header('Location: espace_employe.php');
            } else  { header('Location: espace_veterinaire.php');
            }
            
        } else {
            echo 'Identifiants incorrects';
        }
    } else {
        echo 'Veuillez compléter tous les champs';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
   
 
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="../style/style_page_connexion.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    
    
    <link
      href="https://fonts.googleapis.com/css2?family=Ga+Maamli&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://kit.fontawesome.com/70e8dd41e8.js"
      crossorigin="anonymous"
    ></script>
<!-- FIN POLICE D'ECRITURE -->

    <script defer href="/script.js"></script>

    <title>Zoo Arcadia</title>
  </head>

  <body>
    <header>
      <nav>
        <img
          src="../assets/Logo/logo arcadia sans fond.png"
          alt="Logo du zoo Arcadia"
          class="logo_arcadia"
        />
        <ul>
          <li><a href="../public/index.php">Accueil</a></li>
          <li><a href="page_services.php">Services</a></li>
          <li><a href="page_habitat.php">Habitats</a></li>
          <li><a href="avis.php">Vos avis</a></li>
        </ul>

        <a href="connexion_utilisateur.php" class="btn_connexion"
          ><i class="fa-solid fa-right-to-bracket"></i> Espace employé</a>

      </nav>
    </header>
<div class="block_connexion">
    <h2>Connexion</h2>
    <form action="" method="post">
        <label for="username">Nom d'utilisateur (e-mail) :</label><br>
        <input type="email" id="username" name="username" required autocomplete="off"><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required autocomplete="off"><br><br>

        <input type="submit" name="Se_connecter" value="Se connecter">
    </form>
    </div>
    
</body>

</html>
