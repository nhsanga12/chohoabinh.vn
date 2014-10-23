$(document).ready(function(){
	
	$('#khuvuc').selectbox();
	$('#giasearch').selectbox();
	$('#thoigiandang').selectbox();
	
	
	//auto load page
	$(window).scroll(function(){
		var stops = $("#stop").val();
		if  ($(window).scrollTop() >= $(document).height() - $(window).height() - 200 && stops == '0'){
		   	loadmoredata('http://xalomuaban.com/');
		
		}else if($(window).scrollTop() >= $(document).height() - $(window).height() - 200 && stops == '8'){
			loadmorepro('http://xalomuaban.com/');
		
		}else{
			var stops = 123;
		}
	});
	
	
	//Calender
	$(".trickercalender").click(function(){
		$('#calenderbox').stop(true, true).css('display', 'block');
		$('#calenderbox').stop(true, true).fadeIn(1500);
		var ids = $(this).attr("rel");
		var teno = $(this).html();
		var vitri = teno.replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g,'');
		$("#tenvitri").html(vitri);
		$('#vitribanner option:selected').attr("selected",false);
		$('#vitribanner option').each(function () {
			str = $(this).val();
			if(vitri==$(this).val())
			$(this).attr("selected","selected");
      	});
		LoadCalender(ids,'','');
	});
	$("#closecalender").click(function(){
		$('#calenderbox').stop(true, true).fadeOut(1500);
		$('#calenderbox').stop(true, true).css('display', 'none');
	});
	$("#closecalender2").click(function(){
		$('#calenderbox').stop(true, true).fadeOut(1500);
		$('#calenderbox').stop(true, true).css('display', 'none');
	});
	
	
	// PIN
	$(".pinact").click(function(){
		var ids = $(this).attr("rel");
		var blocks = $(this).attr("rev");
		$('.pin_data').stop(true, true).fadeOut(500);
		$('#pin_data_'+blocks).stop(true, true).css('display', 'block');
		$('#pin_data_'+blocks).stop(true, true).fadeIn(2500);
		
		var tenmang = $('#pinnames_'+ids).val();
		$('#tenmang_'+blocks).html(tenmang);
	});
	
	
	$(".hinhthuctt").change(function(){
		$('.huongdanmuahang').stop(true, true).css('display', 'block');
		$('.huongdanmuahang').fadeIn(2500);
	});
	
	
	$(".chonngayup").click(function(){
		var ids = $(this).attr("rel");
		var checked = $('#thu'+ids).prop("checked");
		//alert(checked);
		if(checked)
			$('#thu'+ids).prop("checked",false);
		else
			$('#thu'+ids).attr("checked",true);
	});
	
	$(".sharelink").click(function(){
		var ids = $(this).attr("rel");
		$('#chiaselink_'+ids).stop(true, true).css('display', 'block');
		$('#chiaselink_'+ids).stop(true, true).fadeIn(1500);
	});
	
	$(".copylink").click(function(){
		this.select();
	});
	
	$(".donglaibt").click(function(){
		var ids = $(this).attr("rel");
		$('#chiaselink_'+ids).stop(true, true).fadeOut(1500);
		$('#chiaselink_'+ids).stop(true, true).css('display', 'none');
	});
	

	$(".title_sms").click(function(){
		var ids = $(this).attr("rel");
		var strs = '<br />';
		var tieudesp = $("#tieudesp_"+ids).html();
		var noidungsp = $("#smscont_"+ids).html();
		var lienket = $("#linktraloi").attr("href");
		strs += '<b>'+tieudesp + "</b><br />";
		strs += noidungsp + "<br />";
		$("#tieudetin").html("<b>Nội dung chi tiết tin</b>");
		$("#noidungxoa").css("text-align","left");
		$("#noidungxoa").css("padding-left","20px");
		$('#nutxoangay_smg').attr("rel",ids);
		$("#traloi_smg").attr("href",lienket);
		$('#xacnhanxoa').stop(true, true).css('display', 'block');
		$('#xacnhanxoa').stop(true, true).fadeIn(1500);
		$('#noidungxoa').html(strs);
	});
	
	$(".nutxoasp").click(function(){
		var ids = $(this).attr("rel");
		var tys = $(this).attr("rev");
		var strs = '';
		var tieudesp = $("#tieudesp_"+ids).html();
		
		if(tys=='smg'){
			$("#tieudetin").html("<b>Xác nhận xóa tin nhắn</b>");
			strs += "<p>Bạn sẽ xóa tin nhắn này ?</p>";
			strs += '<b>'+tieudesp + "</b><br />";
			$('#nutxoangay_smg').attr("rel",ids);
		
		}else{
			var hinhsp = $("#hinhsp_"+ids).attr("src");
			var giasp = $("#giasp_"+ids).html();
			strs += "<p>Bạn sẽ xóa sản phẩm này ?</p>";
			strs += tieudesp + "<br />";
			strs += "<img src='" + hinhsp + "' class='thumlist' width='100' /><br /><br />";
			strs += "Giá:<span class='pro_gia2'>" + giasp + "</span> đ";
			$('#nutxoangay').attr("rel",ids);
		}
		
		$('#xacnhanxoa').stop(true, true).css('display', 'block');
		$('#xacnhanxoa').stop(true, true).fadeIn(1500);
		$('#noidungxoa').html(strs);
		
	});
	$("#nuthuyxoa").click(function(){
		$('#xacnhanxoa').stop(true, true).fadeOut();
		$('#xacnhanxoa').stop(true, true).css('display', 'none');
	});
	$("#nutxoangay").click(function(){
		var ids = $(this).attr("rel");
		$('#xacnhanxoa').stop(true, true).fadeOut(500);
		$('#xacnhanxoa').stop(true, true).css('display', 'none');
		$('#dongsp_'+ids).stop(true, true).fadeOut(1000);
		del_art(ids);	
	});
	
	$("#nutxoangay_smg").click(function(){
		var ids = $(this).attr("rel");
		$('#xacnhanxoa').stop(true, true).fadeOut(500);
		$('#xacnhanxoa').stop(true, true).css('display', 'none');
		$('#dongsp_'+ids).stop(true, true).fadeOut(1000);
		del_smg(ids);	
	});
	
	$("#nutxoabanner").click(function(){
		var ids = $(this).attr("rel");
		$('#xacnhanxoa').stop(true, true).fadeOut(500);
		$('#xacnhanxoa').stop(true, true).css('display', 'none');
		$('#dongsp_'+ids).stop(true, true).fadeOut(1000);
		del_banner(ids);	
	});
	$("#ngungbanner").click(function(){
		var ids = $(this).attr("rel");
		$('#xacnhanxoa').stop(true, true).fadeOut(500);
		$('#xacnhanxoa').stop(true, true).css('display', 'none');
		stop_banner(ids);
	});
	$("#batbanner").click(function(){
		var ids = $(this).attr("rel");
		$('#xacnhanxoa').stop(true, true).fadeOut(500);
		$('#xacnhanxoa').stop(true, true).css('display', 'none');
		play_banner(ids);	
	});
	$(".nutxoabanner").click(function(){
		var ids = $(this).attr("rel");
		var tys = $(this).attr("rev");
		var strs = '';
		var tieudesp = $("#tieudesp_"+ids).html();
		var hinhsp = $("#hinhsp_"+ids).attr("src");
		
		if(tys=='ngung'){
			$("#tieudetin").html("<b>Xác nhận ngưng chạy Banner - sản phẩm VIP</b>");
			strs += "<p>Bạn sẽ ngưng Banner - sản phẩm VIP này ?</p>";
			strs += '<b>'+tieudesp + "</b><br />";
			strs += "<img src='" + hinhsp + "' class='thumlist' width='100' /><br /><br />";
			strs += "<p>Banner - sản phẩm VIP này sẽ tạm thời không hiển thị trên trang web</p>";
			$('#ngungbanner').attr("rel",ids);
			$('#nutxoabanner').stop(true, true).css('display', 'none');
			$('#batbanner').stop(true, true).css('display', 'none');
			$('#ngungbanner').stop(true, true).css('display', 'inline');
		
		}else if(tys=='bat'){
			$("#tieudetin").html("<b>Xác nhận bật Banner - sản phẩm VIP</b>");
			strs += "<p>Bạn sẽ cho chạy lại Banner - sản phẩm VIP này ?</p>";
			strs += '<b>'+tieudesp + "</b><br />";
			strs += "<img src='" + hinhsp + "' class='thumlist' width='100' /><br /><br />";
			strs += "<p>Banner - sản phẩm VIP này sẽ được tính phí sau khi bật lên</p>";
			$('#batbanner').attr("rel",ids);
			$('#nutxoabanner').stop(true, true).css('display', 'none');
			$('#ngungbanner').stop(true, true).css('display', 'none');
			$('#batbanner').stop(true, true).css('display', 'inline');
		
		}else{
			$("#tieudetin").html("<b>Xác nhận xóa Banner - sản phẩm VIP</b>");
			strs += "<p>Bạn sẽ xóa Banner - sản phẩm VIP này ?</p>";
			strs += '<b>'+tieudesp + "</b><br />";
			strs += "<img src='" + hinhsp + "' class='thumlist' width='100' /><br /><br />";
			strs += "<p>Banner - sản phẩm VIP này sẽ <b class=\"red\">bị xóa vĩnh viễn</b> trên trang web</p>";
			$('#nutxoabanner').attr("rel",ids);
			$('#nutxoabanner').stop(true, true).css('display', 'inline');
			$('#ngungbanner').stop(true, true).css('display', 'none');
			$('#batbanner').stop(true, true).css('display', 'none');
			
		}
		
		$('#xacnhanxoa').stop(true, true).css('display', 'block');
		$('#xacnhanxoa').stop(true, true).fadeIn(1500);
		$('#noidungxoa').html(strs);
		
	});
	
	$(".link_tab").click(function(){
		var altval = $(this).attr("rel");
			$('.link_tab').stop(true, true).removeClass("active_tab");
			$(this).stop(true, true).addClass("active_tab");
		var idm = '#'+altval;
		$('.spcolum').stop(true, true).fadeOut();
		$('.spcolum').stop(true, true).css('display', 'none');
		$(idm).stop(true, true).fadeIn(1500);
    });
	
	
	$("#nuttieptuc1").click(function(){
		var altval = $(this).attr("rel");
		var nexttab = parseInt(altval) + 1;
		
		$('#newuser_'+altval).stop(true, true).fadeOut();
		$('#newuser_'+altval).stop(true, true).css('display', 'none');
		
		$('#newuser_'+nexttab).stop(true, true).css('display', 'block');
		$('#newuser_'+nexttab).stop(true, true).fadeIn(1500);
		
		$(this).attr("rel",nexttab);
		if(nexttab==2)
			$('#nutquaylai').stop(true, true).css('display', 'block');
		else
			$('#nutquaylai').stop(true, true).css('display', 'none');
		if(nexttab==2){
			$(this).stop(true, true).css('display', 'none');
			$('#nutluulai').stop(true, true).css('display', 'inline');
		}
		if(nexttab==3){
			$(this).stop(true, true).css('display', 'none');
			$('#nutluulai').stop(true, true).css('display', 'none');
		}
		$('.yarnlet').stop(true, true).removeClass("yarnlet_now");
		$('.left-yarn').stop(true, true).css('background-position', '0 0');
		$('#yarnlet_'+nexttab).stop(true, true).addClass("yarnlet_now");
		
	});
	
	$("#nutquaylai").click(function(){
		$('#newuser_2').stop(true, true).fadeOut();
		$('#newuser_2').stop(true, true).css('display', 'none');
		$('#newuser_1').stop(true, true).css('display', 'block');
		$('#newuser_1').stop(true, true).fadeIn(1500);
		$('.yarnlet').stop(true, true).removeClass("yarnlet_now");
		$('.left-yarn').stop(true, true).css('background-position', '0 -48px');
		$('#yarnlet_1').stop(true, true).addClass("yarnlet_now");
		$('#nuttieptuc').attr("rel",'1');
		
		$('#nutquaylai').stop(true, true).css('display', 'none');
		$('#nuttieptuc').stop(true, true).css('display', 'inline');
		$('#nutluulai').stop(true, true).css('display', 'none');
	});
	
	$("#nuttieptuc").click(function(){
		var altval = $(this).attr("key");
		if(altval == 'xalomuaban' ){
			$('#newuser_1').stop(true, true).fadeOut();
			$('#newuser_1').stop(true, true).css('display', 'none');
			$('#newuser_2').stop(true, true).css('display', 'block');
			$('#newuser_2').stop(true, true).fadeIn(1500);
			$('.yarnlet').stop(true, true).removeClass("yarnlet_now");
			$('.left-yarn').stop(true, true).css('background-position', '0 0');
			$('#yarnlet_2').stop(true, true).addClass("yarnlet_now");
			$('#nuttieptuc').attr("rel",'2');
			
			$('#nutquaylai').stop(true, true).css('display', 'block');
			$('#nuttieptuc').stop(true, true).css('display', 'none');
			$('#nutluulai').stop(true, true).css('display', 'inline');
		}
	});
	
	
	$("#nutluulai").click(function(){
		var user 	= $('#usersname').val();
		var pass 	= $('#password').val();
		var hoten 	= $('#fullname').val();
		var tel 	= $('#phone').val();
		var email 	= $('#email').val();
		var dc 		= $('#address').val();
		$(".loading112").stop(true, true).css('display', 'block');
		$.ajax({
		  type: "POST",
		  url: "http://xalomuaban.com/include/ajaxfunction/adduser.php",
		  data: { user:user,pass:pass,hoten:hoten,tel:tel,email:email,dc:dc  }
		}).done(function( msg ) {
			if(msg = 'success'){
				$(".jquery_ms").stop(true, true).html(msg);
				$(".jquery_ms").stop(true, true).fadeOut(2500,function(){ succes(); });
				
			}else{
				$(".jquery_ms").stop(true, true).html(msg);
				$(".jquery_ms").stop(true, true).fadeOut(2500);
			}
			$(".loading112").stop(true, true).css('display', 'none');
		});	
					
	});
	
	$("#phone").focusout(function(){
		var altval = $(this).val();
		if(!($.isNumeric(altval)) && altval!=''){
			$(".jquery_ms").stop(true, true).css('display', 'block');
			$(".jquery_ms").stop(true, true).html(" Điện thoại phải là số ");
			$(".jquery_ms").stop(true, true).fadeOut(2500);
			$(this).focus();
		}
	});
	
	$("#email").focusout(function(){
		var altval = $(this).val();
		if(altval.match(/^[0-9A-Za-z]+[0-9A-Za-z_.]*@[\w\d.]+.\w{2,4}$/) || altval==''){
			$(".jquery_ms").stop(true, true).css('display', 'none');
			
		}else{
			$(".jquery_ms").stop(true, true).css('display', 'block');
			$(".jquery_ms").stop(true, true).html(" Email không chính xác ");
			$(".jquery_ms").stop(true, true).fadeOut(2500);
			$(this).focus();
		}
	});	
	
	
	$("#usersname").keyup(function(){
		var altval = $(this).val();
		checkuser(altval);						   
	});	
	$("#password, #repassword").keyup(function(){
		checkpass();					   
	});	
	
	$("#loaisanpham1, #loaisanpham2").change(function(){
		var ids = $(this).attr("rel");
		var vals = $(this).val();
		changselect(ids,vals);
	});
	
	$("#muahangngay").click(function(){
		var ids = $(this).attr("rel");
		var slm = $("#soluongmua").val();
		var hinhthuc = $("#hinhthuctt").val();
		if(slm == 'Số lượng mua:1')
			slm = 1;
		savecart(ids,slm,hinhthuc);						   
	});
	
	
	$("#huygiohang").click(function(){
		cancelcart();					   
	});
	
	$(".removeitem").click(function(){
		var ids = $(this).attr("id");
		var vals = $("#in"+ids).val();
		remove_items(vals);
	});
	
	$("#thanhtoan").click(function(){
		$('#xacnhanxoa').stop(true, true).css('display', 'block');
		$('#xacnhanxoa').stop(true, true).fadeIn(1500);
	});
	
	$("#nutmuahang").click(function(){
		cart_order();
		
	});
	$(".sluong").change(function(){
		var ids = $(this).attr("rel");
		var newamount = $(this).val();
		update_cart(ids,newamount);
	});
	
	$("#touser").autocomplete({
		  source:"http://xalomuaban.com/include/ajaxfunction/search.php",
		  minLength: 2,
		  select: function( event, ui ) {
		   $("#idnguoinhan").val(ui.item.id);
		  }
    });
	
	         
});

function update_cart(ids,newamount){
	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/cart.php",
	  data: { action:'update',ids:ids,newamount:newamount}
	}).done(function( msg ) {
		if(msg!=''){
			$(".jquery_ms").stop(true, true).css('display', 'block');
			$(".jquery_ms").stop(true, true).html(msg);
			$(".jquery_ms").stop(true, true).fadeOut(1500,function(){location.reload();});
		}
	});	
}

function cart_order(){
	var fullname,phone,email,address,description;
		fullname 	= $("#fullname").val();
		phone 		= $("#phone").val();
		email 		= $("#email").val();
		address 	= $("#address").val();
		hoadon 		= $("#hoadon").val();
		description = $("#description").val();	
	
	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/cart.php",
	  data: { action:'save',fullname:fullname,phone:phone,email:email,address:address,description:description,hoadon:hoadon}
	}).done(function( msg ) {
		if(msg!=''){
			$('#xacnhanxoa').stop(true, true).fadeOut(500);
			$('#xacnhanxoa').stop(true, true).css('display', 'none');
			$(".jquery_ms").stop(true, true).css('display', 'block');
			$(".jquery_ms").stop(true, true).html('Đơn hàng của bạn đã được gửi');
			$(".jquery_ms").stop(true, true).fadeOut(1500,function(){location.reload();});
		}
		
	});	
}

function remove_items(ids){
	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/cart.php",
	  data: { action:'remove',ids:ids}
	}).done(function( msg ) {
		if(msg!=''){
			$(".jquery_ms").stop(true, true).css('display', 'block');
			$(".jquery_ms").stop(true, true).html('Đã loại bỏ sản phẩm:'+msg);
			$(".jquery_ms").stop(true, true).fadeOut(1500,function(){location.reload();});
		}
		
	});	
}

function cancelcart(){
	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/cart.php",
	  data: { action:'cancel'}
	}).done(function( msg ) {
		if(msg=='done'){
			$('.tb_pro').fadeOut(1000,function(){
				$('.tongtien').html('<div class="giotrong">Giỏ hàng trống !</div>');
											   });
		}
		
	});	
}

function savecart(ids,slm,hinhthuc){
	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/cart.php",
	  data: { action:'add', ids:ids, slm:slm, hinhthuc:hinhthuc  }
	}).done(function( msg ) {
		if(msg!=''){
			$('#soluonghang').html(msg);
			$(".jquery_ms").stop(true, true).css('display', 'block');
			$(".jquery_ms").stop(true, true).html('Đã thêm sản phẩm vào giỏ hàng.');
			$(".jquery_ms").stop(true, true).fadeOut(2500);
		}
	});	
}

function checkuser(altval){	
  	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/checkuser.php",
	  data: { username:altval}
	}).done(function( msg ) {
		if(msg!='Tên truy cập hợp lệ.'){
			$('#kqcheck_usersname').css('color', '#f00');
		}else{
			$('#kqcheck_usersname').css('color', '#336633');
		}
		$('#kqcheck_usersname').html(msg);
		
		var pnote = $('#kqcheck_password').html();
		
		if(pnote=='Mật khẩu hợp lệ.' && msg == 'Tên truy cập hợp lệ.'){
			$('#nuttieptuc').css('color', '#333');
			$('#nuttieptuc').attr("key",'xalomuaban');
		}else{
			$('#nuttieptuc').css('color', '#777');
			$('#nuttieptuc').attr("key",'');
		}
		
	});	
}

function checkpass(){
	var pass = $('#password').val();
	var repass = $('#repassword').val();
	var leng = pass.length;
	$('#kqcheck_password').css('color', '#f00');
	var checw = pass.match(/[a-zA-Z]/);
	var checd = pass.match(/[0-9]/);
	
	if(leng<6 || checw == null || checd == null)
		$('#kqcheck_password').html('Mật khẩu phải: > 6 ký tự, gồm chữ và số');
	else
		$.ajax({
		  type: "POST",
		  url: "http://xalomuaban.com/include/ajaxfunction/checkpass.php",
		  data: { pass:pass, repass:repass  }
		}).done(function( msg ) {
			if(msg!='Mật khẩu hợp lệ.' && msg!='Mật khẩu hợp lệ'){
				$('#kqcheck_password').css('color', '#f00');
			}else{
				$('#kqcheck_password').css('color', '#336633');
				
			}
			$('#kqcheck_password').html(msg);
			
			var unote = $('#kqcheck_usersname').html();
			
			if(msg=='Mật khẩu hợp lệ.' && unote == 'Tên truy cập hợp lệ.'){
				$('#nuttieptuc').css('color', '#333');
				$('#nuttieptuc').attr("key",'xalomuaban');
			}else{
				$('#nuttieptuc').css('color', '#777');
				$('#nuttieptuc').attr("key",'');
			}
		
	});	
}
function checkpassuser(){
}

function succes(){
	$('#newuser_2').stop(true, true).fadeOut();
	$('#newuser_2').stop(true, true).css('display', 'none');
	$('#newuser_3').stop(true, true).css('display', 'block');
	$('#newuser_3').stop(true, true).fadeIn(1500);
	$('.yarnlet').stop(true, true).removeClass("yarnlet_now");
	$('.left-yarn').stop(true, true).css('background-position', '0 0');
	$('#yarnlet_3').stop(true, true).addClass("yarnlet_now");
	
	$('#nutquaylai').stop(true, true).css('display', 'none');
	$('#nuttieptuc').stop(true, true).css('display', 'none');
	$('#nutluulai').stop(true, true).css('display', 'none');	
}

function changselect(ids,vals){
  	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/changselect.php",
	  dataType: "html",
      async: false,
	  data: { ids:ids, cat:vals }
	}).done(function( msg ) {
		$('#loaisanpham'+ids).html(msg);
	});	
}
function del_art(ids){
	var func = 'xoa';
  	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/articles_detail.php",
	  data: { func:func, ids:ids }
	}).done(function( msg ) {
		$(".jquery_ms").stop(true, true).html('Đã xóa sản phẩm.');
		$(".jquery_ms").stop(true, true).css("display","block");
		$(".jquery_ms").stop(true, true).fadeOut(2500);
	});	
}

function del_smg(ids){
	var func = 'xoasmg';
  	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/articles_detail.php",
	  data: { func:func, ids:ids }
	}).done(function( msg ) {
		$(".jquery_ms").stop(true, true).html('Đã xóa tin nhắn.');
		$(".jquery_ms").stop(true, true).css("display","block");
		$(".jquery_ms").stop(true, true).fadeOut(2500);
	});	
}

function del_banner(ids){
	var func = 'xoa';
  	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/banner.php",
	  data: { func:func, ids:ids }
	}).done(function( msg ) {
		$(".jquery_ms").stop(true, true).html('Đã xóa banner - sản phẩm VIP.');
		$(".jquery_ms").stop(true, true).fadeOut(2500);
	});	
}

function stop_banner(ids){
	var func = 'ngung';
  	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/banner.php",
	  data: { func:func, ids:ids }
	}).done(function( msg ) {
		$(".jquery_ms").stop(true, true).html('Đã xóa banner - sản phẩm VIP.');
		$(".jquery_ms").stop(true, true).fadeOut(2500);
		location.reload();
	});	
}
function play_banner(ids){
	var func = 'bat';
  	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/banner.php",
	  data: { func:func, ids:ids }
	}).done(function( msg ) {
		if(msg == 'khongthebat'){
			$(".jquery_ms").stop(true, true).html('Vị trí này đã có người đăng nên không thể bật lại.');
			$(".jquery_ms").stop(true, true).css("display","block");
			$(".jquery_ms").stop(true, true).fadeOut(8500);
		}else{
			$(".jquery_ms").stop(true, true).html('Đã bật banner - sản phẩm VIP.');
			$(".jquery_ms").stop(true, true).css("display","block");
			$(".jquery_ms").stop(true, true).fadeOut(2500);
			location.reload();
		}
	});	
}

function change_vitri(){
	var teno = $("#vitribanner").val();
	$("#tenvitri").html(teno);
	LoadCalender(teno,'','');
}
function change_imgs(){
	var ids = $("#tieudesp option:selected").val();
	$(".thumlist").stop(true, true).css("display","none");
	$("#imgs_"+ids).stop(true, true).css("display","block");
}

function LoadCalender(ids,thang,nam){
  	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/calender.php",
	  data: { ids:ids,thang:thang,nam:nam }
	}).done(function( msg ) {
		$("#noidunglich").html(msg);
	});
	// Chinh lai kich thuoc
	var winH = $(window).height();
	//var popupH = $("#calenderbox").height();
	//var ptop = parseInt(winH) - parseInt(popupH);
	//ptop = parseInt(ptop*40/100);
	if(parseInt(winH)>900)
	 $(".popupxacnhan").css("margin-top","10%");
	else
	 $(".popupxacnhan").css("margin-top","1px");
}
function hinhthucdat(){
	var giatri = $("#hinhthucs").val();
	$('.hinhthucval').stop(true, true).css('display', 'none');
	$("#hinhthuc_"+giatri).stop(true, true).fadeIn(1000);
	$("#htten_"+giatri).stop(true, true).fadeIn(1000);
		
}


function getchoice(ngay,thang,nam){
	var vitri = $("#vitridien").val();
	var ngaythang = ngay+"-"+thang+"-"+nam;
	var idform,idto,idm01,idm02;
	if(vitri==0){
		idform = "tungay";
		idto = "denngay";
		idm01 = "mieuta01";
		idm02 = "mieuta02";
		$("#vitridien").val('1');
	}else{
		idform = "denngay";
		idto = "tungay";
		idm01 = "mieuta02";
		idm02 = "mieuta01";
		$("#vitridien").val('0');
		$(":submit").removeAttr("disabled");
		$("#notesave").html("Có thể lưu lịch lại.");
	}
	$("#calen_"+idform).val(ngaythang);
	$("#dis_"+idform).html(ngaythang);
	$("#dis_"+idform).removeClass("ongaythang_at");
	$("#dis_"+idto).addClass("ongaythang_at");
	$("#"+idm01).html("Chọn lại");
	$("#"+idm02).html("Click chuột vào lịch");
	$("#"+idm01).addClass("blue");
	$("#"+idm01).removeClass("red");
	$("#"+idm02).addClass("red");
	$("#"+idm02).removeClass("blue");
	
}

function rechoice(){
	var vitri = $("#vitridien").val();
	var idform,idto,idm01,idm02;
	if(vitri==0){
		idform = "tungay";
		idto = "denngay";
		idm01 = "mieuta01";
		idm02 = "mieuta02";
		$("#vitridien").val('1');
	}else{
		idform = "denngay";
		idto = "tungay";
		idm01 = "mieuta02";
		idm02 = "mieuta01";
		$("#vitridien").val('0');
	}
	$("#dis_"+idform).removeClass("ongaythang_at");
	$("#dis_"+idto).addClass("ongaythang_at");
	$("#"+idm01).html("Chọn lại");
	$("#"+idm02).html("Click chuột vào lịch để chọn");
	$("#"+idm01).addClass("blue");
	$("#"+idm01).removeClass("red");
	$("#"+idm02).addClass("red");
	$("#"+idm02).removeClass("blue");
}

function loadmoredata(url) 
{
	var trang,trang2,hot,cat;
	trang = $("#trang").val();
	hot = $("#hot").val();
	cat = $("#danhmuc").val();
	$('div#loading').html('<img src="' + url + 'themes/default/images/loading.gif" alt="Loading" border="0" />');	
	trang2 = parseInt(trang) + 1;
	$("#trang").val(trang2);
	
	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/loadmoredata.php",
	  data: { cat:cat,trang:trang,hot:hot}
	}).done(function( msg ) {
		
		$('.newslists').append(msg);
		$('div#loading').empty();
		
		if(msg=='')
		$("#stop").val(1);
	});	
	
}; 

function loadmorepro(url) 
{
	var trang,trang2,cat,price_form,price_to,location,keys,fromdate;
	trang = $("#trang").val();
	trang2 = parseInt(trang) + 1;
	
	cat = $("#danhmuc").val();
	price_form = $("#price_form").val();
	price_to = $("#price_to").val();
	location = $("#location").val();
	keys = $("#keys").val();
	fromdate = $("#fromdate").val();
	
	$('div#loading').html('<img src="' + url + 'themes/default/images/loading.gif" alt="Loading" border="0" />');	
	$("#trang").val(trang2);
	
	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/loadmorepro.php",
	  data: { cat:cat,trang:trang,price_form:price_form,price_to:price_to,location:location,keys:keys,fromdate:fromdate}
	}).done(function( msg ) {
		var dataload = msg.split("noidungketnoi",3);
		
		$('.tb_pro').append(dataload[0]);
		$('.content').append(dataload[1]);
		$('div#loading').empty();
		
		if(msg=='')
		$("#stop").val(1);
	});	
	
};  

