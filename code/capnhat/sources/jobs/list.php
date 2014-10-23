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
	if($id['status']!='') $status = " AND pro.status = '".$id['status']."' ";
	else $status ='';
	
	if($id['jobpos']!='') $jobpos = " AND pro.jobpos = '".$id['jobpos']."' ";
	else $jobpos ='';
	
	$sql = "SELECT pro.*, po.vitri
			FROM ".$config['db_prefix']."_job_profile pro
			LEFT JOIN ".$config['db_prefix']."_job_post po ON po.id = pro.jobpos
			WHERE pro.deleted = '0' AND pro.folder_id = '0' ".$status.$jobpos."
			ORDER BY pro.id DESC
			";
	$rs_list = sql_list($sql);
	$sum = count($rs_list);
	
	$listall = sql_list($sql);
	$total = count($listall);
	
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
	
	
	// thống kê hs nộp theo vị trí
	$sqlp = "SELECT pro.status, pro.jobpos, po.vitri, SUM(1) AS sum
			 FROM ".$config['db_prefix']."_job_profile pro
			 LEFT JOIN ".$config['db_prefix']."_job_post po ON po.id = pro.jobpos
			 WHERE pro.deleted = '0' AND pro.folder_id = '0' AND po.vitri IS NOT NULL
			 GROUP BY pro.jobpos
			 ORDER BY pro.id DESC
			";
	$listpost = sql_list($sqlp);
	$sumpost = count($listpost);
	
	// thống kê hs nộp theo trạng thái
	$sqltrangthai = "SELECT id,status, jobpos, SUM(1) AS sum
			 FROM ".$config['db_prefix']."_job_profile
			 WHERE deleted = '0' AND folder_id = '0'
			 GROUP BY status
			 ORDER BY status ASC
			";
	$ddtrangthai = sql_list($sqltrangthai);
	$sumtt = count($ddtrangthai);
	
	$sqlsum = "	SELECT id FROM ".$config['db_prefix']."_job_profile WHERE deleted = '0' AND folder_id = '0' ";
	$listsum = sql_list($sqlsum);
	$tongcong = count($listsum);
				
?>