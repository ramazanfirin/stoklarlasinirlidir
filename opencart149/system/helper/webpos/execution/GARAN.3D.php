<?php
class API
{

    public $ReqType = 'Auth';
    public $ExtraProcessid = 0;
    public static $timeout = 90;

    private $DataArray = array();

    private $ExtraProcesspuan = '';
    public function __construct()
	{

	}
    public function __get($key){
    }

	public function __set($key, $value){
	if(array_key_exists($key, get_class_vars(__CLASS__))){
	$this->{$key} = $value;
	}
	}

    private function xmlmodel(&$DataArray)
    {
    $extraid = $this->ExtraProcessid;
    $extrapuan = $this->ExtraProcesspuan;

    $strMode = $DataArray['SESSION']['mode'];
    $strVersion = $DataArray['SESSION']['apiversion'];
    $strProvUserID = $DataArray['SESSION']['terminalprovuserid'];
    $strUserID = $DataArray['SESSION']['terminaluserid'];
    $strTerminalID = $DataArray['SESSION']['clientid'];
    $strMerchantID = $DataArray['SESSION']['terminalmerchantid'];
    $strIPAddress = $DataArray['SESSION']['customeripaddress'];
    $strEmailAddress = $DataArray['SESSION']['customeremailaddress'];
    $strOrderID = $DataArray['SESSION']['orderid'];
    $strType = $DataArray['SESSION']['txntype'];
    $strInstallmentCnt = $DataArray['SESSION']['cc_instalment_order'];
    $strAmount = $DataArray['SESSION']['txnamount'];
    $strCurrencyCode = $DataArray['SESSION']['txncurrencycode'];
    $strCardholderPresentCode = 13; //3D Model işlemde bu değer 13 olmalı
    $strMotoInd = "N";
    $strAuthenticationCode = $DataArray['SESSION']['cavv'];
    $strSecurityLevel = $DataArray['SESSION']['eci'];
    $strTxnID = $DataArray['SESSION']['xid'];
    $strMD = $DataArray['SESSION']['md'];
    $SecurityData = strtoupper(sha1($DataArray['propassword'].sprintf("%09d",$strTerminalID)));
    $HashData = strtoupper(sha1($strOrderID.$strTerminalID.$strAmount.$SecurityData));
    return "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>
                    <GVPSRequest>
                    <Mode>$strMode</Mode>
                    <Version>$strVersion</Version>
                    <ChannelCode></ChannelCode>
                    <Terminal>
                      <ProvUserID>$strProvUserID</ProvUserID>
                      <HashData>$HashData</HashData>
                      <UserID>$strUserID</UserID>
                      <ID>$strTerminalID</ID>
                      <MerchantID>$strMerchantID</MerchantID>
                    </Terminal>
                    <Customer>
                      <IPAddress>$strIPAddress</IPAddress>
                      <EmailAddress>$strEmailAddress</EmailAddress>
                    </Customer>
                    <Card>
                      <Number></Number>
                      <ExpireDate></ExpireDate>
                    </Card>
                    <Order>
                      <OrderID>$strOrderID</OrderID>
                      <GroupID></GroupID>
                      <Description></Description>
                    </Order>
                    <Transaction>
                      <Type>$strType</Type>
                      <InstallmentCnt>$strInstallmentCnt</InstallmentCnt>
                      <Amount>$strAmount</Amount>
                      <CurrencyCode>$strCurrencyCode</CurrencyCode>
                      <CardholderPresentCode>$strCardholderPresentCode</CardholderPresentCode>
                      <MotoInd>$strMotoInd</MotoInd>
                      <Description></Description>
                      <Secure3D>
                        <AuthenticationCode>$strAuthenticationCode</AuthenticationCode>
                        <SecurityLevel>$strSecurityLevel</SecurityLevel>
                        <TxnID>$strTxnID</TxnID>
                        <Md>$strMD</Md>
                      </Secure3D>
                    </Transaction>
                    </GVPSRequest>";
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
        case "92" :
            $msg = "Minimum islem limitinin altinda bir ödeme miktari nedeniyle isleminiz gerçeklesmedi.";
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

    $postdata = $this->xmlmodel($this->DataArray);
    $host = $this->DataArray["host"];
    $path = $this->DataArray["path"];
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
        fputs($fp, "data=".$postdata);
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
            $msg['msg'] = $this->grn_error_codes($responseArray['GVPSResponse']['Transaction']['Response']['Code'] ). "-" . $responseArray['GVPSResponse']['Transaction']['Response']['ErrorMsg']. " , ".$responseArray['GVPSResponse']['Transaction']['Response']['SysErrMsg'];
            break;
        case "Error" :
            $msg['result'] = -1;
            $msg['msg'] = ":= ".$this->grn_error_codes( $responseArray['GVPSResponse']['Transaction']['Response']['Code'] ). "-" . $responseArray['GVPSResponse']['Transaction']['Response']['ErrorMsg']. " , ".$responseArray['GVPSResponse']['Transaction']['Response']['SysErrMsg'];
    }
    return $msg;
    }

}
?>
