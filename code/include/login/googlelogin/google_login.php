<?php
require '../../../capnhat/config.php';
$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
$mysql = mysql_select_db($config['db_name'],$mysql) or die('Please set capnhat/config.php to connect a database !');
mysql_query('SET CHARACTER SET utf8');
require '../../../capnhat/mysql/global-mysql.php';
require '../../../capnhat/functions/global-functions.php';
require '../../../capnhat/functions/member-functions.php';

require_once 'src/apiClient.php';
require_once 'src/contrib/apiOauth2Service.php';


session_start();

$client = new apiClient();
$client->setApplicationName("Google Account Login");
$oauth2 = new apiOauth2Service($client);

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  $nlink = filter_var($redirect, FILTER_SANITIZE_URL);
  echo "<script language=\"javascript\">window.location.replace(\"".$nlink."\")</script>";
}

if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['logout'])) { //thoat
  unset($_SESSION['token']);
  unset($_SESSION['google_data']);
  $client->revokeToken();
  echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."\")</script>";
}

if ($client->getAccessToken()) { // dang nhap thanh cong
  $user = $oauth2->userinfo->get();
   
   $sqlc = "SELECT * FROM gnc_users WHERE google_id = '".$user['id']."' AND oauth_provider = 'google' ";
   $result = sql_list($sqlc);
	if(count($result)==0) {
		global $config;
		$newdb['oauth_provider'] = 'google';
		$newdb['oauth_uid'] = $user['id'];
		$newdb['google_id'] = $user['id'];
		$newdb['usersname'] = $user['email'];
		$newdb['fullname'] 	= $user['name'];
		$newdb['email'] = $user['email'];
		$newdb['firstname'] 	= $user['given_name'];
		$newdb['lastname'] 		= $user['family_name'];
		$newdb['gpluslink'] 	= $user['link'];
		$newdb['profile_image'] = $user['picture'];
		$newdb['gender'] 		= $user['gender'];
		$newdb['dob'] 			= $user['birthday'];
		
		$config['db_prefix'] = 'gnc';
		sql_add('users',$newdb);
		$result = sql_list($sqlc);
	}
  	$userdata = $result;
  	$_SESSION['user']['login'] 	= 	true;
	$_SESSION['user']['id'] 	= 	$userdata[0]['usersid'];
	$_SESSION['user']['name'] 	= 	$userdata[0]['fullname'];
	$_SESSION['user']['email'] 	= 	$email;
	$_SESSION['user']['oauth_id'] = $uid;
	$_SESSION['user']['oauth_provider'] = $userdata[0]['oauth_provider'];
	saveIPuser($userdata[0]['usersid']);
	
  echo "<script language=\"javascript\">window.location.replace(\"http://".$_SERVER['HTTP_HOST']."\")</script>";
  
  
} else {
  $authUrl = $client->createAuthUrl();
}
?>

<?php if(isset($personMarkup)):
		print $personMarkup; 
	  endif 
?>

<?php
  if(isset($authUrl)) {
	echo "<script language=\"javascript\">window.location.replace(\"".$authUrl."\")</script>";
  } else {
   	echo "<script language=\"javascript\">window.location.replace(\"http://xalomuaban.com/include/login/googlelogin/google_login.php?logout\")</script>";
  }
?>
