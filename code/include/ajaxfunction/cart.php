<?php
	include('../../capnhat/config.php');
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql) or die('Please set capnhat/config.php to connect a database !');
	mysql_query('SET CHARACTER SET utf8');
	require '../../capnhat/mysql/global-mysql.php';
	require '../../session.php'; 
	
	# Thư viện các Hàm
	require '../../capnhat/functions/global-functions.php';
	require '../../capnhat/functions/auto-load.php';
	require '../../capnhat/functions/categories-functions.php';
	require '../../capnhat/functions/articles-functions.php';
	require '../../capnhat/functions/cal-functions.php';
	require '../../capnhat/functions/seo-functions.php';
	
	# Nội dung chính
	if($_POST['action']=='add'){
		$sum = $_SESSION['cart']['sum'];
		$slm = (int)$_POST['slm'];
		$ids = $_POST['ids'];
		$_SESSION['cartitem'][$ids] += $slm;
		$_SESSION['carthttt'][$ids] = $_POST['hinhthuc'];
		$_SESSION['cart']['sum'] += $slm;
		
		echo $_SESSION['cart']['sum'];
	
	}else if($_POST['action']=='cancel'){
		$_SESSION['cart']['sum']= 0;
		unset($_SESSION['cartitem']);
		unset($_SESSION['carthttt']);
		echo 'done';
	
	}else if($_POST['action']=='remove'){
		$ids = $_POST['ids'];
		$slm = $_SESSION['cartitem'][$ids];
		$_SESSION['cart']['sum'] -= $slm;
		unset($_SESSION['cartitem'][$ids]);
		unset($_SESSION['carthttt'][$ids]);
		$dt = art_deta($ids);
		echo $dt[0]['title'];
		
	}else if($_POST['action']=='save' && $_SESSION['cart']['sum']>0){
		$n=0;
		$amount = array();
		foreach($_SESSION['cartitem'] as $key => $value){
			if($key!='' && $key!=' '){
				if($n!=0) $dau = ","; else $dau = "";
				$strid .= $dau.$key;
				$amount[$key] =  $value; // lay so uong
				$n++;
			}
		}
		
		$sanpham = listarticle($strid);
	
		$row['hoadon'] 		=  $_POST['hoadon'];
		$row['userbuy'] 	=  $_SESSION['user']['id'];
		$row['fullname'] 	=  $_POST['fullname'];
		$row['email'] 		=  $_POST['email'];
		$row['address'] 	=  $_POST['address'];
		$row['phone'] 		=  $_POST['phone'];
		$row['description'] =  $_POST['description'];
		$row['hinhthuctt']  =  $_POST['hinhthuctt'];
		$row['bydate'] 		=  time();
		$row['lastdate'] 	=  time();
		
		for($n=0;$n<count($sanpham);$n++){
			$row['usersid'] =  $sanpham[$n]['usersid'];
			$row['article'] =  $sanpham[$n]['id'];
			$row['amount'] 	=  $amount[$sanpham[$n]['id']];
			$row['gia'] 	=  $sanpham[$n]['gia'];
			sql_add('users_buysell',$row);
		}
		$_SESSION['cart']['sum']= 0;
		unset($_SESSION['cartitem']);
		echo 'Đã đặt hàng thành công.';
	
	}else if($_POST['action']=='update'){
		$ids = $_POST['ids'];
		$_SESSION['cartitem'][$ids] = $_POST['newamount'];
		echo 'Đã cập nhật thành công.';
	}
	
	# Và xử lý menu
	@mysql_close($mysql);

?>
