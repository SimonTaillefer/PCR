<?php

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
                $_SESSION['login'] = $login;
                header("location: accueil_chercheurs.php");
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
                header("location: accueil_abonnes.php");
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

        $requete = "SELECT nomCh, prenomCh, mailch, telch FROM CHERCHEURS WHERE actifCh = 'true'";
        $result = pg_exec($dbconn,$requete) or die('Erreur SQL !<br />'.$sql.'<br />'.pg_last_error());
        echo  "<table>"; 
        echo "<tr>";
            echo "<td>Nom</td>";
            echo "<td>Prenom</td>";
            echo "<td>Mail</td>";
            echo "<td>Telephone</td>";
        echo "</tr>";
        
        $num=pg_numrows($result);
        for ($i=0; $i<$num; $i++)
        {
            $row=pg_fetch_array($result);
            echo "<tr>";
                echo "<td>".$row["nomch"]."</td>"; 
                echo "<td>".$row["prenomch"]."</td>";
                echo "<td>".$row["mailch"]."</td>"; 
                echo "<td>".$row["telch"]."</td>";
            echo "</tr>";
        }
        echo "</table>"; 
        pg_close($dbconn); 
    }
?>