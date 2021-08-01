<?php

class parseResource {
	public $resourcePath = "";
	public $key = "";
	public $error = "";
	public $alias = "";
	function getResourcePath() {
	return $this->resourcePath;
}
function getKey() {
	return $this->key;
}
function getAlias() {
	return $this->alias;
}
function setResourcePath($path) {
	$this->resourcePath = $path;
}
function setAlias($alias) {
	$this->alias = $alias;
}
function setKey($key) {
	$this->key = $key;
}
function createCGZFromCGN() {
	{
		$filenameInput = $this->getResourcePath () . "resource.cgn";
		
		$handleInput = fopen ( $filenameInput, "r" );
		$contentsInput = fread ( $handleInput, filesize ( $filenameInput ) );
		$filenameOutput = $this->getResourcePath () . "resource.cgz";
		@unlink( $filenameOutput );
		$handleOutput = fopen ( $filenameOutput, "w" );
		$dec = $this->decryptData ( $contentsInput, $this->key );
	//echo $dec;
		//die();
		fwrite ( $handleOutput, $dec );
		fclose ( $handleInput );
		fclose ( $handleOutput );
	}
	return true;
}

function readZip() {
	$s = "";
	{
		$filenameInput = $this->getResourcePath () . "resource.cgz";
		$zipentry=null;
		$i = 0;
		$zip = new ZipArchive ();
		$zp = $zip->open($filenameInput);
		if ($zp === TRUE) {
			$zip->extractTo ( $this->resourcePath );
			$zip->close ();
		} else {
			echo 'failed';
			$this->error = "Failed to unzip file";
		}
		 if (strlen ( $this->error ) === 0) {
			$xmlNameInput = $this->resourcePath . $this->getAlias () . ".xml";
			$xmlHandleInput = fopen ( $xmlNameInput, "r" );
			$xmlContentsInput = fread ( $xmlHandleInput, filesize ( $xmlNameInput ) );
			fclose ( $xmlHandleInput );
			unlink($xmlNameInput);
			$s = $xmlContentsInput;
			$S = $s = $this->decryptData ( $s, $this->key );
		} else {
			$this->error = "Unable to open resource";
		} 
		return $s;
	}
}

	//Decryption Method for AES Algorithm Starts

	function decryptData($code,$key) { 
	 
	  $iv = "PGKEYENCDECIVSPC"; 
	  $code = base64_encode($code);
	  $decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
	  return $this->pkcs5_unpad($decrypted);
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
	
	//Decryption Method for AES Algorithm Ends

function getBytes($s) {
	$hex_ary = array ();
	$size = strlen ( $s );
	for($i = 0; $i < $size; $i ++)
		$hex_ary [] = chr ( ord ( $s [$i] ) );
	return $hex_ary;
}

function getString($byteArray) {
	$s = "";
	foreach ( $byteArray as $byte ) {
		$s .= $byte;
	}
	return $s;
}
function StartsWith($Haystack, $Needle) {
	return strpos ( $Haystack, $Needle ) === 0;
}

function EndsWith($Haystack, $Needle) {
	return strrpos ( $Haystack, $Needle ) === strlen ( $Haystack ) - strlen ( $Needle );
}

function xor_string($string) {
	$buf = '';
	$size = strlen ( $string );
	for($i = 0; $i < $size; $i ++)
		$buf .= chr ( ord ( $string [$i] ) ^ 255 );
	return $buf;
}
}

?>