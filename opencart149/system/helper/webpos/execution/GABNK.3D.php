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
    $extraselection = array (null,
                        array("KULLANPUAN","KULLANPUAN"),
                        array("IDEALPUANSORGU","SOR"),
                        array("EXTRAPUANORAN" ,$extrapuan),  /* "02.00"  */
                        array("EXTRAPUANTUTAR",$extrapuan)); /* "5.00"  */

    return "<?xml version=\"1.0\" encoding=\"ISO-8859-9\"?>\r\n".
    "<CC5Request>\r\n".
                "<Name>{$DataArray['name']}</Name>\r\n".
                "<Password>{$DataArray['password']}</Password>\r\n".
                "<ClientId>{$DataArray['clientid']}</ClientId>\r\n".
                "<IPAddress>{$DataArray['ip']}</IPAddress>\r\n".
                "<Email></Email>\r\n".
                "<Mode>P</Mode>\r\n".
                "<OrderId>{$DataArray['orderid']}</OrderId>\r\n".
                "<GroupId></GroupId>\r\n".
                "<TransId></TransId>\r\n".
                "<UserId></UserId>\r\n".
                "<Type>{$this->ReqType}</Type>\r\n".
                "<Number>{$DataArray['md']}</Number>\r\n".
                "<Expires></Expires>\r\n".
                "<Cvv2Val></Cvv2Val>\r\n".
                "<Total>{$DataArray['tutar']}</Total>\r\n".
                "<Currency>{$DataArray['currency']}</Currency>\r\n".        /* 949 */
                "<Taksit>{$DataArray['cc_instalment_order']}</Taksit>\r\n".
                "<PayerTxnId>{$DataArray['xid']}</PayerTxnId>".
	            "<PayerSecurityLevel>{$DataArray['eci']}</PayerSecurityLevel>".
	            "<PayerAuthenticationCode>{$DataArray['cavv']}</PayerAuthenticationCode>".
	            "<CardholderPresentCode>13</CardholderPresentCode>".
                "<BillTo>\r\n".
                    "<Name>{$DataArray['cc_holdername']}</Name>\r\n".
                    "<Street1></Street1>\r\n".
                    "<Street2></Street2>\r\n".
                    "<Street3></Street3>\r\n".
                    "<City></City>\r\n".
                    "<StateProv></StateProv>\r\n".
                    "<PostalCode></PostalCode>\r\n".
                    "<Country>Turkey</Country>\r\n".
                    "<Company></Company>\r\n".
                    "<TelVoice></TelVoice>\r\n".
                "</BillTo>\r\n".
                "<ShipTo>\r\n".
                    "<Name></Name>\r\n".
                    "<Street1></Street1>\r\n".
                    "<Street2></Street2>\r\n".
                    "<Street3></Street3>\r\n".
                    "<City></City>\r\n".
                    "<StateProv></StateProv>\r\n".
                    "<PostalCode></PostalCode>\r\n".
                    "<Country>Turkey</Country>\r\n".
                "</ShipTo>\r\n".
                ((is_array($extraselection[$extraid]))?("<Extra>\r\n<".
                $extraselection[$extraid][0].">".$extraselection[$extraid][1].
                "</".$extraselection[$extraid][0].
                ">\r\n</Extra>\r\n"):"<Extra></Extra>\r\n").
    "</CC5Request>";
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

    public function est_error_codes( $Status )
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
		curl_setopt($ch, CURLOPT_POSTFIELDS, "DATA=".$postdata);
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
    $Response = substr( $buffer, strpos( $buffer, "<CC5Response>" ) );
    $responseArray = $this->xmltohash( $Response );
    switch ( $responseArray['CC5Response']['Response'] )
    {
        case "Approved" :
            $msg['result'] = 1;
            $msg['auth_code'] = $responseArray['CC5Response']['AuthCode'];
            break;
        case "Declined" :
            $msg['result'] = -1;
            $msg['msg'] = $this->est_error_codes( $responseArray['CC5Response']['ProcReturnCode'] );
            break;
        case "Error" :
            $msg['result'] = -1;
            $msg['msg'] = ":= ".$this->est_error_codes( $responseArray['CC5Response']['ProcReturnCode'] )."-".$responseArray['CC5Response']['ErrMsg'];
    }
    return $msg;
    }

}
?>
