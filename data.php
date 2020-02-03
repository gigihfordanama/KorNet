<?php
////////////////////////////////////////////////////////////////////
// API PHP DAN MIKROTIK  /////////////////////////////////////////////
// Create By: Nicolas Daitsch, Modify by Gigih Forda Nama////////////
// Contact: gigih@eng.unila.ac.id/////// //////////////////////////
// Router OS Dengan API////////////////////////////////// //////////
//////////////////////////////////////////////////////////////////// ?>
<?php require_once('api_mt_include2.php'); ?>
<?php
$ipRouteros = "xxx.3.46.xxx";
$Username="UserMikrotik";
$Pass="PasswordMT";
$api_port=8728;


	$API = new routeros_api();
	$API->debug = false;
	if ($API->connect($ipRouteros , $Username , $Pass, $api_port)) {
		$rows = array(); $rows2 = array();	
		   $API->write("/interface/monitor-traffic",false);
		   $API->write("=interface=NamaInterfaceAnda",false);  
		   $API->write("=once=",true);
		   $READ = $API->read(false);
		   $ARRAY = $API->parse_response($READ);
			if(count($ARRAY)>0){  
				$rx = number_format($ARRAY[0]["rx-bits-per-second"]/1024,1);
				$tx = number_format($ARRAY[0]["tx-bits-per-second"]/1024,1);
				$rows['name'] = 'Tx';
				$rows['data'][] = $tx;
				$rows2['name'] = 'Rx';
				$rows2['data'][] = $rx;
			}else{  
				echo $ARRAY['!trap'][0]['message'];	 
			} 
	}else{
		echo "<font color='#ff0000'>Koneksi Anda Gagal.</font>";
	}
	$API->disconnect();

	$result = array();
	array_push($result,$rows);
	array_push($result,$rows2);
	print json_encode($result, JSON_NUMERIC_CHECK);

?>
