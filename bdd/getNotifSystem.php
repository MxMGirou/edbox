<?php
//session_start();

function getUserNotif($id_user)
{
	include "/connect.php";
	
	$tabNotif=array();
	//on selectione toutes les notif de l'user cible qu'il n'a pas encore vues
	$req = $bdd->prepare('SELECT * FROM notification WHERE id_cible=:id_cible AND isSee=0');
	$req -> execute(array('id_cible'=>$id_user));
			 
	while ($donnees = $req->fetch())
	{
		array_push($tabNotif,array(
			"id_notification" => $donnees['id_notification'],
			"id_emeteur"=>$donnees['id_emeteur'],
			"id_cible" => $donnees['id_cible'],
			"content" => $donnees['content']
			)); 
			
			//on incrémente le nbr de notif
		
	}
	$req->closeCursor(); // Termine le traitement de la requête
	
	return $tabNotif;

}


function getNotifIcon($tab)
{
	$img_no_notif="./img/icon_notif_g.png";
	$img_got_notif="./img/icon_notif_r.png";

	if(count($tab)<1){return $img_no_notif;}
	if(count($tab)>0){return $img_got_notif;}
	
}

?>