<div class="nav">
	<div class="menu">
		<ul>
			<? for($m=0;$m<count($menu);$m++){ $sub = categories_by_cat_group(1,$menu[$m]['id']);
			
			   if($m==count($menu)-1) $strbg = ' class="menuend" '; else $strbg ='';
			    
				if($menu[$m]['id']=='1' && ($id['category']=='14' || $p_cat=='14' || $pare=='14'))
			   		$tems = "&nbsp;";
				else if($menu[$m]['id']=='1')
					$tems = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				else
					$tems ='';
					
			   
			   $p_cat	=	get_parentid_category($id['category']);
			   $pare	=	get_parentid_category($p_cat);
			   
			   if($menu[$m]['id']==$id['category'] || $menu[$m]['id'] == $p_cat || $menu[$m]['id'] == $pare || ($menu[$m]['id']=='1' && $id['category']==''))
			   	$strbg = ' class="menuselect" ';
			?>
				<li><? if($menu[$m]['id']=='1'){?>
							<img src="<?=$config['url'];?>themes/<?=themes;?>/images/homeicon.png" alt="homelink" border="0" style=" cursor:pointer;" onclick="newLocation('<?=$config['url'];?>');" />
					<? }?>
					<a href="<?=sys_link('com=home&target=main&category='.$menu[$m]['id']);?>" rel="permalink" <?=$strbg;?> style="font-size:<?=$font;?>px; padding: 0 <?=$padleft;?>px;">
						
						<? 
							if($menu[$m]['id']=='1' && ($id['category']=='14' || $p_cat=='14' || $pare=='14'))
								echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							else 
								echo $tems.$menu[$m]['title'];
						?>
					</a>
					<? if(count($sub)>0){?>
						<ul>
							<li class="top"></li>
							<? for($e=0;$e<count($sub);$e++){ ?>
								<li>
									<a href="<?=sys_link('com=home&target=main&category='.$sub[$e]['id']);?>">
										&nbsp;&nbsp;&nbsp;&nbsp;<?=$sub[$e]['title'];?>
									</a>
								</li>
							<? }?>
							<li class="end"></li>
						</ul>
					<? }?>
				</li>
			<? }?>
		</ul>	
	</div>
</div>