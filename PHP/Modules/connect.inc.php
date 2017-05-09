<?php
  $dbconn = pg_pconnect("dbname=pcr_bd user=postgres password=root")
    or die('Connexion impossible : ' . pg_last_error());
?>