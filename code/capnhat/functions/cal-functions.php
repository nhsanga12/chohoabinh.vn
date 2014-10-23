<?php
function set_counter() {
	global $config;
	$uri  	= rtrim(dirname($_SERVER['PHP_SELF'])); 
	$save	=	$_SERVER['REQUEST_URI']; 
	$save	=	explode("?",$save);
	$save	=	$save[0];
	if($save == $uri) {		
		$config['counter']	+=	1;
		$sql	=	"UPDATE ".$config['db_prefix']."_configs SET key_value=".$config['counter']." WHERE key_id='counter'";
		@mysql_query($sql);	
	} 
}

function formatMoney($number, $cents = 1) { // cents: 0=never, 1=if needed, 2=always
  if (is_numeric($number)) { // a number
    if (!$number) { // zero
      $money = ($cents == 2 ? '0.000' : '0'); // output zero
    } else { // value
      if (floor($number) == $number) { // whole number
        $money = number_format($number, ($cents == 2 ? 2 : 0)); // format
      } else { // cents
        $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2)); // format
      } // integer or decimal
    } // value
	$money=str_replace(',', '.',$money);
    return $money;
  } // numeric
} // formatMoney

function ConvertNumToText($number){
	if (isset($number)){ $i=0;
		while($number>=9){
			$unit = $number%10;
			$unit_array[$i] = $unit;
			$number = round($number/10);
			$unit_array[$i+1] = $number;
			$i++;
		}
	return $unit_array;
	}
}


function tonghoso(){
	global $config;
	$sql = "SELECT pro.*, po.vitri
			FROM ".$config['db_prefix']."_job_profile pro
			LEFT JOIN ".$config['db_prefix']."_job_post po ON po.id = pro.jobpos
			WHERE pro.deleted = '0' AND pro.folder_id = '0' ".$status.$jobpos."
			ORDER BY pro.id DESC
			";
	$rs_list = sql_list($sql);
	return $rs_list;
}


// general ID
function create_guid()
{
	$microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = dechex($a_dec* 1000000);
	$sec_hex = dechex($a_sec);

	ensure_length($dec_hex, 5);
	ensure_length($sec_hex, 6);

	$guid = "";
	$guid .= $dec_hex;
	$guid .= create_guid_section(3);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= create_guid_section(6);

	return $guid;

}

function create_guid_section($characters)
{
	$return = "";
	for($i=0; $i<$characters; $i++)
	{
		$return .= dechex(mt_rand(0,15));
	}
	return $return;
}

function ensure_length(&$string, $length)
{
	$strlen = strlen($string);
	if($strlen < $length)
	{
		$string = str_pad($string,$length,"0");
	}
	else if($strlen > $length)
	{
		$string = substr($string, 0, $length);
	}
}

?>