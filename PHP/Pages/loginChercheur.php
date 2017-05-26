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
        <h3>
          <center> 
          <br>
          Votre login : 
          <?php
          //affichage du login
          if(isset($_SESSION["loginch"])) 
          {
            echo $_SESSION["loginch"]; 
          }
          else 
          {
            echo $_SESSION["loginab"];
          }
          ?>
          </center> 
        </h3>
      
      </div>
    <?php include('../Includes/footer.php'); ?>
    </div> <!-- /container -->

    <?php include('../Includes/js.php'); ?>
    
  </body>
</html>
