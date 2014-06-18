
<header>
<?php 

	//si on est pas sur l'index on affiche le logo
	if($_SERVER['PHP_SELF']!="/EdBox/index.php")
	{
		if(isset($_SESSION['user_id']))
		{?>
			<p><a href="fichiers.php" style='text-decoration:none;'><img src="img/logo-could-3pjt.png" alt="Logo" width="250"/></a></p>	
		<?php
		}
		else
		{?>
		<p><a href="index.php" style='text-decoration:none;'><img src="img/logo-could-3pjt.png" alt="Logo" width="250"/></a></p>	
		<?php
		}
	}
	?>

	
	<?php 
	if(isset($_SESSION['user_id']))
	{
		require "bdd/getNotifSystem.php";
		$tabNotif=array();
		$tabNotif=getUserNotif($_SESSION['user_id']);
		
	
	?>
		<div id="navBar">
			<ul>
				<li ><img src="<?php echo getNotifIcon($tabNotif);?>" id="imgNotif" width="20" style="cursor:pointer" title="Notifications" onclick="displayNotif()"/></li>
				<li><a <?php if($_SERVER['PHP_SELF']=="/EdBox/fichiers.php"){?>style="text-decoration:underline"<?php } ?> href="fichiers.php">Fichiers</a></li>
				<li><a <?php if($_SERVER['PHP_SELF']=="/EdBox/profil.php"){?>style="text-decoration:underline"<?php } ?> href="profil.php">Profil</a></li>
				<li><a <?php if($_SERVER['PHP_SELF']=="/EdBox/partage.php"){?>style="text-decoration:underline"<?php } ?> href="partage.php">Partage</a></li>
				<li><a href="index.php?exit=logout">Logout</a></li>
			</ul>
		</div>
		
		<div id="sectionNotif">
		<?php foreach ($tabNotif as $cle => $value)
		{ ?>
			<p> <span><?php echo $tabNotif[$cle]['content']; ?></span><span class="closeNotif" ><a href="bdd/setSeeNotif.php?id=<?php echo $tabNotif[$cle]['id_notification']; ?>&loc=<?php echo $_SERVER['PHP_SELF'];?>" >x</a> </span> </p>
		<?php
		}
		//SI LA TABLE EST VIDE
		if(empty($tabNotif))
		{ ?>
		
		<p> <span>Vous n'avez pas de notification</span> </p>
		<?php
		}
		?>
		
		</div>
	<?php
	}
	else if($_SERVER['PHP_SELF']!="/EdBox/index.php")
	{?>
		<div id="navBar">
			<ul>
				<li><a  href="index.php">Accueil</a></li>
			</ul>
		</div>
	<?php
	}?>
</header>

<script>
var isVisible=false;
function displayNotif()
{	//variable d'animation
	animation=true;
	
	//si on veux afficher
	if(isVisible==false && animation==true)
	{
		$('#sectionNotif').animate(
		{
			opacity:1
		},300);
	
		$('#imgNotif').attr("src","./img/icon_notif_b.png");
		
		isVisible=true;
		animation=false;
	}
	
	//si on veux cacher
	if(isVisible==true && animation==true)
	{
		$('#sectionNotif').animate(
		{
			opacity:0
		},300);
		
		$('#imgNotif').attr("src","./img/icon_notif_g.png");
	
		isVisible=false;
		animation=false;
	}
	
	
}
</script>