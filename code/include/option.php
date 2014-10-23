<?php 
$khuvuc = array(
	'' => 'Nơi Bán',
	'0' => ' Toàn quốc',
	'1' => ' TP.HCM',
	'15' => ' Hà Nội',
	'10' => ' Cần Thơ',
	'2' => ' An Giang',
	'7' => ' Bình Dương',
	'8' => ' Bình Phước',
	'44' => ' Bình Thuận',
	'6' => ' Bình Định',
	'4' => ' Bạc Liêu',
	'76' => ' Bắc Cạn',
	'3' => ' Bắc Giang',
	'58' => ' Bắc Ninh',
	'5' => ' Bến Tre',
	'28' => ' Biên Hòa',
	'34' => ' Buôn Mê Thuột',
	'35' => ' Cao Bằng',
	'9' => ' Cà Mau',
	'59' => ' Gia Lai',
	'49' => ' Hà Giang',
	'45' => ' Hà Nam',
	'75' => ' Hà Tĩnh',
	'77' => ' Hà Đông',
	'69' => ' Hòa Bình',
	'47' => ' Hạ Long',
	'46' => ' Hải Dương',
	'14' => ' Hải Phòng',
	'42' => ' Hậu Giang',
	'29' => ' Huế',
	'74' => ' Hưng Yên',
	'16' => ' Khánh Hòa',
	'17' => ' Kiên Giang',
	'63' => ' Kontum',
	'48' => ' Lào Cai',
	'18' => ' Lâm Đồng',
	'81' => ' Lạng Sơn',
	'50' => ' Long An',
	'19' => ' Mỹ Tho',
	'43' => ' Nam Định',
	'33' => ' Nghệ An',
	'20' => ' Nha Trang',
	'62' => ' Ninh Bình',
	'68' => ' Ninh Thuận',
	'65' => ' Phú Thọ',
	'37' => ' Phú Yên',
	'53' => ' Quảng Bình',
	'21' => ' Quảng Nam',
	'57' => ' Quảng Ngãi',
	'22' => ' Quảng Ninh',
	'41' => ' Quảng Trị',
	'23' => ' Qui Nhơn',
	'54' => ' Sóc Trăng',
	'82' => ' Sơn La',
	'24' => ' Tây Ninh',
	'36' => ' Thanh Hóa',
	'60' => ' Thái Bình',
	'40' => ' Thái Nguyên',
	'25' => ' Tiền Giang',
	'26' => ' Trà Vinh',
	'51' => ' Tuyên Quang',
	'27' => ' Vũng Tàu',
	'30' => ' Vĩnh Long',
	'83' => ' Vĩnh Phúc',
	'73' => ' Yên Bái',
	'52' => ' Đà Lạt',
	'11' => ' Đà Nẵng',
	'67' => ' Đắc Nông',
	'12' => ' Đồng Nai',
	'13' => ' Đồng Tháp',
);

$makhuvuc = array(
	'Toàn quốc' => '0',
	'TP. Hồ Chí Minh' => '1',
	'Đà Nẵng' => '11',
	'Hà Nội' => '15',
	'Cần Thơ' => '10',
	'Bình Dương' => '7',
	'Đồng Nai' => '12',
	'Khánh Hòa' => '16',
	'An Giang' => '2',
	'Bà Rịa - Vũng Tàu' => '27',
	'Bình Thuận' => '44',
	'Bình Định' => '6',
	'Lai Châu' => '81',
	'Long An' => '50',
);


$giaca = array(
			''	=> 'Chọn giá sản phẩm',
			'0-500000'	=> 'Dưới 500,000',
			'500000-1000000'	=> '500 ngàn - 1 triệu',
			'1000000-3000000'	=> '1 triệu - 3 triệu',
			'3000000-5000000'	=> '3 triệu - 5 triệu',
			'5000000-10000000'	=> 'Hơn 5 triệu',
			);

$thoigian = array(
			''	=> 'Thời gian đăng',
			'1' => 'Trong ngày',
			'3'  => 'Trong vòng 3 ngày',
			'7'  => 'Trong vòng 7 ngày',
			'15' => 'Trong vòng 15 ngày',
			'30' => 'Trong vòng 1 tháng',
			);
			
			
$newuser1 =  array('usersname'	=> 'Tên truy cập',
					'password' 	=> 'Mật khẩu',
					'repassword' => 'Xác nhận mật khẩu',
				);
							
$newuser2 =  array(	'fullname'  => 'Họ và tên',
					'phone'  	=> 'Điện thoại',
					'email' 	=> 'Email',
					'address' 	=> 'Địa chỉ',
				);
				
$khoanthoigian =  array(
							'moc01'  =>  array('00:00','05:59'),
							'moc02'  =>  array('06:00','11:59'),
							'moc03'  =>  array('12:00','17:59'),
							'moc04'  =>  array('18:00','23:59'),
							
				       );
					   
					   
$usesdata = array(
	'tablename' => 'users',
	'fullname' => array(
		'vn' 	=> 'Họ và tên',
		'type' 	=> 'text',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
		'require' => '1',
	),
	 'phone' => array(
		'vn' 	=> 'Điện thoại',
		'type' 	=> 'text',
		'subtabble'=>'detail',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
	 'email' => array(
		'vn' 	=> 'Email',
		'type' 	=> 'text',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
		'require' => '1',
	),
	'address' => array(
		'vn' 	=> 'Địa chỉ',
		'type' 	=> 'text',
		'subtabble'=>'detail',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
	'tengianhang' => array(
		'vn' 	=> 'Tên Shop',
		'type' 	=> 'text',
		'subtabble'=>'detail',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
	'birthday' => array(
		'vn' 	=> 'Ngày sinh',
		'type' 	=> 'date',
		'subtabble'=>'detail',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
	'cmnd' => array(
		'vn' 	=> 'CMND',
		'type' 	=> 'text',
		'subtabble'=>'detail',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
	'description' => array(
		'vn' 	=> 'Thanh toán',
		'type' 	=> 'textarea',
		'subtabble'=>'detail',
		'display' => '1',
		'width' => '600',
		'height' => '100',
		'align' => 'left',
		'textalign' => 'left',
	),
	'profile_image' => array(
		'vn' 	=> 'Ảnh đại diện',
		'type' 	=> 'picture',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
);					   

$makhau = array(
	'password_old' => array(
		'vn' 	=> 'Mật khẩu cũ',
		'type' 	=> 'password',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
	
	'password' => array(
		'vn' 	=> 'Mật khẩu mới',
		'type' 	=> 'password',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
	
	'repassword' => array(
		'vn' 	=> 'Nhập lại mật khẩu mới',
		'type' 	=> 'password',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
);

$banklist = array(
	'1' => array(
			'name' => 'Bảo Kim',
			'fullname' => 'Công thanh toán trực tuyến Bảo Kim',
			'images' => 'baokim.jpg',
			'port'	=> '',
		),
	'2' => array(
			'name' => 'Ngân Lượng',
			'fullname' => 'Công thanh toán trực tuyến Ngân Lượng',
			'images' => 'nganluong.jpg',
			'port'	=> '',
		),
	'3' => array(
			'name' => 'Vietcombank',
			'fullname' => 'Ngân hàng thương mại cổ phần Ngoại thương Việt Nam',
			'images' => 'vietcombank.jpg',
			'port'	=> 'https://www.vietcombank.com.vn/ibanking/',
		),
	'4' => array(
			'name' => 'Viettinbank',
			'fullname' => 'Ngân hàng Công thương Việt Nam',
			'images' => 'viettinbank.jpg',
			'port'	=> 'https://www.vietinbank.vn/ipay/retail/timeout.do',
		),
	
);

$usesbank = array(
	'tablename' => 'users_bank',
	'bankid' => array(
		'vn' 	=> 'Loại tài khoản',
		'type' 	=> 'select',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
	'chinhanh' => array(
		'vn' 	=> 'Chi nhánh',
		'type' 	=> 'text',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
	'chutaikhoan' => array(
		'vn' 	=> 'Tên tài khoản',
		'type' 	=> 'text',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
		'require' => '1',
	),
	'sotaikhoan' => array(
		'vn' 	=> 'Số tài khoản',
		'type' 	=> 'text',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
		'require' => '1',
	),
	'description' => array(
		'vn' 	=> 'Ghi chú',
		'type' 	=> 'textarea',
		'subtabble'=>'detail',
		'display' => '1',
		'width' => '600',
		'height' => '100',
		'align' => 'left',
		'textalign' => 'left',
	),
);

$buysell = array(
	'tablename' => 'users_buysell',
	'fullname' => array(
		'vn' 	=> 'Họ tên',
		'type' 	=> 'text',
		'display' => '1',
		'width' => '200',
		'align' => 'left',
		'textalign' => 'left',
		'require' => '1',
	),
	'phone' => array(
		'vn' 	=> 'Điện thoại',
		'type' 	=> 'text',
		'display' => '1',
		'width' => '200',
		'align' => 'left',
		'textalign' => 'left',
		'require' => '1',
	),
	'email' => array(
		'vn' 	=> 'Email',
		'type' 	=> 'select',
		'display' => '1',
		'width' => '200',
		'align' => 'left',
		'textalign' => 'left',
	),
	'address' => array(
		'vn' 	=> 'Địa chỉ',
		'type' 	=> 'text',
		'display' => '1',
		'width' => '300',
		'align' => 'left',
		'textalign' => 'left',
	),
	'description' => array(
		'vn' 	=> 'Ghi chú',
		'type' 	=> 'textarea',
		'subtabble'=>'detail',
		'display' => '1',
		'width' => '300',
		'height' => '100',
		'align' => 'left',
		'textalign' => 'left',
	),
);

$tinnhan = array(
	'tablename' => 'users_sms',
	'touser' => array(
		'vn' 	=> 'Người nhận',
		'type' 	=> 'text',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
		'require' => '1',
	),
	'title' => array(
		'vn' 	=> 'Tiêu đề',
		'type' 	=> 'text',
		'display' => '1',
		'width' => '280',
		'align' => 'left',
		'textalign' => 'left',
	),
	'contents' => array(
		'vn' 	=> 'Nội dung',
		'type' 	=> 'textarea',
		'display' => '1',
		'width' => '600',
		'height' => '300',
		'align' => 'left',
		'textalign' => 'left',
	),
	

);


$bannergroup = array(
	'vip' => array(
		'vn' 		=> 'Sản phẩm Vip',
		'keydis' 	=> 'VIP',
		'display' 	=> '1',
		'width' 	=> '290',
		'max' 		=> '8',
		'itemcss' 	=> 'float:left;',
	),
	
	'home' => array(
		'vn' 		=> 'Banner <br />trang chủ',
		'keydis' 	=> 'H',
		'display' 	=> '1',
		'max' 		=> '13',
		'itemcss' => 'clear:both;',
	),
	
	'detail' => array(
		'vn' 		=> 'Banner <br />trang trong',
		'keydis' 	=> 'D',
		'display' 	=> '1',
		'max' 		=> '10',
		'itemcss' => 'clear:both;',
	),
	
	'news' => array(
		'vn' 		=> 'Banner <br />tin tức',
		'keydis' 	=> 'N',
		'display' 	=> '1',
		'max' 		=> '10',
		'itemcss' => 'clear:both;',
	),
	

);
 	
?>