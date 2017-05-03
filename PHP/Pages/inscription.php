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
          <center> Inscription Abonnee </center>
        </h2>

         
        <form action="" methode="post">
          <label>Nom </label><br>
          <input type="text" name="nom">
          <br>
          <br>
          <label>Prenom </label><br>
          <input type="text" name="prenom">
          <br>
          <br>
          <label>Email </label><br>
          <input type="text" name="email">
          <br>
          <br>
          <label>Mot de passe</label><br>
          <input type="password" name="motdepasse">
          <br>
          <br>
          <input type="submit" value="valider" name="creercompte">
        </form>
 
       <?php include('../Includes/footer.php'); ?>
    </div>

  </body>
</html>
