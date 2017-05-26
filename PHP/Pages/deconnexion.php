<?php
	//fermeture de la session et redirection vers la page d'accueil
	session_start();
	unset($_SESSION["login"]);
    session_destroy();
    header("location: ../../index.php");
?>