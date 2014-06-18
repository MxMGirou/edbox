<?php
function getUserFacture($id_user)
{
	include "/connect.php";

	//on va chercher la derniere facture
	$req = $bdd->prepare('SELECT * FROM facture WHERE id_user = :id ORDER BY id_facture DESC LIMIT 1');
	$req->execute(array('id' => $id_user));	
	while ($donnees = $req->fetch())
	{
		$infoFacture = array(
		'id_facture' => $donnees['id_facture'],
		'date_emission' => $donnees['date_emission'],
		'date_expiration' => $donnees['date_expiration'],
		'montant' => $donnees['montant'],
		'id_user' => $donnees['id_user'],
		'id_plan' => $donnees['id_plan'],
		'etat' => $donnees['etat']
		);
	}
	$req->closeCursor(); // Termine le traitement de la requête

	return $infoFacture ;
}


?>