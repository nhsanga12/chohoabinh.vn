<div class="tcn">
	<div class="tcn_contents">
		<? if($ok==10){?>
			<div style="color:#CC0000; line-height:18px;">
				Đã cập nhật thành công.
			</div>
		<? }?>
		<p>Lên lịch up tự động cho tin (ID: <?=$detail[0]['id'];?>): <b><?=$detail[0]['title'];?></b></p>
		<? if($ms>0){?>
			
			<p style="color:#CC0000;">Đã tự động up <b><?=$detail[0]['amountap'];?></b> lần. Đã sửa lịch ngày <?=date("d-m-Y H:i",$cauhinhauto[0]['lastdate']);?></p>
		<? }?>
		<form action="" enctype="multipart/form-data" method="post">
		<div class="cauhinhngayup">
			Chọn ngày trong tuần: &nbsp;&nbsp;&nbsp;&nbsp;
			<? for($x=2;$x<9;$x++){?>
				<input type="checkbox" value="<?=$x;?>" name="thu<?=$x;?>" id="thu<?=$x;?>" <? if(in_array($x,$listngay)){?> checked="checked"<? }?> />
				<a class="chonngayup" rel="<?=$x;?>">
					<? if($x==8) echo '<font style="color:#d00;">Chủ nhật</font>'; else {?>
						Thứ <?=$x;?>
					<? }?>
				</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<? }?>
			<div class="soluotup">
				<div class="mucdieuchinhup">
					Thêm lần up ngẫu nhiên:
				</div>
				<? if($ms>0){
					for($m=0;$m<$ms;$m++){?>
					<div class="cacmocthoigian">
						<div class="moctg">Từ <b><?=date("H\hi",$cauhinhauto[$m]['fromtime']-25200);?></b> đến <b><?=date("H\hi",$cauhinhauto[$m]['totime']-25200);?></b>:</div>
						<input type="text" name="lanup_<?=$m;?>" class="lanup" value="<?=$cauhinhauto[$m]['amount'];?>" /> (lần up) <= 24
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" value=" Tạo ngẫu nhiên " style="display:none" />
						<input type="hidden" name="ids<?=$m;?>" value="<?=$cauhinhauto[$m]['autotime'];?>" />
					</div>
					<? }?>
				
				<? }else{
					foreach($khoanthoigian as $key => $value){?>
						<div class="cacmocthoigian">
							<div class="moctg">Từ <b><?=str_replace(":","h",$value[0]);?></b> đến <b><?=str_replace(":","h",$value[1]);?></b>:</div>
							<input type="text" name="lanup_<?=$key;?>" class="lanup" value="10" /> (lần up) <= 24 
							&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="button" value=" Tạo ngẫu nhiên " style="display:none" />
						</div>
				<? } } ?>
				
				
				<div class="cacmocthoigian">
					(Tổng số lần up trong 1 ngày không được quá 60 lần)<br /><br />
				</div>
				<div class="mucdieuchinhup">
					Chọn/Chỉnh thời gian up mỗi ngày:
				</div>
			</div>
			<input type="submit" name="luulai" id="luulai" value=" Lưu lại " />
			<input type="submit" name="huycaidat" id="huycaidat" value=" Hủy cài đặt " />
			<input type="button" name="quayve" id="quayve" value=" Quay lại " onclick="goBack(1)" />
		</div>
		
		</form>
	</div>
	<div class="tcn_footer">
	</div>
</div>
