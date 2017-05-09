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

         
        <form action="" method="post">
          <label>Nom d'utilisateur ou adresse electronique. (obligatoire)</label><br>
          <input type="text" name="username">
          <br>
          <br>
          <input type="submit" value="Envoyer nouveau mot de passe" name="nouveau_mot_de_passe">
        </form>
 
       <?php include('../Includes/footer.php'); ?>
    </div>

  </body>
</html>
