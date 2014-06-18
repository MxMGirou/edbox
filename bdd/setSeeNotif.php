<?php

if(isset($_GET['id']) && isset($_GET['loc']))
{
	include "/connect.php";

	$req = $bdd ->prepare('UPDATE notification SET isSee=1 WHERE id_notification = :id');
	$req -> execute(array('id'=>$_GET['id']));
	
	 header('Location:'.$_GET['loc']);  
}


?>