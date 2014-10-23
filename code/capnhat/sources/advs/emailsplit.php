<?php 
	global $msg;
	// nhận giá trị biến
	if(isset($_POST['submit'])){
		
		// lấy id nhóm
		if($_POST['new_group']!='' && $_POST['new_group']!='Tên nhóm mới'){
			$rsgr['groupname'] = $_POST['new_group'];
			$rsgr['note'] = time();
			$idg = sql_add('email_group',$rsgr);
		}else{
			$idg = $_POST['group'];
		}
		
		// lưu file vào thư mục và database
		$rs['file']			=	sys_uploads('../lib/email/','filenote','txt|TXT');
		$rs['groupfile']	=	$idg;
		$idfile = sql_add('email_file',$rs);
		
		//Xử lí file vào lưu vào email
		$arrFile = file('../lib/email/'.$rs['file']);
		for($m=0;$m<count($arrFile);$m++){
			$email = $arrFile[$m];
			// lọc bỏ tạp text  vd:  "Ngoc. Nguyen Thi" <ngocnt@vgame.com.vn>
			$email = explode("<",$email);
			if($email[1]!='')
				$email = $email[1];
			else
				$email = $email[0];
			$nick = $email[0];
			$email = explode(">",$email);
			$email = $email[0];
			
			$email = str_replace(" ","",$email); // bỏ khoảng trắng
			$email = str_replace(",","",$email); // bỏ dấu ,
			
			//Lưu vào database
			if($email!=''){
				//$arremail = explode("@",$email);
				$rse['email'] 	= $email;
				$rse['nhom'] 	= $idg;
				//$rse['type'] 	= $arremail[1];
				//$rse['group'] 	= $idg;
				$ide = sql_add('email_list',$rse);
			}
			
		}	$msg = 'Đã nạp được '.count($arrFile).' email';
		/* chỉnh file
		$filename = '../lib/email/ketqua.txt';
		if (file_exists($filename))
			{
				$fp = fopen("$filename", "w");
				fputs ($fp,"$msg");
				fclose ($fp);
			}
		$msg .= count($arrFile);// */	
	};
	$sql = "SELECT * FROM gnc_email_group ";
	$nhom = sql_list($sql);
	
	
	
	
	
?>