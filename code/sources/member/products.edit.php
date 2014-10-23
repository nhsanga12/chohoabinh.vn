<?php
	global $id,$config,$pages,$languages;
	require 'include/option.php';
	$detail = articles_detail($id['detail']);
	
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
			$npic				=	sys_uploads('lib/articles/','hinhsp','gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG');
			if ($npic != '') {
				$rs['picture'] = $npic;
			}
			
			$rs['lastdate']	=	time();
			$rsi['id'] = $id['detail'];
			sql_update('news_articles',$rs,$rsi); 
			
			$rsk['article']		=	$id['detail'];
			$rsn['title']		=	$_POST['tensanpham'];
			$rsn['seotit']		=	$_POST['tensanpham'];
			$rsn['seodes']		=	sys_cut(html2text($_POST['contents']),500);
			$rsn['quick']		=	$_POST['quick'];
			$rsn['contents']	=	$_POST['contents'];
			$rsn['gia']			=	$_POST['giasp'];
			$rsn['giacu']		=	$_POST['giatruockhigiam'];
			$rsn['local']		=	$_POST['noirao'];
			
			// sitemap general
				$newlink = CmsBreadcrumbLink('',$rs['category'],$rsk['article'],'',sys_sign($rsn['title'])."_".$rsi['id'].".html");
				$rsn['sitemappoint'] = UpdateSitemap('sitemap_detail.xml',$config['url'].$newlink,'weekly','0.8',$detail[0]['sitemappoint']);
			// END sitemap general
					
			sql_update('news_articles_detail',$rsn,$rsk);
			$ok = 10;
	}
}

?>