<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$redirect_url	= 'https://suqbahrain.com/benefit/thankyou.php';
$response_url	= 'https://suqbahrain.com/benefit/notify.php';
$gateway_url	= 'https://www.test.benefit-gateway.bh/payment/PaymentHTTP.htm?param=paymentInit';//sandbox
//$gateway_url	= 'https://www.benefit-gateway.bh/payment/PaymentHTTP.htm?param=paymentInit';//production
$baddress	= "111 test";
$saddress	= "111 testing";
$country	= "USA";
$currency_code	= "048";//Bahraini Dinar
$order_total= 1;
$order_id	= 'test'.uniqid();
$tranportalid		= '16175950';
$tranportalpassword	= '16175950';
$termresourcekey	= '11630213913211630213913211630213';



$ReqAction = "action=1&"; //Purchase only
$ReqAmount = "amt=".$order_total."&";
$ReqTrackId = "trackid=".$order_id."&";
$ReqTranportalId = "id=".$tranportalid."&";
$ReqTranportalPassword = "password=".$tranportalpassword."&";
$ReqCurrency = "currencycode=".$currency_code."&"; 
$ReqLangid = "langid=USA&";

$shipping_postcode	= '86327';
$shipping_first_name= 'Jamal';
$shipping_last_name	= 'Hossain';
$billing_phone		= '123456';
$country_code		= '048';//Bahrain
$billing_postcode	= '1212';
$billing_phone		= '11651651';
$billing_email		= 'jamal.hossain94@gmail.com';


/* Shipping */
$Reqship_To_Postalcd = "ship_To_Postalcd=".$shipping_postcode."&";
$Reqship_To_Address = "ship_To_Address=".$saddress."&";
$Reqship_To_LastName = "ship_To_LastName=".$shipping_last_name."&";
$Reqship_To_FirstName = "ship_To_FirstName=".$shipping_first_name."&";
$Reqship_To_Phn_Num = "ship_To_Phn_Num=".$billing_phone."&";
$Reqship_To_CountryCd = "ship_To_CountryCd=".$country_code."&"; 

/* Card Holder Details */
$Reqcard_PostalCd = "card_PostalCd=".$billing_postcode."&";
$Reqcard_Address = "card_Address=".$baddress."&";
$Reqcard_Phn_Num = "card_Phn_Num=".$billing_phone."&";
$Reqcust_email = "cust_email=".$billing_email."&";

$ReqResponseUrl = "&responseURL=".$response_url."&";
$ReqErrorUrl = "&errorURL=".$redirect_url."&";

$ReqUdf1 = "udf1=Test1&";	// UDF1 values 
$ReqUdf2 = "udf2="."Test2"."&";	// UDF2 values 
$ReqUdf3 = "udf3="."Test3"."&";	// UDF3 values 
$ReqUdf5 = "udf5="."Test5"."&"; // UDF5 values to be set with udf4 values of configuration

//$ReqUdf4 = "udf4="."WooCommerce3.6.1_Wordpress5.1.1_PHP7.2&";	// UDF4 is a fixed value for tracking
$ReqUdf4 = "udf4="."Test4&";

/*if($this->udf1 !="")
$ReqUdf1 = "udf1=".$this->udf1."&";
if($this->udf2 !="")
$ReqUdf2 = "udf2=".$this->udf2."&";
if($this->udf3 !="")
$ReqUdf3 = "udf3=".$this->udf3."&";
if($this->udf4 !="")
$ReqUdf5 = "udf5=".$this->udf4."&";*/


$TranRequest=$ReqAmount.$ReqAction.$ReqResponseUrl.$ReqErrorUrl.$ReqTrackId.$ReqCurrency.$ReqLangid.$ReqTranportalId.$ReqTranportalPassword.
$Reqship_To_Postalcd.$Reqship_To_Address.$Reqship_To_LastName.$Reqship_To_FirstName.$Reqship_To_Phn_Num.$Reqship_To_CountryCd.$Reqcard_PostalCd.
$Reqcard_Address.$Reqcard_Phn_Num.$Reqcust_email.$ReqUdf1.$ReqUdf2.$ReqUdf3.$ReqUdf4.$ReqUdf5;


$encryption = 'aes';

//echo  $TranRequest;exit;

$req='';
$req = "&trandata=".encryptAES($TranRequest,$termresourcekey);

$req = $req.$ReqErrorUrl.$ReqResponseUrl."&tranportalId=".$tranportalid;
//echo $req;exit;

$html= '<script language="javascript">window.location.href ="'.$gateway_url.$req.'";</script>';

echo $html;exit;

function encryptAES($str,$key) {
	$AES_IV="PGKEYENCDECIVSPC";
	$AES_METHOD="AES-256-CBC";
			
	$str = pkcs5_pad($str); 
	$encrypted = openssl_encrypt($str, $AES_METHOD, $key, OPENSSL_ZERO_PADDING, $AES_IV);
	$encrypted = base64_decode($encrypted);
	$encrypted = unpack('C*', ($encrypted));
	$encrypted = byteArray2Hex($encrypted);
	$encrypted = urlencode($encrypted);
	return $encrypted;
}
function pkcs5_pad ($text) {
	$AES_METHOD="AES-256-CBC";
	$blocksize = openssl_cipher_iv_length($AES_METHOD);
	$pad = $blocksize - (strlen($text) % $blocksize);
	return $text . str_repeat(chr($pad), $pad);
}
function byteArray2Hex($byteArray) {
	$chars = array_map("chr", $byteArray);
	$bin = join($chars);
	return bin2hex($bin);
}
/*
//if($encryption == 'aes')
	//$req = "&trandata=".encryptAES($TranRequest,$termresourcekey);
//elseif($encryption == 'tdes')
	//$req = "&trandata=".encryptTDES($TranRequest,$termresourcekey);

$req = $req.$ReqErrorUrl.$ReqResponseUrl."&tranportalId=".$tranportalid;

$html= '<script language="javascript">window.location.href ="'.$gateway_url.$req.'";</script>';

echo $html;exit;






function pkcs5_pad ($text) {
	$AES_METHOD="AES-256-CBC";
	$blocksize = openssl_cipher_iv_length($AES_METHOD);
	$pad = $blocksize - (strlen($text) % $blocksize);
	return $text . str_repeat(chr($pad), $pad);
}



// TDES Functions start
function encryptTDES($payload, $key) {  
	$chiper = "des-ede3";  //Algorthim used to encrypt
	if((strlen($payload)%8)!=0) {
		//Perform right padding
		$payload = rightPadZeros($payload);
	}
	$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($chiper));
	$encrypted = openssl_encrypt($payload, $chiper, $key,OPENSSL_RAW_DATA,$iv);
	
	$encrypted=unpack('C*', ($encrypted));
	$encrypted=byteArray2Hex($encrypted);
	return strtoupper($encrypted);  
}

function rightPadZeros($Str) {
	if(null == $Str){
		return null;
	}
	$PadStr = $Str;
	
	for ($i = strlen($Str);($i%8)!=0; $i++) {
		$PadStr .= "^";
	}
	return $PadStr;
}