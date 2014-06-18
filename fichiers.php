
<?php
session_start();
include "bdd/connect.php";

if(!isset($_SESSION['user_id']))
{
	header('Location: index.php?exit=needLogin');
}

//REQUETE POUR RECUP LE PLAN
include "bdd/getUserPlan.php";
$planUser = getPlan($_SESSION['user_id']);

//on tchek si on a un plan
if($planUser['stockage']==0)
{
	header('Location: inscription.php?noplan=nothing');
}	

//REQUETE POUR RECUP LA FACTURE
include "bdd/getUserFacture.php";
$factureUser = getUserFacture($_SESSION['user_id']);

//on cherche voir si la facture est payée
if($factureUser['etat']=="non-paye"){$isPaid=false;}
else{$isPaid=true;}


//REQUETE POUR RECUP LES USERS
include "bdd/getAllUser.php";
$tabUser = getAllUser();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style1.css" />
        <link rel="icon" type="image/png" href="img/favicon.ico" />
        <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/jquery.arbitrary-anchor.js"></script>
		<title>EDBox - Fichiers</title>

	<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

	<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script type="text/javascript" src="js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script type="text/javascript" src="js/i18n/elfinder.ru.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			$().ready(function() {
						
			
				// say you want to disable only a couple of commands
				var myCommands = elFinder.prototype._options.commands;
				var disabled = ['extract', 'archive', 'help', 'resize', 'quicklook', 'duplicate', 'home', 'up', 'info','sort', 'view'];
				$.each(disabled, function(i, cmd) {
					(idx = $.inArray(cmd, myCommands)) !== -1 && myCommands.splice(idx,1);
				});
			
				var elf = $('#elfinder').elfinder({
					url : 'php/connector.php',  // connector URL (REQUIRED)
					width : '900',
					lang: 'fr' ,         
					commands : myCommands,
					uiOptions : {
						toolbar : [
							['back', 'forward'],
							['home'],
							['mkdir', 'mkfile', 'upload'],
							['open', 'download'],
							['copy', 'cut', 'paste'],
							['rm'],
							['search'],
							
							
						]},
				}).elfinder('instance');
			});
		</script>
</head>
<body onscroll="getArrowUp()">

	<!--SECTION DAIDE -->
	<div id="sectionAide" style="display:none;">
		<p><span style="text-decoration:underline;cursor:pointer;position:aboslute;left:80px;" onclick="displayHelp()"> Fermer </span></p>
		
		<h2> Partager un lien ? C'est simple ! </h2>
		<p>1- Faites un clique droit sur votre fichier -> Get Info</p>
		<p><img src="img/help/help1.png" width="300" />
		
		<p>2 - Selectionnez le PATH et faites clique droit -> COPIER</p>
		<p><img src="img/help/help2.png" width="400"/>
		
		<p>3 - Cliquez sur le bouton "Génerer un lien" juste en dessous</p>
		<p><img src="img/help/help3.png" width="300"/>
		
		<p>4 - Faite un clique droit sur la zone de texte -> Coller</p>
		<p><img src="img/help/help4.png" width="500" />
		
		<p>5 - Selectionnez votre visibilitée et/ou la personne qui pourra voir le fichier</p>
		<p><img src="img/help/help5.png" width="500" style="border-radius:5px;"/>
		
		<p><span style="text-decoration:underline;cursor:pointer" onclick="displayHelp()"> Fermer </span></p>
	</div>
	<!--FIN SECTION E -->
	
	<div id="corp" style="font-family:champagne;color:white;">
		<?php include "include/header.php";?>
		
		<div id="mainContent">
			
			<?php 
			//si on a bien paiyé, on affiche le gestionaire de fichier 
			if($isPaid==true)
			{?>
			<h3> Taille maximale en upload : 8Mo. |  <span style="text-decoration:underline;cursor:help" onclick="displayHelp()">Comment Partager un lien ? </span></h3>
			<!-- Element where elFinder will be created (REQUIRED) -->
			<div style="margin:0px auto 0px auto; max-width:940px;" id="elfinder"></div>
		
			
						<h2 style="cursor:pointer" onclick="showGenLink()"> Génerer un lien <img src="img/add_link.png" width="40"/></h2>
			<section id="generateurLien" style="display:none">
				
				<form enctype="multipart/form-data" action="bdd/setLink.php" method="post" >
					Privé<input type="radio" name="typeLien" value="prive" onclick='document.getElementById("selectUser").style.display="inline";'/>
					- Public<input type="radio" name="typeLien" value="public" onclick='document.getElementById("selectUser").style.display="none";' />
					
					<p>Permission (pour les dossiers) :  
					Lecture Seule<input type="radio" name="permLien" value="read"/>
					- Lecture/Ecriture <input type="radio" name="permLien" value="write"/>
				
					<p>Lien vers le fichier : <input type="text" size="50" name="url" /></p>
					
					<select name="mailUserCible" id='selectUser' style="display:none" size="5">
						<option value="0" >Choisissez un Utilisateur</option>
					<?php
						foreach ($tabUser as $cle => $valeur)
						{
							echo '<option value="'.$valeur["mail_user"].'" >'.$valeur["mail_user"].'</option>';
						}
						?>
						
					</select>
	
					<p><input class="typeButton" type="submit" value="Générer lien" name="sendNewLink" /></p>
				</form>
				
			</section>
			
			<?php
			}
			else
			{?>
				<h1> Vous n'avez pas payé votre abonement. rendez vous sur votre profil pour la payer </h1>
			<?php
			}
			?>
		
		</div>
		
						<!-- Notre fleche ancre -->
		<?php include "include/getArrowUp.html";?>
		
		<footer>
			<?php include "include/footer.php";?>
		</footer>
	</div>

</body>
<script>

	var isShow=false;
	function showGenLink()
	{
		if(isShow==false)
		{
		
			$( "#generateurLien" ).animate({
					height: "toggle"
					}, 500);
			isShow=true;
		}
	}

	
	function displayHelp()
	{
		$( "#sectionAide" ).animate({
			height: "toggle",
			opacity: "toggle"
			}, 1500);
	}
	
</script>

</html>