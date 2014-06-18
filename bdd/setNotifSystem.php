<?php

//CREATION DE LA NOTIF
function setNotif($id_emeteur, $id_cible)
{
	try
	{
		include "connect.php";
		
		$content = "Un utilisateur à partagé un lien avec vous";

		//on creer la facture
		$req = $bdd -> prepare ('INSERT INTO notification(id_emeteur, id_cible, content) VALUES(?,?,?)');
		$req -> execute (array(
		$id_emeteur,
		$id_cible,
		$content));

		return true ;
	}
	catch (Exception $e)
	{
		echo 'Exception reçue : ',  $e->getMessage(), "\n";
		return false;
	}
	
	
}



?>