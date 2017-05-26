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
          <center> <br>Inscription </center>
        </h1>

        <!-- formulaire d'inscription  -->
        <form action="traitement.php" method="post">
          <fieldset>
            <legend></legend>
            <label>Vous êtes un ? </label>
            <select name="utilisateur">
              <option value=chercheur>Chercheur</option>
              <option value=abonne>Abonné</option>
            </select>
            <br>
            <br>
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
            <label>Telephone </label><br>
            <input type="number" name="tel">
            <br>
            <br>
            <label>Mot de passe</label><br>
            <input type="password" name="motdepasse">
            <br>
            <br>
            <input type="submit" value="valider" name="creercompte">
          </fieldset>
        </form>
      </center>
    </div>
    <?php include('../Includes/footer.php'); ?>
  </div> <!-- /container -->

  <?php include('../Includes/js.php'); ?>
  
</body>
</html>


