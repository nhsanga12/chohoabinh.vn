<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
global $id,$config; 
$seotit = $id['seotitle']; 
$pagetext = page_eny();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if($seotit['title']!='') echo $seotit['title']; else echo $config['keywords'];?> <?=$pagetext;?> </title>
<meta name="description" content="<?php if($seotit['description']!='') echo $seotit['description']; else echo $config['keywords'].$pagetext;?>" />
<meta name="keywords" content="<?=$config['keywords']?>" />
<meta name="author" content="Xalomuaban.com" />
<meta name="generator" content="Copyright 2011 by Xalomuaban.com. All rights reserved." />
<meta name="copyright" content="Develop by Xalomuaban.com" />

<meta name="robots" content="index,follow" />
<script language="javascript" type="text/javascript" src="<?=$config['url']?>js/jquery-1.7.2.min.js"></script>
<script language="javascript" type="text/javascript" src="<?=$config['url']?>js/js.js"></script>
<script language="javascript" type="text/javascript" src="<?=$config['url']?>js/jquery_menu.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>

<!--======Extension======-->

<!--Select box search-->
<script type="text/javascript" src="<?=$config['url']?>Extension/selectbox/jquery.selectbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$config['url']?>Extension/selectbox/selectbox.css" />

<script src="<?=$config['url']?>Extension/ticker/ticker.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?=$config['url']?>Extension/tickers/tickers.css" />
<script src="<?=$config['url']?>Extension/tickers/tickers.js" type="text/javascript"></script>
<script type="text/javascript">
	expandticker.init({
		id: 'expandticker1',
		snippetlength: 25,
		fx: 'slide',
		timers: {rotatepause:3000, fxduration:500} //--No comma following last option!
	})
</script>

<!--Slide banner home-->
<link rel="stylesheet" href="<?=$config['url']?>Extension/nivoslider/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=$config['url']?>Extension/nivoslider/nivo-slider.css" type="text/css" media="screen" />
<script language="javascript" type="text/javascript" src="<?=$config['url']?>js/scrolltopcontrol.js"></script>

<!--===END Extension====-->



<link rel="shortcut icon" href="<?=$config['url']?>favicon.ico" type="image/x-icon" />

<style type="text/css">
<!--
@import url("<?=$config['url']?>themes/<?=themes?>/css/styles.css");
@import url("<?=$config['url']?>themes/<?=themes?>/css/sitedetail.css");
@import url("<?=$config['url']?>themes/<?=themes?>/css/menu.css");
-->
</style>
</head>

<?
	$bg = news_by_cat(27,1,1);
?>
<body style=" <?php if($bg[0]['picture']){?> background:url(<?=$config['url']?>lib/articles/<?=$bg[0]['picture'];?>) <?=$bg[0]['contents'];?><?php }?>" itemscope itemtype="http://schema.org/Product">