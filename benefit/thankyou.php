<?php
echo 'Thank you for your order!</br>';
echo '<pre>';print_r($_POST);

$ResTranData= (isset($_REQUEST['trandata'])? $_REQUEST['trandata'] : null);
$termresourcekey	= '11630213913211630213913211630213';

if($ResTranData !=null)
{
	//Decryption logice starts
	$decryptedData='';
	$encryption = 'aes';
	$decrytedData=decryptAES($ResTranData,$termresourcekey);
	
	$res='';
	parse_str($decrytedData,$res);
	
	echo '<pre>';print_r($res);exit;
	
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
	echo 'success';exit;
	
	$ResPaymentId = $res['paymentid'];
	$ResResult = $res['result'];
	$ResAuth = $res['auth'];
	$ResAVR = $res['avr'];
	$ResRef = $res['ref'];
	$ResTranId = $res['tranid'];
	$ResPostdate = $res['postdate'];
	$ResTrackID = $res['trackid'];
	$ResAmount = $res['amt'];
	$Resudf1 = $res['udf1'];
	$Resudf2 = $res['udf2'];
	$Resudf3 = $res['udf3'];
	$Resudf4 = $res['udf4'];
	$Resudf5 = $res['udf5'];	

	$message = "Thank you for shopping with us. However, the transaction has been declined.";
	if (isset($ResResult) && strtoupper($ResResult) == 'CAPTURED') {
		$message = "Thank you for shopping with us. Your account has been charged and your transaction is successful with following order details: 
								
							<br> 
								Order Id: $ResTrackID<br/>
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