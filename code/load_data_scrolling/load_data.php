<?php
include('config.php');


$last_msg_id=$_GET['last_msg_id'];
$action=$_GET['action'];

if($action <> "get")
{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Load Data while scrolling 9lessons tutorials</title>
<link rel="stylesheet" href="9lessons.css" type="text/css" />
<script type="text/javascript" src="jquery-1.2.6.pack.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
			
		function last_msg_funtion() 
		{ 
		   
           var ID=$(".message_box:last").attr("id");
			$('div#last_msg_loader').html('<img src="bigLoader.gif">');
			$.post("load_data.php?action=get&last_msg_id="+ID,
			
			function(data){
				if (data != "") {
				$(".message_box:last").after(data);			
				}
				$('div#last_msg_loader').empty();
			});
		};  
		
		$(window).scroll(function(){
			if  ($(window).scrollTop() == $(document).height() - $(window).height()){
			   last_msg_funtion();
			}
		}); 
		
	});
	</script>

<style type="text/css">
body,td,th {
	font-family: Georgia, "Times New Roman", Times, serif;
}
</style>
</head>

<body>
<div>
Scroll Down.. Tutorial link <a href="" style="color:#DF3D82;">click here</a>&nbsp;&nbsp;&nbsp;&nbsp; Subscribe 9lessons feeds <a href="http://feeds2.feedburner.com/9lesson" style="color:#DF3D82;">click here</a> &nbsp;&nbsp;&nbsp;&nbsp; Follow me <a href="http://twitter.com/9lessons" style="color:#DF3D82;">@9lessons</a></div>
<div align="center">
<div>
<h2><a href="http://9lessons.blogspot.com">9Lessons.blogspot.com</a></h2>
</div>

<?php

include('load_first.php');

?>
<div id="last_msg_loader"></div>
</div>
</body>
</html>

<?php
}
else
{
 
include('load_second.php');		
	
		}
		?>	