<?php
@session_start();
if (!$_SESSION['auth']) {
	
	$_SESSION['auth']['login'] 		= 	false;
	$_SESSION['auth']['name'] 		= 	false;
	$_SESSION['auth']['id'] 		= 	false;
	$_SESSION['auth']['group'] 		= 	false;
	$_SESSION['auth']['temp'] 		= 	false;
}
?>
