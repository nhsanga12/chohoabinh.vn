<?php
# Phien ban moi chinh ngay 02/12/2010
function resizeIMG ($img_path,$new_width=0,$new_height=0) { // resize ảnh nếu có bất kỳ chiều nào lớn hơn khung mong muốn. khi dùng chú ý trình bày vì size 
		# Lấy định dạng
		$Splitted = explode('.',$img_path);
		# Kiểm tra định dạng			
		$ext= end($Splitted);
		$ext = strtolower($ext);
		if($ext == 'gif')
			$image =   imagecreatefromgif($img_path);
		elseif($ext == 'jpg' || $ext == 'jpeg')
			$image =   imagecreatefromjpeg($img_path);
		elseif($ext == 'png')
			$image =   imagecreatefrompng($img_path);
		$old_width = imagesx($image);
		$old_height= imagesy($image);

		if($old_width<$new_width && $old_height < $new_height){ // ảnh cũ NHỎ hơn ảnh mới (cả 2 chiều) 
			$new_height = $old_height;
			$new_width  = $old_width;
		}else if($old_width > $new_width && $old_height > $new_height){	// ảnh cũ LỚN hơn ảnh mới (cả 2 chiều) 
			if(($new_height * $old_width) > ($new_width * $old_height)){
				$new_height = $new_width * $old_height / $old_width;
			}else{
				$new_width  = $new_height * $old_width / $old_height;	
			};
		}else if($old_width > $new_width){ // chiều NGANG ảnh cũ LỚN ảnh mới 
			$new_height = $new_width * $old_height / $old_width;
		}else{ // chiều CAO ảnh cũ LỚN ảnh mới 
			$new_width  = $new_height * $old_width / $old_height;
		};
		$new_image= imagecreatetruecolor($new_width, $new_height); // khởi tạo ảnh
		$bgc = imagecolorallocate ($new_image, 255, 255, 255); // tạo màu bg
		imagefilledrectangle ($new_image, 0, 0, $new_width, $new_height, $bgc); // tạo bg cho hình
		
		imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
		# Xuất ảnh ra ngoài
		if($ext == 'gif') {
			 header('Content-Type: image/gif');
			 imagegif($new_image,null,100);
		} elseif($ext == 'jpg' || $ext == 'jpeg') {
			 header('Content-Type: image/jpeg');
			 imagejpeg($new_image,null,100);
		} elseif($ext == 'png') {
			 header('Content-Type: image/png');
			 imagepng($new_image,null,100);
		}
		imagedestroy($new_image);
}
# Hàm resize ảnh theo khung , ưu tiên chiều cao, phần ngang dư bị mất
function cropIMGfullHEIGHT ($img_path,$new_width,$new_height) {
		# Lấy định dạng
		$Splitted = explode('.',$img_path);
		# Kiểm tra định dạng			
		$ext= end($Splitted);
		$ext = strtolower($ext);
		if($ext == 'gif')
			$image =   imagecreatefromgif($img_path);
		elseif($ext == 'jpg' || $ext == 'jpeg')
			$image =   imagecreatefromjpeg($img_path);
		elseif($ext == 'png')
			$image =   imagecreatefrompng($img_path);
		$old_width = imagesx($image);
		$old_height= imagesy($image);		
		# Cắt lại hình ảnh
		$wm = $old_width/$new_width;
		$hm = $old_height/$new_height;
		
		$w_height = $new_width/2;
		$h_height = $new_height/2;
		
		$new_image= imagecreatetruecolor($new_width, $new_height);
		$bgc = imagecolorallocate ($new_image, 255, 255, 255);
		imagefilledrectangle ($new_image, 0, 0, $new_width, $new_height, $bgc);
		
		if($old_width > $old_height) {
			$adjusted_width = $old_width / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			imagecopyresampled($new_image, $image,-$int_width,0,0,0,$adjusted_width,$new_height,$old_width,$old_height);
		} elseif(($old_width < $old_height) || ($old_width == $old_height)) {
			$adjusted_height = $old_height / $wm;
			$half_height = $adjusted_height / 2;
			$int_height = $half_height - $h_height;
			imagecopyresampled($new_image, $image,0,-$int_height,0,0,$new_width,$adjusted_height,$old_width,$old_height);
		} else {
			imagecopyresampled($new_image, $image,0,0,0,0,$new_width,$new_height,$old_width,$old_height);
		}
		# Xuất ảnh ra ngoài
		if($ext == 'gif') {
			 header('Content-Type: image/gif');
			 imagegif($new_image,null,100);
		} elseif($ext == 'jpg' || $ext == 'jpeg') {
			 header('Content-Type: image/jpeg');
			 imagejpeg($new_image,null,100);
		} elseif($ext == 'png') {
			 header('Content-Type: image/png');
			 imagepng($new_image,null,100);
		}
		imagedestroy($new_image);
}
# Hàm resize ảnh theo khung , ưu tiên chiều ngang, phần cao dư bị mất
function cropIMGfullWIDTH ($img_path,$new_width,$new_height) {
		# Lấy định dạng
		$Splitted = explode('.',$img_path);
		# Kiểm tra định dạng			
		$ext= end($Splitted);
		$ext = strtolower($ext);
		if($ext == 'gif')
			$image =   imagecreatefromgif($img_path);
		elseif($ext == 'jpg' || $ext == 'jpeg')
			$image =   imagecreatefromjpeg($img_path);
		elseif($ext == 'png')
			$image =   imagecreatefrompng($img_path);
		$old_width = imagesx($image);
		$old_height= imagesy($image);		
		# Cắt lại hình ảnh
		$wm = $old_width/$new_width;
		$hm = $old_height/$new_height;
		
		$w_height = $new_width/2;
		$h_height = $new_height/2;
		
		$new_image= imagecreatetruecolor($new_width, $new_height);
		$bgc = imagecolorallocate ($new_image, 255, 255, 255);
		imagefilledrectangle ($new_image, 0, 0, $new_width, $new_height, $bgc);
		
		if($old_width < $old_height) {
			$adjusted_width = $old_width / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			imagecopyresampled($new_image, $image,-$int_width,0,0,0,$adjusted_width,$new_height,$old_width,$old_height);
		} elseif(($old_width > $old_height) || ($old_width == $old_height)) {
			$adjusted_height = $old_height / $wm;
			$half_height = $adjusted_height / 2;
			$int_height = $half_height - $h_height;
			imagecopyresampled($new_image, $image,0,-$int_height,0,0,$new_width,$adjusted_height,$old_width,$old_height);
		} else {
			imagecopyresampled($new_image, $image,0,0,0,0,$new_width,$new_height,$old_width,$old_height);
		}
		
		# Xuất ảnh ra ngoài
		if($ext == 'gif') {
			 header('Content-Type: image/gif');
			 imagegif($new_image,null,100);
		} elseif($ext == 'jpg' || $ext == 'jpeg') {
			 header('Content-Type: image/jpeg');
			 imagejpeg($new_image,null,100);
		} elseif($ext == 'png') {
			 header('Content-Type: image/png');
			 imagepng($new_image,null,100);
		}
		imagedestroy($new_image);
}
if ($_GET['t'] == 'resize'):resizeIMG(urldecode($_GET['file']),intval($_GET['w']),intval($_GET['h'])); endif;
if ($_GET['t'] == 'cropW'):cropIMGfullWIDTH(urldecode($_GET['file']),intval($_GET['w']),intval($_GET['h'])); endif;
if ($_GET['t'] == 'cropH'):cropIMGfullHEIGHT(urldecode($_GET['file']),intval($_GET['w']),intval($_GET['h'])); endif;


?>