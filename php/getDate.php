<?php
	function myDate()
	{
		$today = getdate();
		$year2=$today['year']+1;
		if($today['mday']<10)$today['mday']='0'.$today['mday'];
		if($today['mon']<10)$today['mon']='0'.$today['mon'];
		
		$s_date = $today['mday'].'/'.$today['mon'].'/'.$today['year'];
		$s_date2 = $today['mday'].'/'.$today['mon'].'/'.$year2;
	
		return array($s_date, $s_date2);
	}
	
	
	
?>