<?php
session_start();

include "connect.php";
//SI ON A BIEN ENVOYE UN POST
if(isset($_POST['sendNewLink']))
{

	if(isset($_POST['typeLien']) && $_POST['typeLien']=="prive")
	{
	
		//CREATION DU LIEN
		$req = $bdd -> prepare ('INSERT INTO edbox_lien_prive (url_fichier, mail_user_cible, id_owner) VALUES (?, ?,?) ');
		$req -> execute (array(
			$_POST['url'],
			$_POST['mailUserCible'],
			$_SESSION['user_id']));
	}
	if(isset($_POST['typeLien']) && $_POST['typeLien']=="public")
	{
	
		//CREATION DU LIEN
		$req = $bdd -> prepare ('INSERT INTO edbox_lien_public (url_fichier, id_owner) VALUES (?,?) ');
		$req -> execute (array(
			$_POST['url'],
			$_SESSION['user_id']));
	}
	
	
	header('Location: ../partage.php?info=createSuccess');

}
else{header('Location: ../index.php?exit=failAccess');}

?>