<!DOCTYPE html>
<?php
include "bdd/connect.php";

$success=null;

if(isset($_GET['id']))
{	
	session_start();

	//si  on a envoyé les post pour creer un plan
	if($_GET['id']==0)
	{
		
		//on prépare la requete
		$req = $bdd -> prepare ('INSERT INTO plan(prix_an, stockage, maxShare, upload, download) VALUES(?, ?, ?,?,?)');
		$req -> execute (array(
		$_POST["prix_an"],
		$_POST["stockage"],
		$_POST["maxShare"],
		$_POST["upload"],
		$_POST["download"]));
		
		//on recherche l'id du plan
		$req = $bdd->query('SELECT id_plan FROM plan ORDER BY id_plan DESC LIMIT 1');		 
		while ($donnees = $req->fetch())
		{
			//on recup l'id du plan
			$planID= $donnees['id_plan'];
		}
		$req->closeCursor(); // Termine le traitement de la requête

	}
	if($_GET['id']>0)
	{
		$planID=$_GET['id'];
	}
	
	
	//on verifie si le plan existe
	//on recherche l'id du du plan
	$foo=false;
	$req = $bdd->query('SELECT id_plan FROM plan WHERE id_plan = '.$planID);			 
	while ($donnees = $req->fetch())
	{ //si il existe
		$foo=true;
	}
	$req->closeCursor(); // Termine le traitement de la requête

	//si le plan existe
	if($foo==true)
	{
		//UPDATE DU PLAN DU USER
		$req = $bdd -> prepare ('UPDATE user SET id_plan = :id_plan WHERE id_user = :id_user ');
		$req -> execute (array(
		'id_plan' => $planID,  
		'id_user' => $_SESSION['user_id']));
		
		$success=true;
	}
	else
	{
		$success=false;
	}
	
	//on va générer la facture
	require "bdd/setFacture.php";
	setFacture($_SESSION['user_id'],$planID);

}
else $success == false;


?>


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
			
			
			<?php 
			//si ça a réussi 
			if( isset($success) && $success==true)
			{ ?>
				
				<h2> Votre plan est bien enregistré. Cliquez <a href="profil.php">ici</a> pour acceder a votre compte</h2>
				
			
			<?php
			}
			else if( isset($success) && $success==false) //si le compte existe déja
			{?>
				<h2> Erreur : le plan rentré ne correspond a aucun plan enregistré.</h2>
			<?php
			}
			else
			{
				echo "Vous ne devriez pas être ici ... cliquez <a href='index.php'> ici </a> pour revenir à l'accueil" ;
			}
			?>	
			
			
		
		</div>
		
		<p id="arrowUp" style="opacity:0;"><a href="#.index" style='text-decoration:none;'><img src="img/arrowUp.png" alt="arrow Up" /></a></p>
		<br></br>
		
		<footer>
			<?php include "include/footer.php";?>
		</footer>
	</div>

</body>
<script type="text/javascript">
	//function pour faire apparaitre la fleche Up
	function getArrowUp()
	{
		
		var height = $(window).height();
		var scrollTop = $(window).scrollTop();
		if(scrollTop>600)
		{
			document.getElementById("arrowUp").style.opacity=0.2;
		}
		else
		{
			document.getElementById("arrowUp").style.opacity=0;
		}
	}
	
	
	
	
</script>
</html>