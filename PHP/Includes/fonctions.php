<?php

function afficherPublicationsChercheurs()
{
    require_once("../Modules/connect.inc.php");

    $requete='SELECT titrepub, typepub, datepub,nomch,prenomch FROM publications p, publier pu, chercheurs ch WHERE p.codepub=pu.codepub AND pu.loginch=ch.loginch';
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $num=pg_num_rows($result);

    for ($i=0; $i<$num; $i++) 
    {
        $row=pg_fetch_array($result);
        echo "<br>";
        echo "<h4><i>".ucfirst($row["typepub"])."</i></h4>";
        echo '<a href="/PCR/PHP/Pages/contenuPub.php?titrepubAfficher='.$row["titrepub"].'&codepubAfficher='.$num.'"  type="submit" name="titrepubAfficher">'.$row["titrepub"]."</a><br>";
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

    for ($i=0; $i<$num; $i++) 
    {
        $row=pg_fetch_array($result);
        echo "<br>";
        echo "<h4><i>".ucfirst($row["typepub"])."</i></h4>";
        echo '<a href="/PCR/PHP/Pages/contenuPub.php?titrepubAfficher='.$row["titrepub"].'"  type="submit" name="titrepubAfficher">'.$row["titrepub"]."</a><br>";
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


function afficherContenuPub($titre,$codepub)
{
    require_once("../Modules/connect.inc.php");

    echo "<h3>".$titre."</h3>";
    $monfichier = fopen("../../Fichiers/".$titre.".txt", 'a+');
    
    while (!feof($monfichier)) 
    {
        $line=fgets($monfichier);
        echo  $line."<br />";
    }
    fclose($monfichier);

    echo "<br><br><h3>Commentaires</h3>";

    $requete="SELECT contenucom,datecom,nomch,prenomch FROM commentaires c,chercheurs ch WHERE c.codepubch='".$codepub."' AND c.loginch=ch.loginch";
    $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    $requete1="SELECT contenucom,datecom,nomabo,prenomabo FROM commentaires c,abonnes a WHERE c.codePubAbo='".$codepub."' AND c.loginAbo=a.loginAbo";
    $result1 = pg_exec($dbconn,$requete1) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());

    $num=pg_num_rows($result);
    $num1=pg_num_rows($result1);

    for ($i=0; $i<$num; $i++) 
    {
        $row=pg_fetch_array($result);
        echo $row["nomch"]." ".$row["prenomch"]."<br>";
        echo $row["datecom"]."<br>";
        echo $row["contenucom"]."<br>";
    }
    for ($i=0; $i<$num1; $i++) 
    {
        $row=pg_fetch_array($result1);
        echo $row["nomabo"]." ".$row["prenomabo"]."<br>";
        echo $row["datecom"]."<br>";
        echo $row["contenucom"]."<br>";
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
        $requete="INSERT INTO commentaires (codeCom, contenuCom, dateCom, codePubCh, loginCh) VALUES ('".$num."','".$contenu."','".$datepub."','".$codepub."','".$login."')";
        header("location: publications.php");
    }
    else
    {
        $requete="INSERT INTO commentaires (codeCom, contenuCom, dateCom, codePubAbo,loginAbo)  VALUES ('".$num."','".$contenu."','".$datepub."','".$codepub."','".$login."')";
        header("location: publications.php");
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


function ajoutMembreEquipe($loginch, $codeEq)
{
    include("../Modules/connect.inc.php");

    $requete="INSERT INTO appartenir VALUES('".$loginch."','".$codeEq."')";
    pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
    
    pg_close($dbconn);
}

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
       echo $row["titreprojet"].", ";
   }
   pg_close($dbconn);
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