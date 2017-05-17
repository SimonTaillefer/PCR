<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <link href="../../Styles/style.css" rel="stylesheet">
    <?php include('../Includes/head.php'); ?>
  </head>

  <body>
    <div class="container">
      <?php include('../Includes/header.html'); ?>
      <!-- Static navbar -->
      <?php include('../Includes/nav.php'); ?>

      <div id="contenu">
        <?php include '../Includes/fonctions.php';
        echo "<br><center><h3>  Annuaire du PCR  </h3></center><br>";
        annuaire();
        ?>
       </div>
      <?php include('../Includes/footer.php'); ?>
    </div> <!-- /container -->

    <?php include('../Includes/js.php'); ?>
    
  </body>
</html>

