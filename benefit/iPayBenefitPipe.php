<?php
include ("parseResource.php");
include ("keystore.php");

class iPayBenefitPipe {
	protected $id = "";
	protected $action = "";
	protected $transId = "";
	protected $amt = "";
	protected $responseURL = "";
	protected $trackId = "";
	protected $udf1 = "";
	protected $udf2 = "";
	protected $udf3 = "";
	protected $udf4 = "";
	protected $udf5 = "";
	protected $paymentPage = "";
	protected $paymentId = "";
	protected $result = "";
	protected $auth = "";
	protected $ref = "";
	protected $avr = "";
	protected $date = "";
	protected $currency = "";
	protected $errorURL = "";
	protected $language = "";
	protected $error = "";
	protected $error_text = "";
	protected $rawResponse = "";
	protected $alias = "";
	protected $debugMsg = "";
	protected $responseCode = "";
	protected $zip = "";
	protected $addr = "";
	protected $member = "";
	protected $cvv2 = "";
	protected $cvv2Verification = "";
	protected $type = "";
	protected $card = "";
	protected $expDay = "";
	protected $expMonth = "";
	protected $expYear = "";
	protected $eci = "";
	protected $cavv = "";
	protected $xid = "";
	protected $resourcePath = "";
	protected $acsurl = "";
	protected $pareq = "";
	protected $pares = "";
	protected $error_service_tag = "";
	protected $keystorePath = "";
	protected $seperator = "\\";
	protected $sep = "/";
	protected $webAddress = "";
	protected $key = "";
	protected $initializationVector = "";
	protected $ivrFlag = "";
	protected $npc356chphoneidformat = "";
	protected $npc356chphoneid = "";
	protected $npc356shopchannel = "";
	protected $npc356availauthchannel = "";
	protected $npc356pareqchannel = "";
	protected $npc356itpcredential = "";
	protected $authDataName = "";
	protected $authDatastrlen = "";
	protected $authDataType = "";
	protected $authDataLabel = "";
	protected $authDataPrompt = "";
	protected $authDataEncryptKey = "";
	protected $authDataEncryptType = "";
	protected $authDataEncryptMandatory = "";
	protected $ivrPasswordStatus = "";
	protected $ivrPassword = "";
	protected $itpauthtran = "";
	protected $itpauthiden = "";
	protected $url = "";
	protected $savedcard = "";
	protected $paymentdebitId = "";
	protected $paymentUrl = "";
	protected $authRespCode = "";

	function getid() {
		return $this->id;
	}
	function getaction() {
		return $this->action;
	}
	function gettransId() {
		return $this->transId;
	}
	function getamt() {
		return $this->amt;
	}
	function getresponseURL() {
		return $this->responseURL;
	}
	function gettrackId() {
		return $this->trackId;
	}
	function getudf1() {
		return $this->udf1;
	}
	function getudf2() {
		return $this->udf2;
	}
	function getudf3() {
		return $this->udf3;
	}
	function getudf4() {
		return $this->udf4;
	}
	function getudf5() {
		return $this->udf5;
	}
	function getpaymentPage() {
		return $this->paymentPage;
	}
	function getpaymentId() {
		return $this->paymentId;
	}
	function getresult() {
		return $this->result;
	}
	function getauth() {
		return $this->auth;
	}
	function getref() {
		return $this->ref;
	}
	function getavr() {
		return $this->avr;
	}
	function getDate() {
		return $this->date;
	}
	function getcurrency() {
		return $this->currency;
	}
	function geterrorURL() {
		return $this->errorURL;
	}
	function getlanguage() {
		return $this->language;
	}
	function geterror() {
		return $this->error;
	}
	function geterror_text() {
		return $this->error_text;
	}
	function getrawResponse() {
		return $this->rawResponse;
	}
	function getalias() {
		return $this->alias;
	}
	function getDebugMsg() {
		return $this->debugMsg;
	}
	function getresponseCode() {
		return $this->responseCode;
	}
	function getzip() {
		return $this->zip;
	}
	function getaddr() {
		return $this->addr;
	}
	function getmember() {
		return $this->member;
	}
	function getcvv2() {
		return $this->cvv2;
	}
	function getcvv2Verification() {
		return $this->cvv2Verification;
	}
	function getType() {
		return $this->type;
	}
	function getcard() {
		return $this->card;
	}
	function getexpDay() {
		return $this->expDay;
	}
	function getexpMonth() {
		return $this->expMonth;
	}
	function getexpYear() {
		return $this->expYear;
	}
	function geteci() {
		return $this->eci;
	}
	function getcavv() {
		return $this->cavv;
	}
	function getxid() {
		return $this->xid;
	}
	function getresourcePath() {
		return $this->resourcePath;
	}
	function getacsurl() {
		return $this->acsurl;
	}
	function getpareq() {
		return $this->pareq;
	}
	function getpares() {
		return $this->pares;
	}
	function geterror_service_tag() {
		return $this->error_service_tag;
	}
	function getkeystorePath() {
		return $this->keystorePath;
	}
	function getseperator() {
		return $this->seperator;
	}
	function getsep() {
		return $this->sep;
	}
	function getwebAddress() {
		return $this->webAddress;
	}
	function getkey() {
		return $this->key;
	}
	function getinitializationVector() {
		return $this->initializationVector;
	}
	function getivrFlag() {
		return $this->ivrFlag;
	}
	function getnpc356chphoneidformat() {
		return $this->npc356availauthchannel;
	}
	function getnpc356chphoneid() {
		return $this->npc356chphoneid;
	}
	function getnpc356shopchannel() {
		return $this->npc356shopchannel;
	}
	function getnpc356availauthchannel() {
		return $this->npc356availauthchannel;
	}
	function getnpc356pareqchannel() {
		return $this->npc356itpcredential;
	}
	function getnpc356itpcredential() {
		return $this->npc356itpcredential;
	}
	function getauthDataName() {
		return $this->authDataName;
	}
	function getauthDatastrlen() {
		return $this->authDatastrlen;
	}
	function getauthDataType() {
		return $this->authDataType;
	}
	function getauthDataLabel() {
		return $this->authDataLabel;
	}
	function getauthDataPrompt() {
		return $this->authDataPrompt;
	}
	function getauthDataEncryptKey() {
		return $this->authDataEncryptKey;
	}
	function getauthDataEncryptType() {
		return $this->authDataEncryptType;
	}
	function getauthDataEncryptMandatory() {
		return $this->authDataEncryptMandatory;
	}
	function getivrPasswordStatus() {
		return $this->ivrPasswordStatus;
	}
	function getivrPassword() {
		return $this->ivrPassword;
	}
	function getitpauthtran() {
		return $this->itpauthtran;
	}
	function getitpauthiden() {
		return $this->itpauthiden;
	}
	function geturl() {
		return $this->url;
	}
	function getsavedcard() {
		return $this->savedcard;
	}
	function getpaymentdebitId() {
		return $this->paymentdebitId;
	}
	function getpaymentUrl() {
		return $this->paymentUrl;
	}
	function getAuthRespCode() {
		return $this->authRespCode;
	}
	function setid($val) {
		$this->id = $val;
	}
	function setaction($val) {
		$this->action = $val;
	}
	function settransId($val) {
		$this->transId = $val;
	}
	function setamt($val) {
		$this->amt = $val;
	}
	function setresponseURL($val) {
		$this->responseURL = $val;
	}
	function settrackId($val) {
		$this->trackId = $val;
	}
	function setudf1($val) {
		$this->udf1 = $val;
	}
	function setudf2($val) {
		$this->udf2 = $val;
	}
	function setudf3($val) {
		$this->udf3 = $val;
	}
	function setudf4($val) {
		$this->udf4 = $val;
	}
	function setudf5($val) {
		$this->udf5 = $val;
	}
	function setpaymentPage($val) {
		$this->paymentPage = $val;
	}
	function setpaymentId($val) {
		$this->paymentId = $val;
	}
	function setresult($val) {
		$this->result = $val;
	}
	function setauth($val) {
		$this->auth = $val;
	}
	function setref($val) {
		$this->ref = $val;
	}
	function setavr($val) {
		$this->avr = $val;
	}
	function setDate($val) {
		$this->date = $val;
	}
	function setcurrency($val) {
		$this->currency = $val;
	}
	function seterrorURL($val) {
		$this->errorURL = $val;
	}
	function setlanguage($val) {
		$this->language = $val;
	}
	function seterror($val) {
		$this->error = $val;
	}
	function seterror_text($val) {
		$this->error_text = $val;
	}
	function setrawResponse($val) {
		$this->rawResponse = $val;
	}
	function setalias($val) {
		$this->alias = $val;
	}
	function setDebugMsg($val) {
		$this->debugMsg = $val;
	}
	function setresponseCode($val) {
		$this->responseCode = $val;
	}
	function setzip($val) {
		$this->zip = $val;
	}
	function setaddr($val) {
		$this->addr = $val;
	}
	function setmember($val) {
		$this->member = $val;
	}
	function setcvv2($val) {
		$this->cvv2 = $val;
	}
	function setcvv2Verification($val) {
		$this->cvv2Verification = $val;
	}
	function setType($val) {
		$this->type = $val;
	}
	function setcard($val) {
		$this->card = $val;
	}
	function setexpDay($val) {
		$this->expDay = $val;
	}
	function setexpMonth($val) {
		$this->expMonth = $val;
	}
	function setexpYear($val) {
		$this->expYear = $val;
	}
	function seteci($val) {
		$this->eci = $val;
	}
	function setcavv($val) {
		$this->cavv = $val;
	}
	function setxid($val) {
		$this->xid = $val;
	}
	function setresourcePath($val) {
		$this->resourcePath = $val;
	}
	function setacsurl($val) {
		$this->acsurl = $val;
	}
	function setpareq($val) {
		$this->pareq = $val;
	}
	function setpares($val) {
		$this->pares = $val;
	}
	function seterror_service_tag($val) {
		$this->error_service_tag = $val;
	}
	function setkeystorePath($val) {
		$this->keystorePath = $val;
	}
	function setseperator($val) {
		$this->seperator = $val;
	}
	function setsep($val) {
		$this->sep = $val;
	}
	function setwebAddress($val) {
		$this->webAddress = $val;
	}
	function setkey($val) {
		$this->key = $val;
	}
	function setinitializationVector($val) {
		$this->initializationVector = $val;
	}
	function setivrFlag($val) {
		$this->ivrFlag = $val;
	}
	function setnpc356chphoneidformat($val) {
		$this->npc356availauthchannel = $val;
	}
	function setnpc356chphoneid($val) {
		$this->npc356chphoneid = $val;
	}
	function setnpc356shopchannel($val) {
		$this->npc356shopchannel = $val;
	}
	function setnpc356availauthchannel($val) {
		$this->npc356availauthchannel = $val;
	}
	function setnpc356pareqchannel($val) {
		$this->npc356itpcredential = $val;
	}
	function setnpc356itpcredential($val) {
		$this->npc356itpcredential = $val;
	}
	function setauthDataName($val) {
		$this->authDataName = $val;
	}
	function setauthDatastrlen($val) {
		$this->authDatastrlen = $val;
	}
	function setauthDataType($val) {
		$this->authDataType = $val;
	}
	function setauthDataLabel($val) {
		$this->authDataLabel = $val;
	}
	function setauthDataPrompt($val) {
		$this->authDataPrompt = $val;
	}
	function setauthDataEncryptKey($val) {
		$this->authDataEncryptKey = $val;
	}
	function setauthDataEncryptType($val) {
		$this->authDataEncryptType = $val;
	}
	function setauthDataEncryptMandatory($val) {
		$this->authDataEncryptMandatory = $val;
	}
	function setivrPasswordStatus($val) {
		$this->ivrPasswordStatus = $val;
	}
	function setivrPassword($val) {
		$this->ivrPassword = $val;
	}
	function setitpauthtran($val) {
		$this->itpauthtran = $val;
	}
	function setitpauthiden($val) {
		$this->itpauthiden = $val;
	}
	function seturl($val) {
		$this->url = $val;
	}
	function setsavedcard($val) {
		$this->savedcard = $val;
	}
	function setpaymentdebitId($val) {
		$this->paymentdebitId = $val;
	}
	function setpaymentUrl($val) {
		$this->paymentUrl = $val;
	}
	function setAuthRespCode($val) {
		$this->authRespCode = $val;
	}

	function buildHostRequest() {
		$strRequest = "";
		try {
			if (strlen ( $this->amt ) > 0) {
				$strRequest .= "amt=" . $this->amt . "&";
			}
			if (strlen ( $this->action ) > 0) {
				$strRequest .= "action=" . $this->action . "&";
			}
			if (strlen ( $this->responseURL ) > 0) {
				$strRequest .= "responseURL=" . $this->responseURL . "&";
			}
			if (strlen ( $this->errorURL ) > 0) {
				$strRequest .= "errorURL=" . $this->errorURL . "&";
			}
			if (strlen ( $this->trackId ) > 0) {
				$strRequest .= "trackid=" . $this->trackId . "&";
			}
			if (strlen ( $this->udf1 ) > 0) {
				$strRequest .= "udf1=" . $this->udf1 . "&";
			}
			if (strlen ( $this->udf2 ) > 0) {
				$strRequest .= "udf2=" . $this->udf2 . "&";
			}
			if (strlen ( $this->udf3 ) > 0) {
				$strRequest .= "udf3=" . $this->udf3 . "&";
			}
			if (strlen ( $this->udf4 ) > 0) {
				$strRequest .= "udf4=" . $this->udf4 . "&";
			}
			if (strlen ( $this->udf5 ) > 0) {
				$strRequest .= "udf5=" . $this->udf5 . "&";
			}
			if (strlen ( $this->currency ) > 0) {
				$strRequest .= "currencycode=" . $this->currency . "&";
			}
			if ($this->language != null && strlen ( $this->language ) > 0) {
				$strRequest .= "langid=" . $this->language . "&";
			}
			return $strRequest;
		} catch ( Exception $e ) {
			return null;
		}
	}
	
	function buildXMLRequest() {
		$requestbuffer = "";
		try {
			$requestbuffer=$requestbuffer . "<request>";
			if ($this->card != null)
				if (strlen ( $this->card ) > 0) {
					$requestbuffer .= "<card>" . $this->card . "</card>";
				}
			if ($this->cvv2 != null)
				if (strlen ( $this->cvv2 ) > 0) {
					$requestbuffer .= "<cvv2>" . $this->cvv2 . "</cvv2>";
				}
			if ($this->currency != null)
				if (strlen( $this->currency ) > 0) {
					$requestbuffer .= "<currencycode>" . $this->currency . "</currencycode>";
				}
			if ($this->expYear != null)
				if (strlen( $this->expYear ) > 0) {
					$requestbuffer .= "<expyear>" . $this->expYear . "</expyear>";
				}
			if ($this->expMonth != null)
				if (strlen ( $this->expMonth ) > 0) {
					$requestbuffer .= "<expmonth>" . $this->expMonth . "</expmonth>";
				}
			if ($this->expDay != null)
				if (strlen ( $this->expDay ) > 0) {
					$requestbuffer .= "<expday>" . "01" . "</expday>";
				}
			if ($this->type != null)
				if (strlen ( $this->type ) > 0) {
					$requestbuffer .= "<type>" . $this->type . "</type>";
				}
			if ($this->transId != null)
				if (strlen ( $this->transId ) > 0) {
					$requestbuffer .= "<transid>" . $this->transId . "</transid>";
				}
			if ($this->zip != null)
				if (strlen ( $this->zip ) > 0) {
					$requestbuffer .= "<zip>" . $this->zip . "</zip>";
				}
			if ($this->addr != null)
				if (strlen ( $this->addr ) > 0) {
					$requestbuffer .= "<addr>" . $this->addr . "</addr>";
				}
			if ($this->member != null)
				if (strlen ( $this->member ) > 0) {
					$requestbuffer .= "<member>" . $this->member . "</member>";
				}
			if ($this->amt != null)
				if (strlen ( $this->amt ) > 0) {
					$requestbuffer .= "<amt>" . $this->amt . "</amt>";
				}
			if ($this->action != null)
				if (strlen ( $this->action ) > 0) {
					$requestbuffer .= "<action>" . $this->action . "</action>";
				}
			if ($this->trackId != null)
				if (strlen ( $this->trackId ) > 0) {
					$requestbuffer .= "<trackid>" . $this->trackId . "</trackid>";
				}
			if ($this->udf1 != null)
				if (strlen ( $this->udf1 ) > 0) {
					$requestbuffer .= "<udf1>" . $this->udf1 . "</udf1>";
				}
			if ($this->udf2 != null)
				if (strlen ( $this->udf2 ) > 0) {
					$requestbuffer .= "<udf2>" . $this->udf2 . "</udf2>";
				}
			if ($this->udf3 != null)
				if (strlen ( $this->udf3 ) > 0) {
					$requestbuffer .= "<udf3>" . $this->udf3 . "</udf3>";
				}
			if ($this->udf4 != null)
				if (strlen ( $this->udf4 ) > 0) {
					$requestbuffer .= "<udf4>" . $this->udf4 . "</udf4>";
				}
			if ($this->udf5 != null)
				if (strlen ( $this->udf5 ) > 0) {
					$requestbuffer .= "<udf5>" . $this->udf5 . "</udf5>";
				}
			if ($this->currency != null)
				if (strlen ( $this->currency ) > 0) {
					$requestbuffer .= "<currency>" . $this->amt . "</currency>";
				}
			if ($this->eci != null)
				if (strlen ( $this->eci ) > 0) {
					$requestbuffer .= "<eci>" . $this->eci . "</eci>";
				}
			if ($this->errorURL != null)
				if (strlen ( $this->errorURL ) > 0) {
					$requestbuffer .= "<errorURL>" . $this->errorURL . "</errorURL>";
				}
			if ($this->responseURL != null)
				if (strlen ( $this->responseURL ) > 0) {
					$requestbuffer .= "<responseURL>" . $this->responseURL . "</responseURL>";
				}
			if ($this->ivrFlag != null)
				if (strlen ( $this->ivrFlag ) > 0) {
					$requestbuffer .= "<ivrFlag>" . $this->ivrFlag . "</ivrFlag>";
				}
			if ($this->npc356chphoneidformat != null)
				if (strlen ( $this->npc356chphoneidformat ) > 0) {
					$requestbuffer .= "<npc356chphoneidformat>" . $this->npc356chphoneidformat . "</npc356chphoneidformat>";
				}
			if ($this->npc356chphoneid != null)
				if (strlen ( $this->npc356chphoneid ) > 0) {
					$requestbuffer .= "<npc356chphoneid>" . $this->npc356chphoneid . "</npc356chphoneid>";
				}
			if ($this->npc356shopchannel != null)
				if (strlen ( $this->npc356shopchannel ) > 0) {
					$requestbuffer .= "<npc356shopchannel>" . $this->npc356shopchannel . "</npc356shopchannel>";
				}
			if ($this->npc356availauthchannel != null)
				if (strlen ( $this->npc356availauthchannel ) > 0) {
					$requestbuffer .= "<npc356availauthchannel>" . $this->npc356availauthchannel . "</npc356availauthchannel>";
				}
			if ($this->npc356pareqchannel != null)
				if (strlen ( $this->npc356pareqchannel ) > 0) {
					$requestbuffer .= "<npc356pareqchannel>" . $this->npc356pareqchannel . "</npc356pareqchannel>";
				}
			if ($this->npc356itpcredential != null)
				if (strlen ( $this->npc356itpcredential ) > 0) {
					$requestbuffer .= "<npc356itpcredential>" . $this->npc356itpcredential . "</npc356itpcredential>";
				}
			if ($this->ivrPasswordStatus != null && $this->ivrPasswordStatus . strlen () > 0)
				$requestbuffer .= "<ivrPasswordStatus>" . $this->ivrPasswordStatus . "</ivrPasswordStatus>";
			if ($this->ivrPassword != null && strlen ( $this->ivrPassword ) > 0) {
				$requestbuffer .= "<ivrPassword>" . $this->ivrPassword . "</ivrPassword>";
			}
			if ($this->savedcard != null) {
				$requestbuffer .= "<savedcard>" . $this->savedcard . "</savedcard>";
			}
			return $requestbuffer;
		} catch ( Exception $e ) {
			return null;
		}
	}
	
	function performPaymentInitializationHTTP() {
		$request = null;
		$requestbuffer = null;
		$xmlData = null;
		try {
		
		    $keyParser = new KeyStore();
			$this->key = $keyParser->parseKeyStore ($this->keystorePath);
						//echo $this->resourcePath;
					//	echo $this->key;
  // die();
			
			$xmlData = $this->parseResource ( $this->key, $this->resourcePath, $this->alias );
	
			
			if ($xmlData != null) {
				$xmlData = $this->parseXMLRequest ( $xmlData );
			} else {
				$error = "Alias name does not exits";
			}
			
			$this->key = $xmlData ['resourceKey'];
			
			                 // $this->key ="925664612116925664612119";
					//echo $this->key;
     //die();
			
			$this->setId ( $xmlData ['id'] );
			//echo $this->$xmlData ['id'];
               // die();			
			
			$requestbuffer = $this->buildHostRequest ();
			$requestbuffer .= "id=" . $xmlData ['id'] . "&password=" . $xmlData ['password'] . "&";
			$this->webAddress = $xmlData ['webaddress'];
			
			//$this ->$requestbuffer;
			//die();
			
			
			$cipheredText = $this->encryptAES( $requestbuffer, $this->key );
			
			$request .= "&trandata=" . $cipheredText;
					
			$request .= "&errorURL=" . $this->errorURL . "&responseURL=" . $this->responseURL . "&tranportalId=" . $xmlData ['id'];
			//$request .= "&errorURL=" . $this->errorURL . "&responseURL=" . $this->responseURL . "&tranportalId=" ."112233001T";
				//echo $request;
    //die();
//$this->webAddress="http://10.44.73.173:8080/FSSNET_BENEFIT";
			$this->webAddress .= "/PaymentHTTP.htm?param=paymentInit" . $request;
				//	echo $this->webAddress;
     //die();
			
		} catch( Exception $e ) {
			$this->error = "Problem while encrypting request data";
			return - 1;
		}
		return 0;
	}

	function performTransactionHTTP() {
		$request = null;
		$requestbuffer = null;
		$xmlData = null;
		try {
			$requestbuffer = $this->buildXMLRequest ();
			$keyParser = new KeyStore();
			$this->key = $keyParser->parseKeyStore ( $this->keystorePath );
			$xmlData = $this->parseResource ( $this->key, $this->resourcePath, $this->alias );
			
			if ($xmlData == null) {
				$this->error = "Alias name does not exits";
				return - 1;
			} else {
				$xmlData = $this->parseXMLRequest( $xmlData );
			}
			
			$requestbuffer .= "<id>". $xmlData ['id'] ."</id>";
			$requestbuffer .= "<password>". $xmlData ['password'] ."</password>";
			$requestbuffer .= "</request>";
			if ($this->responseURL == null || strlen ( trim ( $this->responseURL ) ) <= 0) {
				$this->error = "Response URL is Invalid or NULL";
				return - 1;
			}
			$this->key = $xmlData ['resourceKey'];
			$cipheredText = $this->encryptAES($requestbuffer, $this->key);
			$request .= "&trandata=" . $cipheredText;
			$request .= "&errorURL=" . $this->errorURL;
			$request .= "&responseURL=" . $this->responseURL;
			$request .= "&tranportalId=" . $xmlData ['id'];
			$this->webAddress = $xmlData ['webaddress'];
			$this->setid ( $xmlData ['id'] . "" );
			$this->webAddress .= "/tranPipeHTTP.htm?param=tranInit" . $request;
			return 0;
		} catch ( Exception $e ) {
			$this->error = "Error :(";
			return - 1;
		}
	}

	function parseResource($key, $resourcePath, $alias) {
		$xmlData = null;
		$key = null;
		
		try {
			$parseResouce = new parseResource();
			$parseResouce->setResourcePath ( $resourcePath );
			$parseResouce->setKey ( $this->key );
			$parseResouce->setAlias ( $alias );
			$parseResouce->createCGZFromCGN ();
			$xmlData = $parseResouce->readZip ();
			return $xmlData;
		} catch ( Exception $e ) {
			return null;
		}
	}
	
	function parseEncryptedResultHttp($response) {
		$xmlData = null;
		
		try {
			
			$keyParser = new KeyStore();
			$this->key = $keyParser->parseKeyStore ( $this->keystorePath );
			$xmlData = $this->parseResource ( $this->key, $this->resourcePath, $this->alias );
			if ($xmlData != null) {
				$hm = $this->parseXMLRequest ( $xmlData );
			} else {
				$this->error = "Alias name does not exits";
			}
			$this->key = $hm ['resourceKey'];
			$cipheredText = $this->decryptData ( $response, $this->key );
			if ($cipheredText == null) {
				$this->error = "Invalid response";
				return - 1;
			}
			return parsetrandata ( $cipheredText );
		} catch ( Exception $e ) {
			$this->error = "Internal Error: " + $e->getMessage ();
			return - 1;
		}
	}
	function performVbVTransaction() {
		$request = null;
		$xmlData = null;
		$requestbuffer = null;
		$hm = null;
		try {
			
			$requestbuffer = $this->buildXMLRequest ();
			$keyParser = new KeyStore();
			$this->key = $keyParser->parseKeyStore($this->keystorePath );
			$xmlData = $this->parseResource ( $this->key, $this->resourcePath, $this->alias );
			if ($xmlData == null) {
				$this->error = "Alias name does not exits";
				return - 1;
			} else {
				$hm = $this->parseXMLRequest ( $xmlData );
			}
			$requestbuffer .="<id>" . $hm ['id'] . "</id>";
			$requestbuffer .="<password>" . $hm ['password'] . "</password>";
			$requestbuffer .= "</request>";
			if ($this->responseURL == null || strlen ( trim ( $this->responseURL ) ) == 0) {
				return - 1;
			}
			$this->key = $hm ['resourceKey'];
			
			$cipheredText = $this->encryptAES( $requestbuffer, $this->key );
			
			$request = "&trandata=" . $cipheredText . "&errorURL=" . $this->errorURL . "&responseURL=" . $this->responseURL . "&tranportalId=" . $hm ['id'];
			
			$this->webAddress = $hm ['webaddress'];
			$this->webAddress .= "/VPAS.htm?actionVPAS=VbvVEReqProcessHTTP" . $request;
			return 0;
		} catch ( Exception $e ) {
			$this->error = "Error! " . $e->getMessage ();
			return - 1;
		} 
	}
	function parseEncryptedRequest($trandata) {
		$result = 0;
		$xmlData = null;
		$hm = null;
		try {
			if ($trandata == null) {
				return 0;
			}
			
		
			$keyParser = new KeyStore();
			$this->key = $keyParser->parseKeyStore ( $this->keystorePath );
			$xmlData = $this->parseResource ( $this->key, $this->resourcePath, $this->alias );
			if ($xmlData != null) {
				$hm = $this->parseXMLRequest ( $xmlData );
			} else {
				$this->error = "Alias name does not exits";
			}
			$this->key = $hm ['resourceKey'];
			$trandata = $this->decryptData ( $trandata, $this->key );
			
			$result = $this->parsetrandata($trandata);
			//echo "kkkkkkk";
			//echo $trandata;
			//die();
			return $result;
		} catch ( Exception $e ) {
			return - 1;
		}
	}
	function parseEncryptedResult($response) {
		$xmlData = null;
		$hm = null;
		$resultMap = null;
		try {
			$keyParser = new KeyStore();
			$this->key = $keyParser->parseKeyStore ( $this->keystorePath );
			$xmlData = $this->parseResource ( $this->key, $this->resourcePath, $this->alias );
			if ($xmlData != null) {
				$hm = $this->parseXMLRequest ( $xmlData );
			} else {
				$this->error = "Alias name does not exits";
			}
			$this->key = $hm ['resourceKey'];
			$response = $this->decryptData($response, $this->key);
			$resultMap = $this->parseResponse($response);
			return $this->setTransactionData($resultMap);
		} catch ( Exception $e ) {
			$this->error = "Internal Error: " + e . getMessage ();
			return - 1;
		}
	}
	function parseXMLRequest($request) {
		try {
			$responseMap = null;
			$request = trim ($request );
			$request = substr ( $request, strpos ( $request, "<id>" ), strlen ( $request ) - strpos ( $request, "<id>" ) );
			$request = str_replace ( "</terminal>", "", $request );
			$pos = strpos ( $request, "<" ) == 0;
			if ($request == null || (strlen ( $request ) < 0) || $pos === false) {
				return null;
			} else {
				try {
					$responseMap = $this->parseResponse ( $request );
				} catch ( Exception $ex ) {
					return null;
				}
			}
			return $responseMap;
		} catch ( Exception $e ) {
			return null;
		}
	}
	function parseResponse($response) {
		$begin = 0;
		$end = 0;
		$start = null;
		$value = null;
		$map=[];
		$maps=[];
		$response = trim ( $response );

		$pos = strpos ( $response, "<" ) == 0;
		if ($response == null || (strlen ( $response ) < 0) || $pos === false) {
			return null;
		} else {
			do {
				
				if ((strpos ( $response, '<' ) !== false) && (strpos ( $response, '>' ) !== false)) {
					$start = substr ( $response, ($ind = strpos ( $response, "<" )) + 1, ((strpos ( $response, ">" ) - 1) - $ind) );
					$mapKey = substr ( $response, ($ind = strpos ( $response, ">" )) + 1, ((strpos ( $response, "</" . $start . ">" ) - 1) - $ind) );
					$response = substr ( $response, $from = strpos ( $response, "</" . $start . ">" ) + strlen ( $start ) + 3, strrpos ( $response, ">" ) - $from + 1 );
					$maps [$start] = $mapKey;
				} else {
					break;
				}
			} while ( strlen ( $response ) > 0 );
		}
		return $maps;
	}
	function setTransactionData($resultMap) {
		if (isset ( $resultMap ['error'] )) {
			$this->error = trim ( $resultMap ['error'] );
		}
		if (isset ( $resultMap ['url'] ))
			$this->acsurl = trim ( $resultMap ['url'] );
		if (isset ( $resultMap ['PAReq'] ))
			$this->pareq = trim ( $resultMap ['PAReq'] );
		if (isset ( $resultMap ['paymentid'] ))
			$this->paymentId = trim ( $resultMap ['paymentid'] );
		if (isset ( $resultMap ['payid'] ))
			$this->paymentId = trim ( $resultMap ['payid'] );
		if (isset ( $resultMap ['eci'] ))
			$this->eci = trim ( $resultMap ['eci'] );
		if (isset ( $resultMap ['result'] ))
			$this->result = trim ( $resultMap ['result'] );
		if (isset ( $resultMap ['auth'] ))
			$this->auth = trim ( $resultMap ['auth'] );
		if (isset ( $resultMap ['ref'] ))
			$this->ref = trim ( $resultMap ['ref'] );
		if (isset ( $resultMap ['avr'] ))
			$this->avr = trim ( $resultMap ['avr'] );
		if (isset ( $resultMap ['postdate'] ))
			$this->date = trim ( $resultMap ['postdate'] );
		if (isset ( $resultMap ['tranid'] ))
			$this->transId = trim ( $resultMap ['tranid'] );
		if (isset ( $resultMap ['amt'] ))
			$this->amt = trim ( $resultMap ['amt'] );
		if (isset ( $resultMap ['trackid'] ))
			$this->trackId = trim ( $resultMap ['trackid'] );
		if (isset ( $resultMap ['trackId'] ))
			$this->trackId = trim ( $resultMap ['trackId'] );
		if (isset ( $resultMap ['udf1'] ))
			$this->udf1 = trim ( $resultMap ['udf1'] );
		if (isset ( $resultMap ['udf2'] ))
			$this->udf2 = trim ( $resultMap ['udf2'] );
		if (isset ( $resultMap ['udf3'] ))
			$this->udf3 = trim ( $resultMap ['udf3'] );
		if (isset ( $resultMap ['udf4'] ))
			$this->udf4 = trim ( $resultMap ['udf4'] );
		if (isset ( $resultMap ['udf5'] ))
			$this->udf5 = trim ( $resultMap ['udf5'] );
		if (isset ( $resultMap ['error_code_tag'] ))
			$this->error = trim ( $resultMap ['error_code_tag'] );
		if (isset ( $resultMap ['error_service_tag'] ))
			$this->error_service_tag = trim ( $resultMap ['error_service_tag'] );
		if (isset ( $resultMap ['error_text'] ))
			$this->error_text = trim ( $resultMap ['error_text'] );
		if (isset ( $resultMap ['responsecode'] ))
			$this->responseCode = trim ( $resultMap ['responsecode'] );
		if (isset ( $resultMap ['cvv2response'] ))
			$this->cvv2Verification = trim ( $resultMap ['cvv2response'] );
		if (isset ( $resultMap ['paymentId'] ))
			$this->paymentdebitId = trim ( $resultMap ['paymentId'] );
		if (isset ( $resultMap ['authRespCode'] ))
			$this->authRespCode = trim ( $resultMap ['authRespCode'] );		
		if (isset ( $resultMap ['paymenturl'] )) {
			$this->paymentUrl = trim ( $resultMap ['paymenturl'] );
			return 2;
		}
		return 0;
	}
	function parsetrandata($trandata) {
		try {
			$splitData = $this->splitData ( $trandata );
			if (isset ( $splitData ['paymentid'] )) {
				$this->paymentId = $splitData ['paymentid'];
			}
			if (isset ( $splitData ['result'] )) {
				$this->result = $splitData ['result'];
			}
			if (isset ( $splitData ['authRespCode'] )) {
				$this->authRespCode = $splitData ['authRespCode'];
			}
			if (isset ( $splitData ['udf1'] )) {
				$this->udf1 = $splitData ['udf1'];
			}
			if (isset ( $splitData ['udf2'] )) {
				$this->udf2 = $splitData ['udf2'];
			}
			if (isset ( $splitData ['udf3'] )) {
				$this->udf3 = $splitData ['udf3'];
			}
			if (isset ( $splitData ['udf4'] )) {
				$this->udf4 = $splitData ['udf4'];
			}
			if (isset ( $splitData ['udf5'] )) {
				$this->udf5 = $splitData ['udf5'];
			}
			if (isset ( $splitData ['amt'] )) {
				$this->amt = $splitData ['amt'];
			}
			if (isset ( $splitData ['auth'] )) {
				$this->auth = $splitData ['auth'];
			}
			if (isset ( $splitData ['ref'] )) {
				$this->ref = $splitData ['ref'];
			}
			if (isset ( $splitData ['tranid'] )) {
				$this->transId = $splitData ['tranid'];
			}
			if (isset ( $splitData ['postdate'] )) {
				$this->date = $splitData ['postdate'];
			}
			if (isset ( $splitData ['trackId'] )) {
				$this->trackId = $splitData ['trackId'];
			}
			if (isset ( $splitData ['trackid'] )) {
				$this->trackId = $splitData ['trackid'];
			}
			if (isset ( $splitData ['action'] )) {
				$this->action = $splitData ['action'];
			}
			if (isset ( $splitData ['Error'] )) {
				$this->error = $splitData ['Error'];
			}
			if (isset ( $splitData ['ErrorText'] )) {
				$this->error_text = $splitData ['ErrorText'];
			}
			if (isset ( $splitData ['error_text'] )) {
				$this->error_text = $splitData ['error_text'];
			}
		} catch ( Exception $e ) {
			
			return - 1;
		}
		return 0;
	}
	function splitData($trandata) {
		$splitData=[];
		$data = explode ( "&", $trandata );
		foreach ( $data as $value ) {
			$temp = explode ( "=", $value );
			if ( !isset($temp[1])) {
				$temp[1] = "";
			}
			$splitData [$temp [0]] = $temp [1];
		}
		return $splitData;
	}
	
	//FOR 24 bit length key
function encryptAESold($str,$key) {
$str = $this->pkcs5_pad($str);
$ivlen = openssl_cipher_iv_length($cipher="aes-192-cbc");
//$key=substr($key,0,16);
//echo $key;
//die();
$iv="PGKEYENCDECIVSPC";
$encrypted = openssl_encrypt($str, "aes-192-cbc",$key, OPENSSL_ZERO_PADDING, $iv);
$encrypted = base64_decode($encrypted);
$encrypted=unpack('C*', ($encrypted));
$encrypted=$this->byteArray2Hex($encrypted);
$encrypted = urlencode($encrypted);
return $encrypted;
}

//done for 32 length key

function encryptAES($str,$key) {
	//echo $this->$str;
	//die();
	//$key="01922918104401922918104401922918";
	$iv = 'PGKEYENCDECIVSPC';
	$encrypted = openssl_encrypt($str, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
	$encrypted=unpack('C*', ($encrypted));
	$encrypted=$this->byteArray2Hex($encrypted);
	$encrypted  = urlencode($encrypted);
  return $encrypted;
}





 function pkcs5_pad ($text) {
	  $blocksize = 16;
	 // $blocksize = 8;
	  $pad = $blocksize - (strlen($text) % $blocksize);
	  return $text . str_repeat(chr($pad), $pad);
    }
function byteArray2Hexold($byteArray) {
  $chars = array_map("chr", $byteArray);
  $bin = join($chars);
  return bin2hex($bin);
}


function byteArray2Hex($byteArray) {
    $result = '';
    $HEX_DIGITS = "0123456789abcdef";
    foreach ($byteArray as $value) {
    $result.= $HEX_DIGITS[$value >> 4];
    $result.= $HEX_DIGITS[$value& 0xf];
}

    return $result;
}


//for 24 bit length key
function decryptDataold($code,$key) { 

	 $code =  $this->hex2ByteArray(trim($code));
	  $code=$this->byteArray2String($code);
	  $iv = "PGKEYENCDECIVSPC"; 
	  $code = base64_encode($code);
	  $decrypted = openssl_decrypt($code, 'AES-192-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
	  return $this->pkcs5_unpad($decrypted);
	}
//for 32 bit length key
	function decryptData($code,$key) {
      
	  $code =  $this->hex2ByteArray(trim($code));
	  $code=$this->byteArray2String($code);
	  $iv = 'PGKEYENCDECIVSPC';
	  $code = base64_encode($code);
	  $decrypted = openssl_decrypt($code, 'AES-256-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
	  
	  //echo "hii";
	  //echo $decrypted;
	 /// die();
	 //return $this->$decrypted;
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
	
	
	function performTransaction() {
		$xmlData = null;
		$requestbuffer = "";
		$response = "";
		$webaddr = "";
		$resultMap = null;
		try {
			$keyParser = new Keystore();
			$this->key = $keyParser->parseKeyStore ( $this->keystorePath );
			$xmlData = $this->parseResource ( $this->key, $this->resourcePath, $this->alias );
			if ($xmlData == null) {
				$this->error = "Alias name does not exits";
				return - 1;
			} else {
				$xmlData = $this->parseXMLrequest ( $xmlData );
			}
			$requestbuffer = $this->buildXMLRequest ();
			$requestbuffer .= "<id>" . $xmlData ['id'] . "</id>";
			$this->setid ( $xmlData ['id'] );
			$requestbuffer .= "<password>" . $xmlData ['password'] . "</password>";
			$webaddr = $xmlData ['webaddress'];
			$requestbuffer .= "</request>";
			
			if ($this->getaction () != null && strlen (trim ( $this->getaction () ) ) < 1 && (strcasecmp ( "1", trim ( $this->getaction () ) ) || strcasecmp ( "4", trim ( $this->getaction ) ))) {
				$this->error = "Invalid action";
				return - 1;
			}
			$response = $this->performTranPortalTransaction ($requestbuffer, $webaddr);
			
			if ($response == null || strlen ( $response ) <= 0) {
				$this->error = "Invalid response";
				return - 1;
			}
			 
			$resultMap = $this->parseResponse ( $response );
			return $this->setTransactionData ( $resultMap );
		} catch (Exception $e) {
			$this->error = "Error while processing $request! " + $e->getMessage ();
			return - 1;
		}
	}
	
	function performTranPortalTransaction($request, $webAddress) {
		$webAddress = $webAddress . "/tranPipe.htm?param=tranInit";
		$response = "";
		$tranType = "tran";
		$response = $this->sendMessage ( $request, $webAddress, $tranType );
		return $response;
	}
	
	function performTranPortalTransactionsslKeystore($request, $webAddress, $filePath, $password) {
		$webAddress = $webAddress . "/tranPipe.htm?param=tranInit";
		$response = "";
		$tranType = "tran";
		$response = $this->sendMessage ( $request, $webAddress, $tranType, $filePath, $password );
		return $response;
	}
	
	function sendMessage($request, $webAddress, $tranType) {
		$rawresponse = "";
		$tranType="";
		try {
		
			if (strlen ( $webAddress ) <= 0) {
				return null;
			}
			$contentType = "";
			if (! strcmp ( $tranType, "host" )) {
				$contentType = "Content-Type:application/x-www-form-urlencoded";
			} else if (! strcmp ( $tranType, "tran" )) {
				$contentType = "Content-Type:application/xml";
			}
			if (strlen ( $webAddress ) <= 0) {
				return null;
			}
			$curl = curl_init ();
			if (strlen ( $request ) > 0) {
				curl_setopt ( $curl, CURLOPT_URL, $webAddress );
				curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt ( $curl, CURLOPT_FRESH_CONNECT, TRUE );
				curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false );
				curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
				
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/xml'));
				;  // setting content type header
				curl_setopt ( $curl, CURLOPT_POSTFIELDS, $request ); // Setting raw post data as xml
				                                                     // $header_size = curl_getinfo ( $curl, CURLINFO_HEADER_SIZE );
				                                                     // echo "<br/><br/><CURL>" . $header_size;
				                                                     // echo "<br/><br/>URL".$webAddress;
				$rawresponse = curl_exec ( $curl );
				
				if ($rawresponse == false) {
					echo '<br/>Curl error: ' . curl_error ( $curl );
				}
				curl_close ( $curl );
				return $rawresponse;
			} else {
				return null;
			}
		} catch ( Exception $exception ) {
			echo "<br/><br/><br/>" . $e->getTraceAsString ();
			return null;
		}
	}
	

}

?>
