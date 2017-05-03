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
      <?php include('../Includes/nav.html'); ?>
    </div> <!-- /container -->
    <?php include('../Includes/js.php'); ?>

    <div id="apercu">
        <h2>
          <center> Compte utilisateur</center>
        </h2>

         
        <form action="" methode="post">
          <label>Nom d'utilisateur (obligatoire)</label><br>
          <input type="text" name="username">
          <br>
          <br>
          <label>Mot de passe (obligatoire) </label><br>
          <input type="password" name="motdepasse">
          <br>
          <a href="NouveauMotdePasse.php">mot de passe oublié </a>
          <br>
          <br>
          <input type="submit" value="Se Connecter" name="connexion">
        </form>
 
       <?php include('../Includes/footer.php'); ?>
    </div>

  </body>
</html>
