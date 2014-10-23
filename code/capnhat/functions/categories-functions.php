<?php

function cat_getpare_sam($samid='',$cat,$grp='1') {
	global $config;
	$n = 0; $catold = array();
	while($cat!='' && $cat!='1' && $cat!='0'){
		$sql = " SELECT parentid FROM ".$config['db_prefix']."_news_categories 
				 WHERE id = '".intval($cat)."' AND status > 1 AND groupid= '".$grp."' LIMIT 0,1 ";
				 
		$rs = @mysql_query($sql);
		$temp = @mysql_fetch_array($rs);
		
		$catold[$n] = $cat; $n++;
		$cat = intval($temp['parentid']);
		if($cat==$samid && $samid!=''){	
			return $catold;
		}
	}
	return array();
}

function listmenu_order($listid){
	global $config;
	$arrayid = explode(',',$listid);
	$osql = ',';
	for($m=0;$m<count($arrayid);$m++){
		$osql .= "IF(cat.id='".$arrayid[$m]."',".$m.",";
		$end .= ')';
	}
	
	$osql = $osql.count($listid).$end.' AS thutu ';
	
	$sql = " SELECT cat.id, detail.title, detail.contents,cat.textcolor ".$osql." 
			 FROM ".$config['db_prefix']."_news_categories cat 
			 RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category 
			 WHERE detail.language = '".$config['default_language']."' 
			 	 AND cat.id IN ('".str_replace(",","','",$listid)."') 
				 ORDER BY thutu,cat.oderid ASC, cat.bydate DESC ";
				 
	$listmenu = sql_list($sql);
	return $listmenu;
}

function categories_by_cat_group ($grp,$cat) {
	global $config, $news_categories;
	$sql = "SELECT cat.id, cat.oderid, cat.groupid , detail.title,detail.contents, detail.seotit_cat, cat.lastdate, cat.picture,cat.textcolor FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND cat.status > 1 AND cat.groupid= '".$grp."' AND cat.parentid = '".intval($cat)."' ORDER BY cat.oderid ASC, cat.bydate DESC ";
	return sql_list($sql);
}

function categories_detail($cat) {
	global $config;
	return sql_detail("SELECT cat.id, cat.oderid, cat.groupid, cat.picture,cat.picture_ov, cat.textcolor, detail.seotit_cat, detail.title,detail.contents, cat.lastdate FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category WHERE detail.language = '".$config['default_language']."' AND cat.status > 1 AND cat.id='".intval($cat)."'");
}

//====================NEW==========================
function subcate_del($grp = 0,$parentstr = '') {
		global $config;
		if ($parentstr != '') {
			$nstr = str_replace(" ","", $parentstr);
			$nstr = str_replace(",","','",$nstr);
			$sql = " SELECT id FROM ".$config['db_prefix']."_news_categories
					 WHERE groupid='".$grp."' AND parentid IN ('".$nstr."-1') ORDER BY oderid, id "; //echo $sql;
			
			$rs = @mysql_query($sql);
			while($temp = @mysql_fetch_array($rs)){
				$newparent .= $temp[0].',';
			}
			
			subcate_del($grp,$newparent);//echo $newparent;
			
			// update
			$stru = str_replace(" ","",$newparent);
			$stru = str_replace(",","','",$stru);
			$sqlu = " UPDATE ".$config['db_prefix']."_news_categories SET status = '0'  WHERE groupid='".$grp."' AND id IN ('".$stru."-1') ";
			if($newparent!=''){ 
				@mysql_query($sqlu); //echo $sqlu;
				art_del($grp,$newparent); 
			}
		}
}


function cate_del($grp = 0,$parentstr = '') {
	global $config;
	if($parentstr!=''){
		$stru = str_replace(" ","",$parentstr);
		$stru = str_replace(",","','",$stru);
		$sqlu = " UPDATE ".$config['db_prefix']."_news_categories SET status = '0' WHERE groupid='".$grp."' AND id IN ('".$stru."-1') ";
		@mysql_query($sqlu);//echo $sqlu;
		
		art_del($grp,$parentstr); 
	}
}

function art_del($grp = 0,$parentstr = '') {
	global $config;
	if($parentstr!=''){
		$stru = str_replace(" ","",$parentstr);
		$stru = str_replace(",","','",$stru);
		$sqlu = " UPDATE ".$config['db_prefix']."_news_articles SET status = '0' WHERE category IN ('".$stru."-1') ";
		@mysql_query($sqlu);//echo $sqlu; 
	}
}
					 


function option_select($grp=1 ,$parentid=0 ,$str='',$from='categories',$select=0,$lang='vn') {
		global $config;
		
		$sql = "SELECT cat.id, cat.groupid , detail.title, cat.lastdate FROM ".$config['db_prefix']."_news_".$from." cat RIGHT JOIN ".$config['db_prefix']."_news_".$from."_detail detail ON cat.id = detail.category WHERE detail.language = '".$lang."' AND cat.groupid='".$grp."' ";
		
		if($parentid!=0)
			$sql .= " AND cat.parentid = '".$parentid."' ";
		$sql .= " ORDER BY cat.oderid, cat.id ";
		
		$value = sql_list($sql);
		for ($i =0; $i < count($value); $i++){
			if($value[$i]['id']==$select) $selectxt = ' selected="selected"'; else $selectxt = '';
			echo '<option value="'.$value[$i]['id'].'"'.$selectxt.'>'.$str.' '.$value[$i]['title'].'</option>';
		}
}

function list_thuonghieu($cat=0) {
	global $config;
	$sql = " SELECT detail.thuonghieu, cat.id, cat.oderid, cat.groupid, cat.picture,cat.picture_ov, cat.textcolor, catdt.seotit_cat, catdt.title, catdt.contents, cat.lastdate
			FROM ".$config['db_prefix']."_news_articles art
			LEFT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article
			LEFT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = detail.thuonghieu
			LEFT JOIN ".$config['db_prefix']."_news_categories_detail catdt ON cat.id = catdt.category
			WHERE detail.language = '".$config['default_language']."' AND catdt.language = '".$config['default_language']."' AND art.category='".intval($cat)."' 
			GROUP BY detail.thuonghieu ";
	//echo $sql;
	$listmenu = sql_list($sql);
	return $listmenu;
}

function thuonghieu($grp,$cat) {
	global $config, $news_categories;
	$sql = "SELECT cat.id, cat.oderid, cat.groupid , detail.title,detail.contents, detail.seotit_cat, cat.lastdate, cat.picture,cat.textcolor FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND cat.groupid= '".$grp."' AND cat.parentid = '".intval($cat)."' ORDER BY cat.oderid ASC, cat.bydate DESC ";
	return sql_list($sql);
}

//====================END NEW=========================

function listmenu($listid){
	global $config;
	$sql = "SELECT cat.id, detail.title FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category WHERE detail.language = '".$config['default_language']."' AND cat.id IN ('".str_replace(",","','",$listid)."') ORDER BY cat.oderid ASC, cat.bydate DESC ";
	$listmenu = sql_list($sql);
	return $listmenu;
}

function categories_select ($name = '',$grp = 0,$parentid = 0, $selected = 0, $notin = 0, $str = '', $ext='',$str2 = '') {
		global $config;
		if ($parentid == 0) {
		echo '<select name="'.$name.'" id="'.$name.'" '.$ext.'>';
		echo '<option value="">----------------------------------------</option>';
		}
		$sql = "SELECT cat.id, cat.groupid , detail.title, cat.lastdate FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category WHERE detail.language = '".$config['default_language']."' AND cat.groupid='".$grp."' AND cat.parentid = '".$parentid."' ORDER BY cat.oderid, cat.id ";
		$grpcat[$parentid] = sql_list($sql);
		for ($i =0; $i < count($grpcat[$parentid]); $i++) { 
				$value = $grpcat[$parentid][$i];
				if ($notin != $value['id']) {
					echo '<option value="'.$value['id'].'"';
					if ($selected == $value['id']) echo ' selected';
					if ($parentid == 0) echo ' style="color:#990000" ';
					echo ' >'.$str.' '.$value['title'].'</option>';
					$nstr= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$str2;
					categories_select($name,$grp,$value['id'],$selected,$notin,$nstr,'',$nstr);
				}
		}
		if ($parentid == 0) {
		echo '</select>';
		}
}

function categories_select2 ($prefix='',$name = '',$grp = 0,$parentid = 0, $selected = 0, $notin = 0, $str = '', $ext='',$str2 = '') {
		global $config;
		if($prefix!='') $db_prefix = $prefix; else $db_prefix = $config['db_prefix'];
		
		if ($parentid == 0) {
		echo '<select name="'.$name.'" '.$ext.'>';
		echo '<option value="">----------------------------------------</option>';
		}
		$sql = "SELECT cat.id, cat.groupid , detail.title, cat.lastdate FROM ".$db_prefix."_news_categories cat RIGHT JOIN ".$db_prefix."_news_categories_detail detail ON cat.id = detail.category WHERE detail.language = '".$config['default_language']."' AND cat.groupid='".$grp."' AND cat.parentid = '".$parentid."' ORDER BY cat.oderid, cat.id ";
		$grpcat[$parentid] = sql_list($sql);
		for ($i =0; $i < count($grpcat[$parentid]); $i++) { 
				$value = $grpcat[$parentid][$i];
				if ($notin != $value['id']) {
					echo '<option value="'.$value['id'].'"';
					if ($selected == $value['id']) echo ' selected';
					if ($parentid == 0) echo ' style="color:#990000" ';
					echo ' >'.$str.' '.$value['title'].'</option>';
					$nstr= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$str2;
					categories_select2($db_prefix,$name,$grp,$value['id'],$selected,$notin,$nstr,'',$nstr);
				}
		}
		if ($parentid == 0) {
		echo '</select>';
		}
}
function categories_lilink ($link = '',$grp = 0,$parentid = 0, $selected = 0) {
		global $config;
		$sql = "SELECT cat.id, cat.groupid , detail.title, cat.lastdate FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category WHERE detail.language = '".$config['default_language']."' AND cat.groupid='".$grp."' AND cat.parentid = '".$parentid."' ORDER BY cat.oderid, cat.id ";
		$grpcat[$parentid] = sql_list($sql);
		if ($parentid == 0) {
		echo '<ul>';
		echo "\n";
		} else {
		echo '<ul>';
		}
		echo "\n";
		for ($i =0; $i < count($grpcat[$parentid]); $i++) { 
				$value = $grpcat[$parentid][$i];
				if (sql_exit("SELECT * FROM ".$config['db_prefix']."_news_categories WHERE parentid = '".$value['id']."'") == 0) {
				echo '<li><a href="'.$link.$value['id'].'">';
				if ($selected == $value['id']) echo '<strong>';
				echo $value['title'];
				if ($selected == $value['id']) echo '</strong>';
				echo '</a>';
				echo "\n";
				} else {
				echo '<li><a href="'.$link.$value['id'].'">';
				echo $value['title'];
				echo '</a>';
				echo "\n";
				}
				if (count_child_newscat($value['id']) > 0) {
				categories_lilink($link,$grp,$value['id'],$selected);
				}
				echo '</li>';
				echo "\n";
		}
		echo '</ul>';
		echo "\n";
}

function categories_lilink2 ($link = '',$grp = 0,$parentid = 0, $selected = 0) {
		global $config;
		$sql = "SELECT cat.id, cat.groupid , detail.title, cat.lastdate FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category WHERE detail.language = '".$config['default_language']."' AND cat.groupid='".$grp."' AND cat.parentid = '".$parentid."' ORDER BY cat.oderid, cat.id ";
		$grpcat[$parentid] = sql_list($sql);
		if ($parentid == 0) {
		echo '<div style="font-size:12px; color:#ddd;">';
		echo "";
		} else {
		echo '<div style="font-size:11px;" class="xam">';
		}
		echo "";
		for ($i =0; $i < count($grpcat[$parentid]); $i++) { 
				$value = $grpcat[$parentid][$i];
				if (sql_exit("SELECT * FROM ".$config['db_prefix']."_news_categories WHERE parentid = '".$value['id']."'") == 0) {
				echo ' | <a href="'.$link.$value['id'].'">';
				if ($selected == $value['id']) echo '&nbsp;';
				echo $value['title'];
				if ($selected == $value['id']) echo '&nbsp;';
				echo '</a>';
				echo "\n";
				} else {
				echo ' | <a href="'.$link.$value['id'].'">';
				echo $value['title'];
				echo '</a>';
				echo "\n";
				}
				if (count_child_newscat($value['id']) > 0) {
				categories_lilink2($link,$grp,$value['id'],$selected);
				}
				echo '';
				echo "\n";
		}
		echo '</div>';
		echo "\n";
}
function categories_child2 ($prefix='',$parent,$grp=0) {
	global $config, $str;
	if($prefix!='') $db_prefix = $prefix; else $db_prefix = $config['db_prefix'];
	$sql = "SELECT * FROM ".$db_prefix."_news_categories WHERE parentid = '".$parent."'";
	if ($grp > 0) $sql.=" AND groupid='".$grp."'";
	$temp = sql_list($sql);
	for ($i =0; $i < count($temp); $i++) {
		$str.= ','.$temp[$i]['id'];
		categories_child2($prefix,$temp[$i]['id'],$grp);
	}
}
function categories_child ($parent,$grp=0) {
	global $config, $str;
	$sql = "SELECT * FROM ".$config['db_prefix']."_news_categories WHERE parentid = '".$parent."'";
	if ($grp > 0) $sql.=" AND groupid='".$grp."'";
	$temp = sql_list($sql);
	for ($i =0; $i < count($temp); $i++) {
		$str.= ','.$temp[$i]['id'];
		categories_child($temp[$i]['id'],$grp);
	}
}


function news_search_c($cat,$key) {
	global $config;
	if ($key == 'Nhập từ khóa' || $key == 'Từ khóa')
		$key = '';
	$key = explode(' ',$key);
	$count  = count($key);
	$andrey = '';
	$sql = "SELECT cat.id, cat.groupid , detail.title, detail.contents, cat.lastdate FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category WHERE detail.language = '".$config['default_language']."' AND (";
	for($i=0;$i<$count;$i++) {
		$andrey .= "detail.contents LIKE '%".$key[$i]."%' OR detail.contents LIKE '%".$key[$i]."%'";
		if($i<$count-1) $andrey .= " OR "; 
	}
	$sql .= $andrey.") ORDER BY cat.lastdate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_on_page_s']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page_s'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page_s'];
	//echo $sql;
	return sql_detail($sql);
}
# For show cat in home page
function loadnewscats($link,$grpid = 0, $parent = 0, $ext = -1) {
	global $config,$category, $uncategory, $id;
	$sql = "SELECT cat.*, detail.title FROM ".$config['db_prefix']."_news_categories cat LEFT JOIN ".$config['db_prefix']."_news_categories_detail detail ON detail.category = cat.id WHERE cat.parentid = '".$parent."' AND detail.language='".$config['default_language']."'";
	if ($grpid > 0) $sql.=" AND cat.groupid = '$grpid'";
	$temp = mysql_query($sql);
	$config['query'][]	= $sql;
	$category.= '<ul id="yumenu">';
	$ext+=1;
	$sta = $ext*2+3;
	for ($i=0;$i<$sta;$i++) { $str.="&nbsp;";}
	while ($records = @mysql_fetch_array($temp)) {
		$link['news_group']			= $records['groupid'];
		$link['news_category']		= $records['category'];
		$link['item']				= $records['id'];
		$link['title']				= sys_sign($records['title']);
		if (count_child_newscat($records['id']) == 0) {
		$category.= '<li>'.$str.'<a href="'.sys_link($link).'">';
		$category.= $records['title'];
		$category.= '</a></li>';
		} else {
		$category.= '<li>'.$str.'<a href="'.sys_link($link).'">';
		$category.= $records['title'].'';
		$category.= '</a></li>';	
			if ($ext < $config['cat_show_level']-1) {
				loadnewscats($link,$grpid,$records['id'],$ext);
			} else  {
				if ($uncategory[(count($uncategory)-1)-$ext] == $records['id']) {
				loadnewscats($link,$grpid,$records['id'],$ext);
				}
			}
		}
	}
	$category.= '</ul>';
}
function unloadnewscats($id,$i=-1) {
	global $config,$uncategory;
	$sql = "SELECT cat.*, detail.title FROM ".$config['db_prefix']."_news_categories cat LEFT JOIN ".$config['db_prefix']."_news_categories_detail detail ON detail.category = cat.id WHERE cat.id = '$id' AND detail.language='".$config['default_language']."' ORDER BY cat.id";
	$temp = @mysql_query($sql);
	while ($records = @mysql_fetch_array($temp)) {
		$i++;
		$uncategory[$i] = $records['id'];
		if ($records['parentid'] >= 0) {
			unloadnewscats($records['parentid'],$i);
		}
	}
}
function count_child_newscat($id) {
	global $config;
	$sql = "SELECT * FROM ".$config['db_prefix']."_news_categories cat WHERE cat.parentid = ".$id;
	$sumoff= @mysql_num_rows(@mysql_query($sql));
	return $sumoff;
}
function get_parentid_category($id)
{
	global $config;
	$sql	= "SELECT * FROM ".$config['db_prefix']."_news_categories WHERE id = ".$id." ";
	$temp	= @mysql_query($sql);
	if (count($temp) > 0) {
		$temp	= @mysql_fetch_array($temp);
		return  $temp['parentid'];
	}
	else
		return 0;
}
function get_member($id,$i=0,$str='')
{
	global $config, $listmember;
	if ($i != 0){
		$str	.=	'&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;';
	}
	$listmember	.= $str;
	$listmember	.= '<b>C'.$i.'</b>|--<a href="'.sys_link('com=home@target=main@newscategory=122').'">'.$id.'</a>';
	//Tìm tất cả các thành viên có mã số người bảo trợ là $id
	$sql	= "SELECT * FROM ".$config['db_prefix']."_member mem WHERE mem.sponsorid = ".$id;
	$temp	= @mysql_query($sql);
	//Nếu danh sách này khác rỗng thì vẻ ra và lấy tiếp con của các thành viên vừa tìm được
	if (count($temp) > 0) {
		$i++;//echo $i;
		while ($record = @mysql_fetch_array($temp)) {
			$listmember	.= '<br/>'.$str.$str.'&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<br/>';
			get_member($record['idm'],$i,$str);
			//$listmember	.= '&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;';
		}
	}
}
# For show cat in home page

function sitemap ($link = 'com=home&target=main',$grp = 1,$parentid = 0, $selected = 0, $str) {
		global $config, $extra;
		$sql = "SELECT cat.id, cat.groupid , detail.title, cat.lastdate FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category WHERE detail.language = '".$config['default_language']."' AND cat.groupid='".$grp."' AND cat.parentid = '".$parentid."' ORDER BY cat.oderid, cat.id ";
		$grpcat[$parentid] = sql_list($sql);
		//$temp  = $link;
		if ($parentid != 0)
			$str	.=	"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		for ($i =0; $i < count($grpcat[$parentid]); $i++) { 
				$value = $grpcat[$parentid][$i];
				$n=0;
				for($m=0;$m<count($extra);$m++){
					if($value['id']==$extra[$m]){
						$n=1;
					}
					}
					if($n==0){
						echo $str.'|--- <a href="'.sys_link('com=home&target=main&category='.$value['id']).'">';
						if ($selected == $value['id']) echo '<strong>';
						echo $value['title'];
						if ($selected == $value['id']) echo '</strong>';
						echo '</a>';
						echo "<br />".$str;
						if (count_child_newscat($value['id']) > 0)
							echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "|<br />";
					}
					if (count_child_newscat($value['id']) > 0) {
						sitemap($link,$grp,$value['id'],$selected,$str);
						//echo "<br/>".$str."|<br/>";
					}
		}
}
function newsitemap ($link = 'com=home&target=main',$grp = 1, $menulist, $extra, $str=' class="sitemap"') {
	global $config;
	
	// load các nhóm menu trong $menulist
	for ($i =0; $i < count($menulist); $i++) {
		$sql = "SELECT cat.id, cat.groupid , detail.title, cat.lastdate FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category WHERE detail.language = '".$config['default_language']."' AND cat.groupid='".$grp."' AND cat.parentid = '".$menulist[$i]."' ORDER BY cat.oderid, cat.id ";
		$grpcat[$parentid] = sql_list($sql);
		
		echo '<div'.$str.'>';
			
			// Menu cha
			$menucha = categories_detail($menulist[$i]);
			if(count($grpcat[$parentid])>0 && ($menulist[$i]!='15' && $menulist[$i]!='170' && $menulist[$i]!='169' && $menulist[$i]!='102' && $menulist[$i]!='179' && $menulist[$i]!='16' && $menulist[$i]!='144' && $menulist[$i]!='119' && $menulist[$i]!='167' && $menulist[$i]!='197'))
				echo '<a class="menucha" href="'.sys_link('com=home&target=main&category='.$menulist[$i]).'">';
			else
				echo '<a class="menucha2" href="'.sys_link('com=home&target=main&category='.$menulist[$i]).'">';
			echo $menucha[0]['title']."</a>";
			
			// Các menu con	
			$ch = 0;
			if($menulist[$i]!='15' && $menulist[$i]!='170' && $menulist[$i]!='169' && $menulist[$i]!='102' && $menulist[$i]!='179' && $menulist[$i]!='16' && $menulist[$i]!='144' && $menulist[$i]!='119' && $menulist[$i]!='167' && $menulist[$i]!='197'){		
				for($m=0;$m<count($grpcat[$parentid]);$m++){
					$value = $grpcat[$parentid][$m];
					$n=0;
					for($x=0;$x<count($extra);$x++){
						if($value['id']==$extra[$x]) $n=1;
					}
					if($n==0){
						echo '<br />
							  <a class="menucon" href="'.sys_link('com=home&target=main&category='.$value['id']).'">';if ($selected == $value['id']) 
							echo '<strong>';
								echo $value['title'];if ($selected == $value['id']) 
							echo '</strong>';
						echo '</a>';
						$ch++;
						if($ch==3) echo '</div><div style="width:210px; float:left;">';
					}
				 }
			 }
		 
		 echo '</div>';
	}// end for i
}

function getIdbyKey($key) {
	global $config;
	return sql_detail("SELECT * FROM ".$config['db_prefix']."_news_categories_detail WHERE titkey='".$key."'");
}
?>