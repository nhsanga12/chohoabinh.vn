<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>jQuery Datepicker</title>
<style type="text/css">
@import "jquery.datepick.css";
</style>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
});

function showDate(date) {
	alert('The date chosen is ' + date);
}

</script>
</head>

<body>
	<h1>jQuery Datepicker</h1>
	<p>This page demonstrates the very basics of the
		<a href="http://keith-wood.name/datepick.html">jQuery Datepicker plugin</a>.
		It contains the minimum requirements for using the plugin and
		can be used as the basis for your own experimentation.</p>
	<p>For more detail see the <a href="http://keith-wood.name/datepickRef.html">documentation reference</a> page.</p>
	
	<p>A popup datepicker <input type="text" id="popupDatepicker"></p>
	
	<p>Or inline</p>
	<div id="inlineDatepicker"></div>
	
</body>
</html>
