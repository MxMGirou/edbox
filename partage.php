
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

//REQUETE POUR RECUP LES LIENS
include "bdd/getAllLink.php";
$tabPrivateLink = getAllPrivateLink();
$tabPublicLink = getAllPublicLink();

//REQUETE POUR RECUPERER LE MAIL DU PROPRIO
include "bdd/getUserById.php";


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/style1.css" />
        <link rel="icon" type="image/png" href="img/favicon.ico" />
        <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/jquery.arbitrary-anchor.js"></script>
<title>EDBox - Partage</title>


</head>
<body onscroll="getArrowUp()">

	
	<div id="corp" style="font-family:champagne;color:white;">
		<?php include "include/header.php";?>
		
		<div id="mainContent">
			
			<h1> Vos Partages </h1>
			
			<?php
				//BANDEAU DINFORMATION
				if(isset($_GET['info'] )&& $_GET['info']=="createSuccess")
				{?>
				<div  id="InfoDiv" class="bandeauPaiement bggreen" >
					 Votre Lien à bien été créé
				</div>
				<?php
				}
				if(isset($_GET['info']) && $_GET['info']=="deleteSuccess")
				{?>
				<div  id="InfoDiv" class="bandeauPaiement bggreen" >
					 Votre Lien à bien été supprimé
				</div>
				<?php
				}
				?>
			
			<!--LIEN PRIVES -->
			<section>
				<h2> Liens Privés <img id="arrow_prive" src="img/arrow.png" width="25" onclick='showSection("prive")' style="cursor:pointer" /> </h2>
				<ul id="liste_prive">
					<?php
					$foo=0;
					foreach ($tabPrivateLink as $cle => $valeur)
					{
						if($valeur["id_owner"]==$_SESSION['user_id'])
						{
							echo '<li>Lien : <a href="share.php?p=prive&id='.$valeur["id"].'">localhost/edbox/share.php?p=prive&id='.$valeur["id"].' </a> <a href="bdd/deleteLinkById.php?p=prive&id='.$valeur["id"].'" > <img src="img/delete_link.png" title="Supprimer" width="30" /></a></br><i>Redirige vers : "'.$valeur["url"].'"</i></br>Partagé avec  : '.$valeur["mail_user_cible"].'</br>Permission  : '.$valeur["perm"].'</li>';
							$foo++;
						}

					}
					if($foo==0){echo "<p> Vous n'avez pas de lien privé</p>";} 
					?>
					
					
				</ul>

			</section>

			<hr width="70%" ></hr>
			
			<!--LIEN PUBLICS -->
			<section>
				<h2> Liens Publics <img id="arrow_public" src="img/arrow.png" width="25" onclick='showSection("public")' style="cursor:pointer" /></h2>	
				<ul id="liste_public">
					
					
					<?php
					$foo2=0;
					foreach ($tabPublicLink as $cle => $valeur)
					{
						if($valeur["id_owner"]==$_SESSION['user_id'])
						{
							echo '<li>Lien : <a href="share.php?p=public&id='.$valeur["id"].'">localhost/edbox/share.php?p=public&id='.$valeur["id"].' </a>  <a href="bdd/deleteLinkById.php?p=public&id='.$valeur["id"].'" > <img src="img/delete_link.png" title="Supprimer" width="30" /></a></br><i>Redirige vers : "'.$valeur["url"].'"</i></br>Permission  : '.$valeur["perm"].'</li>';
							$foo2++;
						}

					}
					if($foo2==0){ echo"<p> Vous n'avez pas de lien public</p>";}
					?>
				</ul>	
			
			</section>
			
			<hr width="70%" ></hr>
			
			<!--LIEN PARTAGES -->
			<section>
				<h2> Liens Partagés avec vous <img id="arrow_partage" src="img/arrow.png" width="25" onclick='showSection("partage")' style="cursor:pointer" /></h2>	
				<ul id="liste_partage">
					
					
				<?php
					$foo=0;
					foreach ($tabPrivateLink as $cle => $valeur)
					{
						if($valeur["mail_user_cible"]==$_SESSION['user_mail'])
						{
							echo '<li>Lien : <a href="share.php?p=prive&id='.$valeur["id"].'">localhost/edbox/share.php?p=prive&id='.$valeur["id"].' </a> </br><i>Redirige vers : "'.$valeur["url"].'"</i></br>Propriétaire : '.getUserById($valeur["id_owner"]).'</li>';
							$foo++;
						}

					}
					if($foo==0){echo "<p> Aucun utilisateur n'a partagé de fichier avec vous</p>";} 
					?>
				</ul>	
			
			</section>
			
		
		</div><!--fin main content -->
		<!-- Notre fleche ancre -->
		<?php include "include/getArrowUp.html";?>
		
		<footer>
			<?php include "include/footer.php";?>
		</footer>
	</div>

</body>

<script>

function rotate(degree, div) 
	{
	   $("#arrow_"+div).css({ WebkitTransform: 'rotate(45deg)'});
		$("#arrow_"+div).css({ '-moz-transform': 'rotate(45deg)'});

	}

	//pour gerer la banniere d'infos
	$( window ).load(function()
	{
		//on test si l'element existe
		if($("#InfoDiv").length)
		{
			//on commence la focntion au bout de 5 sec
			setTimeout(function() {
		
				$( "#InfoDiv" ).animate({
					opacity:"0",
					height: "toggle"
					}, 500);
				  
			}, 5000);
			
			
		}
		
		rotate(45,"prive");
		rotate(45,"public");
		rotate(45,"partage");
		
		
	
	});
	
	
	
			
			
	publicVisible=true;
	priveVisible=true;
	partageVisible=true;
	
	function showSection(div)
	{
		 var $elie = $("#arrow_"+div);
		
	   
	   if((div=="public" && publicVisible==true) || (div=="prive" && priveVisible==true) ||(div=="partage" && partageVisible==true))
	   {
	   
		   $elie.animate({  borderSpacing: -45 }, {
				step: function(now,fx) {
				  $(this).css('-webkit-transform','rotate('+now+'deg)'); 
				  $(this).css('-moz-transform','rotate('+now+'deg)');
				  $(this).css('transform','rotate('+now+'deg)');
				},
				duration:'normal'
			},'linear');
			
			if(div=="public"){publicVisible=false;}
			if(div=="prive"){priveVisible=false;}
			if(div=="partage"){partageVisible=false;}
		
		}
		else if((div=="public" && publicVisible==false) || (div=="prive" && priveVisible==false) || (div=="partage" && partageVisible==false))
	   {
	   
		   $elie.animate({  borderSpacing: 45 }, {
				step: function(now,fx) {
				  $(this).css('-webkit-transform','rotate('+now+'deg)'); 
				  $(this).css('-moz-transform','rotate('+now+'deg)');
				  $(this).css('transform','rotate('+now+'deg)');
				},
				duration:'normal'
			},'linear');
			
			if(div=="public"){publicVisible=true;}
			if(div=="prive"){priveVisible=true;}
			if(div=="partage"){partageVisible=true;}
		
		}
			
			$('#liste_'+div).animate({
			
				height: "toggle"
			
			},'400');
			
			
		
	
	}

</script>


</html>