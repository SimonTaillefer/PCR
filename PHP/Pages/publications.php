<?php require_once('../Modules/session_start.php'); ?>
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
        <h2>
          <center> Publications</center>
        </h2>

        <?php include '../Includes/fonctions.php';
          if (isset($_SESSION['loginch'])) 
           {
             afficherPublicationsChercheurs();
           }
           else
           {
             afficherPublications();
           }
        ?>
      </div>
      <?php include('../Includes/footer.php'); ?>
    </div> <!-- /container -->

    <?php include('../Includes/js.php'); ?>
    
  </body>
</html>

