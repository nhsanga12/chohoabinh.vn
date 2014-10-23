<?php
function openFile($file, $mode, $input) {
	if ($mode == "READ") {
		if (file_exists($file)) {
			$handle = fopen($file, "r");
			$output = fread($handle, filesize($file));
			return $output; // output file text
		} else {
			return false; // failed.
		}
	} elseif ($mode == "WRITE") {
		$handle = fopen($file, "w");
		if (!fwrite($handle, $input)) {
			return false; // failed.
		} else {
			return true; //success.
		}
	} elseif ($mode == "READ/WRITE") {       
		if (file_exists($file) && isset($input)) {
			$handle = fopen($file,"r+");
			$read = fread($handle, filesize($file));
			$data = $read.$input;
			if (!fwrite($handle, $data)) {
				return false; // failed.
			} else {
				return true; // success.
			}
		} else {
			return false; // failed.
		}
	} else {
		return false; // failed.
	}
	fclose($handle);
}
function addXmlItem($xmlFile, $firstItem, $item){
	// Backup file
	//if(!copy($xmlFile, 'menubk.xml')) die('Backup failed!');
	// Store file contents in array
	$arrFile = file($xmlFile);
	// Open file for output
	if(($fh = fopen($xmlFile,'w')) === FALSE){
		die('Failed to open file for writing!');
	}
	// Set counters
	$currentLine = 0;
	$cntFile = count($arrFile);
	// Write contents, inserting $item as first item
	while( $currentLine <= $cntFile ){
		if($currentLine == $firstItem)
			fwrite($fh, $item);
		fwrite($fh, $arrFile[$currentLine]);				
		$currentLine++;
	}
	// Delete backup
	//unlink('menubk.xml');
	fclose($fh);
}
function deleteXmlItem($xmlFile,$item_begin, $item_end){
	// Backup file
	//if(!copy($xmlFile, 'backup.xml')) die('Backup failed!');
	// Store file contents in array
	$arrFile = file($xmlFile);
	// Open file for output
	if(($fh = fopen($xmlFile,'w')) === FALSE){
		die('Failed to open file for writing!');
	}
	// Set begin
	$currentLine = 0;		
	$cntFile = count($arrFile);
	// Delete from $item_begin to $item_end
	while( $currentLine <= $cntFile ){
		if(($currentLine >= $item_begin-1) && ($currentLine < $item_end) ) 
			fwrite($fh,'');
		else
			fwrite($fh, $arrFile[$currentLine]);
		$currentLine++;
	}
	// Delete backup
	//unlink('menubk.xml');
	fclose($fh);
}
function writeoverXmlItem($xmlFile,$item_begin, $item_end,$text=''){
	// Backup file
	//if(!copy($xmlFile, 'backup.xml')) die('Backup failed!');
	// Store file contents in array
	$arrFile = file($xmlFile);
	// Open file for output
	if(($fh = fopen($xmlFile,'w')) === FALSE){
		die('Failed to open file for writing!');
	}
	// Set begin
	$currentLine = 0;		
	$cntFile = count($arrFile);
	// Delete from $item_begin to $item_end
	while( $currentLine <= $cntFile ){
		if(($currentLine >= $item_begin-1) && ($currentLine < $item_end) ) 
			fwrite($fh,$text);
		else
			fwrite($fh, $arrFile[$currentLine]);
		$currentLine++;
	}
	// Delete backup
	//unlink('menubk.xml');
	fclose($fh);
}
function CountXML($xmlFile){
	// Store file contents in array
	$arrFile = file($xmlFile);
	$cntFile = count($arrFile);
	return $cntFile;
}


function AddSitemap($xmlFile='../sitemap.xml',$link='http://www.trajan.vn',$changefreq='weekly',$priority='0.8'){
	$firstItem = CountXML($xmlFile)-3; // tim vi tri them moi
	$data = "\n\t\t<url>\n\t\t\t";
	$data .= "<loc>".$link."</loc>\n\t\t\t";
	$data .= "<lastmod>".date('Y-m-d').'T'.date('H:i:s').'+07:00'."</lastmod>\n\t\t\t";
	$data .= "<changefreq>".$changefreq."</changefreq>\n\t\t\t";
	$data .= "<priority>".$priority."</priority>\n\t\t";
	$data .= "</url>\n";
							
	addXmlItem($xmlFile,$firstItem,$data);
	return $firstItem+1; // xuất ra vị trí đầu đoạn
}

function UpdateSitemap($xmlFile='../sitemap.xml',$link='http://www.trajan.vn',$changefreq='weekly',$priority='0.8',$chimuc=0){
	$data = "\n\t\t<url>\n\t\t\t";
	$data .= "<loc>".$link."</loc>\n\t\t\t";
	$data .= "<lastmod>".date('Y-d-m').'T'.date('H:i:s').'+07:00'."</lastmod>\n\t\t\t";
	$data .= "<changefreq>".$changefreq."</changefreq>\n\t\t\t";
	$data .= "<priority>".$priority."</priority>\n\t\t";
	$data .= "</url>\n";
	
	if($chimuc!=0){
		deleteXmlItem($xmlFile,$chimuc,$chimuc+6);
		addXmlItem($xmlFile,$chimuc-1,$data);
		return $chimuc;
	}else return 0;			
}













/**
 * xml2array() will convert the given XML text to an array in the XML structure.
 * Link: http://www.bin-co.com/php/scripts/xml2array/
 * Arguments : $contents - The XML text
 *                $get_attributes - 1 or 0. If this is 1 the function will get the attributes as well as the tag values - this results in a different array structure in the return value.
 *                $priority - Can be 'tag' or 'attribute'. This will change the way the resulting array sturcture. For 'tag', the tags are given more importance.
 * Return: The parsed XML in an array form. Use print_r() to see the resulting array structure.
 * Examples: $array =  xml2array(file_get_contents('feed.xml'));
 *              $array =  xml2array(file_get_contents('feed.xml', 1, 'attribute'));
 */
function xml2array($urlxml, $get_attributes=1, $priority = 'tag') {
	$contents	=	file_get_contents($urlxml);
    if(!$contents) return array();

    if(!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }

    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);

    if(!$xml_values) return;//Hmm...

    //Initializations
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();

    $current = &$xml_array; //Refference

    //Go through the tags.
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
    foreach($xml_values as $data) {
        unset($attributes,$value);//Remove existing values, or there will be trouble

        //This command will extract these variables into the foreach scope
        // tag(string), type(string), level(int), attributes(array).
        extract($data);//We could use the array by itself, but this cooler.

        $result = array();
        $attributes_data = array();
        
        if(isset($value)) {
            if($priority == 'tag') $result = $value;
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
        }

        //Set the attributes too.
        if(isset($attributes) and $get_attributes) {
            foreach($attributes as $attr => $val) {
                if($priority == 'tag') $attributes_data[$attr] = $val;
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }

        //See tag status and do the needed.
        if($type == "open") {//The starting of the tag '<tag>'
            $parent[$level-1] = &$current;
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                $repeated_tag_index[$tag.'_'.$level] = 1;

                $current = &$current[$tag];

            } else { //There was another element with the same tag name

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    $repeated_tag_index[$tag.'_'.$level]++;
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag.'_'.$level] = 2;
                    
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                        unset($current[$tag.'_attr']);
                    }

                }
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                $current = &$current[$tag][$last_item_index];
            }

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            if(!isset($current[$tag])) { //New Key
                $current[$tag] = $result;
                $repeated_tag_index[$tag.'_'.$level] = 1;
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

            } else { //If taken, put all things inside a list(array)
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                    // ...push the new element into that array.
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    
                    if($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag.'_'.$level]++;

                } else { //If it is not an array...
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $get_attributes) {
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }
                        
                        if($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                }
            }

        } elseif($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }
    
    return($xml_array);
}

function rss_reader($url) {
	$rss	=	xml2array($url);
	return $rss['rss']['channel'];	
}
function create_rss($url,$cat) {
	global $id, $config;
	$link	=	($id['com']=='')?'':'com='.$id['com'];
	$link	.=	($id['target']=='')?'':'&target='.$id['target'];
	$rss	= new_articles_by_cat($cat,10);
	$title	= categories_detail($cat);
	echo '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
	echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">'."\r\n";
	echo '<channel>'."\r\n";
	echo '<atom:link href="http://baokhanhad.net/rss.php?cat='.$cat.'" rel="self" type="application/rss+xml" />'."\r\n";
	echo '<title>'.str_replace('&','&amp;',$title[0]['title']).'</title>'."\r\n";
	echo '<link>'.$url.'</link>'."\r\n";
	echo '<description>'.str_replace('&','&amp;',$title[0]['title']).'</description>'."\r\n";
	echo '<lastBuildDate>Mon, 13 Dec 2010 10:37:00 GMT</lastBuildDate>'."\r\n";
	echo '<language>en-us</language>'."\r\n";
	for($i=0; $i<count($rss);$i++){
	  echo '<item>'."\r\n";
	  echo '<title>'.html2text2($rss[$i]['title']).'</title>'."\r\n";
	  echo '<link>'.$url.'/'.sys_link($link.'&category='.$rss[$i]['category'].'&detail='.$rss[$i]['id']).'</link>'."\r\n";
	  $text = sys_cut(html2text2($rss[$i]['quick'].$rss[$i]['contents']),500);
	  $text = str_replace('&','&amp;',$text);

	  
	  echo '<guid>'.$url.'/'.sys_link($link.'&category='.$rss[$i]['category'].'&detail='.$rss[$i]['id']).'</guid>'."\r\n";
	  echo '<pubDate>Mon, 13 Dec 2010 10:37:00 GMT</pubDate>'."\r\n";
	  echo '<description>'.$text.'</description>'."\r\n";
	  echo '</item>'."\r\n";
	}
	
	echo '</channel>'."\r\n";
	echo '</rss>';      
}



?>