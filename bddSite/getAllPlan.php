<?php


//ON regarde si l'utilisateur existe
function getAllPlan()
{
		include "connect.php";
		
		//variable de renvoi (true = il est déja en base, false= il n'est pas en base)
		$tab=array(); 
		//on recherche si l'utilisateur est pas déja inscrit
		$req = $bdd->query('SELECT * FROM edbox_plan ORDER BY id_plan DESC');

		while ($donnees = $req->fetch())
		{
			array_push($tab,array(
			$donnees['id_plan'],
			$donnees['name'],
			$donnees['stockage'],
			$donnees['maxShare'],
			$donnees['upload'],
			$donnees['download'],
			$donnees['prix_an']
			));
	}
		$req->closeCursor(); // Termine le traitement de la requête
			return $tab;
	}


?>
