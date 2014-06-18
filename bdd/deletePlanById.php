<?php
include "connect.php";


if(isset($_GET["id"]))
{
	//ON VERIFIE SI PERSONNE A CE PLAN
	include "getAllUser.php";
	$allUser=  getAllUser();

	$isOK=true;
	foreach($allUser  as $cle => $valeur)
	{
		foreach($valeur  as $cle2 => $valeur2)
		{
			if($cle2=="id_plan" )
			{
				if($valeur2==$_GET["id"]){$isOK=false;}
			}
		}
	}

	if($isOK==false){header('Location: ../admin.php?info=deletePlanFail');}
	else if($isOK==true)
	{
		$req = $bdd -> prepare ('DELETE FROM plan WHERE id_plan =:id');
		$req->execute(array("id"=>$_GET["id"]));
		header('Location: ../admin.php?info=deletePlanSuccess');
	}
	

	
	
}
else
{
	header('Location: ../admin.php?info=errorId');
}


