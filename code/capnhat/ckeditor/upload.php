<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload hình ảnh</title>
<script language="JavaScript" type="text/javascript" src="../js/jscripts.js"></script>
<script type="text/javascript" src="ckeditor.js"></script>
<style type="text/css">
<!--
@import url("../css/styles.css");
@import url("../datepicket/datepicket.css");
-->
</style>
</head>
<body>
<?php
	require '../functions/global-functions.php';
	
	// Các biến truyền từ CKEditor.
	if($_POST['CKEditor']!=''){
		$funcNum = $_POST['funcNum'] ;
		$CKEditor = $_POST['CKEditor'] ;
		$langCode = $_POST['langCode'] ;
	}else{
		$funcNum = $_GET['CKEditorFuncNum'] ;
		$CKEditor = $_GET['CKEditor'] ;
		$langCode = $_GET['langCode'] ;
	}
	
	
	if(isset($_POST['upload'])){
		// Upload file lên thư mục.
		$pic_name	=	sys_uploads('../../lib/articles/','picfile','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV');
		
		// Tạo đường dẫn.
		$url = 'lib/files/'.$pic_name;
	
	}
	 
	// Gửi Url đến CKEditor.
	if(isset($_POST['insert'])){
		$url = $_POST['urltext'];
		$message = 'Không tải lên được, vui lòng kiểm tra lại hệ thống !'; 

		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
	}

?>
	<form action="" method="post" enctype="multipart/form-data">
	<div id="rs_line">
		<div id="rs_line_l">
			Hình ảnh minh họa :
		</div>
		<div id="rs_line_r">
			<input type="file" name="picfile" size="40" /><input type="submit" name="upload" value=" Upload " />
			<input type="hidden" name="funcNum" value=" <?=$funcNum;?> " />
			<input type="hidden" name="CKEditor" value=" <?=$CKEditor;?> " />
			<input type="hidden" name="langCode" value=" <?=$langCode;?> " />
		</div>
	</div>
	
	<? if($pic_name!=''){?>
		<div id="rs_line">
			<div id="rs_line_l">
				Thumnail :
			</div>
			<div id="rs_line_r">
				 <img src="../../lib/files/<?=$pic_name;?>" alt="thumnail" height="100" /> 
			</div>
		</div>
	<? }?>
	
	<div id="rs_line">
		<div id="rs_line_l">
			URL: <input type="text" name="urltext" value="<?=$url;?>" size="63" />
		</div>
		<div id="rs_line_r">
			<input type="submit" name="insert" value=" Nhận link " />
		</div>
	</div>
	</form>
	
</body>