
<?php
	session_start();
include "bdd/connect.php";

//si on est sur cette page et que on a rien envoyé comme formulaire
if(!isset($_POST['sendRegister']) && !isset($_GET['noplan']))
{
	header('Location: index.php?exit=failAccess');
}
//SI ON ENVOIE LE POST DINSCRIPTION
else if(isset($_POST['sendRegister']))
{  

	$logMessage="";

	//on vérifie que les passwords soient les memes
	if($_POST['password_user'] == $_POST['password_user_conf'])
	{ 
		//es ce que le mdp a plus de 5 caracteres?
		if(strlen($_POST['password_user']) > 5)
		{
		
			//REQUETE POUR VERIFIER SI LUTILISATEUR EST DEJA EN BASE
			include "bdd/getUserByMail.php";
			$isHere=getUserByMail($_POST['email_user']);	
			
			//si notre fonction retourne vrai, on peux inscrire, sinon on affiche un message
			if($isHere==true)
			{
				$logMessage="Désolé, l'adresse email rentrée est déja asociée à un compte.";
			}
			else
			{
				//REQUETE POUR Linscription
				include "bdd/setInscription.php";
				$success=setInscription($_POST['email_user'], $_POST['password_user']);
				
				
				//ON CREER SON DOSSIER avec son id en compte
				mkdir("files/".$_SESSION['user_id'], 0700);
				
				$logMessage="Votre compte a bien été créé avec l'adresse : ".$_POST['email_user'];
				$success=true;
			}
		}
		else
		{
			$logMessage="Le mot de passe doit contenir minimum 6 caractères";
			$success=false;
		}
	}
	
	else
	{
		$logMessage="Les Mots de passent ne correspondent pas.";
		$success=false;
	}

}
//SI ON A PAS DE PLAN
else if(isset($_GET['noplan']))
{
	include 'bdd/isUserGetPlan.php';
	$gotPlan=isUserGetPlan($_SESSION['user_id']);
	if($gotPlan==false)
	{
		$logMessage="Veuillez Choisir un plan avant de poursuivre";
		$success=true;
	}
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
<title>EDBox</title>
</head>
<body onscroll="getArrowUp()">

	
	<div id="corp" style="font-family:champagne;color:white;">
		<?php include "include/header.php";?>
		
		<div id="mainContent">
			
			<!--Message de log -->
			<h2 style="color:#292929;"><?php if(isset($logMessage)) echo $logMessage;?></h2>
			
			<?php 
			//si ça a réussi 
			if( isset($success) && $success==true)
			{ ?>
				
				<h2> Choisissez un des plan suivant : </h2>
				<article id="offres"  class='full-width-box services'>

					<section id="service" >
						<h3>Personnel</h3>
						<img src="img/logo/Drive_Download.png" alt="logoFree" />
						<p>Prix: gratuit</p>
						<p>Stockage : 5go</p>
						<a href="setplan.php?id=1"> Valider </a>
					</section>
					
					<section id="service">
						<h3>Professionnel</h3>
						<img src="img/logo/Suit.png" alt="logoPro" />
						<p>Prix: 80$/an</p>
						<p>Stockage : 75go</p>
						<a href="setplan.php?id=2"> Valider </a>
					</section>
					
					<section id="service">
						<h3>Premium</h3>
						<img src="img/logo/Premium.png" alt="logoPremium" />
						<p>Prix: 160$/an</p>
						<p>Stockage : 200go</p>
						<a href="setplan.php?id=3"> Valider </a>
					</section>
				</article>
				
				<h2> Ou créez le votre personalisé </h2>
				
				<form id="formNewPlan" enctype="multipart/form-data" action="setplan.php?id=0" method="post" onsubmit="return(submitform())">		
					<div id="stockage">
						<b>Choissisez votre espace de disque : </b>
						 <input type='number' min="1" max="400" name='stockage' id='plan_stockage' style="width:50px" onchange="hideSend()" required> Go </br><br> 
					</div>
					<div id="bandepassante">
						<b>Choissisez votre bande passante : </b></br><br>
						<label for "upload">Upload : <input type='number' name='upload' id='plan_upload' min='1' max='50' style="width:50px" onchange="hideSend()" required>Mo/s </br>
						<label for "download">Download : </label><input type='number' name='download' id='plan_download' min='1' max='200' style="width:50px" onchange="hideSend()" required>Mo/s</br></br>
					</div>
					<div id="partage">
						<b>Choissisez votre maximum de partage/jours (100 pour illimité) : </b>
						<input type='number' min="0" name='maxShare' id='plan_maxShare' style="width:50px" onchange="hideSend()" required></br>
					</div>
					<input type="number" value="0" id="plan_prix_an" name="prix_an" style="opacity:0"/>
					
					<p><strong> Prix :  <span id="prixPlan">0</span>$ / An</strong></p>
					<p class="typeButton" onclick="getPrice()"> Calculer prix </p>
					
					<p  id="sendNewPlan" style="display:none"><input type="submit" name="sendNewPlan" value="Valider" /></p>
				</form>			
				
			
			<?php
			}
			else if( isset($success) && $success==false) //si le compte existe déja
			{?>
			<section id="registerForm"  style="opacity:0;height:0px;">
				<section id="formLogReg" class="full-width-box register">
					<h2>Inscription</h2>
					<form enctype="multipart/form-data" action="inscription.php" method="post">
						<p><input type="email" name="email_user" placeholder="E-mail" required /></p>
						<p><input type="password" name="password_user" placeholder="Mot de passe" required></p>
						<p><input type="password" name="password_user_conf" placeholder="Confirmation"  required/></p>
						<p><input type="submit" name="sendRegister" value="Valider" /></p>
					</form>
					<i onclick="window.location='#.index'">Déja inscrit?</i>
				</section>
			</section>
			
			
			
			
			<?php
			}
			else
			{
				echo "SI cette page s'affiche, le dev a mal travaillé...Mais si c'est pendant une présentation, sachez que c'est un fou ;)" ;
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
<script type="text/javascript">

	//finction pour calculer le prix
	var isVisible=false;
	function getPrice()
	{
		//on recupere les valeures des input
		var stockage = document.getElementById('plan_stockage').value;
		var upload = document.getElementById('plan_upload').value;
		var download = document.getElementById('plan_download').value;
		var maxShare = document.getElementById('plan_maxShare').value;
		
		if(stockage=="" || upload=="" || download=="" || maxShare==""){alert ("Vous ne pouvez pas laisser de case vide");}
		//alert(stockage);
		//alert(upload);
		//alert(download);
		//alert(maxShare);
		
		var prix=0;
		
		if(stockage>5)
		{
			prix+=stockage*0.8;
			
		}
		if(upload>1)
		{
			prix+=upload*1;
		}
		if(download>5)
		{
			prix+=download*0.5;
		}
		if(maxShare>5)
		{
			prix+=maxShare*0.2;
		}
		
		
		prix=Math.round(prix);
	
		$('#prixPlan').text(prix);
		document.getElementById('plan_prix_an').value=prix;
		
		//on affiche notre bouton envoyer
		if(isVisible==false)
		{
			$( "#sendNewPlan" ).animate({
				height: "toggle"
				}, 500);
			
			isVisible=true;
		}
	}
	
	function hideSend()
	{
		if(isVisible==true)
		{
			$( "#sendNewPlan" ).animate({
				height: "toggle"
				}, 200);
				
			isVisible=false;
		}
	}
	
	function submitform()
	{
		//pour que le formulaire parte, il faut que le bouton envoyer soit visible
		return isVisible;
	}
</script>
</html>