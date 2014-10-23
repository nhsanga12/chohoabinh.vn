<?php global $id,$config;
	$n=0;
	$amount = array();
	if($_SESSION['cart']['sum']>0){
		foreach($_SESSION['cartitem'] as $key => $value){
			if($key!='' && $key!=' '){
				if($n!=0) $dau = ","; else $dau = "";
				$strid .= $dau.$key;
				$amount[$key] =  $value;
				$n++;
			}
		}
	}
	
	$sanpham = listarticle($strid);
	
	$danhmuc = categories_detail($id['category']);	
	require 'include/option.php';
	
	if($_SESSION['user']['login'])
		$memberdt =  member_dt($_SESSION['user']['id']);
	else
		$memberdt = array();
	
	$hoadon = 'HĐTM-'.$_SESSION['user']['id'].date('ymdHi');
?>