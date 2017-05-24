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
  <link href="../../Styles/style_liste.css" rel="stylesheet">
  <?php include('../Includes/head.php'); ?>
  <script src="../../Javascript/fonction.js" type="text/javascript"></script>
</head>

<body>
  <div class="container">
    <?php include('../Includes/header.html'); ?>
    <!-- Static navbar -->
    <?php include('../Includes/nav.php'); ?>

    <div id="contenu">
      <center>
        <?php include '../Includes/fonctions.php'; 
        echo "<br><center><h1>  Créer un projet  </h1></center><legend></legend>"; ?>
        <?php

        $nom = 'Équipe';

        $chercheurs = array (array("name" => "Chercheurs", "align" => "center", "width" => "40px"));         

        if(isset($_POST["submit"])) {

          if(isset($_POST['nom_equipe']) && isset($_POST['titre_projet']) && isset($_POST['theme_projet'])) {

            $numEq = creerEquipe($_POST['nom_equipe']);

            for($i = 0; $i < sizeof($_POST[$nom]); $i++) {
              ajoutMembreEquipe($_POST[$nom][$i], $numEq);
            }

            ajoutMembreEquipe($_SESSION['loginch'], $numEq);

            $titre = htmlspecialchars($_POST['titre_projet']);
            $theme = htmlspecialchars($_POST['theme_projet']);
            $budget = htmlspecialchars($_POST['budget_projet']);
            $description = "";

            if(isset($_POST['description_projet']))
              $description = htmlspecialchars($_POST['description_projet']);

            creerProjet($_SESSION['loginch'],$titre,$theme,$budget,date("d/m/Y"),$description,$numEq);

            header('Location: /PCR/PHP/Pages/mesProjets.php');
          }
          else {
            header('Location: /PCR/PHP/Pages/creationProjet.php');
          }
        }
        ?>
        <div class="div_cadre">
          <form name="form_select" method="post" action="">
            <fieldset>
              <div align="center" >
                <label>Nom de l'équipe </label><br>
                <input type="text" name="nom_equipe">
                <br>
                <br>
                <label>Choisir les membres de l'équipe </label><br>
                <?php echo checkedSelect($nom, $chercheurs, selectionEquipe()); ?>
                <br>
                <br>
                <label>Titre du projet </label><br>
                <input type="text" name="titre_projet">
                <br>
                <br>
                <label>Theme du projet </label><br>
                <input type="text" name="theme_projet">
                <br>
                <br>
                <label>Budget du projet </label><br>
                <input type="text" name="budget_projet">
                <br>
                <br>
                <label>Description </label><br>
                <textarea name="description_projet" rows="15" cols="90"></textarea>
                <br>
                <br>
                <br /><input type="submit" name="submit" value="Créer le projet" />
              </div>
            </fieldset>
          </form>
        </div>
      </center>
    </div>
    <?php include('../Includes/footer.php'); ?>
  </div> <!-- /container -->

  <?php include('../Includes/js.php'); ?>
  
</body>
</html>