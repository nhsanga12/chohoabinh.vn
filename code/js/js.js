function callDomain(id,val) {
	 inputDomain = $(id).attr('value');
	 if (inputDomain == '') {
	 	$(id).attr('value',val);
	 }
}


function goBack(n){
  	window.history.back(n);
}

function newLocation(bien){
	window.location=bien;
}

function acti(subobj){
	if(document.getElementById(subobj).style.display!="block")
		document.getElementById(subobj).style.display="block";
	else
		document.getElementById(subobj).style.display="none";
}

function active(j,c,text)
{
	var id,idj;
	idj	=	text+"_"+j;
	for (i=0;i<=c;i++) {
		id	= text+"_"+i;
		if (id == idj)
			document.getElementById(id).style.display="block";
		else 
			document.getElementById(id).style.display="none";
	}
}

function setCookie(c_name,value,expiredays)
{var exdate=new Date();exdate.setDate(exdate.getDate()+expiredays);
document.cookie=c_name+ "=" +escape(value)+
((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

function MM_validateForm() { 
  if (document.getElementById){
	var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
	for (i=0; i<(args.length-2); i+=3) { 
		test=args[i+2]; val=document.getElementById(args[i]);
		if (val) { 
			nm=val.id; 
			if ((val=val.value)!="") {
				if (test.indexOf('isEmail')!=-1) { 
					p=val.indexOf('@'); p=val.indexOf('.');
					if (p<=1 || p==(val.length-1)) 
						errors+='- '+nm+' không đúng định dạng.\n';
				} else if (test!='R') { 
					num = parseFloat(val);
					if (isNaN(val)) 
						errors+='- '+nm+' phải là số.\n';
					if (test.indexOf('inRange') != -1) { 
						p=test.indexOf(':');
						min=test.substring(8,p); 
						max=test.substring(p+1);
						if (num<min || max<num) 
							errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
					}
				} 
			} else if (test.charAt(0) == 'R') 
				errors += '- '+nm+' không hợp lệ.\n'; 
		}
	} 
	if (errors) 
		alert('Có lỗi trong quá trình xử lý:\n'+errors);
		document.MM_returnValue = (errors == '');
  }
}

function update_likes(idl,amount)
{	
	$(".jquery_ms").ajaxSend(function(e,xhr,opt){
		$(this).html("Đang cập nhật số lần like ...");
	  });
	
	$.ajax({
	  type: "POST",
	  url: "http://xalomuaban.com/include/ajaxfunction/update_likes.php",
	  data: { idl:idl, likes:amount }
	}).done(function( msg ) {
		$("#amount_like_"+idl).stop(true, true).html(amount);		
	});	
}

function changehinhthuc(){
	var hinhthucvalue = document.getElementById('hinhthucvl').value;
	document.getElementById('hinhthuctt').value = hinhthucvalue;
}