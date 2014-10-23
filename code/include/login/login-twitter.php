<?php
require("twitter/twitteroauth.php");
require 'config/twconfig.php';
require '../../session.php';

$twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET);
// Requesting authentication tokens, the parameter is the URL we will be redirected to
$request_token = $twitteroauth->getRequestToken('http://xalomuaban.com/include/login/getTwitterData.php');

// Saving them into the session

$_SESSION['user']['oauth_token'] = $request_token['oauth_token'];
$_SESSION['user']['oauth_token_secret'] = $request_token['oauth_token_secret'];

// If everything goes well..
if ($twitteroauth->http_code == 200) {
    // Let's generate the URL and redirect
    $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
    //header('Location: ' . $url);
	echo "<script language=\"javascript\">window.location.replace(\"".$url."\")</script>";
} else {
    // It's a bad idea to kill the script, but we've got to know when there's an error.
    die('Something wrong happened.');
}
?>
