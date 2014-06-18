<?php
//FONCTION DE LOGIN
	$userID=0;
	// Hachage du mot de passe
	$pass_hache = sha1($_POST["password_user"]);
	
	//on recherche l'id du user
	$req = $bdd->prepare('SELECT * FROM user WHERE mail = :mail');
	$req->execute(array('mail' => $_POST['mail_user']));	
	while ($donnees = $req->fetch())
	{
		//ON RECUP LES INFOS
		$userID= $donnees['id_user'];
		$userPass=$donnees['password'];
		$userMail=$donnees['mail'];

	}
	$req->closeCursor(); // Termine le traitement de la requête
	
	
	//si le mot de passe ne corresponds pas ou que l'adresse mail n'existe pas
	if($userPass!=$pass_hache)
	{
		header('Location: index.php?exit=failLogin');
	}
	else{$_SESSION['user_id'] = $userID;$_SESSION['user_mail'] = $userMail;}//SI LES MDP SONT OK
	?>