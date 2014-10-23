<?php global $id,$config,$languages;

	if (isset($_SESSION['id'])) {
		// Redirection to login page twitter or facebook
		echo "<script language=\"javascript\">window.location.replace(\"http://xalomuaban.com\")</script>";
	}
	
	if (array_key_exists("q", $_GET)) {
		$oauth_provider = $_GET['q'];
		if ($oauth_provider == 'facebook' || $oauth_provider == 'twitter') {
			echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."/include/login/login-".$oauth_provider.".php\")</script>";
		
		} else if ($oauth_provider == 'google') {
			echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."/include/login/googlelogin/google_login.php\")</script>";
		
		} else if ($oauth_provider == 'yahoo') {
			echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."/include/login/login-yahoo.php?login\")</script>";
		}
	}
	
?>