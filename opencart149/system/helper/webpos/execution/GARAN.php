<?php
class API
{
    /*Gerçek Hesap İşlemleri*/
    /*<Aktif>*/
    public static $real_gateway = '';
    public static $real_gatpath = '';
    public static $real_apimode = '';
    public static $real_apiprovuserid = '';
    public static $real_apipropassword = '';
    public static $real_apiagentuserid = '';
    public static $real_apimerchantid = '';
    public static $real_apiterminalid = '';
    /*</Aktif>*/
    /*Test, Sahte Hesap İşlemleri*/
    /*<Test>*/
    public static $test_gateway = '';
    public static $test_gatpath = '';
    public static $test_apimode = '';
    public static $test_apiprovuserid = '';
    public static $test_apipropassword = '';
    public static $test_apiagentuserid = '';
    public static $test_apimerchantid = '';
    public static $test_apiterminalid = '';
    /*</Test>*/
    public $ReqType = 'sales';
    public $ExtraProcessid = 0;
    public static $isrealgateway = false;
    public static $timeout = 90;

    private $DataArray = array("ip"=>'',
                        "orderid" => '',
                        "cc_no"=>'',
                        "cc_month"=>'',
                        "cc_year"=>'',
                        "cc_ccv"=>'',
                        "tutar"=>'',
                        "currency"=>'',
                        "cc_instalment_order" => '',
                        "cc_holdername"=>'',
                        "customeremail"=>'');

    private $ExtraProcesspuan = '';
    public function __construct()
	{
        if (defined('MODULE_PAYMENT_WEBPOS_MODE'))
        {
        if (MODULE_PAYMENT_WEBPOS_MODE == 'Aktif')
        {
            self::$isrealgateway = true;
        }
        else
        {
            self::$isrealgateway = false;
        }
        }
	}
    public function __get($key){
    }

	public function __set($key, $value){
	if(array_key_exists($key, get_class_vars(__CLASS__))){
	$this->{$key} = $value;
	}
	}

    private function xmlmodel(&$mode,&$provuserid,&$propassword,&$agentuserid,&$merchantid,&$terminalid,&$DataArray)
    {
    $extraid = $this->ExtraProcessid;
    $extrapuan = $this->ExtraProcesspuan;
    $extraselection = array (null,
                        array("KULLANPUAN","KULLANPUAN"),
                        array("IDEALPUANSORGU","SOR"),
                        array("EXTRAPUANORAN" ,$extrapuan),  /* "02.00"  */
                        array("EXTRAPUANTUTAR",$extrapuan)); /* "5.00"  */

    $strVersion = "v0.01";
    //$arroid = explode('.',$DataArray['orderid']);
    //$strOrderID = $arroid[1].sprintf("%016d",$arroid[0]);
	$strOrderID = sprintf("%016d",$DataArray['orderid']);
    $strAmount = number_format( $DataArray['tutar'] , 2, "", "" );
    $SecurityData = strtoupper(sha1($propassword.sprintf("%09d",$terminalid)));
    $HashData = strtoupper(sha1($strOrderID.$terminalid.$DataArray['cc_no'].$strAmount.$SecurityData));
    $strCardholderPresentCode = "0";
    $strMotoInd = "N";
    return "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r\n".
    "<GVPSRequest>\r\n".
    "<Mode>$mode</Mode><Version>$strVersion</Version>\r\n".
    "<Terminal><ProvUserID>$provuserid</ProvUserID><HashData>$HashData</HashData><UserID>$agentuserid</UserID><ID>$terminalid</ID><MerchantID>$merchantid</MerchantID></Terminal>\r\n".
    "<Customer><IPAddress>{$DataArray['ip']}</IPAddress><EmailAddress>{$DataArray['customeremail']}</EmailAddress></Customer>\r\n".
    "<Card><Number>{$DataArray['cc_no']}</Number><ExpireDate>{$DataArray['cc_month']}{$DataArray['cc_year']}</ExpireDate><CVV2>{$DataArray['cc_ccv']}</CVV2></Card>\r\n".
    "<Order><OrderID>$strOrderID</OrderID><GroupID></GroupID><Description></Description></Order>\r\n".
    "<Transaction><Type>{$this->ReqType}</Type><InstallmentCnt>{$DataArray['cc_instalment_order']}</InstallmentCnt><Amount>$strAmount</Amount><CurrencyCode>{$DataArray['currency']}</CurrencyCode><CardholderPresentCode>$strCardholderPresentCode</CardholderPresentCode><MotoInd>$strMotoInd</MotoInd><Description></Description><OriginalRetrefNum></OriginalRetrefNum></Transaction>\r\n".
    "</GVPSRequest>";
    }

    private function xmltohash($data)
    {
    $response = array();
    $parser = xml_parser_create( );
    xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
    xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 );
    xml_parse_into_struct( $parser, $data, $values, $tags );
    xml_parser_free( $parser );
    $arrQuotes = array();
    foreach ( $values as $key => $val )
    {
        switch ( $val['type'] )
        {
            case "open" :
                array_push($arrQuotes,$val['tag'] );
                break;
            case "close" :
                array_pop($arrQuotes);
                break;
            case "complete" :
                array_push($arrQuotes,$val['tag'] );
                $val['value'] = (array_key_exists('value', $val))?$val['value']:"";
                eval( "\$response['".implode( $arrQuotes, "']['" ).( "'] = \"".$val['value']."\";" ) );
                array_pop($arrQuotes);
        }
    }
    return $response;
    }

    public function grn_error_codes( $Status )
    {
    switch ( $Status )
    {
        case "01" :
            $msg = "Kredi kartınız için bankanız provizyon talep etmektedir. İşlem sonuçlanmamıştır.";
            return $msg;
        case "02" :
            $msg = "Kredi kartınız için bankanız provizyon talep etmektedir. İşlem sonuçlanmamıştır.";
            return $msg;
        case "04" :
            $msg = "Bu kredi kartı ile alışveriş yapamazsınız. Başka bir kartla tekrar deneyiniz.";
            return $msg;
        case "05" :
            $msg = "İşlem onaylanmadı. Kredi kartınız ile işlem limitini aşmış olabilirsiniz. Bankanızı arayınız.";
            return $msg;
        case "09" :
            $msg = "Kredi kartınız yenilenmiştir. Yenilenmiş kartınız ile tekrar deneyiniz.";
            return $msg;
        case "10" :
            $msg = "İşlem onaylanmadı. Başka bir kredi kartı ile işlem yapmayı deneyiniz.";
            return $msg;
        case "14" :
            $msg = "Kredi kart numaranız hatalıdır. Kart bilgilerinizi kontrol edip tekrar deneyiniz.";
            return $msg;
        case "16" :
            $msg = "Kredi kartınızın bakiyesi yetersiz. Başka bir kredi kartı ile tekrar deneyiniz.";
            return $msg;
        case "30" :
            $msg = "Bankanıza ulaşılamadı. Tekrar denemenizi tavsiye ediyoruz.";
            return $msg;
        case "36" :
            $msg = "Kredi kartınız kayıp veya çalıntı olarak bildirilmiştir.";
            return $msg;
        case "41" :
            $msg = "Kredi kartınız kayıp veya çalıntı olarak bildirilmiştir.";
            return $msg;
        case "43" :
            $msg = "Kredi kartınız kayıp veya çalıntı olarak bildirilmiştir.";
            return $msg;
        case "51" :
            $msg = "Kredi kartınızın bakiyesi yetersiz. Başka bir kredi kartı ile tekrar deneyiniz.";
            return $msg;
        case "54" :
            $msg = "İşlem onaylanmadı. Kartınızı kontrol edip tekrar deneyiniz.";
            return $msg;
        case "57" :
            $msg = "İşlem onaylanmadı. Başka bir kredi kartı ile işlem yapmayı deneyiniz.";
            return $msg;
        case "58" :
            $msg = "Yetkisiz bir işlem yapıldı. Örn: Kredi kartınızın ait olduğu banka dışında bir bankadan taksitlendirme yapıyor olabilirsiniz. Başka bir kredi kartı ile işlem yapmayı deneyiniz.";
            return $msg;
        case "62" :
            $msg = "İşlem onaylanmadı. Başka bir kredi kartı ile işlem yapmayı deneyiniz.";
            return $msg;
        case "65" :
            $msg = "Kredi kartınızın günlük işlem limiti dolmuştur. Başka bir kredi kartı ile deneyiniz.";
            return $msg;
        case "77" :
            $msg = "İşlem onaylanmadı. Başka bir kredi kartı ile işlem yapmayı deneyiniz.";
            return $msg;
        case "82" :
            $msg = "İşlem onaylanmadı. Kart bilgilerinizi kontrol edip tekrar deneyiniz.";
            return $msg;
        case "91" :
            $msg = "Bankanıza ulaşılamıyor. Başka bir kredi kartı ile tekrar deneyiniz.";
            return $msg;
        case "99" :
            $msg = "İşlem onaylanmadı. Kart bilgilerinizi kontrol edip tekrar deneyiniz.";
            return $msg;
    }
    $msg = "Lütfen bilgilerinizi kontrol ediniz..";
    return $msg;
    }


    public function HTTPPOST()
    {
    $mode='';
    $provuserid='';
    $propassword='';
    $agentuserid='';
    $merchantid='';
    $terminalid='';
    $host='';
    $path='';
    $timeout = self::$timeout;
    if(self::$isrealgateway)
    {
        $mode = self::$real_apimode;
        $provuserid = self::$real_apiprovuserid;
        $propassword = self::$real_apipropassword;
        $agentuserid = self::$real_apiagentuserid;
        $merchantid = self::$real_apimerchantid;
        $terminalid = self::$real_apiterminalid;
        $host = self::$real_gateway;
        $path = self::$real_gatpath;
    }
    else
    {
        $mode = self::$test_apimode;
        $provuserid = self::$test_apiprovuserid;
        $propassword = self::$test_apipropassword;
        $agentuserid = self::$test_apiagentuserid;
        $merchantid = self::$test_apimerchantid;
        $terminalid = self::$test_apiterminalid;
        $host = self::$test_gateway;
        $path = self::$test_gatpath;
    }

    $postdata = $this->xmlmodel($mode,$provuserid,$propassword,$agentuserid,$merchantid,$terminalid,$this->DataArray);

    $strlength = strlen( $postdata ) + 5;
    $buffer = "";
    if (!extension_loaded('curl')) {
        $fp = fsockopen("ssl://".$host, 443, $errno, $errstr, $timeout);
        if (!$fp)
        {
            $msg['result'] = -1;
            $msg['msg'] = ":: Bağlantı hatası lütfen daha sonra tekrar deneyiniz.";
            return $msg;
        }
        fputs($fp, "POST ".$path." HTTP/1.1\r\n");
        fputs($fp, "Host: $host\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: ".$strlength."\r\n\r\n");
        fputs($fp, "DATA=".$postdata);
        $buffer = fread( $fp, 8192 );
        fclose($fp);
    }
    else
    {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://".$host.$path);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "data=".$postdata);
        $buffer = curl_exec($ch);
        if (curl_errno($ch))
        {
           $msg['result'] = -1;
           $msg['msg'] = ":: Bağlantı hatası lütfen daha sonra tekrar deneyiniz.";
           return $msg; /* curl_error($ch)  */
        }
        else
        {
           curl_close($ch);
        }
    }
    /*echo $buffer;*/
    $Response = substr( $buffer, strpos( $buffer, "<GVPSResponse>" ) );
    $responseArray = $this->xmltohash( $Response );

    switch ( $responseArray['GVPSResponse']['Transaction']['Response']['Message'] )
    {
        case "Approved" :
            $msg['result'] = 1;
            $msg['auth_code'] = $responseArray['GVPSResponse']['Transaction']['AuthCode'];
            break;
        case "Declined" :
            $msg['result'] = -1;
            $msg['msg'] = $this->grn_error_codes( $responseArray['GVPSResponse']['Transaction']['Response']['Code'] ). "-" . $responseArray['GVPSResponse']['Transaction']['Response']['ErrorMsg']. " , ".$responseArray['GVPSResponse']['Transaction']['Response']['SysErrMsg'];
            break;
        case "Error" :
            $msg['result'] = -1;
            $msg['msg'] = ":= ".$this->grn_error_codes( $responseArray['GVPSResponse']['Transaction']['Response']['Code'] ). "-" . $responseArray['GVPSResponse']['Transaction']['Response']['ErrorMsg']. " , ".$responseArray['GVPSResponse']['Transaction']['Response']['SysErrMsg'];
    }
    return $msg;
    }

}
?>
