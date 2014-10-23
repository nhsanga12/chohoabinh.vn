<?php 
	require '../../config.php';
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql);
	mysql_query('SET CHARACTER SET utf8');
	require '../../mysql/global-mysql.php';
	require '../../session.php';
	require '../../language/menu_vn.php';
	
	function access_check($coms='') {
		$sql = " SELECT id, access FROM gnc_admin_detail
				 WHERE com = '".$coms."' AND admin = '".$_SESSION['auth']['id']."' 
				 AND man = 'main' ";
				   
		$dt = sql_detail($sql);
		if($dt[0]['access']=='1')
			return true;
		else
			return false;
	}	

		
	while(list($key,$value) = each($title)) {
?>
		<div class="tabsmenucontent">
			<ul>
				<?php while(list($skey,$svalue) = each($menu[$key])) { 
					if(access_check($skey) && $skey!='detail' && $skey!='documents' && $skey!='signin' && $skey!='signout' && $skey!='question'){?>
						<li><a href="?gnc=com:<?=$key?>;target:<?=$skey?>;groups:"><?=$svalue;?> </a></li>
				<? } }?>
			</ul>
		</div>
	
<? }?>