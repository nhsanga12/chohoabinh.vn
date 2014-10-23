<?php
	global $id,$config,$pages,$languages;
	if($_SESSION['user']['login'])
		$memberdt =  member_dt($_SESSION['user']['id']);
	else
		$memberdt = array();
?>
<div class="tcn">
	<div class="tcn_header">
		<h3>Thống kế thông tin mới</h3>
	</div>
	<div class="tcn_contents">
		Bạn không có tin nhắn mới nào. (0/0)<br />
		IP đã nhập lần gần nhất là : <?=$memberdt[0]['loginip'];?> <br /><br />
		Sản phẩm mới tạo :<br />
		Lịch sử giao dịch gần nhất:<br />
		Lịch sử nạp pin:<br />
	</div>
	<div class="tcn_footer">
	</div>
</div>
