<?php

//ON RECUP TOUT LES LIENS PRIVE
function getAllPrivateLink()
{
	include "connect.php";
	
	$tabLink=array();
	//on recherche si l'utilisateur est pas déja inscrit
	$req = $bdd->query('SELECT * FROM edbox_lien_prive');
			 
	while ($donnees = $req->fetch())
	{
		array_push($tabLink,array(
			"id"=>$donnees['id'],
			"url"=>$donnees['url_fichier'],
			"id_owner" => $donnees['id_owner'],
			"mail_user_cible" => $donnees['mail_user_cible']
			)); 
		
	}
	$req->closeCursor(); // Termine le traitement de la requête
		
	return $tabLink;
}


//ON RECUP TOUT LES LIENS PUBLICS
function getAllPublicLink()
{
	include "connect.php";
	
	$tabLink=array();
	//on recherche si l'utilisateur est pas déja inscrit
	$req = $bdd->query('SELECT * FROM edbox_lien_public');
			 
	while ($donnees = $req->fetch())
	{
		array_push($tabLink,array(
			"id"=>$donnees['id'],
			"url"=>$donnees['url_fichier'],
			"id_owner" => $donnees['id_owner']
			)); 
		
	}
	$req->closeCursor(); // Termine le traitement de la requête
		
	return $tabLink;
}



?>
