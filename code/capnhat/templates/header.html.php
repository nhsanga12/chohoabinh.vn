<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? global $id;?>
<title><?=$langtext['sys_basic']['title'];?> - <?=$langtext['sys_basic']['version'];?> - <?=$title[$id['com']].' - '.$menu[$id['com']][$id['target']]?></title>

<script language="javascript" type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jscripts.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery_menu.js"></script>
<script language="JavaScript" type="text/javascript" src="js/scrolltopcontrol.js"></script>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckeditor/lang/_languages.js"></script>

<link rel="stylesheet" href="Extension/DatePicker/jquery.datepick.css" type="text/css" />
<!--<script type="text/javascript" src="Extension/DatePicker/jquery.min.js"></script>-->
<script type="text/javascript" src="Extension/DatePicker/jquery.datepick.js"></script>


<link rel="stylesheet" href="Extension/ddsmoothmenu/ddsmoothmenu.css" type="text/css" />
<script type="text/javascript" src="Extension/ddsmoothmenu/ddsmoothmenu.js"></script>
<script type="text/javascript">
	ddsmoothmenu.init({
		mainmenuid: "smoothmenu1",
		orientation: 'h',
		classname: 'ddsmoothmenu',
		/*customtheme: ["#18484a", "#1c7c80"],*/
		contentsource: "markup"
	})
</script>


<script type="text/javascript" src="Extension/Jcrop/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="Extension/Jcrop/jquery.Jcrop.css" type="text/css" />

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

<link rel="stylesheet" type="text/css" href="Extension/mouseovertabs/mouseovertabs.css" />
<link rel="stylesheet" type="text/css" href="css/sitedetail.css" />
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link rel="stylesheet" type="text/css" href="css/styles_old.css" />
</head>
<body>