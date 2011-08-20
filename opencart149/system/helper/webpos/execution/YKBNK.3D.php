<?php

class API
{

    public $ReqType = null;
    public $ExtraProcessid = 0;
    public static $timeout = 90;

    private $DataArray = array();

    private $ExtraProcesspuan = null;
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

    private function xmlmodeltds(&$DataArray)
    {
      $oid = (strlen($DataArray['XID'])>20)? substr(str_replace('.','0',$DataArray['XID']),0,20):substr('00000000000000000000',0,(20-strlen($DataArray['XID']))).str_replace('.','0',$DataArray['XID']);
      $amount = str_replace('.', '', number_format($DataArray['amount'], 2, '',''));
      $instalment = ($DataArray['instalment']!='')?$DataArray['instalment']:'00';
      return "<"."?"."xml version=\"1.0\" encoding=\"ISO-8859-9\"?".">\r\n".
      "<posnetRequest>\r\n".
            "<mid>".$DataArray['mid']."</mid>\r\n".
            "<tid>".$DataArray['tid']."</tid>\r\n".
            "<username>".$DataArray['username']."</username>\r\n".
            "<password>".$DataArray['password']."</password>\r\n".
            "<oosRequestData>\r\n".
                "<posnetid>".$DataArray['posnetid']."</posnetid>\r\n".
                "<ccno>".$DataArray['ccno']."</ccno>\r\n".
                "<expDate>".$DataArray['expdate']."</expDate>\r\n".
                "<cvc>".$DataArray['cvv']."</cvc>\r\n".
                "<amount>".$amount."</amount>\r\n".
                "<currencyCode>".$DataArray['currency']."</currencyCode>\r\n".
                "<installment>".$instalment."</installment>\r\n".
                "<XID>".$oid."</XID>\r\n".
                "<cardHolderName>".$DataArray['custName']."</cardHolderName>\r\n".
                "<tranType>".$this->ReqType."</tranType>\r\n".
            "</oosRequestData>\r\n".
      "</posnetRequest>";
    }

    private function xmlmodelmcrypt(&$DataArray)
    {
      return "<"."?"."xml version=\"1.0\" encoding=\"ISO-8859-9\"?".">\r\n".
      "<posnetRequest>\r\n".
            "<mid>".$DataArray['mid']."</mid>\r\n".
            "<tid>".$DataArray['tid']."</tid>\r\n".
            "<username>".$DataArray['username']."</username>\r\n".
            "<password>".$DataArray['password']."</password>\r\n".
            "<oosResolveMerchantData>\r\n".
                "<bankData>".$DataArray['bankData']."</bankData>\r\n".
                "<merchantData>".$DataArray['merchantData']."</merchantData>\r\n".
                "<sign>".$DataArray['sign']."</sign>\r\n".
            "</oosResolveMerchantData>\r\n".
      "</posnetRequest>";
    }

    private function xmlmodeltrandata(&$DataArray)
    {
      return "<"."?"."xml version=\"1.0\" encoding=\"ISO-8859-9\"?".">\r\n".
      "<posnetRequest>\r\n".
            "<mid>".$DataArray['mid']."</mid>\r\n".
            "<tid>".$DataArray['tid']."</tid>\r\n".
            "<username>".$DataArray['username']."</username>\r\n".
            "<password>".$DataArray['password']."</password>\r\n".
            "<oosTranData>\r\n".
                "<bankData>".$DataArray['bankData']."</bankData>\r\n".
                "<merchantData>".$DataArray['merchantData']."</merchantData>\r\n".
                "<sign>".$DataArray['sign']."</sign>\r\n".
                "<wpAmount>".$DataArray['wpAmount']."</wpAmount>\r\n".
            "</oosTranData>\r\n".
      "</posnetRequest>";
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
    global $webpos_ykbnk_static_ip;
    $postdata = $this->xmlmodeltrandata($this->DataArray);
    $host = $this->DataArray["gateway"];
    $path = $this->DataArray["gatpath"];
    $ssl = $this->DataArray["gatssl"];
    $strlength = strlen( $postdata ) + 8;
    $buffer = "";
    if (!extension_loaded('curl')) {
        $fp = fsockopen((($ssl)?"ssl://".$host:$host), (($ssl)?443:80), $errno, $errstr, $timeout);
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
        fputs($fp, "xmldata=".$postdata);
        $buffer = fread( $fp, 8192 );
        fclose($fp);
    }
    else
    {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,(($ssl)?"https://":"http://").$host.$path);
        if($ssl)
        {
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        }
        if($webpos_ykbnk_static_ip!=''){curl_setopt($ch, CURLOPT_INTERFACE,$webpos_ykbnk_static_ip);}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "xmldata=".$postdata);
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
    /*echo str_replace('<','',$buffer);exit;*/
    $Response = substr( $buffer, strpos( $buffer, "<posnetResponse>" ) );
    $responseArray = $this->xmltohash( $Response );
    $msg['result'] = 0;
    $msg['mdStatus'] = 0;
    $msg['xid'] =  '';
    $msg['amount'] =  '';
    $msg['installment'] =  '';
    if (array_key_exists("approved", $responseArray['posnetResponse']))
    {
      $msg['xid'] =  $responseArray['posnetResponse']['oosResolveMerchantDataResponse']['xid'];
      $msg['amount'] =  $responseArray['posnetResponse']['oosResolveMerchantDataResponse']['amount'];
      $msg['authCode'] =  $responseArray['posnetResponse']['authCode'];
      $msg['result'] = $responseArray['posnetResponse']['approved'];
      $msg['mdStatus'] = $responseArray['posnetResponse']['oosResolveMerchantDataResponse']['mdStatus'];
      $msg['msg'] = $responseArray['posnetResponse']['oosResolveMerchantDataResponse']['mdErrorMessage'].', '.$responseArray['posnetResponse']['respText'];
    }
    else
    {
      $msg['result'] = -2;
      $msg['msg'] = 'Hata kodu: YKB 1111';
    }
    return $msg;
    }

    public function HTTPPOSTTDS()
    {
    global $webpos_ykbnk_static_ip;
    $postdata = $this->xmlmodeltds($this->DataArray);
    $host = $this->DataArray["gateway"];
    $path = $this->DataArray["gatpath"];
    $ssl = $this->DataArray["gatssl"];
    $strlength = strlen( $postdata ) + 8;
    $buffer = "";
    if (!extension_loaded('curl')) {
        $fp = fsockopen((($ssl)?"ssl://".$host:$host), (($ssl)?443:80), $errno, $errstr, $timeout);
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
        fputs($fp, "xmldata=".$postdata);
        $buffer = fread( $fp, 8192 );
        fclose($fp);
    }
    else
    {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,(($ssl)?"https://":"http://").$host.$path);
        if($ssl)
        {
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        }
        if($webpos_ykbnk_static_ip!=''){curl_setopt($ch, CURLOPT_INTERFACE,$webpos_ykbnk_static_ip);}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "xmldata=".$postdata);
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
    $Response = substr( $buffer, strpos( $buffer, "<posnetRequest>" ) );
    $responseArray = $this->xmltohash( $Response );
    $msg['result'] = 0;
    if (array_key_exists("approved", $responseArray['posnetResponse']))
    {
      switch ( $responseArray['posnetResponse']['approved'] )
      {
        case "1" :
              $msg['result'] = 1;
              $msg['data1'] = $responseArray['posnetResponse']['oosRequestDataResponse']['data1'];
              $msg['data2'] = $responseArray['posnetResponse']['oosRequestDataResponse']['data2'];
              $msg['sign']  = $responseArray['posnetResponse']['oosRequestDataResponse']['sign'];
              break;
        case "0" :
              $msg['result'] = -1;
              $msg['msg'] = $this->est_error_codes( $responseArray['posnetResponse']['respCode'] );
              $msg['msg2'] = $responseArray['posnetResponse']['respText'];
              break;
      }
    }
    else
    {
      $msg['result'] = -2;
    }
    return $msg;
    }

    function CheckSign()
    {
    $merchantData   = $this->DataArray["merchantData"];
    $bankData       = $this->DataArray["bankData"];
    $sign           = $this->DataArray["sign"];
    $key            = $this->DataArray["enckey"];

    $msg['result'] = 0;
    if($merchantData == "" || $bankData == "" || $sign == "")
    {
        $msg['sign'] = "GECERSIZ DATA ( Merchant Data=".$merchantData." - Bank Data=".$bankData." - Sign=".$sign." )";
        $msg['result']=-1;
    }
    $data = $merchantData.$bankData.$key;
    $hash = strtoupper(md5($data));
    if (strcmp($hash, $sign) == 0) {
       $msg['result']=1;
    }
    else
    {
        $msg['sign']  = "IMZA GECERLI DEGIL (".$merchantData.$bankData.")";
        $msg['result']= -1;
    }
    return $msg;
    }

    function HTTPPOSTMCRYPT()
    {
    global $webpos_ykbnk_static_ip;
    $postdata = $this->xmlmodelmcrypt($this->DataArray);
    $merchantData   = $this->DataArray["merchantData"];
    $bankData       = $this->DataArray["bankData"];
    $sign           = $this->DataArray["sign"];
    $host           = $this->DataArray["gateway"];
    $path           = $this->DataArray["gatpath"];
    $ssl            = $this->DataArray["gatssl"];
    $strlength = strlen( $postdata ) + 8;
    $buffer = "";
    if (!extension_loaded('curl')) {
        $fp = fsockopen((($ssl)?"ssl://".$host:$host), (($ssl)?443:80), $errno, $errstr, $timeout);
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
        fputs($fp, "xmldata=".$postdata);
        $buffer = fread( $fp, 8192 );
        fclose($fp);
    }
    else
    {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,(($ssl)?"https://":"http://").$host.$path);
        if($ssl)
        {
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        }
        if($webpos_ykbnk_static_ip!=''){curl_setopt($ch, CURLOPT_INTERFACE,$webpos_ykbnk_static_ip);}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "xmldata=".$postdata);
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
    $Response = substr( $buffer, strpos( $buffer, "<posnetRequest>" ) );
    $responseArray = $this->xmltohash( $Response );
    $msg['result'] = 0;
    $msg['mdStatus'] = 0;
    $msg['xid'] =  '';
    $msg['amount'] =  '';
    $msg['installment'] =  '';
    if (array_key_exists("approved", $responseArray['posnetResponse']))
    {
      $msg['xid'] =  $responseArray['posnetResponse']['oosResolveMerchantDataResponse']['xid'];
      $msg['amount'] =  $responseArray['posnetResponse']['oosResolveMerchantDataResponse']['amount'];
      $msg['installment'] =  $responseArray['posnetResponse']['oosResolveMerchantDataResponse']['installment'];
      $msg['result'] = $responseArray['posnetResponse']['approved'];
      $msg['mdStatus'] = $responseArray['posnetResponse']['oosResolveMerchantDataResponse']['mdStatus'];
    }
    else
    {
      $msg['result'] = -2;
    }
    return $msg;
    }

    public function ykb3D_error_codes( $Status )
    {
    switch ( $Status )
    {
        case "1" :
            $msg = "Tam doğrulama";
            return $msg;
        case "2" :
            $msg = "Kart sahibi banka veya Kart 3D-Secure Üyesi Değil, Kartsahibi veya bankası sisteme kayıtlı değil";
            return $msg;
        case "3" :
            $msg = "Kart prefixi 3D-Secure sisteminde tanımlı değil, Kartın bankası sisteme kayıtlı değil (önbellekten)";
            return $msg;
        case "4" :
            $msg = "Authentication Attempt, Doğrulama denemesi, kartsahibi sisteme daha sonra kayıt olmayı seçmiş";
            return $msg;
        case "5" :
            $msg = "Sistem ulaşılabilir değil, Kredi Kartı Doğrulama yapılamıyor.";
            return $msg;
        case "6" :
            $msg = "3-D Secure Hatası, Hata mesajı veya işyeri 3-D Secure sistemine kayıtlı değil";
            return $msg;
        case "7" :
            $msg = "Sistem Hatası";
            return $msg;
        case "8" :
            $msg = "Geçersiz Kart";
            return $msg;
        case "9" :
            $msg = "Üye İşyeri 3D-Secure sistemine kayıtlı değil";
            return $msg;
        case "0" :
            $msg = "3-D secure imzası geçersiz veya Doğrulama başarısız";
            return $msg;

    }
    $msg = "Lütfen bilgilerinizi kontrol ediniz..";
    return $msg;
    }
    public function threeDSecureCheck($threeDMdStatus,$threeDMdStatusOK)
    {
            $checkList = explode(":", $threeDMdStatusOK);
            foreach ($checkList as $value) {
                if($value == $threeDMdStatus)
                    return true;
            }
            return false;
    }
}
?>