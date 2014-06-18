<?php
function setPlan(){

include "connect.php";
	
		$req = $bdd -> prepare ('INSERT INTO edbox_plan(prix_an, stockage, maxShare, upload, download) VALUES(?, ?, ?,?,?)');
		$req -> execute (array(
		$_POST["prix_an"],
		$_POST["stockage"],
		$_POST["maxShare"],
		$_POST["upload"],
		$_POST["download"]));
		
		return true;
}

		
?>