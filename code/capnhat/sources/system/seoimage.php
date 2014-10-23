<?php
	$pre_name	=	$_POST['img_name'];
	$sql = "SELECT * FROM ".$config['db_prefix']."_news_articles WHERE picture <> "."'' ";
	$list_pic	=	sql_list($sql); $dem=count($list_pic);
	if(isset($_POST['submit'])){
		if($pre_name!=''){
			for($m=0;$m<count($list_pic);$m++){
				$cut = explode("_",$list_pic[$m]['picture']); // cắt tên hình
				$tenmoi = $pre_name.'_'.$cut[1];; // tạo tên mới
				if(count($cut)>1){			
					for($i=2; $i<count($cut);$i++){ if($cut[$i]!=''){
						$tenmoi .= '_'.$cut[$i];
					} }
				}
				
				
				// đổi tên file
				$rename = @rename("../lib/articles/".$list_pic[$m]['picture'],"../lib/articles/".$tenmoi); if($rename!=1) $dem = $dem-1;
				
				// đổi tên file trong database
				$rsi['picture']		=	$tenmoi;
				$rsnk['picture']	=	$list_pic[$m]['picture'];
				sql_update('news_articles',$rsi,$rsnk);
				
				$msg = '<br /> Đã đổi thành công '.$dem.'/'.count($list_pic).' file với tên mới "'.$pre_name.'"';
			}
		}
	}
?>