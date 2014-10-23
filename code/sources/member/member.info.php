<?php
	global $id,$config,$pages;
	require 'include/option.php';
	
	if($_SESSION['user']['login'])
		$memberdt =  member_dt($_SESSION['user']['id']);
	else
		$memberdt = array();
	
	if(isset($_POST['luulai']) && $_POST['fullname']!='' && $_POST['email']!='' ){
		//get data	
		foreach($usesdata as $field =>$configuser){
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
			$where['usersid'] = $_SESSION['user']['id'];
			sql_update($usesdata['tablename'],$row,$where);
			
			foreach($rowsub as $subtb =>$subdata){ // luu cac bang phu
				$table = $usesdata['tablename']."_".$subtb;
				$data = $rowsub[$subtb];
				if(check_user_dt($_SESSION['user']['id'])){
					sql_update($table,$data,$where);
				}else{
					$data['usersid'] = $_SESSION['user']['id'];
					sql_add($table,$data);
				}
				$data = array();
			}
		}
		
		// load lai thong tin
		$memberdt =  member_dt($_SESSION['user']['id']);
		
	}else if(isset($_POST['luulai']) && ($_POST['fullname']=='' || $_POST['email']=='')){
		$msg = 'Vui lòng điền vào các ô bắt buộc (*)<br /><br />';
	}
	
	
?>