<?php
session_start();

include "connect.php";

//SI ON A BIEN NOS 2 INFOS DE GET
if(isset($_GET['id']) && isset($_GET['p']))
{
	//SI CEST UN LIEN PRIVE
	if(isset($_GET['p']) && $_GET['p']=="prive")
	{
		//ON VERIFIE QUE LA PERSONNE QUI SUPRIME LE LIEN EST BIEN CELLE CONNECTE
		$isHim=false;
		$req = $bdd->prepare('SELECT id_owner FROM edbox_lien_prive WHERE id_owner= :id ');
		$req->execute(array(
			'id' =>$_SESSION['user_id']));			 
		while ($donnees = $req->fetch())
		{
			$isHim=true;
		}
		$req->closeCursor(); // Termine le traitement de la requête
		
		//SI CEST BIEN LUI
		if($isHim==true)
		{
			$req = $bdd -> prepare ('DELETE FROM edbox_lien_prive WHERE id =:id ');
			$req -> execute (array("id"=>$_GET["id"]));
		}
		
	}
	
	
	//SI CEST UN LIEN PUBLIC
	if(isset($_GET['p']) && $_GET['p']=="public")
	{
		//ON VERIFIE QUE LA PERSONNE QUI SUPRIME LE LIEN EST BIEN CELLE CONNECTE
		$isHim=false;
		$req = $bdd->prepare('SELECT id_owner FROM edbox_lien_public WHERE id_owner= :id ');
		$req->execute(array(
			'id' =>$_SESSION['user_id']));			 
		while ($donnees = $req->fetch())
		{
			$isHim=true;
		}
		$req->closeCursor(); // Termine le traitement de la requête
		
		//SI CEST BIEN LUI
		if($isHim==true)
		{
			$req = $bdd -> prepare ('DELETE FROM edbox_lien_public WHERE id =:id ');
			$req -> execute (array("id"=>$_GET["id"]));
		}
		
	}
	
	
	
	header('Location: ../partage.php?info=deleteSuccess');

}
else{header('Location: ../partage.php');}

?>