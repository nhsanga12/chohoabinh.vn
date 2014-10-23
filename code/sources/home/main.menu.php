<?php
	global $id,$config;
	$p_cat	=	get_parentid_category($id['category']);
	$pare	=	get_parentid_category($p_cat);
	
	if($id['category']=='14' || $p_cat=='14' || $pare=='14'){
		$menu = listmenu_order($config['news_menu']);
		$font = 12;
		$padleft = '9';
	}else{
		$menu = listmenu_order($config['fmenu']);
		$font = $config['menufont'];
		$padleft = $config['menupadding'];
	}
		
?>