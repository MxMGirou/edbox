<?php


function getPlan($userID2)
{
	include "connect.php";

	//on recherche le plan du user
	$req = $bdd->prepare('SELECT id_plan FROM edbox_user WHERE id_user = :id');
	$req->execute(array('id' => $userID2));	
	while ($donnees = $req->fetch())
	{
		$id_plan= $donnees['id_plan'];
	}
	$req->closeCursor(); // Termine le traitement de la requête
	
	
	$req = $bdd->prepare('SELECT * FROM edbox_plan WHERE id_plan = :id');
	$req->execute(array('id' => $id_plan));	
	while ($donnees = $req->fetch())
	{
		$infoPlan = array(
		'id_plan' => $donnees['id_plan'],
		'prix_an' => $donnees['prix_an'],
		'name' => $donnees['name'],
		'stockage' => $donnees['stockage'],
		'maxShare' => $donnees['maxShare'],
		'upload' => $donnees['upload'],
		'download' => $donnees['download']
		);
	}
	$req->closeCursor(); // Termine le traitement de la requête

	return $infoPlan ;
}


?>