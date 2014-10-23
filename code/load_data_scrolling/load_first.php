<?php
	$sqls = " SELECT art.id, art.picture, detail.title, art.category, detail.loaitien, detail.gia, detail.khuyenmai, detail.thuonghieu, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate ,art.status
			 FROM gnc_news_articles art 
			 RIGHT JOIN gnc_news_articles_detail detail ON art.id = detail.article 
			 RIGHT JOIN gnc_news_categories cat ON cat.id = art.category  
			 RIGHT JOIN gnc_news_groups grp ON grp.id = cat.groupid 
			 WHERE detail.language = 'vn' 
	         AND art.status = '2' 
			 AND art.category= '19' ORDER BY art.state_p, art.bydate DESC LIMIT 0,100 ";
	
	
$sql=mysql_query($sqls);
while($row=mysql_fetch_array($sql))
		{
		$msgID= $row['id'];
		$msg= $row['title'];

?>
<div id="<?php echo $msgID; ?>"  align="left" class="message_box" >
<span class="number"><?php echo $msgID; ?></span><?php echo $msg; ?> 
</div>

<?php
}
?>
