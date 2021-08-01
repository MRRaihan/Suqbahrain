<?php
/*$vars	= include('../.env');
$vars	= explode(" ", $vars);
echo 'BENEFIT_TERMINAL_KEY';print_r($vars);exit;*/
$con = $connection =  @mysqli_connect('localhost','suqbahra_trk','B2Vhkjvki?Pm','suqbahra_trk');
	
if(mysqli_connect_errno())
{
	echo "<center><p style='color:red; margin-top:10%;'>Failed to Connect with Database: " . mysqli_connect_error($connection)." ..... !!</p></center>";
	exit;
}


$ResTranData= (isset($_REQUEST['trandata'])? $_REQUEST['trandata'] : null);
//$ResTranData="4729FD8787C2C673CB350A6D1416F78DD088D1042D09C226F18462DA832F111F2F5444E1738811CF2F280842F1EE867EEA828E8F5EC8947775F9D5AEFC12D7705752B3FA7895C9A4F20289476DE59BD9F1AF646CDB6A015158BEA34407ED98B5BBD2447EC9A7720A35A3139581A1BDE6FCC752C79AD9461496C3ACDB33BF39F884DC6ED04B2067238A60EC50894CC57DE038776D72BDC1BADE930D6D1B9369C5AFC4E97FD6C2644A373431C48A75F54320B7F39C47E47D340210D7D43EB1D3F971B6EB6F5F6D295AF96DF29D5EE296C3A44B9AFC457071A8C32C9C6F815A07362C6CBA6204332B04179BCD11ABFE31FCEC3E164349F5DECDC96BF2BBC4E8EA94AD96E8E36CC9FBEEA34240DBC1B4621A9E4AB018CB09F91A554832CE2FD0F7B697CDB2DFE5DE6817AAC5B77FFF5F67D0";
//$tranportalid		= '16175951';
//$tranportalpassword	= '16175951';
//$termresourcekey	= '03154766397603154766397603154766';

$query	= "SELECT *  FROM `business_settings` WHERE `type` LIKE 'BENEFIT_TERMINAL_KEY'";
//echo $query;exit;
$result	= mysqli_query($connection, $query);

if(!$result)
{
	die( "Error: " . mysqli_error($connection) );
	$_SESSION['msg_error'] = "Error: " . mysqli_error($connection);
}

$row	= $result->fetch_row();
//echo '<pre>';print_r($row);exit;
$termresourcekey	= $row[2];
//echo $termresourcekey;exit;

if($ResTranData !=null && !empty($termresourcekey))
{
	//Decryption logice starts
	$decryptedData='';
	$encryption = 'aes';
	$decrytedData=decryptAES($ResTranData,$termresourcekey);
	
	$res='';
	parse_str($decrytedData,$res);
	
	//echo '<pre>';print_r($res);exit;
	
	$response	= json_encode($res);

	//$query	= "INSERT INTO coinpayment_logs SET response='$response'";
	$query	= "INSERT INTO `benefit_log` (`response`) VALUES ('".$response."')";
	//echo $query;exit;
	$result	= mysqli_query($connection, $query);
	
	if(!$result)
	{
		die( "Error: " . mysqli_error($connection) );
		$_SESSION['msg_error'] = "Error: " . mysqli_error($connection);
	}
	//echo 'success';exit;
	
	$ResPaymentId = $res['paymentid'];
	$ResResult = $res['result'];
	$ResAuth = $res['auth'];
	$ResAVR = $res['avr'];
	$ResRef = $res['ref'];
	$ResTranId = $res['tranid'];
	$ResPostdate = $res['postdate'];
	$ResTrackID = explode('_',$res['trackid']);
	$order_id	= $ResTrackID[0];
	$ResAmount = $res['amt'];
	$Resudf1 = $res['udf1'];
	$Resudf2 = $res['udf2'];
	$Resudf3 = $res['udf3'];
	$Resudf4 = $res['udf4'];
	$Resudf5 = $res['udf5'];	

	$message = "Thank you for shopping with us. However, the transaction has been declined.";
	if (isset($ResResult) && strtoupper($ResResult) == 'CAPTURED') {
		$sql	= "UPDATE `orders` SET `payment_status`='paid',`payment_details`='".$response."' WHERE `id` = '".$order_id."'";
		$result	= mysqli_query($connection, $sql);
	
		if(!$result)
		{
			die( "Error: " . mysqli_error($connection) );
			$_SESSION['msg_error'] = "Error: " . mysqli_error($connection);
		}
		
		$sql	= "UPDATE `order_details` SET `payment_status`='paid' WHERE `order_id` = '".$order_id."'";
		$result	= mysqli_query($connection, $sql);
	
		if(!$result)
		{
			die( "Error: " . mysqli_error($connection) );
			$_SESSION['msg_error'] = "Error: " . mysqli_error($connection);
		}
		
		
		$message = "Thank you for shopping with us. Your account has been charged and your transaction is successful with following order details: 
								
							<br> 
								Order Id: $order_id<br/>
								Amount: $ResAmount 
								<br />
								
									
						We will be shipping your order to you soon.";
	}
	
}

function decryptAES($code,$key) { 
	$AES_IV="PGKEYENCDECIVSPC";
	$AES_METHOD="AES-256-CBC";
			
	$code	= hex2ByteArray(trim($code));
	$code	= byteArray2String($code);	  
	$code	= base64_encode($code);
	$decrypted = openssl_decrypt($code, $AES_METHOD, $key, OPENSSL_ZERO_PADDING, $AES_IV);
	return pkcs5_unpad($decrypted);
}

function hex2ByteArray($hexString) {
	$string = hex2bin($hexString);
	return unpack('C*', $string);
}

function byteArray2String($byteArray) {
	$chars = array_map("chr", $byteArray);
	return join($chars);
}

function pkcs5_unpad($text) {
	$pad = ord($text{strlen($text)-1});
	if ($pad > strlen($text)) {
		return false;	
	}
	if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
		return false;
	}
	return substr($text, 0, -1 * $pad);
}


exit('end of the script');