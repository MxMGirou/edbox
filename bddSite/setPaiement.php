<?php

include "connect.php";
//SI ON A BIEN ENVOYE UN POST
if(isset($_POST['sendPaiement']) && isset($_GET['id']))
{
	//UPDATE DU PLAN DU USER
	$req = $bdd -> prepare ('UPDATE edbox_facture SET etat = :etat WHERE id_facture = :id_facture ');
	$req -> execute (array(
	'etat' => "paye",  
	'id_facture' => $_GET['id']));
	
	header('Location: ../profil.php?info=paiementSuccess');

}
else{header('Location: ../index.php?exit=failAccess');}
	

?>