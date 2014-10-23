<?php
	global $id,$config,$pages,$languages;
	
	if($_SESSION['user']['id']!= false)
	$dsbanner = banner_of_mem($_SESSION['user']['id']);
?>