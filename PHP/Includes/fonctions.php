<?php

#Cette fonction d'afficher la liste des publications à un chercheur
function afficherPublicationsChercheurs()
{
    #connexion à la BD
    require_once("../Modules/connect.inc.php");

    #requete SQL ()
    $requete='SELECT titrepub, typepub, datepub,nomch,prenomch FROM publications p, publier pu, chercheurs ch WHERE p.codepub=pu.codepub AND pu.loginch=ch.loginch';
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);

    $num=$num+1;

    for ($i=1; $i<$num; $i++) 
    {
        $row=pg_fetch_array($result);
        echo "<br>";
        echo "<h4><i>".ucfirst($row["typepub"])."</i></h4>";
        #echo '<a href="/PCR/PHP/Pages/contenuPub.php?titrepubAfficher='.$row["titrepub"].'&codepubAfficher='.$i.'"  type="submit" name="titrepubAfficher">'.$row["titrepub"]."</a><br>";
        echo '<a href="/PCR/PHP/Pages/contenuPub.php?codepubAfficher='.$i.'"  type="submit" name="titrepubAfficher">'.$row["titrepub"]."</a><br>";
        echo $row["datepub"]."<br>";
        echo "<i>".strtoupper($row["nomch"])." ".ucfirst($row["prenomch"])."</i><br><br>";
    }
}

#Cette fonction permet d'afficher les publications de type article à un abonné
function afficherPublications()
{
    #connexion à la BD
    require_once("../Modules/connect.inc.php");

    $requete="SELECT titrepub, typepub, datepub,nomch,prenomch FROM publications p, publier pu, chercheurs ch WHERE p.codepub=pu.codepub AND pu.loginch=ch.loginch AND typePub='article' ORDER BY datepub";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);
    
    $num=$num+1;

    for ($i=1; $i<$num; $i++) 
    {
        $row=pg_fetch_array($result);
        echo "<br>";
        echo "<h4><i>".ucfirst($row["typepub"])."</i></h4>";
        #echo '<a href="/PCR/PHP/Pages/contenuPub.php?titrepubAfficher='.$row["titrepub"].'&codepubAfficher='.$i.'"  type="submit" name="titrepubAfficher">'.$row["titrepub"]."</a><br>";
        echo '<a href="/PCR/PHP/Pages/contenuPub.php?codepubAfficher='.$i.'"  type="submit" name="titrepubAfficher">'.$row["titrepub"]."</a><br>";
        echo $row["datepub"]."<br>";
        echo "<i>".strtoupper($row["nomch"])." ".ucfirst($row["prenomch"])."</i><br><br>";
    }
}


#Cette fonction permet d'enregistrer une publication faite par un chercheur dans un fichier
function ajouterPublication($titre,$type,$contenu,$date)
{
    #connexion à la BD
    require_once("../Modules/connect.inc.php");

    #creation et ouverture du fichier contenant la publication
    $monfichier = fopen("../../Fichiers/".$titre.".html", 'a+');


    fputs($monfichier,"$contenu"); 

    fclose($monfichier);

    $requete='SELECT * FROM publications';
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);

    $num=$num+1;
    //enregistrement de la publication
    $requete="INSERT INTO publications VALUES('".$num."','".$titre."','".$type."','".$date."')";
    //enregistrement de l'auteur
    $requete1="INSERT INTO publier VALUES('".$num."','".$_SESSION["loginch"]."')";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $result = pg_exec($dbconn,$requete1) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    header("location: publications.php");   
}


#Cette fonction permet d'afficher une publication au complet et les commentaires faites dessus
function afficherContenuPub($codepub)
{
    require_once("../Modules/connect.inc.php");

    
    $requete="SELECT titrepub FROM publications WHERE codepub='".$codepub."'";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $row=pg_fetch_array($result);
    $titre=$row["titrepub"];

    echo "<center><h3>".$titre."</h3>";

    $monfichier = fopen("../../Fichiers/".$titre.".html", 'a+');
    
    //recuperation et affichage du contenu du fichier
    while (!feof($monfichier)) 
    {
        $line=fgets($monfichier);
        echo  $line."<br />";
    }
    fclose($monfichier);

    echo "</center><br><br><h3>Commentaires</h3>";

    //Affichage des commentaires
    $requete="SELECT contenucom,datecom,nomch,prenomch FROM commentaires c,chercheurs ch WHERE c.codepubch='".$codepub."' AND c.loginch=ch.loginch ";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $requete1="SELECT contenucom,datecom,nomabo,prenomabo FROM commentaires c,abonnes a WHERE c.codePubAbo='".$codepub."' AND c.loginAbo=a.loginAbo ";
    $result1 = pg_exec($dbconn,$requete1) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    $num=pg_num_rows($result);
    $num1=pg_num_rows($result1);

    for ($i=0; $i<$num; $i++) 
    {
        $row=pg_fetch_array($result);
        echo $row["nomch"]." ".$row["prenomch"]."<br>";
        echo $row["datecom"]."<br>";
        echo $row["contenucom"]."<br><br>";
    }
    for ($i=0; $i<$num1; $i++) 
    {
        $row=pg_fetch_array($result1);
        echo $row["nomabo"]." ".$row["prenomabo"]."<br>";
        echo $row["datecom"]."<br>";
        echo $row["contenucom"]."<br><br>";
    }
}

#Cette fonction permet d'enregistrer une commentaire faite sur une publication 
function commenterPublication ($login,$contenu,$datepub,$codepub)
{
    require_once("../Modules/connect.inc.php");

    $requete='SELECT * FROM commentaires';
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);

    $num=$num+1;

    //si lutilisateur est un chercheur
    if ((substr($login, 0, 2))==='ch')
    {
        //enregistrement du commentaire
        $requete="INSERT INTO commentaires (codeCom, contenuCom, dateCom, codePubCh, loginCh) VALUES ('".$num."','".$contenu."','".$datepub."',".$codepub.",'".$login."')";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        header("location: contenuPub.php?codepubAfficher=".$codepub);
    }
    //si cest un abbonné
    else
    {
        //enregistrement du commentaire
        $requete="INSERT INTO commentaires (codeCom, contenuCom, dateCom, codePubAbo,loginAbo)  VALUES ('".$num."','".$contenu."','".$datepub."',".$codepub.",'".$login."')";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        header("location: contenuPub.php?codepubAfficher=".$codepub);
    }
}

#Cette fonction permet l'authentification d'un chercheur et d'un abonné
function connexion ($login,$password)
{
    //si l'utilisateur est un chercheur
    if ((substr($login, 0, 2))==='ch')
    {
        require_once("../Modules/connect.inc.php");
        $password=md5($password);

        $requete="SELECT prenomch,nomch FROM chercheurs WHERE loginch='".$login."' and passch='".$password."' ";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

            //si identifiant correct redirection vers la page d'accueil des chercheurs
        if ((pg_num_rows($result))==1)
        {
            $_SESSION['loginch'] = $login;
            header("location: ../../index.php");
        }
        else
        {
            header("location: connexion.php?msgErreur=Erreur : mauvais login ou mot de passe");
        }

        pg_close($dbconn);
    }
        //si l'utilisateur est un abonné
    elseif ((substr($login, 0, 2))==="ab")
    {
        require_once("../Modules/connect.inc.php");

        $password=md5($password);

        $requete="SELECT prenomabo,nomabo FROM abonnes WHERE loginabo='".$login."' and passabo ='".$password."'";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

            //si identifiant correct redirection vers la page d'accueil des abonnes
        if ((pg_num_rows($result))==1)
        {
            $_SESSION['loginab'] = $login;
            header("location: ../../index.php");
        }
        else
        {
            header("location: connexion.php?msgErreur=Erreur : mauvais login ou mot de passe");
        }

        pg_close($dbconn);
    }
        //identifiants incorrects
    else
    {
        header("location: connexion.php?msgErreur=Erreur : mauvais login ou mot de passe");
    }
}


#Cette fonction permet la creation d'un compte à un chercheur
function inscription_chercheurs ($nom,$prenom,$mail,$tel,$password,$actif)
{
    //connexion et selection de la base de donnees
    require_once("../Modules/connect.inc.php");

    $requete='SELECT * FROM chercheurs';
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);
    $num=$num+1;

    //creation du login
    $login="ch".substr($nom, 0, 1).substr($prenom, 0, 1).$num;
    $password=md5($password);

    //ajout des information dans la BD
    $requete1="INSERT INTO chercheurs VALUES ('".$login."','".$password."','".$nom."','".$prenom."','".$mail."','".$tel."','".$actif."')";
    pg_exec($dbconn,$requete1) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    pg_close($dbconn);
    return $login;
}

#Cette fonction permet la creation d'un compte à un abonné
function inscription_abonnes($nom,$prenom,$mail,$tel,$password,$actif)
{
    //connexion et selection de la base de donnees
  require_once("../Modules/connect.inc.php");

  $requete='SELECT * FROM abonnes';
  $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
  $num=pg_num_rows($result);
  $num=$num+1;

  //creation du login
  $login="ab".substr($nom, 0, 1).substr($prenom, 0, 1).$num;
  $password=md5($password);

  $requete2="INSERT INTO abonnes VALUES('".$login."','".$password."','".$nom."','".$prenom."','".$mail."','".$tel."','".$actif."')";
  pg_exec($dbconn,$requete2) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

  pg_close($dbconn);
  return $login;
}


#Cette fonction permet de mettre à jour le mot de passe dun chercheur/abonné dans la BD lorsque celui ci est modifié
function nouveau_motdePasse ($login,$password)
{
    if ((substr($login, 0, 2))==='ch')
    {
        require_once("../Modules/connect.inc.php");

        $password=md5($password);

        $requete="UPDATE chercheurs SET passch = '".$password."' WHERE loginch='".$login."'";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        header("location: connexion.php");
        pg_close($dbconn);
    }
    elseif ((substr($login, 0, 2))==="ab")
    {

        require_once("../Modules/connect.inc.php");

        $password=md5($password);

        $requete="UPDATE abonnes SET passabo = '".$password."' WHERE loginabo='".$login."'";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        header("location: connexion.php");
        pg_close($dbconn);
    }
    else
    {
        header("location: NouveauMotdePasse.php");
    }
}

#Cette fonction permet d'afficher l'annuaire des chercheur de la plateforme (nom-prenom-numéro-adresse mail)
function annuaire ()
{
    require_once("../Modules/connect.inc.php");

    $requete = "SELECT loginch,nomCh, prenomCh, mailch, telch FROM CHERCHEURS WHERE actifCh = 'true' ORDER BY nomch";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    echo  "<table>"; 
    echo "<tr>";
    echo "<th>Nom</th>";
    echo "<th>Prenom</th>";
    echo "<th>Mail</th>";
    echo "<th>Telephone</th>";
    echo "</tr>";

    $num=pg_numrows($result);
    for ($i=0; $i<$num; $i++)
    {
        $row=pg_fetch_array($result);
        echo '<tr>';
        echo '<td><a href=infoChercheur.php?loginChAfficher='.$row["loginch"].'>'.strtoupper($row["nomch"])."</td>"; 
        echo '<td><a href=infoChercheur.php?loginChAfficher='.$row["loginch"].'>'.ucfirst($row["prenomch"])."</td>";
        echo "<td>".$row["mailch"]."</td>"; 
        echo "<td>".$row["telch"]."</td>";
        echo "</tr>";
    }
    echo "</table>"; 
    pg_close($dbconn); 
}

#Cette fonction permet d'afficher les informations d'un chercheur (nom prenom telephone email equipes auquels il apprtient) ou d'un abonné  (nom prenom email)
function monProfil($login)
{
    require_once("../Modules/connect.inc.php");

    if ((substr($login, 0, 2))==='ch')
    {
        $requete = "SELECT nomCh, prenomCh, mailch, telch FROM CHERCHEURS WHERE loginch = '".$login."'";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        $row=pg_fetch_array($result);
        echo "<center>";
        echo "<b><h3>".strtoupper($row["nomch"])." ".ucfirst($row["prenomch"])."</b></h3>";
        echo "<h3>Coordonnées</h3>";
        echo "<b><u>Email</u> : </b>".$row["mailch"];
        echo "<br><b><u>Téléphone</u> : </b>".$row["telch"];

        $requete = "SELECT nomEq FROM EquipeProjets e,Appartenir a WHERE a.loginch='".$login."' and a.codeEq=e.codeEq";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        $num=pg_numrows($result);
        echo "<br><b><u>Equipes</u> : </b>";
        for ($i=0; $i<$num; $i++)
        {
           $row=pg_fetch_array($result);
           echo $row["nomeq"].", ";
       }
       echo "</center>";
   }
   else
   {
        $requete = "SELECT nomabo, prenomabo, mailabo FROM abonnes WHERE loginabo= '".$login."'";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        $row=pg_fetch_array($result);
        echo "<center>";
        echo "<h4>".strtoupper($row["nomabo"])." ".ucfirst($row["prenomabo"])."</h4>";
        echo "Coordonnes<br>";
        echo "Email : ".$row["mailabo"];
        echo "</center>";
    }
}


#Cette fonction permet d'afficher la liste des chercheurs lors de la creation d'une équipe 
function selectionEquipe()
{
    include("../Modules/connect.inc.php");

    $requete = "SELECT nomch, prenomch, loginch FROM chercheurs ORDER BY nomch";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    $chercheurs = array(); 

    $num = pg_numrows($result);
    for ($i=0; $i<$num; $i++) 
    {
        $row=pg_fetch_array($result);
        $chercheurs[$i] =  array($row["loginch"], strtoupper($row["nomch"]) . ' ' . ucfirst($row["prenomch"]));
    }
    pg_close($dbconn);
    return $chercheurs;
}

#cette fonction permet d'enregistrer une nouvelle equipe dans la BD
function creerEquipe($nom)
{
    require_once("../Modules/connect.inc.php");

    $requete='SELECT * FROM EquipeProjets';
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);
    $num=$num+1;

    $requete2="INSERT INTO equipeprojets VALUES('".$num."','".$nom."')";
    pg_exec($dbconn,$requete2) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    pg_close($dbconn);
    return $num;
}

#cette fonction permet d'ajouter un chercheur à une équipe
function ajoutMembreEquipe($loginch, $codeEq)
{
    include("../Modules/connect.inc.php");

    $requete="INSERT INTO appartenir VALUES('".$loginch."','".$codeEq."')";
    pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    
    pg_close($dbconn);
}

#cette fonction permet d'enregistrer les informations d'un nouveau projet
function creerProjet($login,$titre,$theme,$budget,$date,$description,$codeEq)
{
    include("../Modules/connect.inc.php");

    $requete='SELECT * FROM projets';
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);
    $num=$num+1;

    $codeprojet='prprc'.$num;
    $requete2="INSERT INTO projets VALUES('".$codeprojet."','".$titre."','".$theme."','".$budget."','".$date."','".$description."','".$login."','".$codeEq."')";
    pg_exec($dbconn,$requete2) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    pg_close($dbconn);
}

#cette fonction permmet d'afficher la liste des projets traites à un chercheur
function listeProjets()
{
    require_once("../Modules/connect.inc.php");

    $requete="SELECT codeeq,titreprojet,theme,description,nomeq FROM projets p,equipeprojets e WHERE p.codeequ=e.codeeq ";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);

    for ($i=0; $i<$num; $i++)
    {
        $row=pg_fetch_array($result);
        echo "<b><u>Titre projet</u> : </b>".$row["titreprojet"]."<br>";
        echo "<b><u>Theme projet</u> : </b>".$row["theme"]."<br>";
        echo "<b><u>Description projet</u> : </b>".$row["description"]."<br>";
        echo '<b><u>Nom equipe</u> : </b><a href="membreEquipe.php?codeeqAfficher='.$row["codeeq"].'"">'.$row["nomeq"]."</a><br><br>";
    }
}


#cette fonction permet d'afficher les informations d'une équipe (nom de l'equipe les membres de l'equipe le chef de l'equipe et les projets mené par cette equipe )
function membreEquipe($codeeq)
{
    require_once("../Modules/connect.inc.php");
    $requete="SELECT nomeq FROM equipeprojets WHERE codeEq='".$codeeq."'";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $row=pg_fetch_array($result);
    echo "<center><b><u>Equipe</u> : </b>".$row["nomeq"]."<br>";

    $requete="SELECT nomch,prenomch FROM chercheurs c,projets p WHERE p.codeEqu='".$codeeq."' and loginchefprojet=loginch";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $row=pg_fetch_array($result);
    echo "<b><u>Chef d'equipe</u> : </b>".strtoupper($row["nomch"])." ".ucfirst($row["prenomch"])."<br>";

    $requete="SELECT titreprojet FROM projets WHERE codeEqu='".$codeeq."'";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $row=pg_fetch_array($result);
    echo "<b><u>Projet mené</u> : </b>".$row["titreprojet"]."<br>";

    $requete="SELECT c.loginch,nomch,prenomch FROM chercheurs c,appartenir a WHERE a.loginch=c.loginch AND a.codeEq='".$codeeq."'";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);

    echo "<b><u>Membres equipe</u> : </b>";
    for ($i=0; $i<$num; $i++)
    {
        $row=pg_fetch_array($result);
        echo '<a href=infoChercheur.php?loginChAfficher='.$row["loginch"].'>'.strtoupper($row["nomch"])." ".ucfirst($row["prenomch"])."</a><br>";
    }
}

#cette fonction permet d'afficher à un chercheur la liste des projets sur lesquels il travaille
function voirMesProjets ($login)
{
    require_once("../Modules/connect.inc.php");

    $requete="SELECT codeprojet,titreProjet FROM projets p, Appartenir a WHERE a.loginch='".$login."' and  a.codeEq=p.codeEqu ";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    $num=pg_numrows($result);
    echo "<br><center><h1>Mes Projets </h1><legend></legend>";
    for ($i=0; $i<$num; $i++)
    {
       $row=pg_fetch_array($result);
       echo '<a href=contenuprojet.php?codeprojetAfficher='.$row["codeprojet"].'>'.$row["titreprojet"]."</a><br> ";
   }
   echo "</center>";
   pg_close($dbconn);
}


#cette fonction permet d'afficher les informations d'un projet 
# (nom du projet theme du projet nom de lequipe qui travaille sur le projet nom des membres de l'equipe... )
function detailProjets($login,$codeprojet)
{
    require_once("../Modules/connect.inc.php");

    $requete="SELECT titreprojet,theme,budget,description,loginchefprojet,codeEqu,nomeq,nomch,prenomCh FROM equipeprojets e, chercheurs c,projets p WHERE p.loginchefprojet=c.loginch and  p.codeprojet='".$codeprojet."' AND p.codeEqu=e.codeEq";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
       
    $row=pg_fetch_array($result);
    echo "<br><center><b><u>Projet</u> :</b> ".$row["titreprojet"]."<br>";
    echo "<b><u>Theme</u> :</b> ".$row["theme"]."<br>";
    if ($login==$row["loginchefprojet"])
    {
        echo "<b><u>Budget</u> :</b> ".$row["budget"]."<br>";
    }
    if ($login!=$row["loginchefprojet"])
    {
        echo "<b><u>Chef de projet</u> :</b> ".strtoupper($row["nomch"])." ".ucfirst($row["prenomch"])."<br>";
    }
    echo "<b><u>Equipes</u> :</b> ".$row["nomeq"]."<br>";
    
    echo "<br><b><u>Membres</u> :</b> ";
    $requete="SELECT c.loginch,nomch, prenomch FROM chercheurs c,appartenir a WHERE c.loginch=a.loginch and codeeq='".$row["codeequ"]."'";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    $num=pg_numrows($result);
    for ($i=0; $i<$num; $i++)
    {
        $row=pg_fetch_array($result);
        echo '<a href=infoChercheur.php?loginChAfficher='.$row["loginch"].'>'.strtoupper($row["nomch"])." ".ucfirst($row["prenomch"])."</a><br>";
    }

    echo "<br><br><b><u>Fichiers</u> :</b><br> ";
    $requete="SELECT codefich, nomfich FROM projets p,fichiers f WHERE p.codeprojet=f.codeprojet and p.codeprojet='".$codeprojet."'";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    $num=pg_numrows($result);
    for ($i=0; $i<$num; $i++)
    {
        $row=pg_fetch_array($result);
        echo '<a href=/PCR/Fichiers/'.$row["nomfich"].' onclick="window.open(this.href); return false;">'.$row["nomfich"]." </a><a href='../Modules/telecharger.php?situation=/PCR/Fichiers/".$row['nomfich']."'> <span class='glyphicon glyphicon-download'></span></a><br>";
    }
    echo "</center>";
    pg_close($dbconn);
}

#cette fonction permet d'
function ajoutFichier($index,$tmpName,$taille,$error,$destination,$maxsize=FALSE)
{
   //Test1: fichier correctement uploadé
     if (!isset($index) OR $error > 0) return FALSE;
   //Test2: taille limite
     if ($maxsize !== FALSE AND $taille > $maxsize) return FALSE;
   //Déplacement
     return move_uploaded_file($tmpName,$destination);
}

function checkedSelect( $nom, $structure, $contenu, $selection = null) 
{

  //////////////// entete du composant \\\\\\\\\\\\\\\\\\\\\\\\\        
  if(sizeof($selection) == sizeof($contenu))
    $checked = "checked";
else
    $checked = "";


$str = '<div class="div_select">'
.'<div class="div_select_header">'
.'<table width="100%">'
.'<tr>'
.'<td width="20" align="center"><input type="checkbox" id="'.$nom.'" onClick="javascript:selectAll(this, '.sizeof($contenu).');" '.$checked.'/></td>';

              //--- colonnes
for($i = 0, $max = sizeof($structure); $i < $max; $i++) {
    $str .= '<td ';
    if(isset($structure[$i]["align"])) $str .= 'align="'.$structure[$i]["align"].'" ';
    if(isset($structure[$i]["width"])) $str .= 'width="'.$structure[$i]["width"].'" ';                    
    $str .= '>'.$structure[$i]["name"].'</td>';            
}

$str .= '</tr>'
.'</table>'
.'</div>';

              //////////////// contenu du composant \\\\\\\\\\\\\\\\\\\\\\\\\        
$str .= '<div class="div_select_content" >'                
.'<table width="100%">';

              //--- pour chaque ligne
for($i = 0, $max = sizeof($contenu); $i < $max; $i++) {

                  //--- style css (pair / impair)    
    if($i%2)
      $css_defaut = 'select_odd';
  else
      $css_defaut = 'select_even';    

                  //--- element selectionne ?
  if($selection != null && in_array($contenu[$i][0],$selection)) {                    
      $checked = ' checked';
      $css = 'select_checked';                        
  }
  else {
      $checked = '';
      $css = $css_defaut;                    
  }

                  //--- la checkbox
  $str .= '<tr id="tr_'.$nom.$i.'" class="'.$css.'" onMouseOver=\'javascript:setEvenement("'.$nom.'","'.$i.'","over","'.$css.'",'.sizeof($contenu).',"td");\' onMouseOut=\'javascript:setEvenement("'.$nom.'","'.$i.'","out","'.$css_defaut.'",'.sizeof($contenu).',"td");\' '
  .' onClick=\'javascript:setEvenement("'.$nom.'","'.$i.'","click", "'.$css_defaut.'",'.sizeof($contenu).',"td");\' >'
  .'<td width="20" ><input type="checkbox" id="'.$nom.$i.'" name="'.$nom.'[]" value="'.$contenu[$i][0].'" onClick=\'javascript:setEvenement("'.$nom.'","'.$i.'","click","'.$css_defaut.'",'.sizeof($contenu).',"ck");\' '.$checked.' /></td>';

                  //--- les colonnes
  for($j = 1; $j < sizeof($contenu[$i]); $j++) {                    
      $str .= '<td ';
      if(isset($structure[$j-1]["align"])) $str .= 'align="'.$structure[$j-1]["align"].'" ';    
      if(isset($structure[$j-1]["width"])) $str .= 'width="'.$structure[$j-1]["width"].'" ';                    
      $str .= '>'.$contenu[$i][$j].'</td>';        
  }

  $str .= '</tr>';
}

              //--- fermeture des balises
$str .= '</table>'
.'</div>'
.'</div>';

return $str;
}
?>