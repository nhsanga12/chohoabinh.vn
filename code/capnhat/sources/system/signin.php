<?php
	if (isset($_POST['submit'])) {
		$sql = "SELECT * FROM ".$config['db_prefix']."_admin WHERE username='".addslashes($_POST['username'])."' ";
		$authchk	= sql_detail($sql);
		if ($authchk[0]['username']	==	'') {
			$msg 	= 	$langtext['sys_login']['notuser'];
		} else if (md5(md5(md5($_POST['password']))) != $authchk[0]['password']) {
			$msg	=	$langtext['sys_login']['notpass'];
		} else {
			$_SESSION['auth']['login']		= true;
			$_SESSION['auth']['name']		= $authchk[0]['name'];
			$_SESSION['auth']['id']			= $authchk[0]['id'];
			$_SESSION['auth']['group']		= $authchk[0]['groupjobs'];
			@header("location:?gnc=com:system;target:home");
			echo "<script language=\"javascript\">window.location.replace(\"?gnc=com:system;target:home\")</script>";
		}
	}
?>