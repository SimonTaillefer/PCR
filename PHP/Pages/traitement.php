<?php
require_once('../Modules/session_start.php');
include '../Includes/fonctions.php';

// Formulaire de connexion
if (isset($_POST['connexion']))
{
	connexion($_POST["username"],$_POST["motdepasse"]);
}
// Formulaire de création de compte chercheur ou abonné
elseif (isset($_POST['creercompte']))
{
	// création de compte chercheur
	if (($_POST["utilisateur"])=="chercheur")
	{
		$_SESSION["loginch"]=inscription_chercheurs ($_POST["nom"],$_POST["prenom"],$_POST["email"],$_POST["tel"],$_POST["motdepasse"],"FALSE");
		header("Location: loginChercheur.php");
	}
	// création de compte abonné
	elseif (($_POST["utilisateur"])=="abonne") 
	{
		$_SESSION["loginab"]=inscription_abonnes ($_POST["nom"],$_POST["prenom"],$_POST["email"],$_POST["tel"],$_POST["motdepasse"],"FALSE");
		header("Location: loginChercheur.php");
	}
}
// Formulaire de mot de passe perdu
elseif (isset($_POST["nouveau_mot_de_passe"])) 
{
	nouveau_motdePasse ($_POST["username"],$_POST["pwd"]);
}
// Formulaire de création d'une publication
elseif (isset($_POST["enregistrer"])) 
{
	ajouterPublication($_POST["titrepub"],$_POST["typepub"],$_POST["contenupub"],date("d/m/Y"));
}
// Formulaire de commentaire d'une publication
elseif (isset($_POST["ajouterCommentaire"])) 
{
	// Commentaire d'un abonné
	if (isset($_SESSION["loginab"]))
	{
		commenterPublication($_SESSION["loginab"],$_POST["contenucommentaire"],date("d/m/Y"),$_POST["codepubAfficher"]);
	}
	// Commentaire d'un chercheur
	elseif (isset($_SESSION["loginch"])) 
	{
		commenterPublication($_SESSION["loginch"],$_POST["contenucommentaire"],date("d/m/Y"),$_POST["codepubAfficher"]);
	}
	// Si on tente de faire un commentaire sans être connecté
	else
	{
		header("Location: /PCR/index.php");
	}
}
// Formulaire d'upload de fichier
elseif (isset($_POST["ajouter_fich"])) {
	/*ajoutFichier($_FILES['nom_fich'],$_FILES['nom_fich']['tmp_name'],$_FILES['nom_fich']['size'],$_FILES['nom_fich']['error'],'/PCR/Fichiers/'.$_FILES['nom_fich']['name'],10000);
	*/
	$content_dir = '/PCR/Fichiers/'; // dossier où sera déplacé le fichier

    $tmp_file = $_FILES['fichier']['tmp_name'];

    if( !is_uploaded_file($tmp_file) )
    {
        header("Location: /PCR/index.php");
    }

    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['fichier']['name'];

    if( !move_uploaded_file($tmp_file, $content_dir . $name_file))
    {
        header("Location: /PCR/index.php");
    }

    header("Location: /PCR/PHP/Pages/mesProjets.php");
}
else
{
	header("Location: /PCR/index.php");
}
?>