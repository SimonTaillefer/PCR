<?php

function afficherPublicationsChercheurs()
{
    require_once("../Modules/connect.inc.php");

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


function afficherPublications()
{
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



function ajouterPublication($titre,$type,$contenu,$date)
{
    require_once("../Modules/connect.inc.php");

    $monfichier = fopen("../../Fichiers/".$titre.".txt", 'a+');
 
    fputs($monfichier,"$contenu"); 
 
    fclose($monfichier);

    $requete='SELECT * FROM publications';
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);

    $num=$num+1;
    $requete="INSERT INTO publications VALUES('".$num."','".$titre."','".$type."','".$date."')";
    $requete1="INSERT INTO publier VALUES('".$num."','".$_SESSION["loginch"]."')";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $result = pg_exec($dbconn,$requete1) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    header("location: publications.php");   
}


function afficherContenuPub($codepub)
{
    require_once("../Modules/connect.inc.php");

    
    $requete="SELECT titrepub FROM publications WHERE codepub='".$codepub."'";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $row=pg_fetch_array($result);
    $titre=$row["titrepub"];

    echo "<h3>".$titre."</h3>";

    $monfichier = fopen("../../Fichiers/".$titre.".txt", 'a+');
    
    while (!feof($monfichier)) 
    {
        $line=fgets($monfichier);
        echo  $line."<br />";
    }
    fclose($monfichier);

    echo "<br><br><h3>Commentaires</h3>";

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


function commenterPublication ($login,$contenu,$datepub,$codepub)
{
    require_once("../Modules/connect.inc.php");

    $requete='SELECT * FROM commentaires';
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);

    $num=$num+1;

    if ((substr($login, 0, 2))==='ch')
    {
        $requete="INSERT INTO commentaires (codeCom, contenuCom, dateCom, codePubCh, loginCh) VALUES ('".$num."','".$contenu."','".$datepub."',".$codepub.",'".$login."')";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        header("location: contenuPub.php?codepubAfficher=".$codepub);
    }
    else
    {
        $requete="INSERT INTO commentaires (codeCom, contenuCom, dateCom, codePubAbo,loginAbo)  VALUES ('".$num."','".$contenu."','".$datepub."',".$codepub.",'".$login."')";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        header("location: contenuPub.php?codepubAfficher=".$codepub);
    }
}

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


function inscription_chercheurs ($nom,$prenom,$mail,$tel,$password,$actif)
{
		//connexion et selection de la base de donnees
  require_once("../Modules/connect.inc.php");

  $requete='SELECT * FROM chercheurs';
  $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
  $num=pg_num_rows($result);
  $num=$num+1;

  $login="ch".substr($nom, 0, 1).substr($prenom, 0, 1).$num;
  $password=md5($password);

  $requete1="INSERT INTO chercheurs VALUES ('".$login."','".$password."','".$nom."','".$prenom."','".$mail."','".$tel."','".$actif."')";
  pg_exec($dbconn,$requete1) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

  pg_close($dbconn);
  return $login;
}


function inscription_abonnes($nom,$prenom,$mail,$password,$actif)
{
		//connexion et selection de la base de donnees
  require_once("../Modules/connect.inc.php");

  $requete='SELECT * FROM abonnes';
  $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
  $num=pg_num_rows($result);
  $num=$num+1;

  $login="ab".substr($_POST["prenom"], 0, 1).substr($_POST["nom"], 0, 1).$num;
  $password=md5($password);

  $requete2="INSERT INTO abonnes VALUES('".$login."','".$password."','".$nom."','".$prenom."','".$mail."','".$actif."')";
  pg_exec($dbconn,$requete2) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

  pg_close($dbconn);
  return $login;
}


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

function annuaire ()
{
    require_once("../Modules/connect.inc.php");

    $requete = "SELECT nomCh, prenomCh, mailch, telch FROM CHERCHEURS WHERE actifCh = 'true' ORDER BY nomch";
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
        echo "<tr>";
        echo "<td>".strtoupper($row["nomch"])."</td>"; 
        echo "<td>".ucfirst($row["prenomch"])."</td>";
        echo "<td>".$row["mailch"]."</td>"; 
        echo "<td>".$row["telch"]."</td>";
        echo "</tr>";
    }
    echo "</table>"; 
    pg_close($dbconn); 
}

function recherche() 
{

    require_once("../Modules/connect.inc.php");
}

function monProfil($login)
{
    require_once("../Modules/connect.inc.php");

    if ((substr($login, 0, 2))==='ch')
    {
        $requete = "SELECT nomCh, prenomCh, mailch, telch FROM CHERCHEURS WHERE loginch = '".$login."'";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        $row=pg_fetch_array($result);
        echo "<center>";
        echo "<br><br>";
        echo "<h4>".$row["nomch"]." ".$row["prenomch"]."</h4>";
        echo "Coordonnes<br>";
        echo "Email : ".$row["mailch"];
        echo "<br>Téléphone : ".$row["telch"];

        $requete = "SELECT nomEq FROM EquipeProjets e,Appartenir a WHERE a.loginch='".$login."' and a.codeEq=e.codeEq";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        $num=pg_numrows($result);
        echo "<br>Equipes : ";
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
        echo "<br><br>";
        echo "<h4>".$row["nomabo"]." ".$row["prenomabo"]."</h4>";
        echo "Coordonnes<br>";
        echo "Email : ".$row["mailabo"];
        echo "</center>";
    }

    
}

function selectionEquipe()
{
    require_once("../Modules/connect.inc.php");

    $requete = "SELECT nomch, prenomch FROM chercheurs ORDER BY nomch";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    $chercheurs = array(); 

    $num = pg_numrows($result);
    for ($i=0; $i<$num; $i++) 
    {
        $row=pg_fetch_array($result);
        $chercheurs[$i] =  strtoupper($row["nomch"]) . ' ' . ucfirst($row["prenomch"]);
    }
    return $chercheurs;
}

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
}


function ajoutMembreEquipe($loginch, $codeEq)
{
    require_once("../Modules/connect.inc.php");

    $requete = "INSERT INTO Appartenir VALUES('".$loginch."','".$codeEq."')";
    pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    pg_close($dbconn);
}

function creerProjet($login,$titre,$theme,$budget,$date,$description,$codeEq)
{
    require_once("../Modules/connect.inc.php");

    $requete='SELECT * FROM projets';
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);
    $num=$num+1;

    $codeprojet='prprc'.$num;
    $requete2="INSERT INTO projets VALUES('".$codeprojet."','".$titre."','".$theme."','".$budget."','".$date."','".$description."','".$login."')";
    pg_exec($dbconn,$requete2) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    pg_close($dbconn);
}


function voirMesProjets ($login)
{
    require_once("../Modules/connect.inc.php");

    $requete="SELECT titreProjet FROM projets p, Appartenir a WHERE a.loginch='".$login."' and  a.codeEq=p.codeEq ";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    $num=pg_numrows($result);
    echo "<br>Mes projets : ";
    for ($i=0; $i<$num; $i++)
    {
       $row=pg_fetch_array($result);
       echo $row["titreProjet"].", ";
   }
   pg_close($dbconn);
}
?>