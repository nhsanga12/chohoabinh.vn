<?php
	global $id,$config,$pages,$languages;
	require 'include/option.php';
	$detail = articles_detail($id['detail']);
	
	$cauhinhauto = auto_setting($id['detail']);
	$ms = count($cauhinhauto);
	
	if(isset($_POST['luulai'])){
		$rs['article']	= 	$detail[0]['id'];
		$rs['actidate'] = '';
		for($x=2;$x<9;$x++){
			if($rs['actidate']=='') $dau = ""; else $dau = ",";
			if($_POST['thu'.$x]!='')
			$rs['actidate']	.= $dau.$_POST['thu'.$x];
		}
		$rs['lastdate']	=	time();
		$rs['deleted']	=	'0';
		
		if($ms>0){ //cap nhat
			$rsi['autoid'] = $cauhinhauto[0]['autoid'];
			sql_update('news_articles_auto',$rs,$rsi);
			
		}else{ // tao moi
			$rs['autotype']	= 	'1';
			$rs['bydate']	=	time();
			$newid = sql_add('news_articles_auto',$rs);
			$rsn['autoid']		=	$newid;
		}	
		
		
		$rsn['lastdate']	=	time();
		if($ms>0){//cap nhat
			for($m=0;$m<$ms;$m++){
				$rsn['fromtime']	=	$cauhinhauto[$m]['fromtime'];
				$rsn['totime']		=	$cauhinhauto[$m]['totime'];
				$rsn['amount']		=	$_POST['lanup_'.$m];
				$rsn['bydatestore']	=	taocackhoanthoigian($_POST['lanup_'.$m],$rsn['fromtime'],$rsn['totime']);
				$rsni['autotime']	= 	$_POST['ids'.$m];
				sql_update('news_articles_autotime',$rsn,$rsni);
				
			}
			
		}else{ // tao moi
			foreach($khoanthoigian as $key => $value){
				$rsn['fromtime']	=	getdateval($value[0],'H:i');
				$rsn['totime']		=	getdateval($value[1],'H:i');
				$rsn['amount']		=	$_POST['lanup_'.$key];
				$rsn['bydatestore']	=	taocackhoanthoigian($_POST['lanup_'.$key],$rsn['fromtime'],$rsn['totime']);
				sql_add('news_articles_autotime',$rsn);
			}
		}
		
		$ok = 10;
		$cauhinhauto = auto_setting($id['detail']);
		$ms = count($cauhinhauto);
	}
	
	$listngay = explode(",",$cauhinhauto[0]['actidate']);
	
?>