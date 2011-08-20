<?php
class API
{
    /*Gerçek Hesap İşlemleri*/
    /*<Aktif>*/
    public static $real_apiname;
    public static $real_apipass;
    public static $real_apiclient;
    public static $real_apiposno;
    public static $real_apixcip;
    public static $real_gateway;
    public static $real_gatpath;
    /*</Aktif>*/
    /*Test, Sahte Hesap İşlemleri*/
    /*<Test>*/
    public static $test_gateway;
    public static $test_gatpath;
    public static $test_apiname;
    public static $test_apipass;
    public static $test_apiclient;
    public static $test_apiposno;
    public static $test_apixcip;
    /*</Test>*/
    public $ReqType;
    public $ExtraProcessid=0;
    public static $isrealgateway=false;
    public static $timeout=90;

    private $DataArray;
    private $ExtraProcesspuan;
    public function __construct()
	{
	    $this->ReqType   = 'Auth';
        $this->DataArray = array("ip"=>'',
                            "orderid" => '',
                            "cc_no"=>'',
                            "cc_month"=>'',
                            "cc_year"=>'',
                            "cc_ccv"=>'',
                            "tutar"=>'',
                            "currency"=>'',
                            "cc_instalment_order" => '',
                            "cc_holdername"=>'');
        $this->ExtraProcesspuan = '';

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

    private function getmodel(&$nameis,&$passwordis,&$clientidis,&$posnois,&$xcipis,&$DataArray)
    {
    $extraid = $this->ExtraProcessid;
    $extrapuan = $this->ExtraProcesspuan;
    $ReqTypeis = ($this->ReqType == 'Auth')?'PRO':'OPR';
    $oid = (strlen($DataArray['orderid'])>24)? substr(str_replace('.','0',$DataArray['orderid']),0,24):substr('00000000000000000000',0,(24-strlen($DataArray['orderid']))).str_replace('.','0',$DataArray['orderid']);
    $tutar = sprintf('%012d',str_replace('.', '', number_format($DataArray['tutar'], 2, '','')));
    $installment = ($DataArray['cc_instalment_order']=='')?'00':sprintf('%02d',$DataArray['cc_instalment_order']);
    return  "kullanici=".$nameis.
            "&sifre=".$passwordis.
            "&islem=".$ReqTypeis.
            "&uyeno=".$clientidis.
            "&posno=".$posnois.
            "&kkno=".$DataArray['cc_no'].
            "&gectar=".$DataArray['cc_year'].$DataArray['cc_month'].
            "&cvc=".$DataArray['cc_ccv'].
            "&tutar=".$tutar.
            "&provno=000000".
            "&taksits=".$installment.
            "&islemyeri=I".
            "&uyeref=".$oid.
            "&vbref=0".
            "&khip=".$DataArray['ip'].
            "&xcip=".$xcipis;
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

    public function vkf_error_codes( $Status )
    {
    switch ( $Status )
    {
        case "02" :
            $msg = "Kartla ilgili problem. Bankanızı arayınız.";
            return $msg;
        case "69" :
            $msg = "Eksik Parametre. Kart bilgilerinizi kontrol edip tekrar deneyiniz.";
            return $msg;
        case "68" :
            $msg = "Hatalı İşlem Tipi. Lütfen sorunu yönetime bildirin.";
            return $msg;
        case "67" :
            $msg = "Parametre uzunluklarında uyuşmazlık. Lütfen bilgilerinizi kontrol ediniz.";
            return $msg;
        case "66" :
            $msg = "Numeric deger hatası. Nümerik değerlerden oluşması gereken alanlardan biri veya bırkaçı hatalı.";
            return $msg;
        case "64" :
            $msg = "İşlem tipi taksit e uygun değil.";
            return $msg;
        case "63" :
            $msg = "Request mesajinda illegal karakter var.";
            return $msg;
        case "62" :
            $msg = "Yetkisiz ya da tanımsız kullanıcı.";
            return $msg;
        case "61" :
            $msg = "Hatalı Tarih.";
            return $msg;
        case "60" :
            $msg = "Hareket Bulunamadi.";
            return $msg;
        case "59" :
            $msg = "Gunsonu yapilacak hareket yok/GS Yapilmis.";
            return $msg;
        case "90" :
            $msg = "Kayıt bulunamadı.";
            return $msg;
        case "91" :
            $msg = "Begin Transaction error.";
            return $msg;
        case "92" :
            $msg = "Insert Update Error.";
            return $msg;
        case "96" :
            $msg = "DLL registration error.";
            return $msg;
        case "97" :
            $msg = "IP Hatası.";
            return $msg;
        case "98" :
            $msg = "H. Iletisim hatası.";
            return $msg;
        case "99" :
            $msg = "DB Baglantı hatası.";
            return $msg;
        case "70" :
            $msg = "XCIP hatalı.";
            return $msg;
        case "71" :
            $msg = "Üye İşyeri blokeli ya da tanımsız.";
            return $msg;
        case "72" :
            $msg = "Tanımsız POS.";
            return $msg;
        case "73" :
            $msg = "POS table update error.";
            return $msg;
        case "76" :
            $msg = "Taksit e kapalı.";
            return $msg;
        case "74" :
            $msg = "Hatalı taksit sayısı.";
            return $msg;
        case "75" :
            $msg = "Illegal State.";
            return $msg;
        case "85" :
            $msg = "Kayit Reversal Durumda.";
            return $msg;
        case "86" :
            $msg = "Kayit Degistirilemez.";
            return $msg;
        case "87" :
            $msg = "Kayit Iade Durumda.";
            return $msg;
        case "88" :
            $msg = "Kayit Iptal Durumda.";
            return $msg;
        case "89" :
            $msg = "Geçersiz kayıt.";
            return $msg;
        case "01" :
            $msg = "Eski kayıt. Bir önceki siparişle aynı sipariş numarası girildi.";
            return $msg;
    }
    $msg = "Lütfen bilgilerinizi kontrol ediniz..";
    return $msg;
    }

    public function HTTPPOST()
    {
    $name='';
    $password='';
    $clientid='';
    $posno='';
    $xcip='';
    $host='';
    $path='';
    $timeout = self::$timeout;
    if(self::$isrealgateway)
    {
        $name = self::$real_apiname;
        $password = self::$real_apipass;
        $clientid = self::$real_apiclient;
        $posno = self::$real_apiposno;
        $xcip = self::$real_apixcip;
        $host = self::$real_gateway;
        $path = self::$real_gatpath;
    }
    else
    {
        $name = self::$test_apiname;
        $password = self::$test_apipass;
        $clientid = self::$test_apiclient;
        $posno = self::$test_apiposno;
        $xcip = self::$test_apixcip;
        $host = self::$test_gateway;
        $path = self::$test_gatpath;
    }

    $getdata = $this->getmodel($name,$password,$clientid,$posno,$xcip,$this->DataArray);
    $path = $path.$getdata;

    $buffer = "";
    if (!extension_loaded('curl')) {
        $fp = fsockopen("ssl://".$host, 443, $errno, $errstr, $timeout);
        if (!$fp)
        {
            $msg['result'] = -1;
            $msg['msg'] = ":: Bağlantı hatası lütfen daha sonra tekrar deneyiniz.";
            return $msg;
        }
        fputs($fp, "GET ".$path." HTTP/1.1\r\n");
        fputs($fp, "Host: $host\r\n");
        fputs($fp, "Connection: Close\r\n\r\n");
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
    $Response = substr( $buffer, strpos( $buffer, "<Cevap>" ) );
    $responseArray = $this->xmltohash( $Response );
    switch ( $responseArray['Cevap']['Msg']['Kod'] )
    {
        case "00" :
            $msg['result'] = 1;
            $msg['auth_code'] = $responseArray['Cevap']['Msg']['Mesaj'];
            break;
        default:
            $msg['result'] = -1;
            $msg['msg'] = $this->vkf_error_codes( $responseArray['Cevap']['Msg']['Kod'] )."-".$responseArray['Cevap']['Msg']['BKMKod'];
    }
    return $msg;
    }

}
?>
