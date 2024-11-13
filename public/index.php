<?php

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
  $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: ' . $redirect);
  exit();
}

require_once '../template/header.php';  ?>

<!-- Début Carrousel -->
<main>
  <div class="container-main">
    <div id="carouselExampleCaptions" class="carousel slide d-block mx-auto">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="../assets/image slider/savane.jpg" class="<!-- d-block w-100 --> image_savane" alt="photo de la savane">
          <div class="carousel-caption d-none d-md-block">
            <h5>Des Habitats plus vrai que nature</h5>
            <p>Découvrez un monde où la nature règne en maître, et où chaque habitat est une fenêtre sur la vie sauvage</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../assets/image slider/panneaux solaires.jpg" class="<!-- d-block w-100 --> image_panneaux-solaires" alt="panneaux solaires">
          <div class="carousel-caption d-none d-md-block">
            <h5>Une Indépendance energique</h5>
            <p>Notre zoo fonctionne exclusivement à l’énergie renouvelable, garantissant un impact minimal sur l’environnement.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../assets/image slider/orang_outan_chez_veterinaire-9.webp" class="<!-- d-block w-100 --> image_chimpanze" alt="chimpanze qui se fait soigner">
          <div class="carousel-caption d-none d-md-block">
            <h5>Santé des animaux</h5>
            <p>Nos vétérinaires qui effectuent des contrôles minutieux des animaux chaque jour pour garantir leur bien-être..</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <!-- Fin caroussel -->

    <!-- Texte de présentation arcadia -->
    <div class="presentation_arcadia border border-success border-5 m-5 ">
      <h1>Bienvenue au zoo Arcadia</h1>
      <p>
        Depuis 1960, le Zoo Arcadia est un havre de biodiversité situé près de la légendaire forêt de Brocéliande en Bretagne. Notre zoo abrite une grande variété d’animaux, soigneusement regroupés par habitat : savane, jungle et marais. Nous mettons un point d’honneur à assurer le bien-être de nos résidents grâce à des contrôles vétérinaires quotidiens et une alimentation rigoureusement dosée.</p>
    </div>
    <!-- Fin texte de présentation arcadia -->

    <div class="container my-5">
      <div class="block_habitats">
        <h2 class="text-success text-center mb-4">Nos Habitats</h2>
        <div class="row habitats_list">
          <?php

          $sql = "SELECT habitat_id, nom FROM habitats WHERE nom IN ('savane', 'jungle', 'marais')";
          $habitats = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);

          if (count($habitats) > 0) {
            foreach ($habitats as $habitat) {
              echo "<div class='col-md-4 mb-4'>";
              echo "<div class='card habitat_item'>";
              echo "<a href='../pages/detail_habitat.php?habitat_id=" . $habitat['habitat_id'] . "' class='text-decoration-none'>";
              echo "<div class='card-body'>";
              echo "<p class='card-text text-center text-dark font-weight-bold'>" . $habitat['nom'] . "</p>";
              echo "</div>";
              echo "</a>";
              echo "</div>";
              echo "</div>";
            }
          } else {
            echo "<p class='text-center'>Aucun habitat disponible.</p>";
          }
          ?>
        </div>
        <p class="text-center mt-4"><a href="../pages/page_habitat.php" class="btn btn-success">Cliquez ici pour en savoir plus</a></p>
      </div>
    </div>


    <div class="block_avis">
      <h2>Ce que disent nos visiteurs</h2>
      <?php
      $sql = "SELECT pseudo, commentaire FROM avis WHERE isVisible = TRUE LIMIT 3";
      $avis = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <?php
      if (count($avis) > 0) {
        foreach ($avis as $avi) {
          echo "<div class='element_avis'>";
          echo '<p><strong><i class="bi bi-person-hearts"></i>  ' . $avi['pseudo'] . '</strong></br>' . $avi['commentaire'] . '</p>';
          echo "</div>";
        }
      } else {
        echo "<p>Aucun avis disponible.</p>";
      }


      ?>
    </div>
  </div>
</main>


<?php require_once '../template/footer.php'; ?>