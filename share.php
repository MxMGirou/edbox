
<?php
session_start();
include "bdd/connect.php";

$tabLink=null;
if(isset($_GET['p']) && isset($_GET['id']))
{
	//REQUETE POUR RECUP LES LIENS
	include "bdd/getLinkById.php";
	$tabLink = getLinkById($_GET['p'], $_GET['id']);
	
	//RECUPERER MAIL OWNER
	include "bdd/getUserById.php";
	if($tabLink!=null){$mailOwner = getUserById($tabLink[0]['id_owner']);}
	
}



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style1.css" />
        <link rel="icon" type="image/png" href="img/favicon.ico" />
        <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/jquery.arbitrary-anchor.js"></script>
<title>EDBox - Partagez vos fichiers</title>

<?php
//SI CEST UN DOSSIER ON PREPARE ELFINDER
if($tabLink!=null)
{
	$dossier = $tabLink[0]['url'];
	$perm = $tabLink[0]['perm'];
	
	$_SESSION['path']=$dossier;
	$_SESSION['perm']=$perm;
}

//var_dump(is_dir($_SERVER['DOCUMENT_ROOT']."/EdBox/files/".$dossier));

 if(isset($dossier) && is_dir($_SERVER['DOCUMENT_ROOT']."/EdBox/files/".$dossier) )
{ 
	?>
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
					url : 'php/connectorShared.php',  // connector URL (REQUIRED)
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

<?php
}?>

</head>
<body onscroll="getArrowUp()">

	
	<div id="corp" style="font-family:champagne;color:white;">
		<?php include "include/header.php";?>
		
		<div id="mainContent">
		
			<?php 
			if($tabLink!=null)//si on a quelque chose a afficher
			{
				//var_dump($tabLink);
				
				//ON REGARDE SI UNE SESSION EST EN COUR
				
				//ON REGARDE SI LUTILISATEUR A LES DROIT (si c'est le proprio ou si il est l'utilisateur cible du lien privé)
				if(((isset($_SESSION['user_mail']) && ( $_SESSION['user_mail'] == $mailOwner || $_SESSION['user_mail'] == $tabLink[0]['mail_user_cible']) && $_GET['p']=="prive")) xor $_GET['p']=="public")
				{
					?>
				
				
					<h1> Fichier Partagé </h1>
					<p> Visibilité : <?php echo $_GET['p'];?></p>
					<p> Propriétaire : <?php echo $mailOwner ?></p>
					
					<?php
					
					//ON REGARDE SI CEST UN FICHIER OU UN DOSSIER
					$dossier = $tabLink[0]['url'];
					//var_dump(filesize($_SERVER['DOCUMENT_ROOT']."/EdBox/files/".$dossier));
					
					//SI CEST UN FICHIER
					if(is_file($_SERVER['DOCUMENT_ROOT']."/EdBox/files/".$dossier) )
					{
					  
					
					
					
						//ON FORMATE L URL
						$tabLink[0]['url']=str_replace('\\','/',$tabLink[0]['url']);
						
						//ON VA REGARDER LEXTENTION DU FICHIER  
						//ET ON VA AFFICHERDIFFENTES BALISE EN FONCTION DU FORMAT
						$ext = substr($tabLink[0]['url'], -3);
						
						
						//SI CEST UNE IMAGE
						if($ext=="jpg" ||$ext=="png" ||$ext=="gif" ||$ext=="pmb" ||$ext=="jpeg")
						{ ?>
							<img src="files/<?php echo $tabLink[0]['url'];?>" alt="image de partage" style="border-radius:5px;border:1px solid black; max-width:800px;"/>
							<p><a href="files/<?php echo $tabLink[0]['url'];?>" /> Image taille réelle </a></p>
						<?php
							
							
						}
						//SI CEST UNE MUSIQUE
						else if($ext=="mp3" ||$ext=="ogg")
						{?>
							<audio controls autoplay>
								<?php 
								if($ext=="mp3"){echo '<source src="files/'.$tabLink[0]['url'].'" type="audio/mpeg">';}
								else{echo  '<source src="files/'.$tabLink[0]['url'].'" type="audio/ogg">';}?>
							  
								Your browser does not support the audio element.
							</audio> 
							<p><a href="files/<?php echo $tabLink[0]['url'];?>" />  Télécharger : Clique droit -> Enregister la cible de l'ellement  </a></p>
							<?php
						}
						//SI CEST UNE VIDEO
						else if( $ext=="wmv" || $ext=="flv" || $ext=="mpg" || $ext=="avi" ||$ext=="mp4")
						{
							if($ext=="mp4")
							{?>
								<video width="600" height="400" controls autoplay>
									<?php 
									if($ext=="mp4"){echo '<source src="files/'.$tabLink[0]['url'].'" type="video/mp4">';}
									
									?>
								  
									Your browser does not support the VIDEO element.
								</video> <?php
							}?>
							<p><a href="files/<?php echo $tabLink[0]['url'];?>" />  Télécharger : Clique droit -> Enregister la cible de l'ellement  </a></p>
							<?php
						}
						//SI CEST AUTRE CHOSE
						else
						{ 
							
						
						?>
							<p> <a href="files/<?php echo $tabLink[0]['url'];?>"> Télécharger le fichier </a></p>
						
						<?php
						}
						
					}//SI CEST UN DOSSIER
					else
					{?>
						<div style="margin:0px auto 0px auto; max-width:940px;" id="elfinder"></div>
					<?php
					}
					?>
			<?php	
				}//SI ON A PAS LA PERMISSION
				else
				{?>
					<div style="text-align:center;margin-top:90px"><img src="img/403.png" alt="403 FORBIDDEN" /></div>
				<?php
				}
				
			}
			else //si on a rien a afficher
			{?>
				<div style="text-align:center;margin-top:90px"><img src="img/404.png" alt="404 Not Found" /></div>
				<?php
			}
			?>
			
			<?php
			if(!isset($_SESSION['user_id']))
			{?>
				</br></br>
				<p><button class="but_1" onclick="displayRegister()">J'essaye Edbox</button></p>
					
				<section id="registerForm"  style="opacity:0;height:0px;">
					<section id="formLogReg" class="full-width-box register">
						<h2>Inscription</h2>
						<form enctype="multipart/form-data" action="inscription.php" method="post">
							<p><input type="email" name="email_user" placeholder="E-mail" required /></p>
							<p><input type="password" name="password_user" placeholder="Mot de passe" required></p>
							<p><input type="password" name="password_user_conf" placeholder="Confirmation"  required/></p>
							<p><input type="submit" name="sendRegister" value="Valider" /></p>
						</form>
						<i onclick="window.location='index.php'">Déja inscrit?</i>
					</section>
				</section>
			<?php
			}
			?>
				
			
		</div><!--fin main content -->
		<!-- Notre fleche ancre -->
		<?php include "include/getArrowUp.html";?>
		
		<footer>
			<?php include "include/footer.php";?>
		</footer>
	</div>

</body>

<script>

	//pour gerer la banniere d'infos
	$( window ).load(function()
	{
		//on test si l'element existe
		if($("#infoDiv").length)
		{
			//on commence la focntion au bout de 5 sec
			setTimeout(function() {
		
				$( "#infoDiv" ).animate({
					opacity:"0",
					height: "toggle"
					}, 500);
				  
			}, 5000);
		}
	});
	
		function displayRegister()
	{
		window.location='#.register';
		document.getElementById('registerForm').style.opacity=1;
		document.getElementById('registerForm').style.height="300px";
		
	}

</script>


</html>