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
          <center> Ajouter Publication </center>
        </h2>

        <form action="traitement.php" method="post">
         <label>Type publication : </label>
         <select name="typepub">
          <option value=rapport>rapport</option>
          <option value=memoire>mémoire</option>
          <option value=article>article</option>
          <option value=compte-rendu>compte-rendu</option>
        </select>
        <br>
        <label>Titre</label><br>
        <input type="text" name="titrepub"><br>
        <label>Contenu</label><br>
        <textarea name="contenupub" rows="50" cols="90"></textarea><br><br>
        <input type="submit" value="Enregistrer" name="enregistrer">
      </form >
    </div>
  </center>
  <?php include('../Includes/footer.php'); ?>
</div> <!-- /container -->
<?php include('../Includes/js.php'); ?>

</body>
</html>

