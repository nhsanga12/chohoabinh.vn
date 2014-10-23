<?php
	global $id,$config,$pages,$languages;
	
	if($_SESSION['user']['id']!= false)
	$dssanpham = order_of_mem($_SESSION['user']['id']);
?>