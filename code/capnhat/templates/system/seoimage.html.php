<div class="tieude">
	&nbsp;&nbsp;&nbsp; Chỉnh sửa file ảnh và đổi tên file trong thư mục
</div>
<form action="" method="post" enctype="multipart/form-data">
	<div id="rs_line">
		<span id="red"><em><?=$msg?></em></span>
	</div><br/>
	<div id="rs_line" style=" line-height:20px;">
		Đây là công cụ <b>đổi tên</b> tất cả các hình trong web, vui lòng chèn ký tự tiền tố vào bên dưới : ( <i>nếu trùng tên hệ thống sẽ tự ghi đè </i>).<br/><br/>
		<b>Ví dụ</b> : seoimage_anhdep_12324.jpg ==>>  tiền tố cần điền là : <b>seoimage</b><br/>
	</div><br/>
	<div id="rs_line">
		<div id="rs_line_l">
			Ký tự mới :
		</div>
		<div id="rs_line_r">
			<input type="text" name="img_name" size="35" value="seoimage" />  (<i>không ghi khoảng cách</i>)
		</div>
	</div>	
	<div id="rs_line">
		<div id="rs_line_l">
			Tổng số hình sẽ được thay : 
		</div>
		<div id="rs_line_r">
			<b><?=count($list_pic);?></b> hình <!--<img src="images/filecopy.gif" align="truyen file" />-->
		</div>
	</div>	
	<div id="rs_line">
		<div id="rs_line_r">
			<br />
			<input type="submit" name="submit" value="Chấp nhận" />
			<input type="reset" name="reset" value="Hủy bỏ" /> <span id="red">( Chú ý xem kỹ nội dung trên )</span>
		</div>
	</div>
</form>
<br/><br/>