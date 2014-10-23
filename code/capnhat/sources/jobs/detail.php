<?php
	global $id,$config;
	
	function getmoreanwer($item,$ques_id){
		$sql = " SELECT moreanwer FROM ".$config['db_prefix']."_job_question_re WHERE profile_id = '".$item."' AND question_id = '".$ques_id."' ";
		$query = sql_list($sql);
		return $query[0]['moreanwer'];
	}
	
	
	$trangthai = array(
						'Chưa quyết định',
						'Không phù hợp',
						'Từ chối',
						'Đã kiểm tra',
						'Phỏng vấn',
						'Đề nghị tuyển dụng',
						'Nhận việc'
					);
	if(isset($_POST['save'])){
		$sqlup = " UPDATE ".$config['db_prefix']."_job_profile SET status = '".$_POST['trangthaixem']."' WHERE  id='".$id['items']."' ";
		$query = sql_list($sqlup);
	}
					
	include("cautruc.php");
	
	if($id['items']!=''){			
		$sql = "SELECT pro.*, po.vitri
			FROM ".$config['db_prefix']."_job_profile pro
			LEFT JOIN ".$config['db_prefix']."_job_post po ON po.id = pro.jobpos
			WHERE pro.deleted = '0' AND pro.folder_id = '0' AND pro.id ='".$id['items']."'
			ORDER BY pro.id DESC
			
			";
		$rs_list = sql_list($sql);
	}
	
	if($id['option']=='add'){
		
		$sql2 = " SELECT * FROM ".$config['db_prefix']."_job_degree WHERE profile_id = '".$id['items']."'
				ORDER BY id DESC ";
		$rs_list2 = sql_list($sql2);
		
		require_once 'PHPWord/PHPWord.php';
		$PHPWord = new PHPWord();
		$document = $PHPWord->loadTemplate('Template.docx');
		$document->setValue('Value1', $rs_list[0]['vitri']);
		$document->setValue('Value2', $rs_list[0]['jobwage']);
		$document->setValue('Value3', '');
		$document->setValue('Value4', $rs_list[0]['lastname'].' '.$rs_list[0]['firstname']);
		$document->setValue('Value5', $rs_list[0]['birthday']);
		$document->setValue('Value6', $rs_list[0]['whereborn']);
		$document->setValue('Value7', $rs_list[0]['residence']);
		$document->setValue('Value8', $rs_list[0]['address']);
		$document->setValue('Value9', $rs_list[0]['tel']);
		$document->setValue('Value10', $rs_list[0]['phone']);
		$document->setValue('Value11', $rs_list[0]['email']);
		$document->setValue('Value12', $rs_list[0]['children']);
		$document->setValue('Value13', $rs_list[0]['emrgency']);
		$document->setValue('Value14', $rs_list[0]['relationship']);
		$document->setValue('Value15', $rs_list[0]['telephone2']);
		$document->setValue('Value16', $rs_list[0]['address2']);
		
		if($rs_list[0]['gender']=='Nam'){
			$document->setValue('gener1', "X");
			$document->setValue('gener2', " . ");
		}else{
			$document->setValue('gener1', " . ");
			$document->setValue('gener2', "X");
		}
		
		$marie = explode("-",$config['family']);
		$marie = explode(",",$marie[0]);
		for($m=0;$m<count($marie);$m++){
			$postm = 'marie'.($m+1);
			if($marie[$m]==$rs_list[0]['family'])
				$document->setValue($postm, "X");
			else
				$document->setValue($postm, ".");
		}
		if($rs_list[0]['children']!='' && $rs_list[0]['children']!='0')
			$document->setValue('marie5', ".");
		else
			$document->setValue('marie5', "X");
		
		
		
		for($m=0;$m<5;$m++){
			$pos = 'Value'.($m+2).'0';
			$pos1 = 'Value'.($m+2).'1';
			$pos2 = 'Value'.($m+2).'2';
			$pos3 = 'Value'.($m+2).'3';
			$pos4 = 'Value'.($m+2).'4';
			$document->setValue($pos, $rs_list2[$m]['fromdate'].'-'.$rs_list2[$m]['todate']);
			$document->setValue($pos1, $rs_list2[$m]['schools']);
			$document->setValue($pos2, $rs_list2[$m]['city'].','.$rs_list2[$m]['country']);
			$document->setValue($pos3, $rs_list2[$m]['specialization']);
			$document->setValue($pos4, $rs_list2[$m]['degree']);
		}
		$document->setValue('ngayxuatfile', date("d-m-Y"));
		
		$filename = 'phieuin'.$id['items'].'.docx';
		$document->save($filename);
		
		
		// phan 2
		$PHPWord2 = new PHPWord();
		$document2 = $PHPWord2->loadTemplate('tuyendung_page2-3.docx');
		$sqle = " SELECT * FROM ".$config['db_prefix']."_job_experience WHERE profile_id = '".$id['items']."'
				ORDER BY id DESC ";
		$experience = sql_list($sqle);
		
		for($m=0;$m<4;$m++){
			$pos1 = 'kinhnghiem'.($m+1).'1';
			$pos2 = 'kinhnghiem'.($m+1).'2';
			$pos3 = 'kinhnghiem'.($m+1).'3';
			$pos4 = 'kinhnghiem'.($m+1).'4';
			$pos5 = 'kinhnghiem'.($m+1).'5';
			$pos6 = 'kinhnghiem'.($m+1).'6';
			
			$document2->setValue($pos1, $experience[$m]['fromdate']."-".$experience[$m]['todate']);
			$document2->setValue($pos2, $experience[$m]['company']);
			$document2->setValue($pos3, $experience[$m]['position']);
			$document2->setValue($pos4, $experience[$m]['wage']);
			$document2->setValue($pos5, str_replace("&nbsp;"," ",html2text($experience[$m]['task'])));
			$document2->setValue($pos6, $experience[$m]['reason']);
		}
		
		$sqltk = " SELECT * FROM ".$config['db_prefix']."_job_manager WHERE profile_id = '".$id['items']."'
				ORDER BY bydate DESC ";
		$thamkhao = sql_list($sqltk);
		for($m=0;$m<2;$m++){
			$pos1 = 'thamkhao'.($m+1).'1';
			$pos2 = 'thamkhao'.($m+1).'2';
			$pos3 = 'thamkhao'.($m+1).'3';
			$pos4 = 'thamkhao'.($m+1).'4';
			$pos5 = 'thamkhao'.($m+1).'5';
			
			$document2->setValue($pos1, $thamkhao[$m]['old_manager']);
			$document2->setValue($pos2, $thamkhao[$m]['relationship']);
			$document2->setValue($pos3, $thamkhao[$m]['title']);
			$document2->setValue($pos4, $thamkhao[$m]['company']);
			$document2->setValue($pos5, $thamkhao[$m]['address']);
		}
		
		$sqltr = " SELECT * FROM ".$config['db_prefix']."_job_straining WHERE profile_id = '".$id['items']."'
				ORDER BY fromdate DESC ";
		$khoahoc = sql_list($sqltr);
		for($m=0;$m<3;$m++){
			$pos1 = 'khoahoc'.($m+1).'1';
			$pos2 = 'khoahoc'.($m+1).'2';
			$pos3 = 'khoahoc'.($m+1).'3';
			
			$document2->setValue($pos1, $khoahoc[$m]['fromdate']."-".$khoahoc[$m]['todate']);
			$document2->setValue($pos2, $khoahoc[$m]['company']);
			$document2->setValue($pos3, $khoahoc[$m]['skills']);
		}
		
		
		$nstring = $rs_list[0]['languageskills'].",";
		$langex = explode(",",$nstring);
		$textlg = array('Cơ bản','Trung bình','Tốt');
		for($m=0;$m<3;$m++){
			for($e=0;$e<count($textlg);$e++){
				$pos = 'lang'.($m+1).($e+1);
				$idex = ($m*2)+1;
				if($langex[$idex]==$textlg[$e])
					$document2->setValue($pos, "X");
				else
					$document2->setValue($pos, ".");
				
			}
		}
		
		
		$sqlq = " SELECT q.question_vn, q.plan_vn, q.question_en, q.plan_en, rq.answer
				  FROM  ".$config['db_prefix']."_job_question q
				  LEFT JOIN ".$config['db_prefix']."_job_question_re rq ON rq.question_id = q.id
				  WHERE q.deleted = '0' AND rq.deleted = '0' AND rq.profile_id = '".$id['items']."' ORDER BY q.bydate ASC ";
			
		$rs_listq = sql_list($sqlq);
		
		for($x=0;$x<count($rs_listq)-1;$x++){
			$choice = explode(",",$rs_listq[$x]['plan_vn']);
			for($y=0;$y<count($choice);$y++){
				$pos = 'ch'.($x+1).($y+1);
				if($choice[$y]==$rs_listq[$x]['answer'])
					$document2->setValue($pos, "X");
				else
					$document2->setValue($pos, ".");
				
			}
		}
		
		
		$document2->setValue('computer', str_replace("&nbsp;"," ",html2text($rs_list[0]['softskills'])));
		$document2->setValue('info01', getmoreanwer($id['items'],'5'));
		$document2->setValue('info02', getmoreanwer($id['items'],'1'));
		$document2->setValue('info03', getmoreanwer($id['items'],'2'));
		
		
		
		$filename2 = 'phieuin'.$id['items'].'_t23.docx';
		$document2->save($filename2);
				
		
		
		
	}
	
			
?>