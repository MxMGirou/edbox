<?php

//INSCRIPTION
function setInscription($email, $password)
{

	include "connect.php";
	
	// Hachage du mot de passe
	$pass_hache = sha1($password);
							
							
	//on prépare la requete
	$req = $bdd -> prepare ('INSERT INTO user(mail, password) VALUES(?, ?)');
	$req -> execute (array(
	$email,  
	$pass_hache));

	//on recherche l'id du de l'utilisateur pour le connecter
	$req = $bdd->query('SELECT * FROM user ORDER BY id_user DESC LIMIT 1');
	while ($donnees = $req->fetch())
	{
		//on connecte l'utilisateur direct
		$_SESSION['user_id'] = $donnees['id_user'];
		$_SESSION['user_mail'] = $donnees['mail'];
	}
	$req->closeCursor(); // Termine le traitement de la requête
	
	return true;

}

?>