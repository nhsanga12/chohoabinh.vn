<?php
	global $id,$config,$pages,$languages;
	require 'include/option.php';
if(isset($_POST['tensanpham'])){
	if($_POST['loaisanpham3']!='')
		$cat = $_POST['loaisanpham3'];
	else if($_POST['loaisanpham2']!='')
		$cat = $_POST['loaisanpham2'];
	else if($_POST['loaisanpham1']!='')
		$cat = $_POST['loaisanpham1'];
	else
		$cat = '';
		
	if($_POST['tensanpham']=='' )
		$msg .= 'Tên sản phẩm không được trống. '; 
	else if($cat=='')
		$msg .= 'Vui lòng chọn danh mục sản phẩm. ';
	else if($_POST['giasp']=='')
		$msg .= 'Vui lòng nhập giá sản phẩm. ';
	else {
			$rs['category']	= 	$cat;
			$rs['status']	= 	'2';
			$rs['picture']	=	sys_uploads('lib/articles/','hinhsp','gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG');
			
			$rs['usersid']	=	$_SESSION['user']['id'];
			$rs['bydate']	=	time();
			$rs['lastdate']	=	time();
			$rs['groupid']	=	'1';
			$newid = sql_add('news_articles',$rs);
			
			$rsn['article']		=	$newid;
			$rsn['title']		=	$_POST['tensanpham'];
			$rsn['seotit']		=	$_POST['tensanpham'];
			$rsn['seodes']		=	sys_cut(html2text($_POST['contents']),500);
			$rsn['quick']		=	$_POST['quick'];
			$rsn['contents']	=	$_POST['contents'];
			$rsn['language']	=	'vn';
			$rsn['gia']			=	$_POST['giasp'];
			$rsn['giacu']		=	$_POST['giatruockhigiam'];
			$rsn['loaitien']	=	'VND';
			$rsn['local']		=	$_POST['noirao'];
			
			// sitemap general
				$newlink = CmsBreadcrumbLink('',$rs['category'],$rsn['article'],'',sys_sign($rsn['title'])."_".$newid.".html");
				$rsn['sitemappoint'] = AddSitemap('sitemap_detail.xml',$config['url'].$newlink,'weekly','0.8');
				
			// END sitemap general
					
			sql_add('news_articles_detail',$rsn);
			$ok = 10;
	}
}

?>