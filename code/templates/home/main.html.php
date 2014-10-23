<div class="sitemain">
	<div class="main">
		<? echo sys_option("home","main","header");?>
		
		<div class="content">
		 <?
			$p_cat	=	get_parentid_category($id['category']);
			$pare	=	get_parentid_category($p_cat);
			$countchild	=	count_child_newscat($id['category']);
			
			if($id['detail']!='') 
				$cong	=	'detail';
			else  
				$cong	=	'news';
		
		
			// trang chu
			if($id['category']=='' || $id['category']=='1')
				echo sys_option('home','main','home');
			
			// lien he
			else if($id['category']=='34')
				echo sys_option('news','contact','us');
			
			// giỏ hàng
			else if($id['category']=='81')
				echo sys_option('news','cart','list');	
				
			// san pham thanh vien
			else if($id['category']=='232')
				echo sys_option('news','sanpham','thanhvien');	
			
			// đăng ký
			else if($id['category']=='39')
				echo sys_option('news','new','register');
				
			// đăng nhập
			else if($id['category']=='37')
				echo sys_option('news','log','in');
			
			// đăng nhập tài khoản mạng xã hội
			else if($id['category']=='80')
				echo sys_option('news','social','network');
			
			// đăng xuất
			else if($id['category']=='38')
				echo sys_option('news','log','out');
				
			// trang cá nhân
			else if($id['category']=='62' || $p_cat == '62' || $pare == '62')
				echo sys_option('news','member','manager');
			
			// tim kiem
			else if($id['category']=='51'){
				$id['category']=='2';
				echo sys_option($cong,'san','pham');
			}
			
			// gioi thieu, tin tuc, huong dan
			else if($id['category']=='5' || $p_cat=='14' || $p_cat=='5' || $pare=='14' || $pare=='5')
				echo sys_option($cong,'tin','tuc');
			
			else if($id['category']=='14'){
				echo "<script>window.location='".sys_link('com=home&target=main&category=17')."';</script>";
			}		
			//san pham
			else
				echo sys_option($cong,'san','pham');
		 ?>
		</div>
	</div>
	<? echo sys_option("home","main","footer");?>
</div>