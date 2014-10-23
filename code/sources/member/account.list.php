<?php
	global $id,$config,$pages,$languages;
	require 'include/option.php';
	
	if($_SESSION['user']['login'] && $_SESSION['user']['id']!= false)
	$dstaikhoan = bank_list($_SESSION['user']['id']);
	
	
?>