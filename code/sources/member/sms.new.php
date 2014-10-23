<?php
	global $id,$config,$pages,$languages;
	
	if($_SESSION['user']['id']!= false)
	$dstinnhan = msg_list($_SESSION['user']['id']);
	
	if($id['cate']==22){
		require 'include/option.php';
		if(isset($_POST['guitin']) && $_POST['idnguoinhan']!='' && $_POST['touser']!=''){
			$rs['fromuser']	=	$_SESSION['user']['id'];
			$rs['usersid']	=	$_POST['idnguoinhan'];
			$rs['typesms']	=	'2';
			$rs['title']	=	$_POST['title'];
			$rs['contents']	=	$_POST['contents'];
			$rs['forwardto']= 	$id['detail'];
			$rs['bydate']	=	time();
			$rs['lastdate']	=	time();
			$newid = sql_add('users_sms',$rs);
			$msg = "Đã gửi tin nhắn";
		}else if(isset($_POST['guitin'])){
			$msg = "Thông tin người nhận không tồn tại.";
		}
		
		if($id['detail']!=''){
			$replyto = msg_detail($id['detail']);
			$replyto[0]['title'] = 'RE:'.$replyto[0]['title'];
			$replyto[0]['contents'] = "<br /><br /><br /><br /><br /><br /><b>".$replyto[0]['touser'].":</b><br />-------------------------------<br />".$replyto[0]['contents'];
		}
	}
?>