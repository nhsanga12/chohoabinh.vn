<div class="bgtrang">	
	<div class="rows">
	<table cellpadding="0" cellspacing="0" border="0" style="margin:0; padding:0;">
      <tr>
        <td valign="top" align="left">
        	<div class="lefts">
                <div class="chitietsp">
                    <div class="chitietsp_header">
                        <span> Chi tiết sản phẩm </span>
                        <div class="giohang">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            : <b id="soluonghang"><?=$_SESSION['cart']['sum'];?></b>
                            <a href="<?=sys_link('com=home&target=main&category=81');?>" style=" float:right; text-align:right; margin-right:10px;">Xem giỏ hàng</a>
                        </div>
                    </div>
                    <div class="chitietsp_sum">
                        <div class="chitietsp_img">
                            <img src="<?=$config['url'];?>lib/articles/<?=$sanpham[0]['picture'];?>" alt="<?=$sanpham[0]['title'];?>" class="detail_img" border="0" itemprop="image" />
                        </div>
                        <div class="chitietsp_cont">
                            <h2 itemprop="name"><?=$sanpham[0]['title'];?></h2>
                            <table cellpadding="0" cellspacing="0" class="subpro" style="margin:5px 1px 1px 0px;">
                                <tr><td width="70">Giá:</td>
                                    <td>
                                        <span class="pro_gia2"><? $giatien =formatMoney($sanpham[0]['gia'],0);
                                        if($sanpham[0]['loaitien']=='USD')
                                            echo str_replace(".",",",$giatien);
                                        else
                                            echo $giatien;
                                        ?></span>
                                        <? if($sanpham[0]['loaitien']=='USD') echo $sanpham[0]['loaitien']; else echo 'đ';?>
                                    </td>
                                </tr>
                                <tr><td>Lượt xem:</td><td><span class="pro_duong"><?=$sanpham[0]['opt'];?></span></td></tr>
                                <tr><td>Shop:</td><td>
                                    <a href="<?=sys_link('com=home&target=main&category=232&cate='.$sanpham[0]['usersid']);?>">
                                        <span class="pro_duong">
                                            <? if($users[0]['tengianhang']) echo $users[0]['tengianhang']; else echo $users[0]['fullname'];?>
                                        </span>
                                    </a>
                                </td></tr>
                                <tr><td>Mã SP:</td><td><span class="pro_duong">XLC-<?=$sanpham[0]['category'];?>-T<?=$sanpham[0]['id'];?></span></td></tr>
                                <tr>
                                    <td colspan="2" align="left" valign="bottom" height="70">
                                        <br /><?=$config['smsecho'];?>
                                        <? for($u=0;$u<count($dstaikhoan);$u++){?>
                                            
                                            <? if($dstaikhoan[$u]['bankid']==2){?>
                                                <a href="https://www.nganluong.vn/button_payment.php?receiver=<?=$dstaikhoan[$u]['sotaikhoan'];?>&price=<?=$sanpham[0]['gia'];?>&product_name=<?=$sanpham[0]['title'];?>&comments=Gửi đơn hàng ngày <?=date("d-m-Y");?>&return_url=<?=$config['url'];?>" target="_blank">
                                                    <img src="http://nganluong.vn//data/images/buttons/3.gif" height="24" alt="nganluong" style="margin-top:10px; border:none;" />
                                                </a>
                                            <? }else if($dstaikhoan[$u]['bankid']==1){?>
                                                <a href="https://www.baokim.vn/payment/customize_payment/product?business=<?=$dstaikhoan[$u]['sotaikhoan'];?>&product_name=<?=$sanpham[0]['title'];?>&product_price=<?=$sanpham[0]['gia'];?>&product_quantity=1&total_amount=<?=$sanpham[0]['gia'];?>" target="_blank">
                                                    <img for="button_id_3" src="https://www.baokim.vn/application/uploads/buttons/btn_pay_now_1.png" alt="Nút thanh toán ngay cơ bản" height="24" style="margin-top:10px; border:none;" />
                                                </a>
                                            <? }?>
                                        <? }?>
                                        <select name="hinhthuctt" id="hinhthucvl" style="margin:10px 10px 10px 10px; border:1px solid #ddd; float:right; width:125px; height:25px;" class="hinhthuctt" onchange="changehinhthuc();">
                                            <option value="" label="Thanh toán khác">Thanh toán khác</option>
                                            <option value="1" label="Chuyển khoản">Chuyển khoản</option>
                                            <option value="2" label="Tiền mặt">Tiền mặt</option>
                                        </select>
										<input type="hidden" id="hinhthuctt" value="" />
                                    </td>
                                    
                                </tr>
                                
                                <?php
                                    if($sanpham[0]['likes']=='' || $sanpham[0]['likes']=='0')
                                        $lk = 1;
                                    else
                                        $lk = (int)$sanpham[0]['likes'];
                                ?>
                                <tr>
                                    <td colspan="2" align="left" valign="bottom" height="70">
                                        <div class="huongdanmuahang" style="color:#f00; font-size:11px; position:absolute; margin:-35px 0px 0px 30px; height:30px; display:none;">Chỉnh số lượng và nhấn nút mua hàng để thêm vào giỏ hàng</div>
                                        <div class="sharelink likeshare" style=" float:left; margin-top:5px;" rel="0">Share</div>
                                        
                                        <div class="likeshare" style=" float:left; margin-top:5px;" onclick=" update_likes('<?=$sanpham[0]['id'];?>','<?=$lk+1;?>');">Like</div>
                                        <div class="amount_like">
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td><div class="amount_like_left"></div></td>
                                                    <td><div class="amount_like_center" id="amount_like_<?=$sanpham[0]['id'];?>"><?=$lk;?></div></td>
                                                    <td><div class="amount_like_right"></div></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div style="float:right; width:200px; margin:2px 0px 0px 0px">
                                        
                                        <a id="muahangngay" rel="<?=$sanpham[0]['id'];?>" style="cursor:pointer;"><div class="muahang" style="float:right;">Mua hàng</div></a>
                                        <input type="text" id="soluongmua" class="phanhoi_input" style="width:100px; float:right; margin:0px 0px 0px 0px; border:1px solid #ccc;" value="Số lượng mua:1" onclick=" if(this.value=='Số lượng mua:1') this.value='';" onblur="if(this.value=='') this.value='Số lượng mua:1';" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <? if($users[0]['vip']){?>
                                <div class="ghdamban">
                                    <a href="#">
                                        <img src="<?=$config['url'];?>themes/default/images/gianhangdambao.jpg" alt="gian hang dam bao" width="350" border="0" style="border:none;" />
                                    </a>
                                </div>
                            <? }?>
                            <div class="jquery_ms" style="display:none"> Đang thực hiện ....</div>
                        </div>
                    </div>
                </div>
			
                <div class="pro_list">
                    <div class="pro_list_header2" style=" height:auto;">
                        <div class="spdetail_tab">
                            <span class="active_tab link_tab" rel="chitietsanpham"> Chi tiết sản phẩm </span>
                            <span class="link_tab" rel="thongtinlienhe"> Thông tin liên hệ </span>
                            <span class="link_tab" rel="thanhtoan"> Liên hệ khác </span>
                            <span class="link_tab" rel="dieukiengiaohang"> Ghi chú sản phẩm </span>
                            <span class="link_tab" rel="cungchuyenmuc"> Cùng danh mục </span>
                            <span style="cursor:pointer;" onclick="window.location.assign('<?=sys_link('com=home&target=main&category=232&cate='.$sanpham[0]['usersid']);?>');"> Cùng Shop </span>
                        </div>
                        <div class="spcolum" id="chitietsanpham" style="background:#fff;">
                            <div class="spcttrong" style="margin:0px; display:table;" itemprop="description">
                                <div style="padding:2% 1% 2% 3%; display:table; width:96%;">
                                    <?=removediv($sanpham[0]['contents']);?>
                                 </div>
                            </div>
                            <!--ket thuc noi dung-->
                        </div>
                        <div class="spcolum" id="thongtinlienhe" style="background:#fff;display:none;">
                            <div style="padding:20px; display:table">
                                <table cellpadding="3" cellspacing="3" width="400">
                                    <? if($users[0]['profile_image']){?><tr>
                                        <td width="100" align="right">&nbsp;</td>
                                        <td><img src="<?=$users[0]['profile_image'];?>" alt="hinhdaidien" width="50" style=" margin:0 5px;" /></td>
                                    </tr>
                                    <? }?>
                                    
                                    <tr>
                                        <td width="100" align="right"><b>Chủ shop:</b></td>
                                        <td><a href="#"><?=$users[0]['fullname'];?></a></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Email:</td>
                                        <td><?=$users[0]['email'];?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Điện thoại:</td>
                                        <td><?=$users[0]['phone'];?></td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top">Địa chỉ:</td>
                                        <td><?=$users[0]['address'];?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="spcolum" id="thanhtoan" style="background:#fff;display:none;">
                            <div style="display:table; width:90%; padding:4%;">
                                <?=$users[0]['description'];?>
                                
                                <table cellpadding="5" cellspacing="0" width="100%" style="margin-top:15px;">
                                <? for($i=0;$i<count($dstaikhoan);$i++){ $idbank = $dstaikhoan[$i]['bankid'];?>
                                    <tr id="dongsp_<?=$dstaikhoan[$i]['users_bankid'];?>">
                                        <td width="210" valign="top" align="left" style="border-bottom:1px solid #eee;">
                                            <a href="<?=$banklist[$idbank]['port'];?>" target="_blank"><img src="<?=$config['url'];?>lib/images/<?=$banklist[$idbank]['images'];?>" class="thumlist" width="200" id="hinhsp_<?=$dstaikhoan[$i]['users_bankid'];?>" border="0" /></a>
                                        </td>
                                        <td align="left" valign="top" style="border-bottom:1px solid #eee;">
                                            <div class="noidungtomtat" style="margin:0; padding:0; width:100%; line-height:18px; border:none;">
                                                <a href="<?=$banklist[$idbank]['port'];?>" target="_blank">
                                                    <h2 style="margin-top:0px; line-height:12px;"><?=$banklist[$idbank]['fullname'];?></h2>
                                                </a>
                                                Chi nhánh: <a class="pro_gia2" id="chinhanh_<?=$dstaikhoan[$i]['users_bankid'];?>"><?=$dstaikhoan[$i]['chinhanh'];?></a><br />
                                                Tên tài khoản: <a class="pro_duong"><?=$dstaikhoan[$i]['chutaikhoan'];?></a><br />
                                                Số tài khoản/Email: <a class="pro_duong"><?=$dstaikhoan[$i]['sotaikhoan'];?></a><br /><br /><br />
                                                <? if($dstaikhoan[$i]['status']=='1'){?>
                                                    <div class="dangtat">Đang tắt</div>
                                                <? }?>
                                            </div>
                        
                                        </td>
                                    </tr>
                                    <? }?>
                                </table>
                            </div>
                        </div>
                        <div class="spcolum" id="dieukiengiaohang" style="background:#fff;display:none;">
                            <div style="padding:20px; display:table">
                                <?=removediv($sanpham[0]['quick']);?>
                            </div>
                        </div>
                        
                         
                    </div>
                </div>
                
                <div class="spcolum" id="cungchuyenmuc" style="background:#fff;display:none;">
                    <div style="padding:20px; display:table">
                        <div class="pro_list_cont">
                            <input name="danhmuc" id="danhmuc" type="hidden" value="<?=$id['category'];?>" />
                            <input name="trang" id="trang" type="hidden" value="<?=$id['page'];?>" />                            
                            <input name="stop" id="stop" type="hidden" value="8" />
                        
                        
                            <table cellpadding="0" cellspacing="0" width="100%" class="tb_pro">
                                <? for($n=0;$n<count($sanphamkhac);$n++){ if($sanphamkhac[$n]['id']!==$id['detail']){?>
                                    <tr>
                                        <td width="180" valign="top">
                                            <a href="<?=sys_link('com=home&target=main&category='.$sanphamkhac[$n]['category'].'&detail='.$sanphamkhac[$n]['id']);?>"><img src="<?=$config['url'];?>lib/articles/thums_<?=$sanphamkhac[$n]['picture'];?>" alt="<?=$sanphamkhac[$n]['title'];?>" class="listpro_img" border="0" /></a>
                                        </td>
                                        <td width="400" valign="top">
                                            <div class="noidungtomtat">
                                                <a href="<?=sys_link('com=home&target=main&category='.$sanphamkhac[$n]['category'].'&detail='.$sanphamkhac[$n]['id']);?>"><h2><?=$sanphamkhac[$n]['title'];?></h2></a>
                                                <table cellpadding="0" cellspacing="0" class="subpro" width="90%">
                                                    <tr>
                                                        <td width="70">Chủ shop:</td>
                                                        <td>
                                                            <a href="<?=sys_link('com=home&target=main&category=232&cate='.$sanphamkhac[$n]['usersid']);?>"><?=$sanphamkhac[$n]['fullname'];?></a>
                                                        </td>
                                                    </tr>
                                                    <tr><td>Điện thoại:</td><td><?=$sanphamkhac[$n]['phone'];?></td></tr>
                                                    <tr><td valign="top">Địa chỉ:</td><td><?=$sanphamkhac[$n]['address'];?></td></tr>
                                                    <tr><td>Tình trạng:</td><td><? if($sanphamkhac[$n]['acti']!='') echo '<div class="xacthuc">Chưa xác thực thông tin</div>'; else echo 'Đã xác thực thông tin';?></td></tr>
                                                    <tr><td>Danh hiệu:</td><td><? if($sanphamkhac[$n]['vip']==1) echo '<div class="vip">VIP</div>'; else echo '<div class="thanhvien">Thành viên</div>';?></td></tr>
                                                    
                                                    <tr><td></td>
                                                    
                                                    <?php
                                                            if($sanphamkhac[$n]['likes']=='' || $sanphamkhac[$n]['likes']=='0')
                                                                $lk = 1;
                                                            else
                                                                $lk = (int)$sanphamkhac[$n]['likes'];
                                                        ?>
                                                    <td align="right">
                                                        <div class="amount_like" style="float: right; margin-top:0px;">
                                                            <table cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td><div class="amount_like_left"></div></td>
                                                                    <td><div class="amount_like_center" id="amount_like_<?=$sanphamkhac[$n]['id'];?>"><?=$lk;?></div></td>
                                                                    <td><div class="amount_like_right"></div></td>
                                                                </tr>
                                                            </table>
                                                        </div>	
                                                        <div class="likeshare" style="float: right;" onclick=" update_likes('<?=$sanphamkhac[$n]['id'];?>','<?=$lk+1;?>');">Like</div>
                                                        <div class="sharelink likeshare" style="float: right;" rel="<?=$n;?>">Share</div>
                                                    </td></tr>
                                                </table>
                                            </div>
                                        </td>
                                        <td valign="top">
                                            <table cellpadding="0" cellspacing="0" class="subpro" style="margin:15px 1px 1px 25px;">
                                                <tr><td width="70">Giá:</td>
                                                    <td>
                                                        <span class="pro_gia"><? $giatien =formatMoney($sanphamkhac[$n]['gia'],0);
                                                        if($sanphamkhac[$n]['loaitien']=='USD')
                                                            echo str_replace(".",",",$giatien);
                                                        else
                                                            echo $giatien;
                                                        ?></span>
                                                        <? if($sanphamkhac[$n]['loaitien']=='USD') echo $sanphamkhac[$n]['loaitien']; else echo 'đ';?>
                                                    </td>
                                                </tr>
                                                <tr><td>Lượt xem:</td><td><b><?=$sanphamkhac[$n]['opt'];?></b></td></tr>
                                                <tr><td>Phản hồi:</td><td><b><?=$sanphamkhac[$n]['comments'];?></b></td></tr>
                                                <tr>
                                                    <td colspan="2" align="center" valign="bottom" height="90">
                                                        <a href="<?=sys_link('com=home&target=main&category='.$sanphamkhac[$n]['category'].'&detail='.$sanphamkhac[$n]['id']);?>"><div class="xemchitiet_bt" style="width:100px;">Xem chi tiết</div></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>					
                                <? } } ?>
                            </table>
                        </div>
                    </div>
                </div>
                
				<? if(count($sms)>0){?>
                <div class="phanhoi">
                    <div class="phanhoi_header">
                        &nbsp;&nbsp;&nbsp;Phản hồi
                    </div>
                    <div class="phanhoi_form">
                        <table width="100%" cellspacing="2">
                            <? for($i=0;$i<count($sms);$i++){?>
                                <tr>
                                    <td valign="top" width="60">
                                        <? 	if($sms[$i]['profile_image']){?>
                                            <img src="<?=$sms[$i]['profile_image'];?>" alt="hinhdaidien" width="50" style=" margin:0 5px;" />
                                        <? }else{?>
                                            <div style="border:1px solid #ddd; width:50px; height:50px; display:table; text-align:center; vertical-align:middle; color:#ddd;">Không hình</div>
                                        <? }?>
                                    </td>
                                    <td valign="top">
                                        <font style="color:#3B5998; font-weight:bold; font-size:12px; line-height:15px;">
                                        <? 	if($sms[$i]['fullname'])
                                                echo $sms[$i]['fullname'];
                                            else
                                                echo $sms[$i]['dienthoai'];
                                        ?>
                                        </font><br />
                                        <?=$sms[$i]['contents'];?>
                                    </td>
                                    <td width="120" align="right" style="color:#666; font-size:11px;">
                                        <?=date("H:i \N\g\à\y d-m-Y",$sms[$i]['bydate']);?>
                                    </td>
                                </tr>
                                <tr><td height="10" align="right" colspan="3" style="border-top:1px solid #eef;">&nbsp;</td></tr>
                            <? }?>
                        </table>
                    </div>
                </div>
                <? }?>
                
                <div class="phanhoi">
                    <div class="phanhoi_header">
                        &nbsp;&nbsp;&nbsp;Gửi phản hồi
                    </div>
                    <div class="phanhoi_form">
                        <form action="" enctype="multipart/form-data" method="post">
                        <table>
                            <tr>
                                <td>Điện thoại</td>
                                <td>
                                    <input type="text" name="dienthoai" id="dienthoai" value="<?=$yourdt[0]['phone'];?>" class="phanhoi_input" />
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>
                                    <input type="text" name="email" id="email" value="<?=$yourdt[0]['email'];?>" class="phanhoi_input" />
                                </td>
                            </tr>
                            <tr>
                                <td>Nội dung</td>
                                <td>
                                    <textarea name="noidung" id="noidung" class="phanhoi_input" style="width:350px; height:150px; padding:5px; line-height:18px;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Ký tự ngẫu nhiên</td>
                                <td>
                                    <input type="text" name="verification" id="verification" class="phanhoi_input" style=" float:left; width:99px;" />
                                    <div style="width:99px; background:#fff; height:25px; float:left;margin:5px 0px 5px 10px;">
                                        <img src="<?=$config['url']?>security.php" width="90" height="24" />
                                    </div>
                                    <input type="submit" name="nutgui" id="nutgui" value=" Gửi " class="phanhoi_send" />
                                </td>
                            </tr>
                        </table> 
                        </form>
                    </div>
                </div>
						
			</div>
        </td>
		<td valign="top" align="right">
		<!--CỘT PHẢI-->
		<?=sys_option('home','main','right');?>
		</td>
       </tr>
     </table>
	</div>
</div>


<div class="bgxacnhan popuplink" id="chiaselink_0">
	<div class="popupxacnhan">
		<div style="width:450px; height:auto;" class="regbox regbox_corner_top regbox_corner_bottom">
			<div class="regbox_header regbox_corner_top" style="width:450px; text-align:left;">
				<b>Chia sẽ link với các mạng xã hội</b>
			</div>
			<div class="regbox_cont" id="noidungxoa" style="height:250px; background:#fff;">
				<br />
				Bạn có thể link sản phẩm đến các trang sau :
				<div class="login">
					<div class="wrap-login">
						<div class="xalomuaban" style="margin-right:0px; margin-left:10px;">
							<a href="http://www.facebook.com/sharer/sharer.php?u=<?=sys_link('com=home&target=main&category='.$sanpham[0]['category'].'&detail='.$sanpham[0]['id']);?>&t=<?=$sanpham[0]['title'];?>" target="_blank" class="lg-face">Facebook</a>
						</div>
						<div class="xalomuaban">
							<a href="http://link.apps.zing.vn/share?url=<?=sys_link('com=home&target=main&category='.$sanpham[0]['category'].'&detail='.$sanpham[0]['id']);?>" target="_blank" class="lg-zing">Zing</a>
						</div>
						<div class="xalomuaban">
							<a href="https://plus.google.com/share?url=<?=sys_link('com=home&target=main&category='.$sanpham[0]['category'].'&detail='.$sanpham[0]['id']);?>&hl=vi" target="_blank" class="lg-google">Google</a>
						</div>
						<div class="xalomuaban">
							<a href="https://twitter.com/intent/tweet?url=<?=sys_link('com=home&target=main&category='.$sanpham[0]['category'].'&detail='.$sanpham[0]['id']);?>&text=<?=$sanpham[0]['title'];?>" target="_blank" class="lg-twitter">Twitter</a>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				hoặc copy đường link sau đây  và dán vào các trang cá nhân của bạn: <br />
				<input class="tcninput copylink" value="<?=sys_link('com=home&target=main&category='.$id['category'].'&detail='.$id['detail']);?>" style="margin-top:10px; width:80%;" /><br /><br />
			
			</div>
			<div class="regbox_footer regbox_corner_bottom"><input type="button" name="nuthuyxoa" class="newuser_button donglaibt" value=" Đóng lại " style="display: inline;"  rel="0" /></div>
		</div>
	</div>
</div>