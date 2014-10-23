<?php global $id,$config;

			$_SESSION['user']['login']		= false;
			$_SESSION['user']['name']		= false;
			$_SESSION['user']['id']			= false;
			
			$_SESSION['user']['oauth_id'] 		= 	false;
			$_SESSION['user']['oauth_provider'] = 	false;
			$_SESSION['user']['email'] 			= 	false;
			$_SESSION['user']['oauth_token'] 	= 	false;
			$_SESSION['user']['oauth_token_secret'] = 	false;
	
			unset($_SESSION['user']['oauth_id']);
    		unset($_SESSION['user']['oauth_provider']);
			unset($_SESSION['user']['oauth_token']);
    		unset($_SESSION['user']['oauth_token_secret']);
    		unset($_SESSION['user']['id']);
			unset($_SESSION['user']);
			
			unset($_SESSION['id']);
   			unset($_SESSION['username']);
    		unset($_SESSION['oauth_provider']);
			session_destroy();
			echo "<script language=\"javascript\"> goBack('1');</script>";
?>