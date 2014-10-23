<?php
	global $id,$config,$pages,$languages;
	
	if($_SESSION['user']['id']!= false)
	$dssanpham = pro_of_mem($_SESSION['user']['id']);
?>