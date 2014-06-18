<?php

function setFacture($id_user,$id_plan)
{
	include "/connect.php";
	
	//on va chercher la date
	require "./php/getDate.php";
	$date = myDate();
	
	

	//on va chercher le prix du plan
	$req = $bdd->prepare('SELECT prix_an FROM plan WHERE id_plan = :id');
	$req -> execute(array('id'=>$id_plan));
	while ($donnees = $req->fetch())
	{
		$prix_plan = $donnees['prix_an'];
	}
	$req->closeCursor(); // Termine le traitement de la requête

	if($prix_plan==0){$etat_facture="paye";}
	else{$etat_facture="non-paye";}
	
	//on creer la facture
	$req = $bdd -> prepare ('INSERT INTO facture(	date_emission, date_expiration, montant, id_user, id_plan, etat) VALUES(?,?,?,?,?,?)');
	$req -> execute (array(
	$date[0],
	$date[1],
	$prix_plan,
	$id_user,
	$id_plan,
	$etat_facture));

	return true ;
}


?>