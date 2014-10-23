<?php
	global $id,$config,$pages;
	if($_SESSION['user']['id']==true){
		$memdt = member_dt($_SESSION['user']['id']);
	}

?>