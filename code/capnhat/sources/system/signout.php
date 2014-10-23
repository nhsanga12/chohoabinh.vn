<?php
	@session_destroy();
	$_SESSION['auth']['login']		= false;
	//@header("location:?lbm=com:system;target:signin");
	echo "<script language=\"javascript\">window.location.replace(\"?gnc=com:system;target:signin\")</script>";
?>