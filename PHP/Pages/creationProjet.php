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
      echo "<br><center><h3>  Créer un projet  </h3></center><br>"; ?>
      <form action="traitement.php" method="post">
        <fieldset>
          <legend>Création du projet</legend>
          <label>Sélectionner les membres de l'équipe </label>
          <br>
          <select name="username" size="5" multiple>
            <?php
            $chercheurs = selectionEquipe();
            foreach ($chercheurs as $chercheur) {
              echo '<option>'.$chercheur.'</option>';
            }
            ?>
          </select>
          <br>
          <br>
          <label>Nom de l'équipe </label><br>
          <input type="text" name="nomEquipe">
          <br>
          <br>
          <input type="submit" value="Créer projet" name="creationProjet">
        </fieldset>
      </form>
    </div>
    <?php include('../Includes/footer.php'); ?>
  </div> <!-- /container -->

  <?php include('../Includes/js.php'); ?>
  
</body>
</html>