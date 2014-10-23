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
	
	# Nội dung chính
			
	 //khoi tao ngay
	 $date =time();
	 $day = date('d', $date);
	 
	 if(isset($_POST['thang']) && $_POST['thang']!='')
	 	$month = (int)$_POST['thang'];
	 else
	 	$month = date('m', $date);
		
	
	 if(isset($_POST['nam']) && $_POST['nam']!='')
	 	$year = (int)$_POST['nam'];
	 else
		$year = date('Y', $date);
	 
	 //thang truoc va thang sau
	 if($month==1)
	 	$lastmonth = mktime(0,0,0,12, 1, $year-1); 
	 else
	 	$lastmonth = mktime(0,0,0,$month-1, 1, $year);
		
		
	if($month==12)
	 	$nextmonth = mktime(0,0,0,1, 1, $year+1); 
	 else
	 	$nextmonth = mktime(0,0,0,$month+1, 1, $year);
	 
	 
	 $first_day = mktime(0,0,0,$month, 1, $year) ; //Tao ngay dau tien cua thang
	 $title = "Tháng ".$month." - Năm ".$year;//Ten thang  
	 
	 //Tim ki tu ngay dau tien 
	 $day_of_week = date('D', $first_day) ;
	 
	 // Tìm khoảng trắng đầu lịch
	 switch($day_of_week){ 
		 case "Mon": $blank = 0; break; 
		 case "Tue": $blank = 1; break; 
		 case "Wed": $blank = 2; break; 
		 case "Thu": $blank = 3; break; 
		 case "Fri": $blank = 4; break; 
		 case "Sat": $blank = 5; break;
		 case "Sun": $blank = 6; break;
	 }
	
	 //ngày cuối tháng
	 $days_in_month = cal_days_in_month(0, $month, $year) ;
	 
	 $columm = 1; 
	 
	 $str .= "<tr>";
	 //Các khoảng trắng từ ô đầu đến ngày đầu
	 while ( $blank > 0 ) 
	 { 
		$str .= "<td></td>"; 
		$blank = $blank-1; 
		$columm++;
	 }
	 
	 if(isset($_POST['ids']) && $_POST['ids']!='')
		//$detail = articles_detail($_POST['id']);
		$calenderbanner = banner_calender( $_POST['ids'],(int)strtotime($year."-".$month."-01"),(int)strtotime($year."-".$month."-".$days_in_month));
	 else
		//$detail = array();
		$calenderbanner = array();
	
	 //ngày bắt đầu tháng
	 $day_num = 1;
	
	// xây dựng nội dung ngày	
	 while ( $day_num <= $days_in_month ){
	 	 $timenow = (int)strtotime($year."-".$month."-".$day_num);
		 if($day_num==$day && $month == date("m")) $morestr = "<div class=\"homnay\">Hôm nay</div>"; else $morestr = ""; 
		 if(in_array($timenow,$calenderbanner)){
		 	$classstr = "bgdadat";
		 	$links = "";
		 }else{
		 	$classstr = "ngaythang";
			$links = " onclick=\"getchoice('$day_num','$month','$year');\" ";
		 }
		 
		 $str .= "<td class=\"".$classstr."\" ".$links."> $morestr $day_num </td>";
		 $day_num++; 
		 $columm++;
		 
		 //xuống dòng nếu thứ >7
		 if ($columm > 7){
			$str .= "</tr><tr>";
			$columm = 1;
		 }
	 } 
	 
	 //khoảng trắng cuối lịch
	 while ( $columm >1 && $columm <=7 ){ 
		 $str .= "<td> </td>"; 
		 $columm++; 
	 } 
	
	 $str .= "</tr>";
	
	# Và xử lý menu
	@mysql_close($mysql);


	$thu =array("Thứ Hai","Thứ Ba","Thứ Tư","Thứ Năm","Thứ Sáu","Thứ Bảy","Chủ nhật");
?>


<table cellpadding="0" cellspacing="0" style="width:100%; border:1px solid #ddd; border-collapse:collapse;">
	<tr>
		<th style="padding:10px;">
			<div class="monthclick" onclick="LoadCalender('','<?=date("m",$lastmonth);?>','<?=date("Y",$lastmonth);?>')">
				<?=date("m",$lastmonth);?><br />
				<span style="font-size:8px"><?=date("Y",$lastmonth);?></span>
			</div>
		</th>
		<th colspan="5" style="color:#CC6600;padding:10px;"><? //echo $timenow."<br>"; print_r($calenderbanner);?><?=$title;?></th>
		<th style="padding:10px;">
			<div class="monthclick" onclick="LoadCalender('','<?=date("m",$nextmonth);?>','<?=date("Y",$nextmonth);?>')">
				<?=date("m",$nextmonth);?><br />
				<span style="font-size:8px"><?=date("Y",$nextmonth);?></span>
			</div>
		</th>
	</tr>
	<tr>
		<? for($i=0;$i<count($thu);$i++){?>
			<td style="border:1px solid #ddd; font-size:13px; font-weight:bold; background:#eee; padding:10px;">
				<?=$thu[$i];?>
			</td>
		<? }?>
	</tr>
	<?=$str;?>
</table>