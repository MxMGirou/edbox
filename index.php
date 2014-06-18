<?php
session_start();

if(isset($_GET['exit']) && $_GET['exit']=="logout" && isset($_SESSION['user_id']))
{
	unset($_SESSION['user_id']);
	unset($_SESSION['user_mail']);
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

	


	<div id="corp">
	
		<?php 
		if(isset($_GET['exit'])) //SI ON A UNE BANNIERE A AFFICHER
		{
			 if($_GET['exit']=="logout"){?><p id="lougoutDiv" class="indexBan  bggreen" >Vous êtes déconnecté </p><?php } ?> 
			<?php if($_GET['exit']=="failLogin"){?><p id="lougoutDiv"  class="indexBan bgred" > Mauvais utilisateur ou mauvais mot de passe</p><?php } ?>
			<?php if($_GET['exit']=="needLogin"){?><p id="lougoutDiv" class="indexBan bgred"> Vous devez vous connecter </p><?php } ?>
			<?php if($_GET['exit']=="failAccess"){?><p id="lougoutDiv" class="indexBan bgred"> Vous ne pouvez pas accèder a cette page </p><?php } ?>
		
		<?php
		}?>
	
		<article id="index" class='full-width-box index'>
			<section>
				<img src="img/logo-could-3pjt.png" alt="logo" />
				<h1>Vos fichiers de tous les jours, partout.</h1>
			</section>
			<?php include "include/header.php";?>
			
			<section id="formLogReg">
				<h2>Connexion</h2>
				<form enctype="multipart/form-data" action="profil.php" method="post">
					<p><input type="text" name="mail_user" placeholder="E-mail" /></p>
					<p><input type="password" name="password_user" placeholder="Mot de passe" /></p>
					<p><input type="submit" name="sendLogin" value="Valider" /></p>
				</form>
				<i onclick="displayRegister()">Pas encore inscrit?</i>
			</section>
			
			
			<div>
				<section id="android" class="dp50">
					<span>
						<a href="#">
							<img src="img/android.png" width="90" />
							<i>Telecharger l'app </br>   Android</i>
						</a>
					</span>
				</section>
				
				<section id="android" class="dp50">
					<span>
						<a href="#">
							<img src="img/ios.png" width="80" />
							<i>Telecharger l'app </br>   iOS</i>
						</a>
					</span>
				</section>
			</div>
			<div class="clear"></div>
					
			<section id="IndexAbout">
				<p><a href="#.about"> - About - </a></p>
				<hr width="90%" style="color:#96d5fc;"></hr>
			</section>
		</article>
		
		<article id="about" class='full-width-box about'>
			<h1>Qu'es ce que c'est?</h1>
			<span>
				<img src="img/logo/Drive_Upload.png" alt="logofree" style="float:left"/>
				<i>EveryDay Box (EDBox)est une plateforme de cloud. Transportez, créez et modifiez vos données depuis n'importe ou! il vous suffit juste d'une connexion internet !</i>
			</span>
			
			<h1>Sécurité et intégrité</h1>
			<span>
				<img src="img/logo/Antivirus.png" alt="logosecu" style="float:right"/>
				<i>Avec nos méthodes de cryptages avancées et élaborées par nos soins, nous garantissons la sécurité et l'intégrité de vos données. vous pourrez ainsi les partagez avec qui vous voudrez de manirère tout a fait sécurisée !</i>
			</span>
			
			<h1>Version mobile</h1>
			<span>
				<img src="img/logo/Phone_settings.png" alt="logosecu" style="float:left"/>
				<i>EveryDay Box a son application mobile qui tourne sous Android. vous pourrez ainsi transporter vos fichiers avec vous sur vos tablettes ou vos smartphones !</i>
			</span>
			
			<br></br><br></br><br></br>
			<p class="lienAncre" style="text-align:center;font-size:12px;"><a href="#.services"> Voir plus... </a></p>
			
			
			<hr width="90%" style="color:#96d5fc;"></hr>
		</article>
		
		<article id="offres"  class='full-width-box services'>
			<h1>Nos Services</h1>
			
			
			<section id="service" >
				<h3>Personnel</h3>
				<img src="img/logo/Drive_Download.png" alt="logoFree" />
				<p>Prix: gratuit</p>
				<p>Stockage : 5go</p>
				<a href="#">Plus d'infos</a>
			</section>
			
			<section id="service">
				<h3>Professionnel</h3>
				<img src="img/logo/Suit.png" alt="logoPro" />
				<p>Prix: 80$/an</p>
				<p>Stockage : 75go</p>
				<a href="#">Plus d'infos</a>
			</section>
			
			<section id="service">
				<h3>Premium</h3>
				<img src="img/logo/Premium.png" alt="logoPremium" />
				<p>Prix: 160$/an</p>
				<p>Stockage : 200go</p>
				<a href="#">Plus d'infos</a>
			</section>
			<h2> Ou Creez le votre personalisé ! </h2>
			
			<p><button class="but_1" onclick="displayRegister()">J'essaye !</button></p>
			
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
			
		</article>
				<!-- Notre fleche ancre -->
		<?php include "include/getArrowUp.html";?>
		
		<footer>
			<?php include "include/footer.php";?>
		</footer>
	</div>

</body>
<script type="text/javascript">
	
	
	
	function displayRegister()
	{
		window.location='#.register';
		document.getElementById('registerForm').style.opacity=1;
		document.getElementById('registerForm').style.height="300px";
		
	}
	
	//pour gerer la banniere d'infos
	$( window ).load(function()
	{
		//on test si l'element existe
		if($("#lougoutDiv").length)
		{
			//on commence la focntion au bout de 2 sec
			setTimeout(function() {
		
			$( "#lougoutDiv" ).animate({
					opacity:"0",
					height: "toggle"
					}, 500);
				  
			}, 4000);
		}
	});
	
</script>
</html>