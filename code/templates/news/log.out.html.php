<?php
	require 'include/option.php';
	global $id,$config,$languages;
	$banner_right = news_by_cat(16,1,20);
	
	$danhmuc = categories_detail($id['category']);
	
?>
<div class="bgtrang">
	
	<div class="rows">
		<div class="lefts">
			<div class="pro_list">
				<div class="regbox regbox_corner_top regbox_corner_bottom">
					<div class="regbox_header regbox_corner_top">
						<?=$danhmuc[0]['title'];?>
					</div>
					<div class="regbox_cont">
						<div class="regbox_cont_note">
							Đang trong tiến trình thoát ...
						</div>
						
					</div>
					<div class="regbox_footer regbox_corner_bottom">&nbsp;</div>
				</div>
			</div>
		</div>
		<div class="jquery_ms"></div>
		
		<?=sys_option('home','main','right');?>
	</div>
</div>