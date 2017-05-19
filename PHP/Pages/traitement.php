<?php
session_start();
include '../Includes/fonctions.php';

if (isset($_POST['connexion']))
{
	connexion($_POST["username"],$_POST["motdepasse"]);
}

elseif (isset($_POST['creercompte']))
{
	if (($_POST["utilisateur"])=="chercheur")
	{
		$_SESSION["login"]=inscription_chercheurs ($_POST["nom"],$_POST["prenom"],$_POST["email"],$_POST["tel"],$_POST["motdepasse"],"FALSE");
		header("Location: loginChercheur.php");
	}
	elseif (($_POST["utilisateur"])=="abonne") 
	{
		$_SESSION["login"]=inscription_abonnes ($_POST["nom"],$_POST["prenom"],$_POST["email"],$_POST["motdepasse"],"FALSE");
	}
}
elseif (isset($_POST["nouveau_mot_de_passe"])) 
{
	nouveau_motdePasse ($_POST["username"],$_POST["pwd"]);
}
elseif (isset($_POST["creation_equipe"])) {
		# code...
}

?>