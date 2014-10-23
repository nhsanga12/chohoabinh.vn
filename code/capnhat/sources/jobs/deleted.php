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
	
	$sql = "SELECT pro.*, po.vitri
			FROM ".$config['db_prefix']."_job_profile pro
			LEFT JOIN ".$config['db_prefix']."_job_post po ON po.id = pro.jobpos
			WHERE pro.deleted = '1' AND pro.folder_id = '0' 
			ORDER BY pro.id DESC
			";
	$rs_list = sql_list($sql);
	$sum = count($rs_list);
	
	// phục hồi
	if($id['option']=='edit'){
		$sqlup = "  UPDATE ".$config['db_prefix']."_job_profile
					SET deleted = '0',lastdate = '".time()."'
					WHERE id IN('".str_replace(",","','",$id['item'])."0') 
					AND deleted = '1'
			";
		$up = sql_list($sqlup);
		$rs_list = sql_list($sql);
	}
	
	// xóa vĩnh viễn
	if($id['option']=='delete'){
		$sqlup = "  DELETE FROM ".$config['db_prefix']."_job_profile
					WHERE id IN('".str_replace(",","','",$id['item'])."0') 
					AND deleted = '1'
			";
		$up = sql_list($sqlup);
		$rs_list = sql_list($sql);
	}
				
?>