<?php

class API
{
    /*Gerçek Hesap İşlemleri*/
    /*<Aktif>*/
    public static $real_apiname = '';
    public static $real_apipass = '';
    public static $real_apiclient = '';
    public static $real_gateway = '';
    public static $real_gatpath = '';
    /*</Aktif>*/
    /*Test, Sahte Hesap İşlemleri*/
    /*<Test>*/
    public static $test_gateway = '';
    public static $test_gatpath = '';
    public static $test_apiname = '';
    public static $test_apipass = '';
    public static $test_apiclient = '';
    /*</Test>*/
    public $ReqType = 'Auth';
    public $ExtraProcessid = 0;
    public static $isrealgateway = false;
    public static $timeout = 90;

    public $DataArray = array("ip"=>'',
                        "orderid" => '',
                        "cc_no"=>'',
                        "cc_month"=>'',
                        "cc_year"=>'',
                        "cc_ccv"=>'',
                        "tutar"=>'',
                        "currency"=>'',
                        "cc_instalment_order" => '',
                        "cc_holdername"=>'',
						"cc_type"=>'');
						
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

    private function xmlmodel(&$nameis,&$passwordis,&$clientidis,&$DataArray)
    {
    $extraid = $this->ExtraProcessid;
    $extrapuan = $this->ExtraProcesspuan;
    $extraselection = array (null,
                        array("KULLANPUAN","KULLANPUAN"),
                        array("IDEALPUANSORGU","SOR"),
                        array("EXTRAPUANORAN" ,$extrapuan),  /* "02.00"  */
                        array("EXTRAPUANTUTAR",$extrapuan)); /* "5.00"  */
	if($DataArray['cc_type']=="Visa") { $kart_tipi="VISA"; } 
	else if($DataArray['cc_type']=="Master Card") { $kart_tipi="MasterCard"; }  else { $kart_tipi=$DataArray['cc_type']; }
	
		$today = getdate( );
        $increment = $today['year'];
        for ( ; $increment < $today['year'] + 10; ++$increment )
        {
            $Year[] = array( "id" => strftime( "%y", mktime( 0, 0, 0, 1, 1, $increment ) ), "text" => strftime( "%Y", mktime( 0, 0, 0, 1, 1, $increment ) ) );
        }
				for( $increment=0; $increment<count($Year); $increment++) {
					if($Year[$increment]["id"]==$DataArray["cc_year"]) 
					{
					$cc_year=$Year[$increment]["text"]; 
					}
				}
				if(trim($DataArray["cc_instalment_order"])==''){
				$taksitfinish=0;
				} else { $taksitfinish=$DataArray["cc_instalment_order"]; }
			
				$Fay=date("m");
				$Fyil=date("Y");
				$Fgun=date("d");
				$TrnxID='FETA_'.$DataArray["orderid"];
				$TrnxID=str_replace(".","",$TrnxID);
				
		 return "<?xml version=\"1.0\" encoding=\"ISO-8859-9\" ?>\r\n".
		"<ePaymentMsg VersionInfo=\"2.0\" TT=\"Request\" RM=\"Direct\" CT=\"Money\">\r\n".
			"<Operation ActionType=\"Sale\">\r\n".
				"<OpData>\r\n".
					"<MerchantInfo MerchantId=\"{$clientidis}\" MerchantPassword=\"{$passwordis}\"/>\r\n".
					"<ActionInfo>\r\n".
						"<TrnxCommon TrnxID=\"{$TrnxID}\" Protocol=\"156\">\r\n".
							"<AmountInfo Amount=\"{$DataArray['tutar']}\" Currency=\"949\" />\r\n".
							"<ProtocolData></ProtocolData>\r\n".
						"</TrnxCommon>\r\n".
						"<PaymentTypeInfo>\r\n".
							"<InstallmentInfo NumberOfInstallments=\"{$taksitfinish}\" />\r\n".
						"</PaymentTypeInfo>\r\n".
					"</ActionInfo>\r\n".
					"<PANInfo PAN=\"{$DataArray['cc_no']}\" ExpiryDate=\"{$cc_year}{$DataArray['cc_month']}\" CVV2=\"{$DataArray['cc_ccv']}\" BrandID=\"{$kart_tipi}\" />\r\n".
					"<OrgTrnxInfo />\r\n".
					"<CustomData/>\r\n".
				"</OpData>\r\n".
			"</Operation>\r\n".
		"</ePaymentMsg>";
				
		/*return '<?xml version="1.0" encoding="ISO-8859-9"?><ePaymentMsg VersionInfo="2.0" TT="Request" RM="Direct" CT="Money"><Operation ActionType="Sale"><OpData><MerchantInfo MerchantId="'.$clientidis.'" MerchantPassword="'.$passwordis.'"/><ActionInfo><TrnxCommon TrnxID="'.$TrnxID.'" Protocol="156"><AmountInfo Amount="'.$DataArray["tutar"].'" Currency="949"/><ProtocolData></ProtocolData></TrnxCommon><PaymentTypeInfo><InstallmentInfo NumberOfInstallments="'.$taksitfinish.'"/></PaymentTypeInfo></ActionInfo><PANInfo PAN="'.$DataArray["cc_no"].'" ExpiryDate="'.$cc_year.''.$DataArray["cc_month"].'" CVV2="'.$DataArray["cc_ccv"].'" BrandID="'.$kart_tipi.'"></PANInfo><OrgTrnxInfo></OrgTrnxInfo><CustomData></CustomData></OpData></Operation></ePaymentMsg>'; */
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
        case "0" :
            $msg = "Onay kodu.";
            return $msg;
        case "1" :
            $msg = "Bankanızı arayın.";
            return $msg;
        case "2" :
            $msg = "Bankanızı arayın.";
            return $msg;
        case "4" :
            $msg = "Red-Karta El Koy.";
            return $msg;
        case "5" :
            $msg = "Red-Onaylanmadı.";
            return $msg;
        case "8" :
            $msg = "Kimlik Kontrolü/Onay Kodu.";
            return $msg;
        case "11" :
            $msg = "Onay kodu.";
            return $msg;
        case "12" :
            $msg = "Red-Geçersiz İşlem.";
            return $msg;
        case "13" :
            $msg = "Red-Geçersiz Tutar.";
            return $msg;
        case "14" :
            $msg = "Red-Hatalı Kart.";
            return $msg;
        case "15" :
            $msg = "Red-Gecersiz Kart.";
            return $msg;
        case "30" :
            $msg = "Bankanızı arayın.";
            return $msg;
        case "33" :
            $msg = "Red-Karta El Koy.";
            return $msg;
        case "34" :
            $msg = "Red-Karta El Koy.";
            return $msg;
        case "38" :
            $msg = "Red-Karta El Koy.";
            return $msg;
        case "41" :
            $msg = "Red-Karta El Koy.";
            return $msg;
        case "43" :
            $msg = "Red-Karta El Koy.";
            return $msg;
        case "51" :
            $msg = "Red-Yetersiz Bakiye.";
            return $msg;
        case "54" :
            $msg = "Red-Onaylanmadı.";
            return $msg;
        case "55" :
            $msg = "Red-Sifre Tekrar.";
            return $msg;
        case "57" :
            $msg = "Red-Onaylanmadı.";
            return $msg;
        case "58" :
            $msg = "Red-Onaylanmadı.";
            return $msg;
        case "62" :
            $msg = "Red-Onaylanmadı.";
            return $msg;
        case "65" :
            $msg = "Red-Onaylanmadı.";
            return $msg;
        case "75" :
            $msg = "Red-Onaylanmadı.";
            return $msg;
        case "91" :
            $msg = "Red-Bağlantı yok";
            return $msg;
        case "92" :
            $msg = "Red-Gecersiz Kart.";
            return $msg;
        case "96" :
            $msg = "Red Baglanti Yok.";
            return $msg;
        case "1010" :
            $msg = "Internal Error.";
            return $msg;
        case "1020" :
            $msg = "Internal Error.";
            return $msg;
        case "1030" :
            $msg = "Internal Error.";
            return $msg;
        case "5000" :
            $msg = "ISRS No error.";
            return $msg;
        case "5001" :
            $msg = "Client required field empty error.";
            return $msg;
        case "5002" :
            $msg = "Communication Error.";
            return $msg;
        case "5003" :
            $msg = "POS Interface Error.";
            return $msg;
        case "5101" :
            $msg = "Merchant Authorizer Configuration File property is not set.";
            return $msg;
        case "5102" :
            $msg = "Merchant Authorizer VerifyNumericValues returned false.";
            return $msg;
        case "5103" :
            $msg = "Merchant Authorizer SendAndReceive fails.";
            return $msg;
        case "5201" :
            $msg = "Merchant Factory Configuration File property is not set.";
            return $msg;
        case "5301" :
            $msg = "Configuration File property is not set.";
            return $msg;
        case "5302" :
            $msg = "Modifier VerifyNumericValues returned false.";
            return $msg;
        case "5303" :
            $msg = "Modifier SendAndReceive fails.";
            return $msg;
        case "5401" :
            $msg = "Merchant Query Configuration File property is not set.";
            return $msg;
        case "5402" :
            $msg = "Merchant Query Action Type is invalid.";
            return $msg;
        case "5403" :
            $msg = "Merchant Query SendAndReceive fails.";
            return $msg;
        case "5501" :
            $msg = "Batch Operation Configuration File property is not set.";
            return $msg;
        case "5502" :
            $msg = "Batch Operation VerifyNumericValues returned false.";
            return $msg;
        case "5503" :
            $msg = "Batch Operation Action Type is invalid.";
            return $msg;
        case "5504" :
            $msg = "Batch Operation SendAndReceive fails.";
            return $msg;
        case "5601" :
            $msg = "Refund Configuration File property is not set.";
            return $msg;
        case "5602" :
            $msg = "Refund VerifyNumericValues returned false.";
            return $msg;
        case "5603" :
            $msg = "Refund Operation SendAndReceive fails.";
            return $msg;
        case "6000" :
            $msg = "Xml hatası.";
            return $msg;
        case "6010" :
            $msg = "Tutar sayısal değil.";
            return $msg;
        case "6011" :
            $msg = "Para birimi değeri sayısal değil.";
            return $msg;
        case "6012" :
            $msg = "Kart numarası sayısal değil.";
            return $msg;
        case "6013" :
            $msg = "CVV2 değeri sayısal değil.";
            return $msg;
        case "6014" :
            $msg = "Gecersiz son kullanım tarihi.";
            return $msg;
        case "6015" :
            $msg = "Tutar 20000 YTLden büyük.";
            return $msg;
        case "6016" :
            $msg = "İşlem numarasi kabul edilemiyor.";
            return $msg;
        case "6020" :
            $msg = "Para tipi sistemde tanımlı değil.";
            return $msg;
        case "6021" :
            $msg = "Kart tipi sistemde tanımlı değil.";
            return $msg;
        case "6030" :
            $msg = "Kart son kullanım tarihi geçmis.";
            return $msg;
        case "6040" :
            $msg = "Firma geçerli değil.";
            return $msg;
        case "6041" :
            $msg = "Firma sifresi hatalı.";
            return $msg;
        case "6042" :
            $msg = "Firma mesgul.";
            return $msg;
        case "6050" :
            $msg = "Terminal geçerli değil.";
            return $msg;
        case "6051" :
            $msg = "Terminal mesgul.";
            return $msg;
        case "6060" :
            $msg = "Firma bu islemi gerçeklestirmek icin yetkili değil.";
            return $msg;
        case "6061" :
            $msg = "Terminal bu islemi gerçeklestirmek icin yetkili değil.";
            return $msg;
        case "6062" :
            $msg = "Kullanıcı bu islemi gerçeklestirmek icin yetkili değil.";
            return $msg;
        case "6070" :
            $msg = "Açılmıs batch bulunamadı.";
            return $msg;
        case "6071" :
            $msg = "Sıra numarası olusturulamıyor.";
            return $msg;
        case "6072" :
            $msg = "Otorizasyon isteği veritabanina yazılamıyor.";
            return $msg;
        case "6073" :
            $msg = "Orijinal islem bilgisi bos.";
            return $msg;
        case "6074" :
            $msg = "Orijinal islem değistirilemez.";
            return $msg;
        case "6075" :
            $msg = "Degistirilecek tutar orijinal islem tutarından büyük.";
            return $msg;
        case "6076" :
            $msg = "Reauth süresi geçmis.";
            return $msg;
        case "6077" :
            $msg = "Orijinal islem mesgul.";
            return $msg;
        case "6078" :
            $msg = "Orijinal islem bulunamadı.";
            return $msg;
        case "6079" :
            $msg = "Orijinal islem isteği ile değisiklik islem isteği aynı batch de bulunmuyor.";
            return $msg;
        case "6080" :
            $msg = "Orijinal islem isteği ile degisiklik islem isteği aynı türde değil.";
            return $msg;
        case "6081" :
            $msg = "Değisiklik yapılabilecek sure dolmustur.";
            return $msg;
        case "6082" :
            $msg = "Bu islem numarası ile baska bir Islem daha once gerceklestirilmistir.";
            return $msg;
        case "6083" :
            $msg = "Aynı islem numarası ile baska bir islem daha once batch isteği icin gerçeklestirilmis.";
            return $msg;
        case "6084" :
            $msg = "Batch için hiç bir açık para tipi bulunmuyor.";
            return $msg;
        case "6085" :
            $msg = "Terminaller icin açılmıs batchler bulundu.";
            return $msg;
        case "6086" :
            $msg = "Terminal havuzu yaratılamadı.";
            return $msg;
        case "6087" :
            $msg = "Firma islemi otorizasyon modülünde veritabanı hatası.";
            return $msg;
        case "6088" :
            $msg = "Dslem isteği veritabanına yazilamadi.";
            return $msg;
        case "6089" :
            $msg = "Orijinal islemi alırken veritabanında hata olustu.";
            return $msg;
        case "6090" :
            $msg = "Alısveris sıra bilgisi veritabanına yazilamadi.";
            return $msg;
        case "6091" :
            $msg = "LI hatası.";
            return $msg;
        case "6093" :
            $msg = "Sorgu kontrolü hatalı dondu.";
            return $msg;
        case "6094" :
            $msg = "Ekleme sorgu islemi hatalı dondu.";
            return $msg;
        case "6095" :
            $msg = "Sorgu islemi basarısız.";
            return $msg;
        case "6096" :
            $msg = "Firma değerlendirmesinde veritabanı hatası.";
            return $msg;
        case "6097" :
            $msg = "Terminal kontrol hatası.";
            return $msg;
        case "6098" :
            $msg = "Orijinal islem bilgisi bos.";
            return $msg;
        case "6099" :
            $msg = "Dslem alanları orijinal islem ile aynı değil.";
            return $msg;
        case "6100" :
            $msg = "Tutarda birden fazla hane ayracı var.";
            return $msg;
        case "6101" :
            $msg = "Tutar binler ayracını içeremez.";
            return $msg;
        case "6103" :
            $msg = "Geçersiz tutar biçimi.";
            return $msg;
        case "6104" :
            $msg = "Firmaya ait terminal bulunmuyor.";
            return $msg;
        case "7000" :
            $msg = "Zorunlu alan eksik.";
            return $msg;
        case "7001" :
            $msg = "Dahili hata.";
            return $msg;
        case "7011" :
            $msg = "Orijinal kart numarası ile değisiklik islemi pan numarası farklı.";
            return $msg;
        case "7012" :
            $msg = "Orijinal son kullanma tarihi ile değisiklik islemi son kullanma tarihi farklı.";
            return $msg;
        case "7013" :
            $msg = "Orijinal CVV2 değeri ile değisiklik islemi CVV2 değeri farklı.";
            return $msg;
        case "7014" :
            $msg = "Orijinal otorizasyon kodu ile değisiklik islemi otorizasyon kodu farklı.";
            return $msg;
        case "7015" :
            $msg = "Orijinal para kodu ile değisiklik islemi para kodu farklı.";
            return $msg;
        case "7016" :
            $msg = "Orijinal taksit sayisi ile değisiklik islemi taksit sayısı farklı.";
            return $msg;
        case "7019" :
            $msg = "Değisiklik islemi tutari ile orijinal islem tutari esit olmak zorundadir.";
            return $msg;
        case "9000" :
            $msg = "Dslem devam ediyor.";
            return $msg;
        case "9005" :
            $msg = "Dahili hata, POS sıra numarası alınamadı.";
            return $msg;
        case "9006" :
            $msg = "XML mesajı olması gerektiğinden büyük.";
            return $msg;
        case "9997" :
            $msg = "Xml cevabı hazırlanamadı.";
            return $msg;
        case "9998" :
            $msg = "Xml isteğinde gerekli parametreler bulunamadı.";
            return $msg;
        case "9999" :
            $msg = "Hatalı XML mesajı.";
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
    $host='';
    $path='';
    $timeout = self::$timeout;
    if(self::$isrealgateway)
    {
        $name = self::$real_apiname;
        $password = self::$real_apipass;
        $clientid = self::$real_apiclient;
        $host = self::$real_gateway;
        $path = self::$real_gatpath;
    }
    else
    {
        $name = self::$test_apiname;
        $password = self::$test_apipass;
        $clientid = self::$test_apiclient;
        $host = self::$test_gateway;
        $path = self::$test_gatpath;
    }

    $postdata = $this->xmlmodel($name,$password,$clientid,$this->DataArray);

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
        fputs($fp, "prmstr=".$postdata);
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
		curl_setopt($ch, CURLOPT_POSTFIELDS, "prmstr=".$postdata);
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
// işlem kontrolu için döner değerler alınıyor.
		preg_match('/AuthCode="(.*?)"/i', $buffer, $AuthC);
		@$AuthCode=$AuthC[1];
		preg_match('/ResultCode="(.*?)"/i', $buffer, $ResultC);
		@$ResultCode=$ResultC[1];
		preg_match('/<status>(.*)<\/status>/i', $buffer, $StatusC);
		$Status=$StatusC[1];

		if(trim($Status)=='') {
		if($ResultCode=="0000") {
		    $msg['result'] = 1;
            $msg['auth_code'] = $AuthCode;
			} else {
			$msg['result'] = -1;
            $msg['msg'] = ":= ".$this->est_error_codes( $ResultCode )."-".$ResultCode;
			}
			} else {
			$msg['result'] = -1;
            $msg['msg'] = ":= ".$this->est_error_codes( $Status )."-".$ResultCode;
			}

    return $msg;
    }

}
?>
