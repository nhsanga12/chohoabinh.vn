<?php
	global $id,$config,$pages,$languages;
	
	if($_SESSION['user']['id']!= false)
	$tinnhanphanhoi = comment_of_pro($_SESSION['user']['id']);
?>