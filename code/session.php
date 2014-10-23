<?php
session_start();
if (!$_SESSION['user']) {
	$_SESSION['loadads'] = array();
	$_SESSION['user']['login'] 		= 	false;
	$_SESSION['user']['name'] 		= 	false;
	$_SESSION['user']['id'] 		= 	false;
	$_SESSION['user']['themes']		= 	false;
	$_SESSION['user']['pages']		= 	0;
	$_SESSION['user']['limit']		= 	3;
	$_SESSION['loadads']			= 	false;
}
?>
