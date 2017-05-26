<!-- Navigateur avec l'utilisation de bootstrap -->
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/PCR/index.php"><span class="glyphicon glyphicon-home"></span> Accueil </a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<?php 
				// Si c'est un chercheur, on va afficher les liste déroulantes des projets sinon rien
				if (!isset($_SESSION["loginch"]))
				{

				}
				else
				{
					echo '<li class="dropdown">';
					echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Projets <span class="caret"></span></a>';
					echo '<ul class="dropdown-menu">';
					echo '<li><a href="/PCR/PHP/Pages/creationProjet.php">Creer Projets</a></li>';
					echo '<li><a href="/PCR/PHP/Pages/mesProjets.php">Voir mes Projets</a></li>';
			  		echo '<li><a href="/PCR/PHP/Pages/listeProjets.php">Tous les projets</a></li>';
			  //<li><a href="#">Mot du directeur</a></li>
					echo "</ul>";
					echo "</li>";
					
				}
				?>
				<li>
					<a href="/PCR/PHP/Pages/annuaire.php"><span class="glyphicon glyphicon-list-alt"></span> Annuaire</a>
				</li>
				<?php 
				// Si c'est un chercheur, on va afficher la liste déroulante des publications (créer + voir / commenter) sinon juste "voir"
				if (!isset($_SESSION["loginch"]))
				{
					echo "<li>";
						echo '<a href="/PCR/PHP/Pages/publications.php"><span class="glyphicon glyphicon-pencil"></span> Publications</a>';
					echo "</li>";
				}
				else
				{
					echo '<li class="dropdown">';
					echo '<a href="/PCR/PHP/Pages/publications.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Publications <span class="caret"></span></a>';
					echo '<ul class="dropdown-menu">';
					echo '<li><a href="/PCR/PHP/Pages/ajouterPublication.php">Nouvelle Publication</a></li>';
					echo '<li><a href="/PCR/PHP/Pages/publications.php">Voir les publications</a></li>';
					echo "</ul>";
					echo "</li>";
					
				}
				?>				
				<li>
					<?php 
					// Si un abonné ou chercheur est connecté, on affiche "déconnexion", sinon "connexion" + formulaire
					if ((!isset($_SESSION['loginch'])) && (!isset($_SESSION['loginab'])))
						echo '<a href="/PCR/PHP/Pages/connexion.php"><span class="glyphicon glyphicon-log-in"></span> Connexion</a>';
					else
						echo '<a href="/PCR/PHP/Pages/deconnexion.php"><span class="glyphicon glyphicon-log-out"></span> Deconnexion</a>';
					?>
				</li>
				<?php 
				// Si personne n'est connecté, on affiche "inscription" sinon "mon profil"
				if((!isset($_SESSION['loginch'])) && (!isset($_SESSION['loginab'])))
				{
					echo "<li>";
					echo '<a href="/PCR/PHP/Pages/inscription.php"><span class="glyphicon glyphicon-plus"></span> Inscription</a>';
					echo "</li>";
				}
				else
				{
					echo "<li>";
					echo '<a href="/PCR/PHP/Pages/monProfil.php"><span class="glyphicon glyphicon-plus"></span> Mon Profil</a>';
					echo "</li>";
				}
				?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<form class="navbar-form navbar-left" method="post" action="recherche.php">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Rechercher...">
						</div>
						<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
					</form>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</nav>
