<?php
	include('../../capnhat/config.php');
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql) or die('Please set capnhat/config.php to connect a database !');
	mysql_query('SET CHARACTER SET utf8');
	require '../../capnhat/mysql/global-mysql.php';
	require '../../session.php'; 
	global $id, $config, $pages;
	# Thư viện các Hàm
	require '../../capnhat/functions/global-functions.php';
	require '../../capnhat/functions/auto-load.php';
	require '../../capnhat/functions/categories-functions.php';
	require '../../capnhat/functions/articles-functions.php';
	require '../../capnhat/functions/cal-functions.php';
	require '../../capnhat/functions/xml-functions.php';
	require '../../capnhat/functions/html-functions.php';
	require '../../capnhat/functions/image-functions.php';
	require '../../capnhat/functions/seo-functions.php';
	
	require '../../capnhat/functions/group-functions.php';
	require '../../capnhat/functions/member-functions.php';
	
	# Nội dung chính
	
	
	if($_POST['cat']!=''){
		$config['limit_news'] = 4;
		$id['page'] = (int)$_POST['trang']+1;
		if($_POST['hot']=='')
			$sanpham = getnews($_POST['cat']);
		else
			$sanpham = newnews($_POST['cat']);
		
		for($n=0;$n<count($sanpham);$n++){
?>
		<tr>
            <td width="160" valign="top">
                <div class="imgnews">
                <a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'].'&page='.$id['page']);?>">
                    <? if($sanpham[$n]['picture']=='' || $sanpham[$n]['picture']== 'icon_view.png' || $sanpham[$n]['picture']=='icon_dongsukien_red.png' || $sanpham[$n]['picture']=='pix_news.jpg'){?>
                        <img src="<?=$config['url'];?>themes/default/images/News-Icon24.jpg" alt="Xa lộ tin tức" class="news_img" border="0" />
                    
                    <? }else{?>
                        <img src="<?=$config['url'];?>lib/articles/<?=$sanpham[$n]['picture'];?>" alt="<?=$sanpham[$n]['title'];?>" class="news_img" border="0" />
                    <? }?>
                </a>
                </div>
            </td>
            <td width="480" valign="top">
                <div class="noidungtomtat" style="border:none;">
                    <a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'].'&page='.$id['page']);?>">
                    	<h2 style="margin-bottom:3px;"><?=$sanpham[$n]['title'];?></h2>
                    </a>
                    <p class="newsupdate">
                        <font style="color:#993300;">
                            <?=date("H:i",$sanpham[$n]['lastdate']);?>
                        </font> | 
                        <?=date("d/m/Y",$sanpham[$n]['lastdate']);?>
                         &nbsp;&nbsp; <?=$sanpham[$n]['local'];?>
                    </p>
                    <p class="sumnews">
                        <?=sys_cut(html2text($sanpham[$n]['quick'].$sanpham[$n]['contents']),450);?>
                    </p>
                </div>
            </td>
            <td valign="top" align="center">
                
                <?php
                    if($sanpham[$n]['likes']=='' || $sanpham[$n]['likes']=='0')
                        $lk = 1;
                    else
                        $lk = (int)$sanpham[$n]['likes'];
                ?>
        
                <div class="likebt" onclick=" update_likes('<?=$sanpham[$n]['id'];?>','<?=$lk+1;?>');" style="cursor:pointer;">
                    <div class="amount_like" style="margin-left:65px;">
                        <table cellpadding="0" cellspacing="0" style="border:none;">
                            <tr>
                                <td style="border:none;"><div class="amount_like_left"></div></td>
                                <td style="border:none;"><div class="amount_like_center" id="amount_like_<?=$sanpham[$n]['id'];?>"><?=$lk;?></div></td>
                                <td style="border:none;"><div class="amount_like_right"></div></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br />
                Lượt xem: <?=$sanpham[$n]['opt'];?><br /><br />
                <div class="sharebt sharelink" rel="<?=$n;?>" style="cursor:pointer;">&nbsp;</div>
            </td>
        </tr>
<?
		}
		
	}
	
	# Và xử lý menu
	@mysql_close($mysql);

?>
