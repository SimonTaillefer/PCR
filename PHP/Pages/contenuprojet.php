<?php
require_once('../Modules/session_start.php');
if (!isset($_SESSION["loginch"]))
  header("Location: /PCR/index.php");
?>
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

          detailProjets ($_SESSION["loginch"],$_GET["codeprojetAfficher"]);
        ?>
       </div>
      <?php include('../Includes/footer.php'); ?>
    </div> <!-- /container -->

    <?php include('../Includes/js.php'); ?>
    
  </body>
</html>

