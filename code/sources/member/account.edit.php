<?php
	global $id,$config,$pages;
	require 'include/option.php';
	
	if($_SESSION['user']['login'] && $id['detail']!=''){
		$bankdt =  chitietbangdon('users_bank','*',$id['detail']," AND usersid ='".$_SESSION['user']['id']."' ");
		
	}else{
		$bankdt = array();
	}
	
	if(isset($_POST['luulai']) && $_POST['chutaikhoan']!='' && $_POST['sotaikhoan']!='' ){
		//get data	
		foreach($usesbank as $field =>$configuser){
			if($field!='tablename' && $configuser['display']=='1'){
				//TH picture
				if($configuser['type']=='picture'){
					$npic	=	sys_uploads('lib/articles/',$field.'_new','gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG');
					if ($npic != '') {
						$_POST[$field] = $config['url'].'lib/articles/'.$npic;
					}
				}
				
				if($configuser['subtabble']!=''){
					$rowsub[$configuser['subtabble']][$field] = $_POST[$field];
				
				}else{
					$row[$field] = $_POST[$field];
				}
				
				
			}
			
		}
		
		// save data
		if($_SESSION['user']['login'] && $_SESSION['user']['id']!=''){
			$where['users_bankid'] = $id['detail'];
			$row['tennganhang'] = $banklist[$_POST['bankid']]['fullname'];
			
			if($id['detail']!=''){
				sql_update($usesbank['tablename'],$row,$where);
				$newid = $id['detail'];
				$msg = 'Đã cập nhật tài khoản thành công. <br /><br />';
			}else{
				$row['usersid'] = $_SESSION['user']['id'];
				$newid = sql_add($usesbank['tablename'],$row);
				$msg = 'Đã thêm tài khoản thành công. <br /><br />';
			}
			
		}
		
		// load lai thong tin
		$bankdt =  chitietbangdon('users_bank','*',$newid," AND usersid ='".$_SESSION['user']['id']."' ");
		
	}else if(isset($_POST['luulai']) && ($_POST['chutaikhoan']=='' || $_POST['sotaikhoan']=='')){
		$msg = 'Vui lòng điền vào các ô bắt buộc (*).<br /><br />';
	}
	
	
?>