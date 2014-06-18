<?php

//ON VA CHERCHER L ID DE LUTILISATEUR
function getUserIdByMail($mail)
{
		include "/connect.php";
		
		//on recherche si l'utilisateur est pas déja inscrit
		$req = $bdd->prepare('SELECT id_user FROM user WHERE mail = :mail ');
						$req->execute(array(
							'mail' => $mail
							));
					 
		while ($donnees = $req->fetch())
		{
			$foo = $donnees['id_user'];
		}
		$req->closeCursor(); // Termine le traitement de la requête
			
		return $foo;
}


?>
