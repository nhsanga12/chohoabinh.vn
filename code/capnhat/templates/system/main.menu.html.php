<script src="Extension/mouseovertabs/mouseovertabs.js" type="text/javascript"></script>

<div id="mytabsmenu" class="tabsmenuclass">
	<ul>
		<?php
			while (list($key,$value) = each($title)) {
				if(count($menu[$key]>0))
					$submenu_class = 'gotsubmenu';
				else
					$submenu_class = '';
		?>
			
				<li><a style="cursor:pointer" rel="<?=$submenu_class;?><? if($key== $id['com']) echo '[selected]';?>"><?=$value;?></a></li>
		<? }?>
		
	</ul>
</div>

<div id="mysubmenuarea" class="tabsmenucontentclass">
	<a href="Extension/mouseovertabs/submenucontents.php" style="visibility:hidden">Sub Menu contents</a>
</div>

<script type="text/javascript">
	//mouseovertabsmenu.init("tabs_container_id", "submenu_container_id", "bool_hidecontentsmouseout")
	mouseovertabsmenu.init("mytabsmenu", "mysubmenuarea", false);
</script>