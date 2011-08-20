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

    public static function zrt_error_codes( $Status )
    {
        switch ( $Status )
        {
            case "00" :
                $msg = "OTORIZASYON VERILDI –ONAY VERILDI";
                return $msg;
            case "02" :
                $msg = "KARTI VEREN BANKAYI ARAYINIZ.";
                return $msg;
            case "03" :
                $msg = "GEÇERSIZ ÜYE ISYERI";
                return $msg;
            case "04" :
                $msg = "KARTA EL KOYUNUZ";
                return $msg;
            case "05" :
                $msg = "Islem Onaylanmadi";
                return $msg;
            case "12" :
                $msg = "Geçersiz Islem";
                return $msg;
            case "13" :
                $msg = "Geçersiz Islem tutari";
                return $msg;
            case "14" :
                $msg = "Geçersiz Kart Numarasi";
                return $msg;
            case "15" :
                $msg = "Kart Veren Banka Tanimsiz";
                return $msg;
            case "41" :
                $msg = "KAYIP KART";
                return $msg;
            case "43" :
                $msg = "Çalinti Kart";
                return $msg;
            case "51" :
                $msg = "Kart limiti Yetersiz";
                return $msg;
            case "54" :
                $msg = "Vade Sonu Geçmis Kart";
                return $msg;
            case "57" :
                $msg = "Islem Tipine Müsade Yok";
                return $msg;
            case "58" :
                $msg = "Islem Tipi Terminale Kapali";
                return $msg;
            case "62" :
                $msg = "KISITLANMIS KART";
                return $msg;
            case "91" :
                $msg = "BU HESAPTA HIÇBIR ISLEM YAPILAMAZ";
                return $msg;
            case "96" :
                $msg = "SISTEM ARIZASI";
                return $msg;
        }
    $msg = "Lütfen bilgilerinizi kontrol ediniz..";
    return $msg;
    }

    public function HTTPPOST()
    {
    $name = $this->DataArray["apiname"];
    $password = $this->DataArray["apipass"];
    $clientid = $this->DataArray["clientid"];
    $gate = $this->DataArray["savegate"];

    $oid = $this->DataArray['oid'];
    $instalment = $this->DataArray['instalment'];
    $mnt = str_replace('.', '', number_format($this->DataArray['amount'], 2, '',''));

    $postdata = "AmountMerchant=&AmountCode=949&MerchantID=&UserName=&Password=&MerchantGUID=&InstalmentCount=&AmountBank=";
    $strlength = strlen( $postdata );
    $buffer = "";
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $gate);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    $buffer = curl_exec($ch);
    if (curl_errno($ch))
    {
      $msg['result'] = -1;
      $msg['msg'] = "Baglanti hatasi lütfen daha sonra tekrar deneyiniz.";
      return $msg;
    }
    else
    {
      curl_close($ch);
    }
    if(preg_match('/^([a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12})/', $buffer, $matches))
    {
    $msg['result'] = 1;
    $msg['msg'] = $matches[1];
    }
    else
    {
    $msg['result'] = 0;
    $msg['msg'] = trim(strip_tags($buffer));
    }
    return $msg;
    }

}
?>