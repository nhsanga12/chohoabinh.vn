<?php
	global $id,$config,$pages;
	$bannerchinh = news_by_cat(15,1,9);
	$bannerright = news_by_cat(41,1,1);
	
	$catlist = explode(",",$config['grouphome']);
	$bannerlist = explode(",",$config['groupbanner']);
?>

<div class="rows">
	<div class="lefts">
	
		<div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
				<? for($i=0;$i<count($bannerchinh);$i++){?>
					<? if($bannerchinh[$i]['picture']){?>
						<a href="<?=$bannerchinh[$i]['quick'];?>">
							<img src="<?=$config['url'];?>lib/articles/<?=$bannerchinh[$i]['picture'];?>" alt="<?=$bannerchinh[0]['title'];?>" data-thumb="<?=$config['url'];?>lib/articles/<?=$bannerchinh[$i]['picture'];?>" border="0" />
						</a>
					<? }?>
				<? }?>
			</div>
		</div>
		<script type="text/javascript" src="<?=$config['url'];?>Extension/nivoslider/jquery.nivo.slider.js"></script>
		<script type="text/javascript">
			$(window).load(function() {
				$('#slider').nivoSlider();
			});
		</script>
		
		<?
			$bgtit .= 'width:1000px;';
			$sanphamhot = getvipro('VIP','1',8);
			/*echo "<pre>";
			print_r($sanphamhot);
			echo "</pre>";*/
		?>
		<div class="box_hot">
			<h2>Sản phẩm nổi bật</h2>
			<div class="box_hot_cont" style=" border:1px solid #0aaaee">
				<table cellpadding="3" cellspacing="0" width="100%">
					<? for($h=0;$h<2;$h++){?>
					<tr>
						<? for($i=1;$i<5;$i++){ $n = $h*4+$i; ?>
							<td class="tdsanphamhot" width="25%" align="center" valign="top">
								<? if($sanphamhot[$n]['picture']){?>
									<a href="<?=sys_link('com=home&target=main&category='.$sanphamhot[$n]['category'].'&detail='.$sanphamhot[$n]['articles']);?>">
									<img src="<?=$config['url'];?>lib/articles/thums_<?=$sanphamhot[$n]['picture'];?>" alt="<?=$bannerright[0]['title'];?>" class="homepro" border="0" /></a><br />
								
									<a href="<?=sys_link('com=home&target=main&category='.$sanphamhot[$n]['category'].'&detail='.$sanphamhot[$n]['articles']);?>" class="tieude">
										<?  //if($sanphamhot[$n]['status']==3) 
												//echo sys_cut($sanphamhot[$n]['title'],19);
											//else 
												echo str_replace(".","",sys_cut($sanphamhot[$n]['title'],21));
										?>
										
									</a><br />
									<span class="gia" style="color:#<?=$mausac;?>">
										<? $giatien =formatMoney($sanphamhot[$n]['gia'],0);
											if($sanphamhot[$n]['loaitien']=='USD')
												echo str_replace(".",",",$giatien);
											else
												echo $giatien;
										?>
										<? if($sanphamhot[$n]['loaitien']=='USD') echo '$'; else echo 'đ';?>
									</span><br />
									<span><a href="<?=sys_link('com=home&target=main&category=50&detail='.$sanphamhot[$n]['articles'].'&ok='.$shop[0]['id']);?>" style="font-size:11px;"><?=$shop[0]['fullname'];?></a></span><br />
								
								<? }else{?>
									<a href="<?=sys_link('com=home&target=main&category=71&detail=0&cate=20&ok=95'.$n);?>" target="_blank">
                                    	<img src="<?=$config['url'];?>themes/default/images/ads_banner.jpg" alt="sanphamhot" class="homepro" border="0" />
                                    </a>
									<a href="<?=sys_link('com=home&target=main&category=71&detail=0&cate=20&ok=95'.$n);?>" class="tieude" target="_blank">Sản phẩm Vip</a><br />
									<span class="gia" style="color:#<?=$mausac;?>">
									</span><br />
									<span>&nbsp;</span><br />
								<? }?>
									
				
							</td>
						<? }?>
					</tr>
					<? }?>
				</table>
			</div>
		</div>
		
		
		<? for($p=0;$p<count($catlist);$p++){
			$title = categories_detail($catlist[$p]);
			$mausac = $title[0]['textcolor'];
			if($title[0]['picture'])
				$bgtit = "background:url(".$config['url']."lib/banner/".$title[0]['picture'].") repeat-x; color:#fff;";
			else
				$bgtit = '';
			$tem = $config['limit_news'];	
			
			$config['limit_news'] = 4;
			$sanpham = normal_cat($catlist[$p]);
			$config['limit_news'] = $tem;
			
			$dong = round(count($sanpham)/4);
			if(count($sanpham)%4>0) 
				$dong++;
			
			if($bannerlist[$p])	
			$banner_left = news_by_cat($bannerlist[$p],1,5);
		?>
		
			<div class="box_hot">
				<a href="<?=sys_link('com=home&target=main&category='.$title[0]['id'])?>">
					<span class="box_hot_tit" style=" <?=$bgtit;?>">
						<?=$title[0]['title'];?>
					</span>
				</a>
				<div class="box_hot_cont" style=" border:1px solid #<?=$mausac;?>">
					<table cellpadding="3" cellspacing="0" width="100%">
						<? for($h=0;$h<$dong;$h++){?>
						<tr>
							<? for($i=0;$i<4;$i++){ $n = $h*4+$i; $shop = member_dt($sanpham[$n]['thuonghieu']); ?>
								<td class="tdsanpham<? if($sanpham[$n]['status']==3) echo'hot';?>" width="25%" align="center" valign="top">
									<? if($sanpham[$n]['picture']){?>
										<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>"><img src="<?=$config['url'];?>lib/articles/thums_<?=$sanpham[$n]['picture'];?>" alt="<?=$bannerright[0]['title'];?>" class="homepro" border="0" /></a><br />
										
										<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>" class="tieude">
											<?=$sanpham[$n]['title'];?>
											
										</a><br />
										<span class="gia" style="color:#<?=$mausac;?>">
											<? $giatien =formatMoney($sanpham[$n]['gia'],0);
												if($sanpham[$n]['loaitien']=='USD')
													echo str_replace(".",",",$giatien);
												else
													echo $giatien;
											?>
											<? if($sanphamhot[$n]['loaitien']=='USD') echo '$'; else echo 'đ';?>
										</span><br />
										<span><a href="<?=sys_link('com=home&target=main&category=50&detail='.$sanpham[$n]['id'].'&ok='.$shop[0]['id']);?>" style="font-size:11px;"><?=$shop[0]['fullname'];?></a></span><br />
									<? }?>
								</td>
							<? }?>
						</tr>
						<? }?>
					</table>
				</div>
			</div>
			<div class="groupbanner" <? if(count($banner_left)==0){?> style=" height:1px;"<? }?>>
				<? if(count($banner_left)==0) echo '&nbsp;';?>
				<? for($i=0;$i<count($banner_left);$i++){
					if($banner_left[$i]['picture']){?>
						<a href="<?=$banner_left[$i]['contents'];?>">
							<img src="<?=$config['url'];?>lib/articles/<?=$banner_left[$i]['picture'];?>" alt="<?=$banner_left[$i]['title'];?>" border="0" />
						</a>
				<? } } ?>
			</div>
		<? }?>
	</div>
	
	<?=sys_option('home','main','right');?>
	
</div>