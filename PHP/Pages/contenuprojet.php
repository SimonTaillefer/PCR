<?php
// Sécurité en cas d'accès sans connexion, on redirige vers la page d'accueil
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
      <center>
        <h1>
          <center><br>Projet</center><legend></legend>
        </h1>
        <?php include '../Includes/fonctions.php';
        // Appel de la fonction du fichiers fonctions.php qui affiche le détail du projet
        detailProjets ($_SESSION["loginch"],$_GET["codeprojetAfficher"]);
        ?>
        <br><br>
        <fieldset>
        <!-- Formulaire de dépôt d'un fichier -->
          <legend>Déposer des fichiers</legend>
          <form method="post" action="traitement.php" enctype="multipart/form-data">
            <label for="mon_fichier">Fichier (tous formats de max. 10 Mo) :</label><br />
            <!-- Limite la taille de l'upload du fichier -->
            <input type="hidden" name="MAX_FILE_SIZE" value="10000 " /><br>
            <input type="file" name="nom_fich"/><br>
            <input type="submit" name="ajouter_fich" value="Ajouter fichier" />
          </form>
        </fieldset>
      </center>
    </div>
    <?php include('../Includes/footer.php'); ?>
  </div> <!-- /container -->

  <?php include('../Includes/js.php'); ?>

</body>
</html>

