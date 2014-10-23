<?php

require("twitter/twitteroauth.php");
require 'config/twconfig.php';
require 'config/functions.php';
require '../../session.php';

if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['user']['oauth_token']) && !empty($_SESSION['user']['oauth_token_secret'])) {
    // We've got everything we need
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['user']['oauth_token'], $_SESSION['user']['oauth_token_secret']);
// Let's request the access token
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
// Save it in a session var
    $_SESSION['user']['access_token'] = $access_token;
// Let's get the user's info
    $user_info = $twitteroauth->get('account/verify_credentials');
// Print user's info
   /* echo '<pre>';
    print_r($user_info);
    echo '</pre><br/>';*/
	
    if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        //header('Location: login-twitter.php');
		echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."/include/login/login-twitter.php\")</script>";
		
    } else {
	   $twitter_otoken	=$_SESSION['user']['oauth_token'];
	   $twitter_otoken_secret =$_SESSION['user']['oauth_token_secret'];
	   $email='';
        $uid = $user_info->id;
        $username = $user_info->name;
        $user = new User();
        $userdata = $user->checkUser($uid, 'twitter', $username,$email,$twitter_otoken,$twitter_otoken_secret);
        if(!empty($userdata)){
			$_SESSION['user']['login'] 	= 	true;
            $_SESSION['user']['id'] 	= 	$userdata[0]['usersid'];
            $_SESSION['user']['name'] 	= 	$userdata[0]['fullname'];
			$_SESSION['user']['email'] 	= 	$email;
			$_SESSION['user']['oauth_id'] = $uid;
            $_SESSION['user']['oauth_provider'] = $userdata[0]['oauth_provider'];
			saveIPuser($userdata[0]['usersid']);
			
            //header("Location: home.php");
			echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."\")</script>";
        }
    }
} else {
    // Something's missing, go back to square 1
   echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."/include/login/login-twitter.php\")</script>";
}
?>
