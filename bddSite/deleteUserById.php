<?php
include "connect.php";
include "../php/deleteDir.php";

if(isset($_GET["id"]))
{
	$req = $bdd -> prepare ('DELETE FROM edbox_user WHERE id_user =:id');
	$req->execute(array("id"=>$_GET["id"]));
	
	RepEfface('../files/'.$_GET["id"]);

}

header('Location: ../admin.php');

