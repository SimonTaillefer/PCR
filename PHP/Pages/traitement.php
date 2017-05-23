<?php
require_once('../Modules/session_start.php');
include '../Includes/fonctions.php';

if (isset($_POST['connexion']))
{
	connexion($_POST["username"],$_POST["motdepasse"]);
}

elseif (isset($_POST['creercompte']))
{
	if (($_POST["utilisateur"])=="chercheur")
	{
		$_SESSION["loginch"]=inscription_chercheurs ($_POST["nom"],$_POST["prenom"],$_POST["email"],$_POST["tel"],$_POST["motdepasse"],"FALSE");
		header("Location: loginChercheur.php");
	}
	elseif (($_POST["utilisateur"])=="abonne") 
	{
		$_SESSION["loginab"]=inscription_abonnes ($_POST["nom"],$_POST["prenom"],$_POST["email"],$_POST["motdepasse"],"FALSE");
	}
}
elseif (isset($_POST["nouveau_mot_de_passe"])) 
{
	nouveau_motdePasse ($_POST["username"],$_POST["pwd"]);
}
elseif (isset($_POST["enregistrer"])) 
{
	ajouterPublication($_POST["titrepub"],$_POST["typepub"],$_POST["contenupub"],date("d/m/Y"));
}
elseif (isset($_POST["ajouterCommentaire"])) 
{
	if (isset($_SESSION["loginab"]))
	{
		commenterPublication($_SESSION["loginab"],$_POST["contenucommentaire"],date("d/m/Y"),$_POST["codepubAfficher"]);
	}
	elseif (isset($_SESSION["loginch"])) 
	{
		commenterPublication($_SESSION["loginch"],$_POST["contenucommentaire"],date("d/m/Y"),$_POST["codepubAfficher"]);
	}
}
?>