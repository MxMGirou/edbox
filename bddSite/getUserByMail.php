<?php

//ON regarde si l'utilisateur existe
function getUserByMail($mail)
{
		include "connect.php";
		
		//variable de renvoi (true = il est déja en base, false= il n'est pas en base)
		$isHere=false; 
		//on recherche si l'utilisateur est pas déja inscrit
		$req = $bdd->prepare('SELECT mail FROM edbox_user WHERE mail = :mail ');
						$req->execute(array(
							'mail' => $_POST['email_user']
							));
					 
		while ($donnees = $req->fetch())
		{
			$foo = $donnees['mail'];
			$isHere=true;
		}
		$req->closeCursor(); // Termine le traitement de la requête
			
		return $isHere;
}


?>
