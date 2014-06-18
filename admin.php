<?php 
include "bdd/connect.php";
include "bdd/setPlan.php";
include "bdd/setInscription.php";
include "bdd/getAllPlan.php";
include "bdd/getAllUser.php";

if(isset($_POST["sendNewPlan"])){

$isPlanCreate=setPlan();

}

if(isset($_POST["sendRegister"])){

$isUserCreate = setInscription($_POST["email_user"],$_POST["password_user"]);

}

$allPlan= getAllPlan();
$allUser=  getAllUser();
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
	<body>

		<div id="corp_admin">
			<?php
			if(isset($_GET['info'])) //SI ON A UNE BANNIERE A AFFICHER
			{
				 if($_GET['info']=="deletePlanFail"){?><p id="divInfo"  class="indexBan bgred" >Des utilisateurs ont ce plan </p><?php } ?> 
				<?php if($_GET['info']=="deletePlanSuccess"){?><p id="divInfo" class="indexBan bggreen" > Plan supprimé avec succes</p><?php } ?>
				<?php if($_GET['info']=="errorId"){?><p id="divInfo" class="indexBan bgred"> Erreur - Aucune ID transmise </p><?php } ?>
							
			<?php
			}
			else{?><p id="divInfo" class="indexBan bggreen"> Bienvenue sur la Panel d'administration</p><?php }
			?>
		
			<h1 class="mainTitle">EdBox - Administration</h1>
			
			<h1>Gestion des Utilisateurs</h1>

			
			<table>
			<tr>
				<th><b>ID User</b></th>
				<th><b>Mail</b></th>
				<th><b>ID Plan</b></th>
				<th>Supprimer</th>
			</tr>

			<?php

			foreach($allUser  as $cle => $valeur)
			{
				echo '<tr>';
				foreach($valeur as $cle2=>$valeur2)
				{
				 echo'<td>'.$valeur2.'</td>';
				 if($cle2=="id_user"){$userid=$valeur2;}
				
				}
				echo'<td><a href="bdd/deleteUserById.php?id='.$userid.'">Supprimer</a></td></tr>';
			}
			?>

			</table>
			
			<h2>Ajout d'un utilisateur :</h2>
			
			
			<section id="registerForm">
				<section id="formLogReg" class="full-width-box register">
					<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
						<p><input type="email" name="email_user" placeholder="E-mail" required /></p>
						<p><input type="password" name="password_user" placeholder="Mot de passe" required></p>
						<p><input type="password" name="password_user_conf" placeholder="Confirmation"  required/></p>
						<p><input type="submit" name="sendRegister" value="Valider" /></p>
					</form>
				</section>
			</section>
							

			<hr width="100%" style="color:#292929;" /> 

			
			<h1>Gestion des Plans</h1>
			
			<table>
			<tr>
				<th><b>ID</b></th>
				<th><b>Nom Plan</b></th>
				<th><b>Stockage (Go)</b></th>
				<th><b>Partage</b></th>
				<th><b>Upload (Mo)</b></th>
				<th><b>Download (Mo)</b></th>
				<th><b>Prix ($)</b></th>
				<th><b>Supprimer</b></th>
			</tr>
			<?php

			foreach($allPlan  as $cle => $valeur)
			{
				echo '<tr>';
				foreach($valeur as $cle2=>$valeur2)
				{
					 echo'<td>'.$valeur2.'</td>';
					 if($cle2=="id_plan")
					 {
						$planid=$valeur2;
						if($valeur2==1 ||$valeur2==2 ||$valeur2==3){$okDel="no";}
						else{$okDel="yes";}
					}
					
				}
				if($okDel=="yes"){echo'<td><a href="bdd/deletePlanById.php?id='.$planid.'">Supprimer</a></td></tr>';}
			}
			?>
			</table>
			<br>
			<br>
			<h2>Créer un plan :<h2>

			<form id="formNewPlan" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" onsubmit="return(submitform())">		
				<div id="stockage">
					Choissisez votre espace de disque :
				 <input type='number' min="1" max="400" name='stockage' id='plan_stockage' style="width:50px" onchange="hideSend()" required> Go </br><br> 
				</div>
				<div id="bandepassante">
					Choissisez votre bande passante : </br><br>
					<label for "upload">Upload : <input type='number' name='upload' id='plan_upload' min='1' max='50' style="width:50px" onchange="hideSend()" required>Mo/s </br>
					<label for "download">Download : </label><input type='number' name='download' id='plan_download' min='1' max='200' style="width:50px" onchange="hideSend()" required>Mo/s</br></br>
				</div>
				<div id="partage">
					Choissisez votre maximum de partage/jours (100 pour illimité) : 
					<input type='number' min="0" name='maxShare' id='plan_maxShare' style="width:50px" onchange="hideSend()" required></br>
				</div>

				<p> Prix : <input type="number" value="0" id="plan_prix_an" name="prix_an"  style="opacity:0;width:50px;"/> <span id="prixPlan">0</span>$ / An </p>
				
				<div>
					<input type="radio"id="choixPrixPerso" name="choixPrix" value="perso" onclick="typePrix(this.value)">Prix personnalisé
					<input type="radio" id="choixPrixAuto" name="choixPrix" value="auto" onclick="typePrix(this.value)" selected="selected" >Prix automatique
				</div>
				
				
				<p class="typeButton" onclick="getPrice()"> Calculer prix </p>
				
				<p  id="sendNewPlan" style="display:none"><input type="submit" name="sendNewPlan" value="Valider" /></p>
			</form>	




			
			<footer>
				<?php include "include/footer.php";?>
			</footer>
		</div>


	</body>
	<script>	
		var isVisible=false;

		function getPrice()
		{
			if(document.getElementById('choixPrixAuto').checked==true)
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
				//alert(prix);
				
				$('#prixPlan').text(prix);
				document.getElementById('plan_prix_an').value=prix;
			}
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
		
		function typePrix(type)
		{
			if(type=="perso")
			{
				document.getElementById('plan_prix_an').style.opacity="1";
				document.getElementById('prixPlan').style.opacity="0";
				if(isVisible==false)
				{
					$( "#sendNewPlan" ).animate({
						height: "toggle"
						}, 500);
					
					isVisible=true;
				}
			}
			else if(type=="auto")
			{
				document.getElementById('plan_prix_an').style.opacity="0";
				document.getElementById('prixPlan').style.opacity="1";
				
				if(isVisible==true)
				{
					$( "#sendNewPlan" ).animate({
						height: "toggle"
						}, 200);
						
					isVisible=false;
				}
			}
		
		}
		
		
		//pour gerer la banniere d'infos
	$( window ).load(function()
	{
		//on test si l'element existe
		if($("#divInfo").length)
		{
			//on commence la focntion au bout de 2 sec
			setTimeout(function() {
		
			$( "#divInfo" ).animate({
					opacity:"0",
					height: "toggle"
					}, 500);
				  
			}, 4000);
		}
	});
		
	</script>
</html>