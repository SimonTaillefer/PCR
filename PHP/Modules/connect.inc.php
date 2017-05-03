<?php
  $user = 'postgres';
  $mdp = 'postgres';
  try{
	 $conn = new PDO ('pgsql:host=localhost;dbname=PCR_BD;charset=UTF8', $user, $mdp, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    }
  catch (PDOException $e){
     echo "Erreur : ".$e->getMessage();
     die();
  }
?>