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
        <h1>
          <center> <br>Compte utilisateur</center>
        </h1>

        <!-- Formulaire de connexion -->
        <form action="traitement.php" method="post">
          <fieldset>
            <legend></legend>
            <label>Nom d'utilisateur </label><br>
            <input type="text" name="username">
            <br>
            <br>
            <label>Mot de passe </label><br>
            <input type="password" name="motdepasse">
            <br>
            <a href="NouveauMotdePasse.php">mot de passe oublié </a>
            <br>
            <br>
            <input type="submit" value="Se Connecter" name="connexion">
          </fieldset>
        </form>

        <!-- affichage d'un msg derreur si l'identificatition echou -->
        <?php 
        if (isset($_GET['msgErreur']))  
        {
          echo '<p>' . $_GET['msgErreur'] . '</p>';
        }
        ?>
      </center>
    </div>
    <?php include('../Includes/footer.php'); ?>
  </div> <!-- /container -->

  <?php include('../Includes/js.php'); ?>
  
</body>
</html>

