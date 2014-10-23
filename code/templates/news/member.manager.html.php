<?php
	require 'include/option.php';
	global $id,$config,$languages,$pages;
	$banner_right = news_by_cat(16,1,20);
	$title = categories_detail($id['category']);
	$danhmuc = categories_by_cat_group(1,62);
	
	if($_SESSION['user']['login']==true && $memdt[0]['acti']==''){
?>	
	<div class="bgtrang">
        <div class="rows" style="height:300px; text-align:center; font-size:16px;">
           <br /><br /><br /><br /><br />
            Tài khoản của bạn hiện chưa kích hoạt, vui lòng check email để kích hoạt !
        </div>
    </div>
	

<?php }else if($_SESSION['user']['login']==true){?>
<div class="bgtrang">
	<div class="rows">
		
		<div class="memlefts">
			<div class="mem_menu regbox_corner_top regbox_corner_bottom">
				<div class="menuleft">
					<ul>
						<? for($m=0;$m<count($danhmuc);$m++){
							$danhmuccon = categories_by_cat_group(1,$danhmuc[$m]['id']);
						?>
							<li>
								<a href="#topten">
									<?=$danhmuc[$m]['title'];?>
									<? if($danhmuc[$m]['id']=='66')
										echo "(".count_msg($_SESSION['user']['id']).")";
									?>
								</a>
								
								<? if(count($danhmuccon)>0){?>
									<ul>
										<? for($x=0;$x<count($danhmuccon);$x++){?>
											<li>
												<a href="<?=sys_link('com=home&target=main&category='.$danhmuccon[$x]['id']);?>">
													<?=$danhmuccon[$x]['title'];?>
													<? if($danhmuccon[$x]['id']=='76')
                                                        echo "(".count_msg($_SESSION['user']['id'],2).")";
                                                    ?>
                                                    <? if($danhmuccon[$x]['id']=='77')
                                                        echo "(".count_msg($_SESSION['user']['id'],1).")";
                                                    ?>
                                                </a>
											</li>
										<? }?>
									</ul>
								<? }?>
								
							</li>
						  <? }?>
						</ul>
					</div>
			</div>
		</div>
		<a name="topten"></a>
		<div class="memright">
			<div class="regbox regbox_corner_top regbox_corner_bottom" style="width:765px; height:auto; margin-top:0px; margin-left:0px;">
					<div class="regbox_header regbox_corner_top" style="width:755px;">
						<b>
						<? if($id['cate']==10)
								echo 'Cấu hình lịch up tin tự động';
						   else if($id['category']=='71' && $id['cate']=='10') 
								echo  'Chỉnh sửa sản phẩm';
							 else if($id['category']=='71' && ( $id['cate']=='20' || $id['cate']=='21' )) 
								echo  'Cài đặt tin vip';
						   else
								echo $title[0]['title'];
						?>
						</b>
					</div>
					<div class="regbox_cont" style="height:569px;">
					
					<?php 
						// trang cá nhân
						if($id['category']=='62')
							echo sys_option('member','home','pages');
						// thêm sp
						else if($id['category']=='70')
							echo sys_option('member','products','add');
						// chỉnh sản phẩm
						else if($id['category']=='71' && $id['detail']!='' && $id['cate']==10)
							echo sys_option('member','products','autoup');
						// đặt vào vị trí vip, banner
						else if($id['category']=='71' && $id['detail']!='' && ( $id['cate']==20 || $id['cate']=='21') )
							echo sys_option('member','products','banner');
						// chỉnh sản phẩm
						else if($id['category']=='71' && $id['detail']!='')
							echo sys_option('member','products','edit');
						// danh sách sản phẩm
						else if($id['category']=='71')
							echo sys_option('member','products','list');
						// danh sách banner - sản phẩm vip
						else if($id['category']=='469')
							echo sys_option('member','banner','list');
							
						// đăng xuất
						else if($id['category']=='72')
							echo sys_option('member','products','order');
						// thong tin ca nhan
						else if($id['category']=='68')
							echo sys_option('member','member','info');
						// doi mat khau
						else if($id['category']=='69')
							echo sys_option('member','member','changepass');
						// danh sach tai khoan
						else if($id['category']=='73')
							echo sys_option('member','account','list');
						// tao tai khoan
						else if($id['category']=='74')
							echo sys_option('member','account','edit');
						// lich su giao dich
						else if($id['category']=='75')
							echo sys_option('member','account','history');
						// tin nhan moi
						else if($id['category']=='76')
							echo sys_option('member','sms','new');
						// tin nhan đã xem
						else if($id['category']=='77')
							echo sys_option('member','sms','old');
						// tin nhan đã xem
						else if($id['category']=='78')
							echo sys_option('member','pin','add');
						// tin nhan đã xem
						else if($id['category']=='79')
							echo sys_option('member','pin','history');
						else
							echo sys_option('member','home','pages');
					?>
						
												
					</div>
					<div class="regbox_footer regbox_corner_bottom" style="border-left:none;">
						&nbsp;
						<? 
							if($pages['page']>1)
								divPageup(9);
						?>
					</div>
				</div>
		</div>
		
	</div>
</div>

<div class="jquery_ms"></div>
<? 
	}else{
	
		echo "<script language=\"javascript\">window.location.replace(\"".$config['url']."menu-group/dang-nhap/\")</script>";
	}
?>