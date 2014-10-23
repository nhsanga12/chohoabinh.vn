<?php

require '../../session.php';
require 'facebook/facebook.php';
require 'config/fbconfig.php';
require 'config/functions.php';

$facebook = new Facebook(array(
            'appId' => APP_ID,
            'secret' => APP_SECRET,
            ));

$user = $facebook->getUser();

if($user) {

  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }






    if (!empty($user_profile)) {
        # User info ok? Let's print it (Here we will be adding the login and registering routines)
  
        $username = $user_profile['name'];
		$uid 	  = $user_profile['id'];
		$email 	  = $user_profile['email'];
        $user 	  = new User();
       	$userdata = $user->checkUser($uid, 'facebook', $username,$email,$twitter_otoken,$twitter_otoken_secret);
		
        if(count($userdata)>0){
           $_SESSION['user']['login'] 	= 	true;
		   $_SESSION['user']['name'] 	= 	$userdata[0]['fullname'];
		   $_SESSION['user']['id'] 		= 	$userdata[0]['usersid'];
           $_SESSION['user']['email'] 	= 	$email;
		   $_SESSION['user']['oauth_id'] 		= $uid;
		   $_SESSION['user']['oauth_provider'] 	= $userdata[0]['oauth_provider'];
		   
			saveIPuser($userdata[0]['usersid']);
			
		   echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."\")</script>";
            //header("Location: home.php");// login thanh cong
        }
    } else {
        # For testing purposes, if there was an error, let's kill the script
        die("There was an error.");
    }
} else {
    # There's no active session, let's generate one
	$login_url = $facebook->getLoginUrl(array( 'scope' => 'email'));
    //header("Location: " . $login_url);
	 //echo "<script language=\"javascript\">window.location.replace(\"https://www.facebook.com/login.php?login_attempt=1\")</ script>";
	 echo "<script language=\"javascript\">window.location.replace(\"".$login_url."\")</script>";
}
?>
