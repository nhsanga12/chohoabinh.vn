<?php
	global $id,$config;
	$demuc = array('STT','Ngày nộp','Người nộp','Vị trí','Trạng thái');
	$field = array('','bydate','name','vitri','status');
	$align = array('left','left','left','left','left');
	$trangthai = array(
						'Chưa quyết định',
						'Không phù hợp',
						'Từ chối',
						'Đã kiểm tra',
						'Phỏng vấn',
						'Đề nghị tuyển dụng',
						'Nhận việc'
					);
	$linkpos = 2;
	if($_POST['tungay']!='')
		$tungay = (int)strtotime($_POST['tungay']);
	else
		$tungay = 0;
	if($_POST['denngay']!='')
		$denngay = (int)strtotime($_POST['denngay']) + 86400;
	else
		$denngay = (int)time() + 30000000; // 1 nam
	
	$where ='';
	
	if($_POST['nguoinop']!='')
		$where .=" AND pro.lastname LIKE '%".$_POST['nguoinop']."%' ";
	if($_POST['vitrituyendung']!='')
		$where .=" AND po.id = '".$_POST['vitrituyendung']."' ";
	if($_POST['didong']!='')
		$where .=" AND pro.phone LIKE '%".$_POST['didong']."%' ";
	if($_POST['email']!='')
		$where .=" AND pro.email LIKE '%".$_POST['email']."%' ";
	if($_POST['email']!='')
		$where .=" AND pro.email LIKE '%".$_POST['email']."%' ";
	if($_POST['trangthaixem']!='')
		$where .=" AND pro.status = '".$_POST['trangthaixem']."' ";
		
	
	$sql = "SELECT pro.*, po.vitri, po.id AS vitriid
			FROM ".$config['db_prefix']."_job_profile pro
			LEFT JOIN ".$config['db_prefix']."_job_post po ON po.id = pro.jobpos
			WHERE pro.deleted = '0' AND pro.folder_id = '0' ".$where."
			ORDER BY pro.id DESC
			";
	$rs_list = sql_list($sql);
	$sum = count($rs_list);
	
	
	// update
	if($id['option']=='edit' && $id['status']!=''){
		$sqlup = "  UPDATE ".$config['db_prefix']."_job_profile
					SET status = '".$id['status']."',lastdate = '".time()."'
					WHERE id IN('".str_replace(",","','",$id['item'])."0') 
					AND deleted = '0' AND folder_id = '0'
			";
		$up = sql_list($sqlup);
		$rs_list = sql_list($sql);
	}
	
	// move
	if($id['option']=='add'){
		$sqlup = "  UPDATE ".$config['db_prefix']."_job_profile
					SET folder_id = '".$id['fid']."',lastdate = '".time()."'
					WHERE id IN('".str_replace(",","','",$id['item'])."0') 
					AND deleted = '0' AND folder_id = '0'
			";
		$up = sql_list($sqlup);
		$rs_list = sql_list($sql);
	}
	
	// deleted
	if($id['option']=='delete'){
		$sqlup = "  UPDATE ".$config['db_prefix']."_job_profile
					SET deleted = '1',lastdate = '".time()."'
					WHERE id IN('".str_replace(",","','",$id['item'])."0') 
					AND deleted = '0' AND folder_id = '0'
			";
		$up = sql_list($sqlup);
		$rs_list = sql_list($sql);
	}
	
	$sqlp = "SELECT id, vitri
			 FROM ".$config['db_prefix']."_job_post
			 WHERE deleted = '0' AND acti = '2'
			 ORDER BY id DESC
			";
	$listpost = sql_list($sqlp);
		
?>