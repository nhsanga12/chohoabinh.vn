<?php
function sys_uploads($folder,$file,$type='gif|jpg|png|swf|GIF|JPG|PNG|SWF')
{
	global $config;
	$upload_file = "";
	if ( $_SERVER["REQUEST_METHOD"] != "POST" ) {
		return $upload_file;
	}
				
	if ( !isset($_FILES[$file]["error"]) || $_FILES[$file]["error"] != 0 ) {
		return $upload_file;
	}
	if ( $_FILES[$file]["size"] > $config['max_upload_file_size'] ) {	
		return $upload_file;
	}
	$temp = preg_split('/[\/\\\\]+/', $_FILES[$file]["name"]);
	$filename = $temp[count($temp)-1];
	if ( !preg_match('/\.('.$type.')$/i', $filename )) {
		return $upload_file;
	} 
	$filename = str_replace("%20","",$filename);
	$upload_file = 'laptop_'. $filename;	
	if ( move_uploaded_file($_FILES[$file]["tmp_name"],$folder.$upload_file) ) {
		return $upload_file;
	} else {
		return $upload_file;
	}
}

// Required: anonymous function number as explained above.
$funcNum = $_GET['CKEditorFuncNum'] ;
// Optional: instance name (might be used to load specific configuration file or anything else)
$CKEditor = $_GET['CKEditor'] ;
// Optional: might be used to provide localized messages
$langCode = $_GET['langCode'] ;
 
// Upload file lên thư mục.
$pic_name	=	sys_uploads('../../lib/articles/','picfile','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV');
		
// Tạo đường dẫn.
$url = 'lib/files/'.$pic_name;

// Usually you will assign here something only if file could not be uploaded.
$message = '';
 
echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
?>