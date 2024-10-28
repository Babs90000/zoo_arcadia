<?php

require_once '../configuration/env.php';


$sql = "SELECT type_jour, heure_ouverture, heure_fermeture FROM horaires_ouverture";
$statement = $bdd->prepare($sql);
$statement->execute();
$horaires = $statement->fetchAll(PDO::FETCH_ASSOC);


$horaires_semaine = '';
$horaires_autres = '';


foreach ($horaires as $horaire) {
  if ($horaire['type_jour'] == 'En semaine') {
    $horaires_semaine = $horaire['heure_ouverture'] . ' - ' .$horaire['heure_fermeture'];
  } elseif ($horaire['type_jour'] == 'Autres jours') {
    $horaires_autres = $horaire['heure_ouverture'] . ' - ' . $horaire['heure_fermeture'];
  }
}
?>



<footer>
      <!-- <div class="footer_container"> -->
      <div class="adresse_et_contact">
        <a href="https://www.google.fr/maps/place/1+Pl.+du+Roi+Saint-Judicael,+35380+Paimpont/@48.0191776,-2.1741847,16.77z/data=!4m6!3m5!1s0x480fada98c18e4a7:0x9069468ab7e79161!8m2!3d48.0186478!4d-2.1732679!16s%2Fg%2F11c4wjqh8q?entry=ttu&g_ep=EgoyMDI0MDgyOC4wIKXMDSoASAFQAw%3D%3D" target="_blank">
          <p> 
            <strong class="intitule"><i class="bi bi-geo-alt-fill"></i> Où nous trouver ?</strong><br>
            1 place du roi Saint-Judicaël <br>
            35380 Paimpont Bretagne, France
          </p>
        </a>
        <p><strong>Contact</strong><br>
        <a href="../pages/formulaire_contact.php"><i class="bi bi-envelope-at-fill"></i> Formulaire de contact</a><br>
       <a href="tel:+33145074569"><i class="bi bi-telephone-fill"></i> +33145074569</a></p>
      </div>
      

        <div class="block_suivi_rs ">
          <h2 class="titre-footer">SUIVEZ-NOUS</h2>
            <div class="logo-rs">
              <a href="#"><i class="bi bi-facebook"></i>
              <a href="#"><i class="bi bi-twitter-x"></i></a>
              <a href="#"><i class="bi bi-tiktok"></i></a>
              <a href="#"><i class="bi bi-instagram"></i></a>
              <a href="#"><i class="bi bi-youtube"></i></a>
              <a href="#"><i class="bi bi-threads"></i></a>
            </div>
        </div>
  
            <div class="horaire_ouverture">
              <p class="horaire"><i class="bi bi-calendar-day-fill"></i><br><strong>Nos horaires d'ouverture</strong><br>
                En semaine : <?php echo $horaires_semaine; ?><br>
              Autres jours : <?php echo $horaires_autres; ?></p><br>
              
              </div>       
      <!-- </div>
 -->
    </footer>
  </body>
</html>
