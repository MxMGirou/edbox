<?php

//ON regarde si l'utilisateur existe
function getAllUser()
{
		include "connect.php";
		
		$tabUser=array();
		//on recherche si l'utilisateur est pas déja inscrit
		$req = $bdd->query('SELECT * FROM edbox_user');
				 
		while ($donnees = $req->fetch())
		{
			array_push($tabUser,array(
				"id_user"=>$donnees['id_user'],
				"mail_user"=>$donnees['mail'],
				"id_plan" => $donnees['id_plan']
				)); 
			
		}
		$req->closeCursor(); // Termine le traitement de la requête
			
		return $tabUser;
}


?>
