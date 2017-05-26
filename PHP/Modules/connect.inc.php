<?php
// Connexion à la base de données ou affichage d'un message d'erreur
$dbconn = pg_pconnect("dbname=pcr_bd user=postgres password=root")
or die('Connexion impossible : ' . pg_last_error());
?>