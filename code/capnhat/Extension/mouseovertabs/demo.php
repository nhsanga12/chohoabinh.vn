<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>


</head>

<link rel="stylesheet" type="text/css" href="mouseovertabs.css" />
<script src="mouseovertabs.js" type="text/javascript"></script>
<body>
	<div id="mytabsmenu" class="tabsmenuclass">
		<ul>
			<li><a href="http://www.javascriptkit.com" rel="gotsubmenu[selected]">JavaScript Kit</a></li>
			<li><a href="http://www.cssdrive.com" rel="gotsubmenu">CSS Drive</a></li>
			<li><a href="http://www.codingforums.com">No Sub Menu</a></li>
		</ul>
	</div>
	
	<div id="mysubmenuarea" class="tabsmenucontentclass">
		<a href="submenucontents.htm" style="visibility:hidden">Sub Menu contents</a>
	</div>
	
	<script type="text/javascript">
		//mouseovertabsmenu.init("tabs_container_id", "submenu_container_id", "bool_hidecontentsmouseout")
		mouseovertabsmenu.init("mytabsmenu", "mysubmenuarea", true);
	</script>
</body>
</html>
