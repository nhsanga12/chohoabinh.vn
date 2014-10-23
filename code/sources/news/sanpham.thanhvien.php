<?php
	global $id,$config,$pages,$languages;
	
	if($id['cate']!=''){
		$users = member_dt($id['cate']);
		$sanpham = pro_of_mem_full($id['cate']);
		$danhmuc = categories_detail($id['category']);
	}
			
?>