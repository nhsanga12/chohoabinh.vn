function chkall () {
	gid = document.frm.iddetail;
	if (gid != null) {
		z = gid.length;
		if (z == null) gid.checked = document.frm.idall.checked;
		else {
			for (i=0;i<z;i++) {
					gid[i].checked = document.frm.idall.checked;
			}
		}
	}
}
function chkallcol(i) {
	var gid,ckall;
	if(i==1){
		gid = document.frm.iddetail_1;
		ckall = document.frm.idall_1.checked;
	}else if(i==2){
		gid = document.frm.iddetail_2;
		ckall = document.frm.idall_2.checked;
	}
	else if(i==3){
		gid = document.frm.iddetail_3;
		ckall = document.frm.idall_3.checked;
	}
	else if(i==4){
		gid = document.frm.iddetail_4;
		ckall = document.frm.idall_4.checked;
	}
	
	if (gid != null) {
		z = gid.length;
		if (z == null) gid.checked = ckall;
		else {
			for (i=0;i<z;i++) {
					gid[i].checked = ckall;
			}
		}
	}
}

function goBack(){ //quay lại
	window.history.back()
}
function checkeditem() {
	gid = document.frm.iddetail;
	if (gid != null) {
		str = '';
		z = gid.length;
		if (z == null) { if (gid.checked == true) str= gid.value+','; }
		else {
			for (i=0;i<z;i++) {
				if (gid[i].checked == true) str+= gid[i].value+',';
			}
		}
	}
	return str;
}
function cfrm_del(mainurl) {
	chk = checkeditem();
	if (chk == '') {
		alert('Bạn vui lòng chọn ít nhất 1 mẫu tin');
	} else {
		window.location = ''+mainurl+';item:'+chk;
	}
}
function cfrm_save(mainurl) {
	var chk = checkeditem();
	var status = document.getElementById('trangthaixem').value;
	if (chk == '') {
		alert('Bạn vui lòng chọn ít nhất 1 mẫu tin');
	} else {
		window.location = ''+mainurl+';status:'+status+';item:'+chk;
	}
}

function cfrm_move(mainurl) {
	var chk = checkeditem();
	var thumuc = document.getElementById('thumuc').value; alert(thumuc);
	if (chk == '') {
		alert('Bạn vui lòng chọn ít nhất 1 mẫu tin');
	} else {
		window.location = ''+mainurl+';fid:'+thumuc+';item:'+chk;
	}
}

function cfrm_dupple(mainurl) {
	chk = checkeditem();
	if (chk == '') {
		alert('Bạn vui lòng chọn ít nhất 1 mẫu tin');
	} else {
		window.location = ''+mainurl+';item:'+chk;
	}
}
function gotopage(page,url) {
	window.location = url + page;
}
function active(id)
{
	var chiso	=	'edit_'+id;
		if (document.getElementById(chiso).style.display == "none")
			document.getElementById(chiso).style.display="block";
		else 
			document.getElementById(chiso).style.display="none";
}
function retext(id)
{
	var chiso1	=	'new_'+id;
	var chiso2	=	'old_'+id;
		if (document.getElementById(chiso1).style.display == "none"){
			document.getElementById(chiso1).style.display="block";
			document.getElementById(chiso2).style.display="none";
		}
		else {
			document.getElementById(chiso1).style.display="none";
			document.getElementById(chiso2).style.display="block";
		}	
}
function mactive(j,c)// active 1 id trong nhóm id text_j, c là tổng id của nhóm
{
	var id,idj;
	idj	=	"nhom_"+j;
	for (i=0;i<=c;i++) {
		id	= "nhom_"+i;
		if (id == idj)
			document.getElementById(id).style.display="block";
		else 
			document.getElementById(id).style.display="none";
	}

}
function getnewcat()
{
	//$("#testthu").load('http://localhost/sim/capnhat/language/getcate.php');
	var grpid;
	grpid = document.getElementById('groupid').value;
	
	$.ajax({
	  type: "POST",
	  url: "language/getcate.php",
	  data: { grpid: grpid}
	}).done(function( msg ) {
	 	$("#testthu").html(msg);
	});
	
}


function update_cate(cid,cfield)
{
	var gt,clo;
	gt = document.getElementById(''+cfield+'_'+cid).value;
	
	if(gt==1)
		clo = '#f00';
	else if(gt==2)
		clo = '#039';
	else
		clo = '#f00';
	
	$(".jquery_ms").ajaxSend(function(e,xhr,opt){
		$(this).css('display', 'block');
		$(this).html("Đang cập nhật danh mục ...");
	  });
	
	$.ajax({
	  type: "POST",
	  url: "language/update_cate.php",
	  data: { cfield:cfield, values:gt, cid:cid }
	}).done(function( msg ) {
	 	$('#'+cfield+'_'+cid).css('color', clo);
		$(".jquery_ms").stop(true, true).html("Đã cập nhật xong danh mục !!");
		$(".jquery_ms").stop(true, true).fadeOut(2500);
		
	});
	
}

function update_art(aid,afield,tb_detail)
{
	var gt,clo;
	gt = document.getElementById(''+afield+'_'+aid).value;
	
	if(gt==1)
		clo = '#f00';
	else if(gt==2)
		clo = '#039';
	else if(gt==3)
		clo = '#090';
	else
		clo = '#f00';
		
	if(tb_detail!='') tb_detail="_detail";
	
	$(".jquery_ms").ajaxSend(function(e,xhr,opt){
		$(this).css('display', 'block');
		$(this).html("Đang cập nhật bài viết ...");
	  });
	
	$.ajax({
	  type: "POST",
	  url: "language/update_art.php",
	  data: { afield:afield, values:gt, aid:aid, tb_detail:tb_detail }
	}).done(function( msg ) {
	 	$('#'+afield+'_'+aid).css('color', clo);
		$(".jquery_ms").stop(true, true).html("Đã cập nhật xong bài viết !!");
		$(".jquery_ms").stop(true, true).fadeOut(2500);
		
	});
	
}

function save_thumnail()
{
	var x01,y01,ww,hh,fname;
	x01 = $("#x1").val();
	y01 = $("#y1").val();
	ww = $("#w").val();
	hh = $("#h").val();
	fname = $("#save_thumnails").attr("rel");
	if(x01!='' && y01!='' && ww!='' && hh!='' && fname!=''){
		$(".jquery_ms").ajaxSend(function(e,xhr,opt){
			$(this).css('display', 'block');
			$(this).html("Đang xử lý hình ...");
		  });
		
		$.ajax({
		  type: "POST",
		  url: "language/savethumnail.php",
		  data: { x01:x01, y01:y01, ww:ww, hh:hh,fname:fname }
		}).done(function( msg ) {
			$(".jquery_ms").stop(true, true).html("Đã xử lý hình xong !!");
			$('#ketquathum').html("<img src='../lib/articles/thums_" + fname + "' width='150' style='margin:0px 5px;' id='newthums' /><br />Kết quả:<br />");
			return reloadImg('newthums');
			$(".jquery_ms").stop(true, true).fadeOut();
			window.location.reload();
			
		});
	
	}else{
		alert('Rê và kéo chuột trên hình bên trái để chọn vùng cần cắt.');
	}
	
}

function savethumtemp($link){
	var x01,y01,ww,hh,fname;
	x01 = $("#x1").val();
	y01 = $("#y1").val();
	ww = $("#w").val();
	hh = $("#h").val();
	fname = $("#save_thumnails").attr("rel");
	
	if(x01!='' && y01!='' && ww!='' && hh!='' && fname!=''){
		$(".jquery_ms").ajaxSend(function(e,xhr,opt){
			$(this).css('display', 'block');
			$(this).html("Đang xử lý hình ...");
		  });
		
		$.ajax({
		  type: "POST",
		  url: "language/savethumnail.php",
		  data: { x01:x01, y01:y01, ww:ww, hh:hh,fname:fname }
		}).done(function( msg ) {
			$(".jquery_ms").stop(true, true).html("Đã xử lý hình xong !!");
			$(".jquery_ms").stop(true, true).fadeOut(2500,function(){
				$('#ketquathum').html("<img src='../lib/articles/thums_" + fname + "' width='150' style='margin:0px 5px;' id='newthums' /><br />Kết quả<br />");
				return reloadImg('newthums');							   	
			});
			
		});
	
	}else{
		alert('Rê và kéo chuột trên hình bên trái để chọn vùng cần cắt.');
	}

}

function reloadImg(id) {
   var obj = document.getElementById(id);
   var src = obj.src;
   var pos = src.indexOf('?');
   if (pos >= 0) {
      src = src.substr(0, pos);
   }
   var date = new Date();
   obj.src = src + '?v=' + date.getTime();
   return false;
}


