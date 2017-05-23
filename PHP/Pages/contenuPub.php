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
          		<center>  Publication contenu</center>
        	</h2>

          <?php include '../Includes/fonctions.php';            
            afficherContenuPub($_GET["codepubAfficher"]);
         

          echo '<form action="traitement.php" method="post">';
            echo "<br>";
              echo '<textarea name="contenucommentaire" rows="6" cols="100"></textarea><br><br>';
              echo '<input type="hidden" value="'.$_GET["codepubAfficher"].'" name="codepubAfficher"> ';
              echo '<input type="submit" value="Envoyer" name="ajouterCommentaire">';
          echo '</form >';
          ?>
        </div>
    
        <?php include('../Includes/footer.php'); ?>
    </div> <!-- /container -->
  <?php include('../Includes/js.php'); ?>
    
  </body>
</html>

