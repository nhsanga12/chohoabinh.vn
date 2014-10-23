<?php 
	global $id,$config,$pages;
	require 'include/option.php';
	
	if($id['category']=='' || $id['category']=='1'){
		$banner_right = getvipro('H');
		$max = (int)$bannergroup['home']['max'];
		$keyb = '96';
	}else if($p_cat=='14' || $pare=='14' || $pare=='5'){
		$banner_right = getvipro('N');
		$max = (int)$bannergroup['news']['max'];
		$keyb = '98';
	}else{
		$banner_right = getvipro('D');
		$max = (int)$bannergroup['detail']['max'];
		$keyb = '97';
	}
	
/*	echo "<pre>";
	print_r($banner_right);
	echo "</pre>";
*/
?>

<div class="rights">
	<div class="right_banner">
		<? for($i=1;$i<=$max;$i++){
				if($banner_right[$i]['picture']==''){?>
					<div class="rightblock">
						<a href="<?=sys_link('com=home&target=main&category=71&detail=0&cate=21&ok='.$keyb.$i);?>" target="_blank">
							<img src="<?=$config['url'];?>themes/<?=themes;?>/images/ads_banner.jpg" alt="<?=$banner_right[$i]['title'];?>" border="0" style="border:1px solid #ddd;" />
						</a>
					</div>
					
				<? }else if($banner_right[$i]['types']==2){?>
					<div class="rightblock">
						<a href="<?=$banner_right[$i]['links'];?>" target="_blank">
							<img src="<?=$config['url'];?>lib/articles/<?=$banner_right[$i]['picture'];?>" alt="<?=$banner_right[$i]['title'];?>" border="0" class="imgr" />
						</a>
					</div>
				
				<? }else{?>
					<div class="rightblock">
						<div class="left_box_pro" style="height:200px; overflow:hidden;">
							<a href="<?=sys_link('com=home&target=main&category='.$banner_right[$i]['category'].'&detail='.$banner_right[$i]['id']);?>"><img src="<?=$config['url'];?>lib/articles/thums_<?=$banner_right[$i]['picture'];?>" alt="<?=$banner_right[$i]['title'];?>" class="listpro_img" border="0" style="margin:5px 0px;" /></a>
							<a href="<?=sys_link('com=home&target=main&category='.$banner_right[$i]['category'].'&detail='.$banner_right[$i]['id']);?>"><h3 style="font-size:11px;"><?=str_replace(".","",sys_cut($banner_right[$i]['title'],40));?></h3></a>
							Giá:
							<span class="pro_gia2">
								<? $giatien =formatMoney($banner_right[$i]['gia'],0);
								if($banner_right[$i]['loaitien']=='USD')
									echo str_replace(".",",",$giatien);
								else
									echo $giatien;?>
							</span>
							<? if($banner_right[$i]['loaitien']=='USD') echo '$'; else echo 'đ';?>
						</div>
					</div>
				<? }?>
				
		<? } ?>
		
	</div>
</div>
<div class="clear"></div>