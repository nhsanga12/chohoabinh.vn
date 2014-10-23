<?
// Bổ xung ngày 04 08 2010
// tái sử dụng lại hàm: sys_cut(), categories_detail($cat), articles_detail($detail)
function seo_atc($cat='',$detail='',$cut_tit=68,$cut_des=250){
	global $config;
	if($detail=='' && $cat==''){
		$seo['title'] 		= sys_cut($config['title'],$cut_tit);
		$seo['description']	= sys_cut($config['description'],$cut_des).'.';
	}else if($detail=='' || $detail==0 ){
		$news = categories_detail($cat);
		$seo['title'] 		= sys_cut($news[0]['seotit_cat'],$cut_tit);
		if(strlen($news[0]['contents'])>50)
			$seo['description']	= sys_cut(html2text_br($news[0]['contents']),$cut_des).'.';
		else
			$seo['description']	= sys_cut(html2text_br($config['description']),$cut_des).'.';
	}else{
		$news_dt 	= articles_detail($detail);
		$tieude = categories_detail($cat);
		//lấy tiêu đề
		if($news_dt[0]['seotit']!='')
			$seo['title'] 		=  $news_dt[0]['seotit'].' | '.$tieude[0]['seotit_cat'];
		else
			$seo['title'] 		=  sys_cut($news_dt[0]['title'],$cut_tit).' | '.sys_cut($tieude[0]['seotit_cat'],$cut_tit);
		//lấy mô tả	
		if($news_dt[0]['seodes']!='')
			$seo['description'] 		=  $news_dt[0]['seodes'];
		else 
		if(strlen($news_dt[0]['quick'])>50)
			$seo['description'] 		=  sys_cut(html2text_br($news_dt[0]['quick']),$cut_des).'.';	
		else
			$seo['description'] 		= sys_cut(html2text_br($news_dt[0]['contents']),$cut_des).'.';	
	}
	// kiểm tra lần cuối
	if($seo['title']=='') $seo['title']= sys_cut($config['varurl'],$cut_tit);
	if(strlen($seo['description'])<10) $seo['description']	= sys_cut($config['description'],$cut_des).'.';
	
	return $seo;		
}
function page_eny(){ //chỉ mã hóa từ trang 1 đến 99. Khắc phục trùng lặp SEO khi phân trang khác
	global $id;
	$kytupage = array('','- Rao vặt','- Mua bán','- Mua hàng','- Online','- Vật Giá','- Trực tuyến','- Tiếp thị','- Nhà đất','- Đặt hàng','- Bán nhanh');
	if($id['page']=='')
		$text = $kytupage[0];
	else{
		if($id['page']>9){
			$foo = $id['page']/10;
			$foo = settype($foo, "integer");
			$le  = $id['page']%10;
			$text = $kytupage[$foo].' và '.$kytupage[$le];
		}else
			$text = $kytupage[$id['page']];
	}	
	return $text;
}

function analys_key($key=''){
	if($key!=''){
		$key = explode(" ",$key); $nc =count($key);
		if($key[$nc-1]=='') $nc = $nc-1;
		for($i=0;$i<$nc;$i++){ 
			$newkey[$i] = '';
			for($k=0;$k<$i+1;$k++){
				if($k!=0){
					$newkey[$i] .= ' ';
					$newkey[$i] .= $key[$k];
				}else{
					$newkey[$i] .= $key[$k];
				}
			}
		}
	}
	return $newkey;
}
function analys_key_notspace($key=''){
	if($key!=''){
		$key = explode(" ",$key); $nc =count($key);
		if($key[$nc-1]=='') $nc = $nc-1;
		for($i=0;$i<$nc;$i++){ 
			$newkey[$i] = '';
			for($k=0;$k<$i+1;$k++){
				$newkey[$i] .= $key[$k];
			}
		}
	}
	return $newkey;
}
function BreadcrumbLists($cat,$deta=''){
	global $config;
	$link =''; 
	while($cat!=0){
		$menu = categories_detail($cat);
		if($link=='' && $deta=='')
			$chuoi = '<a class="menucha" href="';
		else
			$chuoi = '<a class="menucon" href="';
			
		$chuoi .= sys_link('com=home&target=main&category='.$cat);
		$chuoi .= '">'.$menu[0]['title']."</a> > ";
		
		$link = $chuoi.$link;
		$cat = get_parentid_category($cat);
	}
	echo $link;
	if($deta!='') { $title = art_deta($deta); echo '<a class="menucha" href="" >'.$title[0]['title'].'</a>'; }
}
function BreadcrumbLink($startlink ='', $cat, $deta='', $p='', $o='', $c='',$l=''){
	global $config;
	$link = $startlink; if($cat=='') $cat =0;
	while($cat > 1){
		// lấy tiêu đề menu
		$menu = categories_detail($cat);  
		
		// chuyển thành không dấu
		$chuoi = sys_sign($menu[0]['title']); 
		
		// tạo chuỗi  menu3/menu2/menu1/
		$link = $chuoi."/".$link; 
		
		// tìm id menu cha
		$cat = get_parentid_category($cat); 
	}
	// nếu có deta, tạo thêm ../menu1/tieu_de.html
	if($deta!='') { 
		$title = art_deta($deta);
		$link .= str_replace("...","",sys_cut(sys_sign($title[0]['title']),80))."_".$deta;
	}
	
	// nếu không có category nào thì chèn thêm /home/
	if($config['default_language']=='en') $home = "trang-chu/"; else $home="home/";
	if( ($link == $startlink) && ($p!=0 || $o!="" || $c!="" || $l!=""))
		$link .= $home;

	// nếu có pages,ok,cate hay lang
	if($p!=0) $link .="_P".$p; else if($deta!='') $link .="_P1";
	if($o!="") $link .="_O".$o;
	if($c!="") $link .="_C".$c;
	if($l!="") $link .="_L".$l; 
	
	if($deta!='') $link .=".html";
	return $link;
	
}

function CmsBreadcrumbLink($startlink ='', $cat, $deta='', $more='',$moredeta=''){
	global $config;
	$link = $startlink; if($cat=='') $cat =0;
	while($cat > 1){
		// lấy tiêu đề menu
		$menu = categories_detail($cat);  
		
		// chuyển thành không dấu
		$chuoi = sys_sign($menu[0]['title']); 
		
		// tạo chuỗi  menu3/menu2/menu1/
		$link = $chuoi."/".$link; 
		
		// tìm id menu cha
		$cat = get_parentid_category($cat); 
	}
	
	if($more!="") $link .=$more.'/';	
	
	// nếu có deta, tạo thêm ../menu1/tieu_de.html
	if($moredeta!="") $link .=$moredeta;
	
	// nếu không có category nào thì chèn thêm /home/
	if($config['default_language']=='en') $home = "trang-chu/"; else $home="home/";
	if($link == $startlink)
		$link .= $home;
	
	return $link;
	
}

class enATC {
	var $k = array(
	'home'=>'laptop','laptop'=>'home',
	'main'=>'giaonhanh','giaonhanh'=>'main',
	'105'=>'sony','sony'=>'105',
	'16'=>'asus','asus'=>'16',
	'91'=>'hp','hp'=>'91',
	'0-0-0-0'=>'chinhhang','chinhhang'=>'0-0-0-0',
	'0-0-0'=>'notebook','notebook'=>'0-0-0',
	'888'=>'canon','canon'=>'888',
	'='=>'%','/'=>'.','.'=>'/'
	); // Các từ khóa lồng vào
	function encode_atc($str) {
		return strtr($str,$this->k);	
	}
	function decode_atc($str) {
			return strtr($str,$this->k);
	}
}

class encodeATC {
	var $k = array('a'=>'n','b'=>'o','c'=>'p','d'=>'q','e'=>'r','f'=>'s','g'=>'t','h'=>'u','i'=>'v','j'=>'w','k'=>'x','l'=>'y','m'=>'z','n'=>'a','o'=>'b','p'=>'c','q'=>'d','r'=>'e','s'=>'f','t'=>'g','u'=>'h','v'=>'i','w'=>'j','x'=>'k','y'=>'l','z'=>'m','A'=>'N','B'=>'O','C'=>'P','D'=>'Q','E'=>'R','F'=>'S','G'=>'T','H'=>'U','I'=>'V','J'=>'W','K'=>'X','L'=>'Y','M'=>'Z','N'=>'A','O'=>'B','P'=>'C','Q'=>'D','R'=>'E','S'=>'F','T'=>'G','U'=>'H','V'=>'I','W'=>'J','X'=>'K','Y'=>'L','Z'=>'M','='=>'-','/'=>'.','.'=>'/','_'=>'%');
	function __encode($str) {
		return strtr($str,$this->k);	
	}
	function __decode($str) {
			return strtr($str,$this->k);
	}
	function encode($str) {
		return $this->__encode(base64_encode($str));
	}
	function decode($str) {
		return base64_decode($this->__decode($str));
	}
}
class encodeYu {
	var $k = array('a'=>'n','b'=>'o','c'=>'p','d'=>'q','e'=>'r','f'=>'s','g'=>'t','h'=>'u','i'=>'v','j'=>'w','k'=>'x','l'=>'y','m'=>'z','n'=>'a','o'=>'b','p'=>'c','q'=>'d','r'=>'e','s'=>'f','t'=>'g','u'=>'h','v'=>'i','w'=>'j','x'=>'k','y'=>'l','z'=>'m','A'=>'N','B'=>'O','C'=>'P','D'=>'Q','E'=>'R','F'=>'S','G'=>'T','H'=>'U','I'=>'V','J'=>'W','K'=>'X','L'=>'Y','M'=>'Z','N'=>'A','O'=>'B','P'=>'C','Q'=>'D','R'=>'E','S'=>'F','T'=>'G','U'=>'H','V'=>'I','W'=>'J','X'=>'K','Y'=>'L','Z'=>'M','='=>'&','/'=>'.','.'=>'/');
	function __encode($str) {
		return strtr($str,$this->k);	
	}
	function __decode($str) {
			return strtr($str,$this->k);
	}
	function encode($str) {
		return $this->__encode(base64_encode($str));
	}
	function decode($str) {
		return base64_decode($this->__decode($str));
	}
}

?>