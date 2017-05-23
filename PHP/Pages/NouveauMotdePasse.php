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
      <center>
        <h2>
          <center> Compte utilisateur</center>
        </h2>

        <form action="traitement.php" method="post">
          <fieldset>
            <legend>Nouveau mot de passe</legend>
            <br>
            <label>Nom d'utilisateur ou adresse electronique. (obligatoire)</label><br>
            <input type="text" name="username">
            <br>
            <label>Nouveau mot de passe </label><br>
            <input type="password" name="pwd">
            <br>
            <br>
            <input type="submit" value="Changer mot de passe" name="nouveau_mot_de_passe">
          </fieldset>
        </form>
      </center>
    </div>
    <?php include('../Includes/footer.php'); ?>
  </div> <!-- /container -->

  <?php include('../Includes/js.php'); ?>
  
</body>
</html>