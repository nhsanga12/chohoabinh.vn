<?php
require 'dbconfig.php';

class User {

    function checkUser($uid, $oauth_provider, $username,$email,$twitter_otoken,$twitter_otoken_secret) 
	{	global $config;
        $query = " SELECT * FROM gnc_users WHERE oauth_uid = '".$uid."' AND oauth_provider = '".$oauth_provider."' ";
        $result = sql_list($query);
        if(count($result)>0) {
            # User is already present
			
        } else {
            #user not present. Insert a new Record
			$newdb['oauth_provider'] = $oauth_provider;
			$newdb['oauth_uid'] = $uid;
			
			if($oauth_provider=='facebook' || $oauth_provider=='google')
				$newdb['usersname'] = $email;
			else{
				$newdb['usersname'] = str_replace(" ","",strtolower($username));
				$newdb['usersname'] = sys_sign($newdb['usersname']);
			}
				
			$newdb['fullname'] 	= $username;
			$newdb['email'] = $email;
			$newdb['twitter_oauth_token'] = $twitter_otoken;
			$newdb['twitter_oauth_token_secret'] = $twitter_otoken_secret;
			
			$config['db_prefix'] = 'gnc';
			sql_add('users',$newdb);
			
            $query = " SELECT * FROM gnc_users WHERE oauth_uid = '".$uid."' AND oauth_provider = '".$oauth_provider."' ";
			$result = sql_list($query);
            return $result;
        }
        return $result;
    }
	
}

?>
