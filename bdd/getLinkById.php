<?php


function getLinkById($type, $id)
{
	include "/connect.php";
		
	$tabLink=array();

	//SI CEST UN LIEN PRIVE
	if(isset($type) && $type=="prive")
	{
		//ON VERIFIE QUE LA PERSONNE QUI SUPRIME LE LIEN EST BIEN CELLE CONNECTE
		$isHim=false;
		$req = $bdd->prepare('SELECT * FROM lien_prive WHERE id= :id ');
		$req->execute(array(
			'id' =>$id));			 
		while ($donnees = $req->fetch())
		{
			array_push($tabLink,array(
				"id"=>$donnees['id'],
				"url"=>$donnees['url_fichier'],
				"id_owner" => $donnees['id_owner'],
				"mail_user_cible" => $donnees['mail_user_cible'],
				"perm" => $donnees['perm']
				)); 
		}
		$req->closeCursor(); // Termine le traitement de la requête
		
		return $tabLink;
		
	}
	
	
	//SI CEST UN LIEN PUBLIC
	else if(isset($type) && $type=="public")
	{
		//ON VERIFIE QUE LA PERSONNE QUI SUPRIME LE LIEN EST BIEN CELLE CONNECTE
		$isHim=false;
		$req = $bdd->prepare('SELECT * FROM lien_public WHERE id= :id ');
		$req->execute(array(
			'id' =>$id));			 
		while ($donnees = $req->fetch())
		{
			array_push($tabLink,array(
				"id"=>$donnees['id'],
				"url"=>$donnees['url_fichier'],
				"id_owner" => $donnees['id_owner'],
				"perm" => $donnees['perm']
				)); 
		}
		$req->closeCursor(); // Termine le traitement de la requête
		
		return $tabLink;

	}
	else
	{
		return null;
	}
	
}
	
	
	
?>