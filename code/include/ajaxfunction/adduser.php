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
	
	global $config,$id;
	
	# Nội dung chính
	if($_POST['user']!='' && $_POST['pass']!='' && $_SESSION['user']['themes'] == 1 && $_SESSION['user']['pages'] == 1){
			$rs['usersname']	= 	$_POST['user'];
			$rs['password']		= 	md5(md5(md5($_POST['pass'])));
			$rs['fullname']		= 	$_POST['hoten'];
			$rs['email']		= 	$_POST['email'];
			$rs['bydate']	= $rs['lastdate'] = time();
			$newid = sql_add('users',$rs);
			
			$rsn['usersid']		=	$newid;
			$rsn['phone']		=	$_POST['tel'];
			$rsn['address']		=	$_POST['dc'];
			sql_add('users_detail',$rsn);
			
			
			if($_POST['email']!=''){
			// XỬ LÝ GỬI EMAIL
				$from_email = explode(",",$config['emailserver']);
				$from 		= $from_email[1];
				$fromname 	= $from_email[0];
				
				$to_email = explode(",",$config['to_email']);
				$to			= $rs['email'];
				$name		= $rs['fullname'];
				
				$keyactive  = md5($rs['email'])."-".$rs['bydate'];
				
				$Subject	= "Welcome to Xalomuaban.com, ".$rs['usersname'];
				$contents 	.= "Chào ".$rs['usersname']."<br /><br />";
				$contents 	.= "Bạn vừa đăng ký thành viên trên website xalomuaban.com với thông tin sau:<br /><br />";
				$contents 	.= "Tên đăng nhập: ".$rs['usersname']."<br />";
				$contents 	.= "Mật khẩu: ".$_POST['pass']."<br />";
				$contents 	.= "Họ tên: ".$rs['fullname']."<br />";
				$contents 	.= "Email: ".$rs['email']."<br /><br />";
				
				$contents 	.= "Vui lòng xác nhận đăng ký bằng cách <a href=\"".sys_link('com=home&target=main&category=39')."?q=".$keyactive."\">nhấn vào đây.</a><br /><br />";
				
				$contents 	.= "Nếu link không hoạt động vui lòng copy dòng sau vào trình duyệt:".sys_link('com=home&target=main&category=39')."?q=".$keyactive." <br /><br />";				
				$contents 	.= "Cảm ơn bạn rất nhiều. Chúc bạn có những trải nghiệm vừa ý.<br /><br />";
				$contents 	.= "<br /><br />";
				$note 		= "Custormer request. Auto sender.";
				
				require("../phpmailer/class.phpmailer.php");
				require("../phpmailer/class.smtp.php");
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->Host = $from_email[3];
				$mail->Port = $from_email[4];
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->Username = $from;
				$mail->Password = $from_email[2];
				$mail->From = $from;
				$mail->FromName = $fromname;
				$mail->AddAddress($to,$name);
				$mail->AddReplyTo($from,$fromname);
				$mail->WordWrap = 50;
				$mail->IsHTML(true);
				$mail->Subject = $Subject;
				$mail->Body = $contents;
				$mail->AltBody = $note;
				//$mail->SMTPDebug = 2;
				if(!$mail->Send())
					echo "<h1 style=\"color:#f00;\">Erro: " . $mail->ErrorInfo . '</h1><br /><br />';
				else
					echo 'success';

			}else{
				echo 'success';
			}
			
			
	
	}else
		echo 'Vui lòng kiểm tra lại tên và mật khẩu.';
	
	# Và xử lý menu
	@mysql_close($mysql);

?>
