<?php
	global $id,$config,$languages;
	
	$artlist = news_by_cat($id['category'],1,1);
	
	if($id['detail']!='')
		$detail = $id['detail'];
	else
		$detail = $artlist[0]['id'];
	$dts = articles_detail($detail);
		
	$title = categories_detail($id['category']);

	$off = 0; $langs = $config['default_language'];
		
	if($_POST['nutgui']){
		// XỬ LÝ GỬI EMAIL
		$from_email = explode(",",$config['emailserver']);
		$from 		= $from_email[1];
		$fromname 	= $from_email[0];
		
		$to_email 	= explode(",",$config['to_email']);
		$to			= $to_email[1];
		$name		= $to_email[0];
		
		$Subject	= "Custormer request form ".$_POST['dienthoai'];
		$contents 	.= "Hi Xalomuaban admin website:<br /><br />";
		$contents 	.= "There is new inquiry from XLMB Website. Please take a look at the client’s inquiry below:<br /><br />";
		$contents 	.= "Name: ".$_POST['fullname']."<br />";
		$contents 	.= "Email: ".$_POST['email']."<br />";
		$contents 	.= "Phone: ".$_POST['phone']."<br />";
		$contents 	.= "Questions/Comments: ".$_POST['noidung']."<br /><br /><br />";
		$contents 	.= "Thank you<br /><br />";
		
		$note 		= "Custormer request. Auto sender.";
		$note 		= "Custormer request. Auto sender.";
		
		require("include/phpmailer/class.phpmailer.php");
		require("include/phpmailer/class.smtp.php");
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
		if($_POST['verification']!=$_SESSION['security_code']){
			$msm =  "<h3 style=\"color:#f00;\"> Vui lòng nhập Ký tự ngẫu nhiên </h3><br /><br />";
		}
		else if(!$mail->Send())
		{
			$msm =  "<h3 style=\"color:#f00;\">Erro: " . $mail->ErrorInfo . '</h3><br /><br />';
		}
		else
		{
			$msm =  "<h3 style=\"color:#f00;\">Cảm ơn bạn đã gửi email cho Xalomuaban. Chúng tôi sẽ phản hồi bạn trong thời gian sớm nhất.</h3><br /><br />";
			$off = 1;
			$mail->AddAddress($_POST['email'],$_POST['fullname']);
			$mail->Subject = "Auto reply form SIM";
			
			$newcont  = "Cảm ơn bạn đã gửi email cho Xalomuaban. Bạn đã gửi yêu cầu cho chúng tôi với nội dung sau:"."<br /><br />";
			$newcont .= $_POST['noidung'];
			$mail->Body = $newcont;
			$mail->Send();
		}
		
	}


?>