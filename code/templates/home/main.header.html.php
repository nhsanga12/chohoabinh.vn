<?php
	global $id,$config,$languages;
	$menu = listmenu($config['fmenu']);
	$p_cat	= get_parentid_category($id['category']);
	$pare	= get_parentid_category($p_cat);
	
	$tieude = categories_detail($id['category']);
	$capcha = categories_detail($p_cat);
	
	$logo = news_by_cat(28,1,1);	
?>


<div class="header">
	<div class="logosearch">
		<div class="headerleft">
        	<a href="<?=$config['url'];?>">
				<img src="<?=$config['url'];?>lib/articles/<?=$logo[0]['picture'];?>" alt="<?=$logo[0]['title'];?>" style="border:none;" border="0" />
            </a>
		</div>
        
        <div class="headerright">
            <div class="headerright_center">
                <div class="searchtop">
                    <form action="<?=sys_link('com=home&target=main&category=2');?>" enctype="multipart/form-data" method="post">
                        <input name="keysearch" type="text" class="searchip" value="<? if(isset($_POST['keysearch'])) echo $_POST['keysearch']; else echo $languages['searchip'];?>" onclick=" if(this.value=='<?=$languages['searchip'];?>') this.value= ''; " onblur="if(this.value=='') this.value= '<?=$languages['searchip'];?>';" />
                        <input type="submit" class="searchbt" value=" " />
                    </form>
                </div>
            </div>
            <div class="headerright_right">
                <table cellpadding="3" cellspacing="0">
                    <tr>
                        <td colspan="4" align="left" style=" line-height:32px; color:#fff;">Hỗ trợ trực tuyến</td>
                    </tr>
                    <tr>
                        <td width="21" align="left"><img id="yahoo_1" src="<?=$config['url'];?>themes/<?=themes;?>/images/<?=checknick($nick[0]['contents'],'yahoo');?>" /></td>
                        <td width="80" align="left"><a class="ylink" href="ymsgr:sendIM?<?=$nick[0]['contents'];?>"><?=$nick[0]['title'];?></a></td>
                        <td width="21" align="left"><img id="yahoo_2" src="<?=$config['url'];?>themes/<?=themes;?>/images/<?=checknick($nick[1]['contents'],'yahoo');?>" /></td>
                        <td align="left"><a class="ylink" href="ymsgr:sendIM?<?=$nick[1]['contents'];?>"><?=$nick[1]['title'];?></a></td>
                    </tr>
                    <tr>
                        <td width="21" align="left"><img id="skype_1" src="<?=$config['url'];?>themes/<?=themes;?>/images/<?=checknick($nick[2]['contents'],'skype');?>" /></td>
                        <td align="left"><a class="ylink" href="skype:<?=$nick[2]['contents'];?>?chat"><?=$nick[2]['title'];?></a></td>
                        <td width="21" align="left"><img id="skype_2" src="<?=$config['url'];?>themes/<?=themes;?>/images/<?=checknick($nick[3]['contents'],'skype');?>" /></td>
                        <td align="left"><a class="ylink" href="skype:<?=$nick[3]['contents'];?>?chat"><?=$nick[3]['title'];?></a></td>
                    </tr>
                </table>
            </div>
            <div class="headerright_bot">
            	<? if($_SESSION['user']['login'] == true){?>
                    Chào bạn, <a href="<?=sys_link('com=home&target=main&category=62');?>" style="font-weight:bold;"><?=$_SESSION['user']['name'];?></a>
                    (<?=count_msg($_SESSION['user']['id']);?>)
                    &nbsp;&nbsp;
                    <a href="<?=sys_link('com=home&target=main&category=70');?>">Đăng tin</a> | 
                    <a href="<?=sys_link('com=home&target=main&category=38');?>">Thoát</a>
                <? }else{?>
                <div style="color:#f0f0f0;">
                    <a class="ylink dangnhaplk" href="<?=sys_link('com=home&target=main&category=39');?>">Đăng ký</a>&nbsp; | &nbsp; 
                    <a class="ylink dangnhaplk" href="<?=sys_link('com=home&target=main&category=40');?>">Đăng tin</a>&nbsp;&nbsp;
                    <input type="button" class="dangnhapbt" value=" Đăng nhập " onclick="newLocation('<?=sys_link('com=home&target=main&category=37');?>');" />
                </div>
                <? }?>
            </div>
         </div>
         
	</div>
	
	
	<? if($id['category']=='14' || $p_cat=='14' || $pare=='15' ) echo ''; else{ $tintucmoi = news_by_cat(18); ?>
		<div class="ticktop">
        	
            <div class="tickernew" style="width:838px; height:35px; overflow:hidden;">
            	<div id="expandticker1" class="expandticker">
 					<? for($i=0;$i<count($tintucmoi);$i++){?>
                    <div class="expandcontent">
                		<a href="<?=sys_link('com=home&target=main&category='.$tintucmoi[$i]['category'].'&detail='.$tintucmoi[$i]['id']);?>"><?=$tintucmoi[$i]['title'];?></a>
                    </div>
                     <? }?>
 				</div>
                <!--<div id="dropcontentsubject"></div>
				<? for($i=0;$i<count($tintucmoi);$i++){?>
                    <div id="dropmsg<?=$i;?>" class="dropcontent">
                        <a href="<?=sys_link('com=home&target=main&category='.$tintucmoi[$i]['category'].'&detail='.$tintucmoi[$i]['id']);?>"><?=$tintucmoi[$i]['title'];?></a>
                    </div>
                <? }?>-->
            </div>
            
			<a href="<?=sys_link('com=home&target=main&category=14');?>">
            	<div class="tickernew" style="width:155px; text-align:center; float:right;">XA LỘ TIN TỨC</div>
            </a>
            
		</div>
	<? }?>
	
	<div class="menutop">
		<? echo sys_option("home","main","menu");?>
	</div>
	
	
</div>

<? 
	$samid = 2;
	$idcat = cat_getpare_sam($samid,$id['category']);
	$sum = count($idcat);
	
	if($id['category']!='' && $id['category']!='1' && $sum>0){
		$danhmuccon = categories_by_cat_group(1,$idcat[$sum-1]);
?>
	<div class="pro_sublink">
		<div class="pro_sublink_list">
			<? for($m=0;$m<count($danhmuccon);$m++){ if($danhmuccon[$m]['id']==$id['category'] || $danhmuccon[$m]['id']==$idcat[$sum-2]) $clss = 'pro_mainsl'; else $clss ='pro_mainlink'; ?>
				<div style="height:30px; float:left;"><a href="<?=sys_link('com=home&target=main&category='.$danhmuccon[$m]['id']);?>" class="<?=$clss;?>">
					<?=$danhmuccon[$m]['title'];?>
				</a> |</div>
			<? }?>
		</div>
	</div>
	<? if($sum>1){
		$danhmuccon2 = categories_by_cat_group(1,$idcat[$sum-2]);
		if(count($danhmuccon2)>0){ ?>
			<div class="pro_subsub">
				<div class="pro_subsub_list">
					<? for($m=0;$m<count($danhmuccon2);$m++){
							if($danhmuccon2[$m]['id']==$id['category']) $clss = 'slink_sl'; else $clss ='slink';?>
						<div style="height:30px; float:left;"><a href="<?=sys_link('com=home&target=main&category='.$danhmuccon2[$m]['id']);?>" class="<?=$clss;?>">
							<?=$danhmuccon2[$m]['title'];?>
						</a>|</div>
					<? }?>
				</div>
			</div>
	<? } } ?>
	
<? }?>