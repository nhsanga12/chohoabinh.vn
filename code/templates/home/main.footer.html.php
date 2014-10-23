<div class="footer">
	<div class="navfooter">
		<div class="main">
			<table cellpadding="3" cellspacing="0" width="100%">
				<tr>
					<? for($i=0;$i<count($menu);$i++){ 
						$sub = categories_by_cat_group(1,$menu[$i]['id']);
						if(count($sub)==0)
							$linkfoot = news_by_cat($menu[$i]['id'],1,10);
					?>
						<td width="25%" valign="top"><br />
							<a class="footlink">
								<?=$menu[$i]['title'];?>
							</a>
							<div class="sublinkfoot">
								<? if(count($sub)>0){?>
										<? for($s=0;$s<count($sub);$s++){ ?>
											<a href="<?=sys_link('com=home&target=main&category='.$sub[$s]['id']);?>" class="sublink">
												<?=$sub[$s]['title'];?>
											</a><br />
										<? }?>
								
								<? }else if(count($linkfoot)>1 && $menu[$i]['id']!='30'){?>
										<? for($s=0;$s<count($linkfoot);$s++){ ?>
											<a href="<?=sys_link('com=home&target=main&category='.$linkfoot[$s]['category'].'&detail='.$linkfoot[$s]['id']);?>" class="sublink">
												<?=$linkfoot[$s]['title'];?>
											</a><br />
										<? }?>
								
								<? }else if(count($linkfoot)>1){?>
										<? for($s=0;$s<count($linkfoot);$s++){ ?>
											<a href="<?=$linkfoot[$s]['contents'];?>" class="sublink" target="_blank">
												<img src="<?=$config['url'];?>lib/articles/<?=$linkfoot[$s]['picture'];?>" alt="<?=sys_sign($linkfoot[$s]['title']);?>" style="border:none;" />
											</a>
											<? if($s==2) echo '<br />';?>
										<? }?>
										
								<? }else if(count($linkfoot)==1){?>
										<?=$linkfoot[0]['contents'];?>
										
								<? }else echo '';?>
								
							</div>
						</td>
					<? }?>
				</tr>
			</table>
		</div>
	</div>
	<div class="copyright">
		<div class="main" style="line-height:20px;"><br />
			<?=$copyright[0]['contents'];?>
		</div>
	</div>
</div>