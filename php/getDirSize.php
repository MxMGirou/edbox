<?php
function foldersize($rep) 
{
	
	
	$racine=@opendir($rep);
    $taille=0;
    while($dossier=@readdir($racine)){
      if(!in_array($dossier, array("..", "."))){
        if(is_dir("$rep/$dossier")){
          $taille+=foldersize("$rep/$dossier");
        }else{
          $taille+=@filesize("$rep/$dossier");
        }
      }
    }
    @closedir($racine);
    return $taille;
  }
function taille_dossier1($rep){
    $racine=@opendir($rep);
    $taille=0;
    $dossier=@readdir($racine);
    $dossier=@readdir($racine);
    while($dossier=@readdir($racine)){
       
       if(is_dir("$rep/$dossier")){
          $taille+=foldersize("$rep/$dossier");
        }else{
          $taille+=@filesize("$rep/$dossier");
        }
       
    }
    @closedir($racine);
    return $taille;
}

function format_size($size , $round)
{
	//Size must be bytes!
	$sizes = array(' Octet(s)', 'ko', 'Mo', 'Go', 'To', 'Po', 'Eo', 'Zo', 'Yo');
	for ($i=0; $size > 1024 && $i < count($sizes) - 1; $i++) $size /= 1024;
	return round($size,$round).$sizes[$i];
} 

function format_size2($size , $round, $capacite)
{
	//Size must be bytes!
	$sizes = array(' Octet(s)', 'ko', 'Mo', 'Go', 'To', 'Po', 'Eo', 'Zo', 'Yo');
	for ($i=0; $size > 1024 && $i < count($sizes) - 1; $i++) $size /= 1024;
	
	//on formate correctement la capacité(de base en GO)
	if($i==0){$capacite*=1000000000;}
	if($i==1){$capacite*=1000000;}
	if($i==2){$capacite*=1000;}
	
	
	$percent = $size/$capacite*100;
	
	return (round($percent,$round));
}

function format_capacity($size , $round)
{


}

?>