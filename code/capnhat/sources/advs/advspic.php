<?php
	$file	=	sys_uploads_slide('../slide/','images','jpg');
	$cut = explode(".",$file); 
	if ($file != '')
		$msg	=	"Đã upload thành công file ".$file;
	else
		$msg	=	"Bạn phải chọn file cần upload";
	if ($cut[1] != 'jpg')
		$msg	=	"Không upload được. Hình không đúng định dạng. Chỉ upload được thình có phần mở rộng \".jpg \"";
	
?>