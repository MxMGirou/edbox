<?php

//ON regarde si l'utilisateur existe
function getUserById($id)
{
		include "/connect.php";
		
		//variable de renvoi (true = il est déja en base, false= il n'est pas en base)
		$foo=null; 
		//on recherche si l'utilisateur est pas déja inscrit
		$req = $bdd->prepare('SELECT mail FROM user WHERE id_user = :id ');
		$req->execute(array('id' => $id));
					 
		while ($donnees = $req->fetch())
		{
			$foo = $donnees['mail'];
		}
		$req->closeCursor(); // Termine le traitement de la requête
			
		return $foo;
}


?>
