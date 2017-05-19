<?php require_once('PHP/Modules/session_start.php'); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
	  <link href="Styles/style.css" rel="stylesheet">
	  <?php include('PHP/Includes/head.php'); ?>
  </head>

  <body>
    <div class="container">
	    <?php include('PHP/Includes/header.html'); ?>
      <!-- Static navbar -->
      <?php include('PHP/Includes/nav.php'); ?>
      <div id="contenu">
        <h1><center>Accueil</center></h1>
        <center><img id="img_accueil" src="/PCR/Multimedias/Images/image_accueil.jpg" alt="l'image d'accueil"></center>
        <br>
        <p>L’environnement du financement de la recherche a changé : passage d’un mode de « financement direct » des laboratoires à un mode de « financement par projet », via des institutions et des programmations dédiées. Le management de projets n' a jamais eu autant d'importance qu'aujourd'hui.</p>

        <p>PCR a été développée dans l'objectif principal d'être un outil de collaboration qui permet à des chercheurs de pouvoir mener à bien leurs projets en apportant:</p>
        <ul>
          <li>une plateforme simple d'utilisation et sécurisée</li>
          <li>une plateforme qui centralise les informations</li>
          <li>une plateforme qui facilite la communication intra et inter équipes de chercheurs</li>
          <li>une plateforme qui promeut la recherche en mettant à disposition de tous les informations issues des dernières recherches</li>
          <li>une plateforme qui fédère, facilite et valorise les compétences et les initiatives en matière d'innovation</li>
        </ul>
        <p>PCR est l'outil de collaboration par excellence !</p>
      </div>
      <?php include('PHP/Includes/footer.php'); ?>
    </div> <!-- /container -->

    <?php include('PHP/Includes/js.php'); ?>
    
  </body>
</html>
