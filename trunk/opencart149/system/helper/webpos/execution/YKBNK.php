<?php

class API
{
    /*Gerçek Hesap İşlemleri*/
    /*<Aktif>*/
//    public static $real_apiclient = '';
    public static $real_apiname = '';
    public static $real_apipass = '';
    public static $real_mid = '';
    public static $real_tid = '';
    public static $real_gateway = '';
    public static $real_gatpath = '';

    /*</Aktif>*/
    /*Test, Sahte Hesap İşlemleri*/
    /*<Test>*/
    public static $test_gateway = '';
    public static $test_gatpath = '';
    public static $test_mid = '';
    public static $test_tid = '';
    public static $test_apiname = '';
    public static $test_apipass = '';
    /*</Test>*/
    public $ReqType = 'Auth';
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
                        "cc_holdername"=>'');

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

    private function xmlmodel(&$nameis,&$passwordis,&$midis,&$tidis,&$DataArray)
    {
    $extraid = $this->ExtraProcessid;
    $extrapuan = $this->ExtraProcesspuan;
    $extraselection = array (null,
                        array("KULLANPUAN","KULLANPUAN"),
                        array("IDEALPUANSORGU","SOR"),
                        array("EXTRAPUANORAN" ,$extrapuan),  /* "02.00"  */
                        array("EXTRAPUANTUTAR",$extrapuan)); /* "5.00"  */

    $oid = (strlen($DataArray['orderid'])>24)? substr(str_replace('.','0',$DataArray['orderid']),0,24):substr('00000000000000000000',0,(24-strlen($DataArray['orderid']))).str_replace('.','0',$DataArray['orderid']);

    return "<posnetRequest>\r\n".
                "<mid>{$midis}</mid>\r\n".
                "<tid>{$tidis}</tid>\r\n".
                "<sale>\r\n".
                	"<amount>".str_replace('.', '', number_format($DataArray['tutar'], 2, '',''))."</amount>\r\n".  // tutar 15.34 yerine 1534 olmalı
                	"<ccno>{$DataArray['cc_no']}</ccno>\r\n".
                	"<currencyCode>YT</currencyCode>\r\n".        /* {$DataArray['currency']} */
                	"<cvc>{$DataArray['cc_ccv']}</cvc>\r\n".
                	"<expDate>{$DataArray['cc_year']}{$DataArray['cc_month']}</expDate>\r\n".   // ykb de YYMM istenir
                	"<orderID>{$oid}</orderID>\r\n".     // order_id 24 karakterli olmalı
                	(($DataArray['cc_instalment_order']!='')?"<installment>{$DataArray['cc_instalment_order']}</installment>\r\n":'').
                "</sale>\r\n".
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

    public function ykb_error_codes( $Status )
    {
    switch ( $Status )
    {
       case "0003": $msg = "Banka online bağlantısında bir sorun oluştu. Sorun sistem yöneticilerine iletilmiştir. MID,TID,IP HATALI girilmiş olabilir"; break;
       case "0095": $msg = "İşlem onaylanmadı. Kart bilgilerinden (KK No, SKT, CVV) biri yada birkaçı hatalı girilmiş veya Worldcard için bankaca tanımlanmış günlük limitiniz aşılmış olabilir. Kredi kartınızla günde en fazla 3 internet alışverişi yapılabilir."; break;
       case "0100": $msg = "İşlem tamamlanamadı. Banka ile bağlantıda sorun oluştu. Bir süre sonra tekrar deneyiniz."; break;
       case "0110": $msg = "İşlem onaylanmadı. Kredi kart limitini aşmış olabilirsiniz. Bankanızı arayınız."; break;
       case "0124": $msg = "İşlem onaylanmadı. Muhtemelen bankada teknik bir çalışma olabilir. Daha sonra tekrar deneyebilir veya başka bir banka kredi kartı ile işlem yapabilirsiniz."; break;
       case "0129": $msg = "Geçersiz kredi kartı. Bankanızı arayınız."; break;
       case "0170": $msg = "Kartınız onaylanmadı. Bankanızı arayıp provizyon alınamadığını bildiriniz, veya başka kart deneyiniz."; break;
       case "0173": $msg = "Kartınız internet üzerinden alışverişe uygun görünmüyor. Bankanızı arayıp durumu kontrol ediniz veya başka bir kartla deneyiniz."; break;
       case "0213": $msg = "Kartınızın limiti yetersiz görünüyor. Bankanızı arayarak kontrol ediniz."; break;
       case "0217": $msg = "Kullanılan kredi kartı kayıp veya çalıntı olarak bildirilmiştir !! Bilgiler kaydedilmiştir."; break;
       case "0225": $msg = "Kredi kart numaranız hatalıdır. Kart bilgilerinizi kontrol edip tekrar deneyiniz."; break;
       case "0229": $msg = "Geçersiz İşlem. Taksitli işlemlerde Yapı Kredi kredi kartlarından birini kullandığınıza emin olunuz."; break;
       case "0267": $msg = "Kredi kart numaranız hatalıdır. Kart bilgilerinizi kontrol edip tekrar deneyiniz."; break;
       case "0360": $msg = "Kredi kartınız bu tip işleme izin vermiyor veya kartın kredisi yetersiz. Kartı veren bankayı arayın."; break;
       case "0363": $msg = "Kredi kart numaranız hatalıdır. Kart bilgilerinizi kontrol edip tekrar deneyiniz."; break;
       case "0400": $msg = "Yapı Kredi kredi kartları merkezinde teknik bir sorun var. Daha sonra tekrar deneyiniz."; break;
       case "0534": $msg = "Bu kartla işlem yapamazsınız."; break;
       case "0551": $msg = "Numara bir kredi kartına ait değil."; break;
       case "0876": $msg = "Kart bilgilerinden (KK No, SKT, CVV) biri yada birkaçı hatalı girilmiş veya Worldcard'lar için bankaca tanımlanmış günlük limitler aşılmış olabilir."; break;
       case "0877": $msg = "Kredi kartınızın arkasında bulunan 3 haneli CVC kodu girilmedi veya yanlış."; break;
       case "0995": $msg = "Kartı veren (issuer) banka ile iletişimde zaman aşımı oldu (bankadan zamanında yanıt alınamadı). Tekrar deneyiniz. Sorun devam ederse, kartı veren bankayı arayıp, bir sanal pos işleminde bu hatanın alındığını belirtiniz."; break;
       default:     $msg = "Bir hata oluştu (Hata no:".$Status.") Tekrar deneyiniz. Sorun devam ederse lütfen bizimle temasa geçiniz."; break;
    }
    return $msg;
    }

    public function HTTPPOST()
    {
    $name='';
    $password='';
    $clientid='';
    $host='';
    $path='';
    $timeout = self::$timeout;
    if(self::$isrealgateway)
    {
        $name = self::$real_apiname;
        $password = self::$real_apipass;
        $mid = self::$real_mid;
        $tid = self::$real_tid;
        $host = self::$real_gateway;
        $path = self::$real_gatpath;
    }
    else
    {
        $name = self::$test_apiname;
        $password = self::$test_apipass;
        $mid = self::$test_mid;
        $tid = self::$test_tid;
        $host = self::$test_gateway;
        $path = self::$test_gatpath;
    }

    $postdata = $this->xmlmodel($name,$password,$mid,$tid,$this->DataArray);

    $strlength = strlen( $postdata ) + 8;
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
        fputs($fp, "Content-length: ".$strlength."\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, "xmldata=".$postdata);
        $buffer = "";
        //while (!feof($fp)) {
        //    $buffer .= fread($fp, 1024);
        //}
	while(!feof($fp)) {
	$buffer .= fgets($fp, 4096);
	}
        fclose($fp);
    }
    else
    {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,((self::$isrealgateway)?"https://":"http://").$host.$path);
        //curl_setopt($ch, CURLOPT_INTERFACE,'');
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
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
    //    echo str_replace("<","&lt;",str_replace(">","&gt;",$buffer));exit;/*echo $buffer;*/
    
    $Response = substr( $buffer, strpos( $buffer, "<posnetResponse>" ) );
    $responseArray = $this->xmltohash( $Response );
    switch ( $responseArray['posnetResponse']['approved'] )
    {
        case "1" :
            $msg['result'] = 1;
            $msg['auth_code'] = $responseArray['posnetResponse']['authCode'];
            break;
        case "0" :
            $msg['result'] = -1;
            $msg['msg'] = $this->ykb_error_codes( $responseArray['posnetResponse']['respCode'] ); /* respText */
            break;
    }
    return $msg;
    }

}
?>
