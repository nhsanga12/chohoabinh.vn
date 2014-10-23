<?php

// Include the YOS library.
require 'yahoo/lib/Yahoo.inc';
//require 'yahoo/lib/YahooSessionStore.php';

require '../../session.php';
require 'config/yhconfig.php';
require 'config/functions.php';

if (array_key_exists("login", $_GET)) {
    $session = YahooSession::requireSession(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, OAUTH_APP_ID);
    if (is_object($session)) {
        $user = $session->getSessionedUser();
        $profile = $user->getProfile();
        $name = $profile->nickname; // Getting user name
        $guid = $profile->guid; // Getting Yahoo ID
		//$email 		= $user_profile['email'];
		echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."\")</script>";
        $user 	  = new User();
       	$userdata = $user->checkUser($uid, 'yahoo', $username,$email,'','');
		
		if(count($userdata)>0){
           $_SESSION['user']['login'] 	= 	true;
		   $_SESSION['user']['name'] 	= 	$userdata[0]['fullname'];
		   $_SESSION['user']['id'] 		= 	$userdata[0]['usersid'];
           //$_SESSION['user']['email'] 	= 	$email;
		   $_SESSION['user']['oauth_id'] 		= $uid;
		   $_SESSION['user']['oauth_provider'] 	= 'yahoo';
			
			saveIPuser($userdata[0]['usersid']);
			
		   echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."\")</script>";
        }       
    }
}

if (array_key_exists("logout", $_GET)) {
    // User logging out and Clearing all Session data
    YahooSession::clearSession();
    unset($_SESSION['login']);
    unset($_SESSION['name']);
    unset($_SESSION['guid']);
    unset($_SESSION['oauth_provider']);
    // After logout Redirection here
    echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."\")</script>";
}
?>
