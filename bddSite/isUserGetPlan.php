<?php

//ON regarde si l'utilisateur a un plan
function isUserGetPlan($id)
{
		include "connect.php";
		
		//variable de renvoi (true = il est déja en base, false= il n'est pas en base)
		$foo=null; 
		//on recherche si l'utilisateur est pas déja inscrit
		$req = $bdd->prepare('SELECT id_plan FROM edbox_user WHERE id_user = :id ');
		$req->execute(array('id' => $id));
					 
		while ($donnees = $req->fetch())
		{
			$foo = $donnees['id_plan'];
		}
		$req->closeCursor(); // Termine le traitement de la requête
			
		if($foo==0){return false;}
		if($foo!=0){return true;}
}


?>
