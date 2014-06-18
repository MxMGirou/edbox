
<?php
session_start();
include "bdd/connect.php";


//$success=null;

//si on nous envoi une demande de connexion
if(isset($_POST['sendLogin']))
{	
	//REQUETE DE LOGIN
	include "bdd/login.php";
}	

//on tchek si on a une variable de session
if(!isset($_SESSION['user_id']))
{
	header('Location: index.php?exit=needLogin');
}	



//FONCTION DE RECUPERATION DE POIDS DU DOSSIER
require "php/getDirSize.php";

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

//on calcule la capacité et la taille des fichiers 
$total_size = foldersize("files/".$_SESSION['user_id']); 
$myCap = format_size2($total_size, 1 ,$planUser['stockage'] );



	
?> 




<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style1.css" />
        <link rel="icon" type="image/png" href="img/favicon.ico" />
        <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/jquery.arbitrary-anchor.js"></script>
		<title>EDBox - Profil</title>
	</head>

	<body onscroll="getArrowUp()" onload="setCapacityBar()">

		
		<div id="corp" style="font-family:champagne;color:white;">
			<?php include "include/header.php";?>
			
			<div id="mainContent">
				
				<h1> Profil</h1>
				
				<?php //BANDEROLE DINFO
				if($isPaid==false)
				{?>
				<div id="factureDiv2" class="bandeauPaiement bgred" >
					Vous avez une facture en attente de <?php echo $factureUser['montant'];?> $ .
				</div>
				<?php
				}
				if(isset($_GET['info']))
				{
				?>
				<div  id="factureDiv" class="bandeauPaiement bggreen" >
					 Votre paiement à été approuvé.
				</div>
				<?php
				}
				?>
				
				
				<div style="width:700px;margin:0px auto 60px auto">
					<!--INFO UTILISATEUR -->
					<section id="info_user" class="dp50">
					
						<h2><strong>Infos : </strong></h2>
						<p>E-mail : <?php echo $_SESSION['user_mail'];?></p>
						<p>Mot de passse : ******</p>
						
					</section>
					
					
					<!--INFO ESPACE  -->
					<section id="espace_user" class="dp50">
					
						<h2><strong>Espace : </strong></h2>
						<?php  $total_size = foldersize("files/".$_SESSION['user_id']);
								echo format_size ($total_size, 2 ) ." sur ". $planUser['stockage'] . "Go  "; 	if($myCap>84){echo "  <img src='img/warning_icon.png' title='moins de 15% d espace restant' alt='ATTENTION' />";}?>
							
						<div id="capacityBar" ><!-- progress bar complete -->
							<div id="capacityBarR" title="<?php echo $myCap.'%';?>" style="padding-left:5px; "><!-- progress bar qui indique la quantité -->
								<span style="margin-right:auto;margin-left:auto;"><?php echo $myCap.'%';?></span>
							</div>
						</div>
						<p><a href="#" id="voirFacture" >Voir mes factures</a></p>
						
					</section>
					<div class="clear"></div>
				</div>
				
				
				
				<!--FACTURE UTILISATEUR -->
				<div id="facture_user" >
				
					<?php// var_dump($factureUser);var_dump($planUser);  ?>
					<!--<hr style="width:50%; margin:40px auto 20px auto;"></hr>-->
					<h2><strong> Facture N°<?php echo $factureUser['id_facture']; ?></strong></h2>
					<?php //si la personne a déja payé on le dit
					if($factureUser['etat']=="paye"){ echo "<h3> <u>Payé </u></h3>";}
					?>
					
					<p class="dp50" style="height:60px"><u>Montant </u>:  <?php echo $factureUser['montant']; ?>$  </br><u> Plan </u>: <?php echo $planUser['name']; ?> </p>
					<p class="dp50" style="height:60px"><u>Date d'émission </u>: <?php echo $factureUser['date_emission']; ?> </br><u> Date d'expiration </u> : <?php echo $factureUser['date_expiration']; ?> </p>
					
					<?php 
					if($factureUser['etat']=="non-paye") //si la personne a pas payé, on lui affiche le formulaire de paiement
					{ ?>
						<h2> <u>Payer par carte : </u><img style="position:relative;top:10px;" src="img/cartes.png" width="50"/></h2>
						
						<!--FORMULAIRE PAIEMENT -->
						<form enctype="multipart/form-data" action="bdd/setPaiement.php?id=<?php echo $factureUser['id_facture']; ?>" method="post"> </br>
							Numéro de carte : <input type="text" name="numero_carte" size="18"  required /></br>
							Date d'expiration (MM/AA) : <input type="text" name="exp_mois" size="2" required /> / <input type="text" name="exp_anne" size="2" required />  </br>
							Cryptogramme : <input type="text" name="crypto" required size="3" /> </br>
							<input type="submit" value="Payer" name="sendPaiement" />
						</form>
						
					<?php
					} 
					else{echo "</br></br></br></br>";}
					?>
					
					
				</div>
				
				<div class="clear"></div>
				
				<hr style="width:80%; margin:10px auto 20px auto;"></hr>
				
				
				<!--INFO PLAN-->
				<section id="plan_user">
					<h2><strong>Plan :  </strong></h2>
					<div class="dp30">
						<p><u>Type</u> : <?php if($planUser['name'])echo $planUser['name']; ?></p>
						<p><u>Prix / an </u> : <?php echo $planUser['prix_an']; ?> $ </p>
					</div>
					
					<div class="dp30">
						<?php
						if($planUser['name']=="Gratuit"){ echo '<img src="img/logo/Drive_Download.png" alt="logo"/>'; }
						 if($planUser['name']=="Professionnel"){  echo '<img src="img/logo/Suit.png" alt="logo" />';  }
						if($planUser['name']=="Premium"){  echo '<img src="img/logo/Premium.png" alt="logo" />';  }
						 if($planUser['name']=="Custom"){  echo '<img src="img/logo/Setup.png" alt="logo" /> '; }
						 ?>
					</div>
					
					<div class="dp30">
						<p><u>Débit montant</u> : <?php echo $planUser['upload']; ?>Mo/s </p>
						<p><u>Débit descendant</u> : <?php echo $planUser['download']; ?> Mo/s </p>
						<p><u> Maximum de partage / Jour </u> : <?php echo $planUser['maxShare']; ?> </p>
					</div>
					
					
					<div class="clear"></div>
				</section>
				
				
			
			</div><!--FIN MAIN CONTENT -->
			
			<!-- Notre fleche ancre -->
			<?php include "include/getArrowUp.html";?>
			
			<footer>
				<?php include "include/footer.php";?>
			</footer>
		</div>

	</body>
	<script type="text/javascript">
		
		
		//fonction pour afficher ou masquer la facture
		$( "#voirFacture" ).text("Voir ma facture");
		$('#voirFacture').click(function()
		{
			 $( "#facture_user" ).animate({
			height: "toggle"
			}, 1000);
			
		
			if($( "#voirFacture" ).text()=="Voir ma facture"){$( "#voirFacture" ).text("Masquer ma facture");}
			else{$( "#voirFacture" ).text("Voir ma facture");}
			
		});
		
		
		//fonction pour animer la pbar de progression
		function setCapacityBar()
		{
			
				//on commence la focntion au bout de 2 sec
			setTimeout(function() {
				//on recupere le titre(il contient le pourcentage)
				var pourcent=	$( "#capacityBarR" ).attr('title');
				$( "#capacityBarR" ).animate({
					width: pourcent
					}, 1000);
				  
			}, 2000)
		
		}
		
		//pour gerer la banniere d'infos
	$( window ).load(function()
	{
		//on test si l'element existe
		if($("#factureDiv").length)
		{
			//on commence la focntion au bout de 2 sec
			setTimeout(function() {
		
				$( "#factureDiv" ).animate({
					opacity:"0",
					height: "toggle"
					}, 500);
				  
			}, 5000);
		}
	});
	
	
		
	</script>
</html>