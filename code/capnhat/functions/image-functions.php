<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*
*/
class SimpleImage {
 
   var $image;
   var $image_type;
 
   function load($filename) {
 
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
 
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
 
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image);
      }
   }
   function getWidth() {
 
      return imagesx($this->image);
   }
   function getHeight() {
 
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
 
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
 
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
 
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
 
   function cropthums($new_width=200,$new_height=200,$x1,$y1,$width, $height,$boundw=350) {
   	  $scale = $boundw / $this->getWidth()*100;
	  $this->scale($scale);
	  $new_image = imagecreatetruecolor($width, $height);
	  imagecopy($new_image, $this->image,0,0,$x1, $y1,$this->getWidth(), $this->getHeight());
      $this->image = $new_image;
	  $this->resize($new_width,$new_height);
   }
   
   function cropss($new_width=200,$new_height=200,$xx1,$yy1,$ww,$hh,$boundw=350) {
   	  $scale = $boundw / $this->getWidth()*100;
	  /*$x1 = $scale * $xx1;
	  $y1 = $scale * $yy1;
	  $width = $scale * $ww;
	  $height = $scale * $hh;
	  
      $new_image1 = imagecreatetruecolor($width, $height);
      imagecopy($new_image1, $this->image,0,0,$x1, $y1,$this->getWidth(), $this->getHeight());
      $this->image = $new_image1;*/
	  $this->scale($scale);
   }
   
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }
   
   function blurimg($width,$height,$amount_blur =35) {
		 $this->resize($width,$height);
		 for($i=0;$i<$amount_blur;$i++){
			imagefilter($this->image, IMG_FILTER_BRIGHTNESS);
		 }
		 for($i=0;$i<$amount_blur;$i++){
			imagefilter( $this->image, IMG_FILTER_GAUSSIAN_BLUR);
			
		 }
   }
   
   function resizecrop($width,$height) {
   		$old_width = $this->getWidth();
		$old_height = $this->getHeight();
		if($old_width<$width && $old_height < $height){ // ảnh cũ NHỎ hơn ảnh mới (cả 2 chiều) 
			$height = $old_height;
			$width  = $old_width;
		}else if($old_width > $width && $old_height > $height){	// ảnh cũ LỚN hơn ảnh mới (cả 2 chiều) 
			if(($height * $old_width) > ($width * $old_height)){
				$height = $width * $old_height / $old_width;
			}else{
				$width  = $height * $old_width / $old_height;	
			};
		}else if($old_width > $width){ // chiều NGANG ảnh cũ LỚN ảnh mới 
			$height = $width * $old_height / $old_width;
		}else{ // chiều CAO ảnh cũ LỚN ảnh mới 
			$width  = $height * $old_width / $old_height;
		};
		
      $new_image = imagecreatetruecolor($width, $height);
	  $bgc = imagecolorallocate ($new_image, 255, 255, 255); // tạo màu bg
	  imagefilledrectangle ($new_image, 0, 0, $width, $height, $bgc); // tạo bg cho hình
		
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }
   
   function resizefull($width,$height) { // dùng cho resize ảnh vuông
   		$old_width = $this->getWidth();
		$old_height = $this->getHeight();
		if($old_width<= $old_height ){ // chiều ngang lớn hơn chiều cao 
			$this->resizecropW($width,$height);
		}else if($old_width > $old_height ){ // chiều ngang lớn hơn chiều cao 
			$this->resizecropW($width,$height);
		}
   }
   
   function resizecropH($width,$height) {
   		$old_width = $this->getWidth();
		$old_height = $this->getHeight();
		
		$wm = $old_width/$width;
		$hm = $old_height/$height;		
		$w_height = $width/2;
		$h_height = $height/2;
		
      $new_image = imagecreatetruecolor($width, $height);
	  $bgc = imagecolorallocate ($new_image, 255, 255, 255); // tạo màu bg
	  imagefilledrectangle ($new_image, 0, 0, $width, $height, $bgc); // tạo bg cho hình
	  
	  if($old_width > $old_height) {
			$adjusted_width = $old_width / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			imagecopyresampled($new_image, $this->image,-$int_width,0,0,0,$adjusted_width,$height,$old_width,$old_height);
		} elseif(($old_width < $old_height) || ($old_width == $old_height)) {
			$adjusted_height = $old_height / $wm;
			$half_height = $adjusted_height / 2;
			$int_height = $half_height - $h_height;
			imagecopyresampled($new_image, $this->image,0,-$int_height,0,0,$width,$adjusted_height,$old_width,$old_height);
		} else {
			imagecopyresampled($new_image, $this->image,0,0,0,0,$width,$height,$old_width,$old_height);
		}
		
      $this->image = $new_image;
   }  
   
   function resizecropW($width,$height) {
   		$old_width = $this->getWidth();
		$old_height = $this->getHeight();
		
		$wm = $old_width/$width;
		$hm = $old_height/$height;		
		$w_height = $width/2;
		$h_height = $height/2;
		
      $new_image = imagecreatetruecolor($width, $height);
	  $bgc = imagecolorallocate ($new_image, 255, 255, 255); // tạo màu bg
	  imagefilledrectangle ($new_image, 0, 0, $width, $height, $bgc); // tạo bg cho hình
	  
	  if($old_width < $old_height) {
			$adjusted_width = $old_width / $hm;
			$half_width = $adjusted_width / 2;
			$int_width = $half_width - $w_height;
			imagecopyresampled($new_image, $this->image,-$int_width,0,0,0,$adjusted_width,$height,$old_width,$old_height);
		} elseif(($old_width > $old_height) || ($old_width == $old_height)) {
			$adjusted_height = $old_height / $wm;
			$half_height = $adjusted_height / 2;
			$int_height = $half_height - $h_height;
			imagecopyresampled($new_image, $this->image,0,-$int_height,0,0,$width,$adjusted_height,$old_width,$old_height);
		} else {
			imagecopyresampled($new_image, $this->image,0,0,0,0,$width,$height,$old_width,$old_height);
		}
		
      $this->image = $new_image;
   }          
 
}
?>