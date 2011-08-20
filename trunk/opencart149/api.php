<?php
/*
  $Id: OPENCART WEBPOS PRO V.1.0

  Webpos Pro, Open Source E-Commerce Payment Solutions

  Coded by Yavuz Yasin Düzgün (duzgun)
  Copyright (c) http://www.duzgun.com , http://www.opencart.com.tr

  Released under the GNU General Public License
*/

$est = array('AKBNK','ISCTR','GABNK','TEBNK','FINBN','HALKB','DENIZ','FORTS','ANDLB','KUVTR');

require_once('api_config.php');

function requestapi(){
$api = NULL;
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
if($_POST['api'] == 'OTHER')
{
$api = basename(constant_config('webpos_cc_other_id'));
}
else
{
if (!(strpos(constant_config('webpos_cc_apis'),$_POST['api'])===false))
{
$api = $_POST['api'];
}
else
{
$api = NULL;
}
}
}
return $api;
}
	
function WPS()
{
global $est;

if(isset($_SESSION['transferdata']) && is_array($_SESSION['transferdata']))
{
if(in_array($_SESSION['transferdata']['api'],$est)){
if(in_array($_SESSION['transferdata']['storetype'],array('3d','3d_pay','3d_oos_pay')) && $_POST["Response"]=="Error" && isset($_POST["ErrMsg"]))
redirect('payment',array('error'=>$_POST["ErrMsg"].' Hata Kodu:4532'));
}
} 

$webpos_storetype = 0;
$storetype  = isset($_POST['storetype'])?strtolower($_POST['storetype']):"";
$storelevel = isset($_POST['secure3dsecuritylevel'])?strtolower($_POST['secure3dsecuritylevel']):"";
if ($storetype == '3d')
{
$webpos_storetype =1;
}
else if ($storetype == 'ykb3d')
{
$webpos_storetype =2;
}
else if ($storetype == 'mpi3d')
{
$webpos_storetype =3;
}
else if ($storetype == '3d_pay')
{
$webpos_storetype =4;
}
else if ($storetype == '3d_oos_pay')
{
$webpos_storetype =5;
}
else if ($storelevel == '3d')
{
$webpos_storetype =6;
}
else if ($storelevel == '3d_pay')
{
$webpos_storetype =7;
}
else if ($storelevel == '3d_full')
{
$webpos_storetype =8;
}
else if ($storelevel == '3d_half')
{
$webpos_storetype =9;
}
else if ($storelevel == '3d_oos_pay')
{
$webpos_storetype =10;
}
else if ($storelevel == '3d_oos_full')
{
$webpos_storetype =11;
}
else if ($storelevel == '3d_oos_half')
{
$webpos_storetype =12;
}
else if ($storelevel == 'oos_pay')
{
$webpos_storetype =10;
}
return $webpos_storetype;
}

function WPT()
{
$webpos_taksit = 0;
$webpos_oran = 0;
$webpos_amount = 0;
$webpos  = isset($_POST['webpos_taksit'])?$_POST['webpos_taksit']:"";
if($webpos!="")
{
if (strpos($webpos, 'x') !== false)
{
$webpos_taksit_pieces = explode('x', $webpos);
if(count($webpos_taksit_pieces)==3)
{
if($webpos_taksit_pieces[0]==0)
{
$webpos_taksit =0;
$webpos_oran = $webpos_taksit_pieces[1];
$webpos_amount = $webpos_taksit_pieces[2];
}
else
{
$webpos_taksit = $webpos_taksit_pieces[0];
$webpos_oran = $webpos_taksit_pieces[1];
$webpos_amount = $webpos_taksit_pieces[2];
}
}
}
}
return array($webpos_taksit,$webpos_oran,$webpos_amount);	
}
	
function utf8_urldecode($str) {
  global $utf8_urldecode;
   if(isset($utf8_urldecode) && $utf8_urldecode == true){
    $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
    return iconv("UTF-8", "ISO-8859-9",html_entity_decode(trim($str), ENT_QUOTES, 'UTF-8'));
    }else
    {
    return $str;
    }
}

function est3D_error_codes( $Status )
{
    switch ( $Status )
    {
        case "1" :
            $msg = "Tam doğrulama";
            return $msg;
        case "2" :
            $msg = "Kartsahibi veya bankası sisteme kayıtlı değil";
            return $msg;
        case "3" :
            $msg = "Kartın bankası sisteme kayıtlı değil (önbellekten)";
            return $msg;
        case "4" :
            $msg = "Doğrulama denemesi, kartsahibi sisteme daha sonra kayıt olmayı seçmiş";
            return $msg;
        case "5" :
            $msg = "Kredi Kartı Doğrulama yapılamıyor.";
            return $msg;
        case "6" :
            $msg = "3-D Secure Hatası, Hata mesajı veya işyeri 3-D Secure sistemine kayıtlı değil";
            return $msg;
        case "7" :
            $msg = "Sistem Hatası";
            return $msg;
        case "8" :
            $msg = "Bilinmeyen kartno, Visa veya MasterCard tanımsız";
            return $msg;
        case "0" :
            $msg = "3-D secure imzası geçersiz veya Doğrulama başarısız";
            return $msg;

    }
    $msg = "Lütfen bilgilerinizi kontrol ediniz..";
    return $msg;
}

function G3D_error_codes( $Status )
{
  switch ( $Status )
  {
    case "1" :
    $msg = "Tam doğrulama";
    return $msg;
    case "2" :
    $msg = "Kartsahibi veya bankasy sisteme kayıtlı değil";
    return $msg;
    case "3" :
    $msg = "Kartyn bankası sisteme kayıtlı değil (önbellekten)";
    return $msg;
    case "4" :
    $msg = "Do?rulama denemesi, kartsahibi sisteme daha sonra kayyt olmayı seçmiç";
    return $msg;
    case "5" :
    $msg = "Kredi Kartı Doğrulama yapylamıyor.";
    return $msg;
    case "6" :
    $msg = "3-D Secure Hatası, Hata mesajı veya işyeri 3-D Secure sistemine kayıtlı değil";
    return $msg;
    case "7" :
    $msg = "Sistem Hatası";
    return $msg;
    case "8" :
    $msg = "Bilinmeyen kartno, Visa veya MasterCard tanımsız";
    return $msg;
    case "0" :
    $msg = "3-D secure imzası geçersiz veya Doğrulama başarısız";
    return $msg;
  }
    $msg = "Lütfen bilgilerinizi kontrol ediniz..";
    return $msg;
}
$okUrl   = api_redirect('api'); //"http://localhost/osc/3DModelodeme.php?success"; //tep_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL', true, false); //
$failUrl = api_redirect('api'); //"http://localhost/osc/3DModelodeme.php?fail";//tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false); //

if(isset($_POST['go']) && $_POST['go'] == 'ZRAAT_OOS')
{
$api     = '';
if($_POST['api'] == 'OTHER')
{
$api = basename(constant_config('webpos_cc_other_id'));
}
else
{
if (!(strpos(constant_config('webpos_cc_apis'),$_POST['api'])===false))
{
  $api = $_POST['api'];
}
else
{
  $api = '';
}
}
if (!empty($api))
{
include(DIR_WEBPOS.'webpos/'.basename($api).'.OOS.php');
require(DIR_WEBPOS.'webpos/execution/'.basename($api).'.OOS.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}

$sendgate = $ThreeD[$isrealgateway]['sendgate'];

$client = new API();
$client->ReqType = $reqtype;
$client->ExtraProcessid = 0;
$client->DataArray = array(
                        "oid" => sprintf("%016d",$_POST['oid']),
                        "instalment" => $_POST['taksit'],
                        "amount" => $_POST['amount'],
                        'clientid'  => $ThreeD[$isrealgateway]['clientid'],
                        'apiname'  => $ThreeD[$isrealgateway]['apiname'],
                        'apipass'  => $ThreeD[$isrealgateway]['apipass'],
                        'savegate' => $ThreeD[$isrealgateway]['savegate']
                        );

$result = $client->HTTPPOST();

$_SESSION['transferdata'] = array('oid'=>$_POST['oid'],'storetype'=>'zrt_oos','api'=>$api);

if($result['result'] === 1)
{
echo "1"."\n".$sendgate.'?TransactionID='.$result['msg'];
}
else
{
echo "0"."\n".$result['msg'];
}
}
else
{
echo '-1'."\n".'API NAME ERROR';
}
}
else if(isset($_GET['TransactionGUID']) && preg_match('/^([a-zA-Z0-9]{8}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{12})$/', $_GET['TransactionGUID']))
{
if($_GET['RC']=='00')
{
//tep_redirect($link.FILENAME_CHECKOUT_PROCESS."?sonuc=00&".session_name()."=".$sess_result['sesskey']);
}
else
{
//tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=partnerpos&error=' . urlencode(zrt_error_codes($_GET['RC']).':'.$_GET['ErrorNo']), 'SSL', true, false));
}
}
else if(isset($_POST['go']) && $_POST['go'] == 'EST3D_OOS_PAY')
{

$rnd     = microtime();
$api     = '';

if($_POST['api'] == 'OTHER')
{
$api = basename(constant_config('webpos_cc_other_id'));
}
else
{
if (!(strpos(constant_config('webpos_cc_apis'),$_POST['api'])===false))
{
  $api = $_POST['api'];
}
else
{
  $api = '';
}
}
if (!empty($api))
{
include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}
$clientid = $ThreeD[$isrealgateway]['clientid'];
$storetype= $ThreeD[$isrealgateway]['storetype'];
$lang     = $ThreeD[$isrealgateway]['lang'];
$post     = $ThreeD[$isrealgateway]['3Dgate'];
$storekey = $ThreeD[$isrealgateway]['storekey'];
$taksit = $_POST['taksit'];

//if (!tep_session_is_registered('transferdata')) tep_session_register('transferdata');
$_SESSION['transferdata'] = array('oid'=>$_POST['oid'],'storetype'=>strtolower($storetype),'api'=>$api);

$hashstr = $clientid . $_POST['oid'] . $_POST['amount'] . $okUrl . $failUrl . $reqtype . $taksit . $rnd  . $storekey;
$hash = base64_encode(pack('H*',sha1($hashstr)));
echo $hash."\n".$clientid."\n".$okUrl."\n".$failUrl."\n".$rnd."\n".$storetype."\n".$lang."\n".$reqtype."\n".$taksit."\n".$post;



}
else
{
echo ''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n";
}
}
else if(isset($_POST['go']) && $_POST['go'] == 'GRN3D_OOS_PAY')
{
$rnd     = microtime();
$api     = '';

if($_POST['api'] == 'OTHER')
{
$api = basename(constant_config('webpos_cc_other_id'));
}
else
{
if (!(strpos(constant_config('webpos_cc_apis'),$_POST['api'])===false))
{
  $api = $_POST['api'];
}
else
{
  $api = '';
}
}
if (!empty($api))
{
include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}

$merchantid = $ThreeD[$isrealgateway]['merchantid'];
$terminalid = $ThreeD[$isrealgateway]['terminalid'];
$storetype = $ThreeD[$isrealgateway]['storetype'];
$mode = $ThreeD[$isrealgateway]['mode'];
$provuserid = $ThreeD[$isrealgateway]['provuserid'];
$propassword = $ThreeD[$isrealgateway]['propassword'];
$currency_value = $ThreeD[$isrealgateway]['currency'];
$agentuserid = $ThreeD[$isrealgateway]['agentuserid'];
$post     = $ThreeD[$isrealgateway]['3Dgate'];
$storekey = $ThreeD[$isrealgateway]['storekey'];
$lang = $ThreeD[$isrealgateway]['lang'];
$apiversion = "v0.01";
$taksit = $_POST['taksit'];
$amount = str_replace('.', '', number_format($_POST['amount'], 2, '',''));
//$arroid = explode('.',$_POST['oid']);
//$oid = $arroid[1].sprintf("%016d",$arroid[0]);
$oid = sprintf("%016d",$_POST['oid']);

//if (!tep_session_is_registered('transferdata')) tep_session_register('transferdata');
$_SESSION['transferdata'] = array('oid'=>$_POST['oid'],'storetype'=>strtolower($storetype),'api'=>$api);

$SecurityData = strtoupper(sha1($propassword.sprintf("%09d",$terminalid)));
$HashData = strtoupper(sha1($terminalid.$oid.$amount.$okUrl.$failUrl.$reqtype.$taksit.$storekey.$SecurityData));

echo $storetype."\n".$mode."\n".$apiversion."\n".$provuserid."\n".$agentuserid."\n".$merchantid."\n".$reqtype."\n".$amount."\n".$currency_value."\n".$taksit."\n".$oid."\n".$terminalid."\n".$okUrl."\n".$failUrl."\n".$_SERVER["REMOTE_ADDR"]."\n".$HashData."\n".$post."\n".$lang."\n".$rnd;
}
else
{
echo ''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".'';
}
}
else if(isset($_POST['go']) && $_POST['go'] == '3d_pay')
{
$mdStatus = (int)$_POST['mdStatus'];
// Visa card da md status 7 döndürüyor test işleminde. ücrette çekilmiş olarak yansıyor
if($mdStatus <1 || $mdStatus >4)
{
redirect('payment',array(   'error'=> est3D_error_codes($mdStatus).". Api Hata Kodu:1029"  ,
                            'webpos_cc_owner'=>urlencode( $_POST['webpos_cc_owner'] ),
                            'webpos_cc_expires_month'=>$_POST['Ecom_Payment_Card_ExpDate_Month'],
                            'webpos_cc_expires_year'=>$_POST['Ecom_Payment_Card_ExpDate_Year']
                            ));
}
$api = '';
if($_POST['api'] == 'OTHER')
{
$api = basename(constant_config('webpos_cc_other_id'));
}
else
{
if (!(strpos(constant_config('webpos_cc_apis'),$_POST['api'])===false))
{
$api = $_POST['api'];
}
else
{
$api = '';
}
}
if (!empty($api))
{
include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode') == 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}

$hashparams = $_POST["HASHPARAMS"];
$hashparamsval = $_POST["HASHPARAMSVAL"];
$hashparam = $_POST["HASH"];
$paramsval="";
$index1=0;
$index2=0;

while($index1 < strlen($hashparams))
{
$index2 = strpos($hashparams,":",$index1);
$vl = isset($_POST[substr($hashparams,$index1,$index2- $index1)])?$_POST[substr($hashparams,$index1,$index2- $index1)]:null;
if($vl == null)
$vl = "";
$paramsval = $paramsval . $vl;
$index1 = $index2 + 1;
}
$hashval = $paramsval.$ThreeD[$isrealgateway]['storekey'];
$hash = base64_encode(pack('H*',sha1($hashval)));
if($paramsval != $hashparamsval || $hashparam != $hash)
{
redirect('payment',array(   'error'=> "Güvenlik Uyarisi. Sayisal Imza Geçerli Degil"  ,
                            'webpos_cc_owner'=>urlencode( $_POST['webpos_cc_owner'] ),
                            'webpos_cc_expires_month'=>$_POST['Ecom_Payment_Card_ExpDate_Month'],
                            'webpos_cc_expires_year'=>$_POST['Ecom_Payment_Card_ExpDate_Year']
                            ));
}
$ErrMsg = $_POST["ErrMsg"];
$response = $_POST["Response"];
if($response == "Approved")
{
$_SESSION['ccencodekey'] = 1;
redirect('process',array('api'=>$api,'ottaksitapi'=>$_POST['webpos_taksit'],'transaction_id'=>urlencode($_POST['AuthCode'])));
}
else
{
redirect('payment',array(   'error'=> "Ödeme Islemi Basarisiz. Hata = ".$ErrMsg  ,
                            'webpos_cc_owner'=>urlencode( $_POST['webpos_cc_owner'] ),
                            'webpos_cc_expires_month'=>$_POST['Ecom_Payment_Card_ExpDate_Month'],
                            'webpos_cc_expires_year'=>$_POST['Ecom_Payment_Card_ExpDate_Year']
                            ));
}
}
else
{
 redirect('payment',array('error'=> "API NAME ERROR!!!" ));
}
//end of 3d_pay block
}
else if(isset($_POST['go']) && $_POST['go'] == 'EST3D')
{
$rnd     = microtime();
$api     = '';

if($_POST['api'] == 'OTHER')
{
$api = basename(constant_config('webpos_cc_other_id'));
}
else
{
if (!(strpos(constant_config('webpos_cc_apis'),$_POST['api'])===false))
{
  $api = $_POST['api'];
}
else
{
  $api = '';
}
}
if (!empty($api))
{
include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}
$clientid = $ThreeD[$isrealgateway]['clientid'];
$storetype= $ThreeD[$isrealgateway]['storetype'];
$lang     = $ThreeD[$isrealgateway]['lang'];
$post     = $ThreeD[$isrealgateway]['3Dgate'];
$storekey = $ThreeD[$isrealgateway]['storekey'];

//if (!tep_session_is_registered('transferdata')) tep_session_register('transferdata');
$_SESSION['transferdata'] = array('oid'=>$_POST['oid'],'storetype'=>strtolower($storetype),'api'=>$api);

$hashstr = $clientid . $_POST['oid'] . $_POST['amount'] . $okUrl . $failUrl . $rnd  . $storekey;
$hash = base64_encode(pack('H*',sha1($hashstr)));
echo $hash."\n".$clientid."\n".$okUrl."\n".$failUrl."\n".$rnd."\n".$storetype."\n".$lang."\n".$post;
}
else
{
echo ''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".'';
}
}
else if(isset($_POST['go']) && $_POST['go'] == 'EST3D_PAY')
{
$rnd     = microtime();
$api     = '';

if($_POST['api'] == 'OTHER')
{
$api = basename(constant_config('webpos_cc_other_id'));
}
else
{
if (!(strpos(constant_config('webpos_cc_apis'),$_POST['api'])===false))
{
  $api = $_POST['api'];
}
else
{
  $api = '';
}
}
if (!empty($api))
{
include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}
$clientid = $ThreeD[$isrealgateway]['clientid'];
$storetype= $ThreeD[$isrealgateway]['storetype'];
$lang     = $ThreeD[$isrealgateway]['lang'];
$post     = $ThreeD[$isrealgateway]['3Dgate'];
$storekey = $ThreeD[$isrealgateway]['storekey'];
$taksit = $_POST['taksit'];

//if (!tep_session_is_registered('transferdata')) tep_session_register('transferdata');
$_SESSION['transferdata'] = array('oid'=>$_POST['oid'],'storetype'=>strtolower($storetype),'api'=>$api);

$hashstr = $clientid . $_POST['oid'] . $_POST['amount'] . $okUrl . $failUrl . $reqtype . $taksit . $rnd  . $storekey;
$hash = base64_encode(pack('H*',sha1($hashstr)));
echo $hash."\n".$clientid."\n".$okUrl."\n".$failUrl."\n".$rnd."\n".$storetype."\n".$lang."\n".$reqtype."\n".$taksit."\n".$post;



}
else
{
echo ''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n";
}
}
else if(isset($_POST['go']) && $_POST['go'] == 'GRN3D')
{
$rnd     = microtime();
$api     = '';

if($_POST['api'] == 'OTHER')
{
$api = basename(constant_config('webpos_cc_other_id'));
}
else
{
if (!(strpos(constant_config('webpos_cc_apis'),$_POST['api'])===false))
{
  $api = $_POST['api'];
}
else
{
  $api = '';
}
}
if (!empty($api))
{
include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}
$merchantid = $ThreeD[$isrealgateway]['merchantid'];
$terminalid = $ThreeD[$isrealgateway]['terminalid'];
$storetype = $ThreeD[$isrealgateway]['storetype'];
$mode = $ThreeD[$isrealgateway]['mode'];
$provuserid = $ThreeD[$isrealgateway]['provuserid'];
$propassword = $ThreeD[$isrealgateway]['propassword'];
$currency_value = $ThreeD[$isrealgateway]['currency'];
$agentuserid = $ThreeD[$isrealgateway]['agentuserid'];
$post     = $ThreeD[$isrealgateway]['3Dgate'];
$storekey = $ThreeD[$isrealgateway]['storekey'];
$apiversion = "v0.01";
$taksit = $_POST['taksit'];
$amount = str_replace('.', '', number_format($_POST['amount'], 2, '',''));
//$arroid = explode('.',$_POST['oid']);
//$oid = $arroid[1].sprintf("%016d",$arroid[0]);
$oid = sprintf("%016d",$_POST['oid']);

//if (!tep_session_is_registered('transferdata')) tep_session_register('transferdata');
$_SESSION['transferdata'] = array('oid'=>$_POST['oid'],'storetype'=>strtolower($storetype),'api'=>$api);

$SecurityData = strtoupper(sha1($propassword.sprintf("%09d",$terminalid)));
$HashData = strtoupper(sha1($terminalid.$oid.$amount.$okUrl.$failUrl.$reqtype.$taksit.$storekey.$SecurityData));

echo $storetype."\n".$mode."\n".$apiversion."\n".$provuserid."\n".$agentuserid."\n".$merchantid."\n".$reqtype."\n".$amount."\n".$currency_value."\n".$taksit."\n".$oid."\n".$terminalid."\n".$okUrl."\n".$failUrl."\n".$_SERVER["REMOTE_ADDR"]."\n".$HashData."\n".$post;
}
else
{
echo ''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".'';
}
}
else if(isset($_POST['go']) && $_POST['go'] == 'YKB3D')
{

$rnd     = microtime();
$api     = '';

if($_POST['api'] == 'OTHER')
{
$api = basename(constant_config('webpos_cc_other_id'));
}
else
{
if (!(strpos(constant_config('webpos_cc_apis'),$_POST['api'])===false))
{
  $api = $_POST['api'];
}
else
{
  $api = '';
}
}
if (!empty($api))
{
include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
require(DIR_WEBPOS.'webpos/execution/'.basename($api).'.3D.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}
$client = new API();
$client->ReqType = $reqtype;
$client->ExtraProcessid = 0;
$client->DataArray = array(
                        "ip" => GetHostByName($_SERVER['REMOTE_ADDR']),
                        'td_check'  => $ThreeD[$isrealgateway]['td_check'],
                        'username'  => $ThreeD[$isrealgateway]['username'],
                        'password'  => $ThreeD[$isrealgateway]['password'],
                        'mid'       => $ThreeD[$isrealgateway]['mid'],
                        'tid'       => $ThreeD[$isrealgateway]['tid'],
                        'posnetid'  => $ThreeD[$isrealgateway]['posnetid'],
                        '3Dgate'    => $ThreeD[$isrealgateway]['3Dgate'],
                        'gateway'   => $ThreeD[$isrealgateway]['gateway'],
                        'gatpath'   => $ThreeD[$isrealgateway]['gatpath'],
                        'gatssl'    => $ThreeD[$isrealgateway]['gatssl'],
                        'enckey'    => $ThreeD[$isrealgateway]['enckey'],
                        'mcrypt'    => $ThreeD[$isrealgateway]['mcrypt'],
                        'td_mask'   => $ThreeD[$isrealgateway]['td_mask'],
                        "XID" => $_POST['oid'],
                        "ccno" => $_POST['ccno'],
                        "expdate" =>$_POST['expdy'].$_POST['expdm'],
                        "cvv" => $_POST['cvv'],
                        "tranType" => 'Sale',
                        "instalment" => $_POST['taksit'],
                        "currency" => 'YT',
                        "amount" => $_POST['amount'],
                        "vftCode" => '',
                        "custName" => utf8_urldecode($_POST['owner']));

$result = $client->HTTPPOSTTDS();
$webpos_cc_owner = utf8_urldecode($_POST['owner']);
$securecode = utf8_urldecode($_POST['SecureCode']);
$webpos_taksit = $_POST['wpt'];
$payment = $_POST['py'];
$ccno = substr( $_POST['ccno'], 0, 4 ).str_repeat( "*", strlen( $_POST['ccno'] ) - 8 ).substr( $_POST['ccno'], -4 );
$cvv = '**'.substr( $_POST['cvv'],-1 );
$expdy = $_POST['expdy'];
$expdm = $_POST['expdm'];

//if (!tep_session_is_registered('transferdata')) tep_session_register('transferdata');
$_SESSION['transferdata'] = array('oid'=>$_POST['oid'],'storetype'=>'ykb3d','api'=>$api);

//if (!tep_session_is_registered('ykbtransferdata')) tep_session_register('ykbtransferdata');
$_SESSION['ykbtransferdata'] = array('webpos_cc_owner'=>$webpos_cc_owner,'SecureCode'=>$securecode,'webpos_taksit'=>$webpos_taksit,'payment'=>$payment,'storetype'=>'ykb3d','api'=>$api,'webpos_cc_checkcode'=>$cvv,'webpos_cc_number'=>$ccno,'webpos_cc_expires_month'=>$expdm,'webpos_cc_expires_year'=>$expdy);
if($result['result'] == 1)
{
$posnetData = $result['data1'];
$posnetData2 = $result['data2'];
$digest = $result['sign'];
$mid = $ThreeD[$isrealgateway]['mid'];
$posnetID = $ThreeD[$isrealgateway]['posnetid'];
$vftCode ='';
$merchantReturnURL = api_redirect('pre');
$lang = $ThreeD[$isrealgateway]['lang'];
$url = "";
$openANewWindow = 0;
$post = $ThreeD[$isrealgateway]['3Dgate'];
}
else
{
$posnetData = '0';
$posnetData2 = '';
$digest = '';
$mid = '';
$posnetID = '';
$vftCode = '';
$merchantReturnURL = '';
$lang ='';
$url = '';
$openANewWindow = '';
$post     =  api_redirect('payment',array('error'=>$result['msg'].', '.$result['msg2']));
}
echo $posnetData."\n".$posnetData2."\n".$digest."\n".$mid."\n".$posnetID."\n".$vftCode."\n".$merchantReturnURL."\n".$lang."\n".$url."\n".$openANewWindow."\n".$post;
}
else
{
echo '0'."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".''."\n".'#';
}
}
else if(isset($_POST['go']) && $_POST['go'] == 'MPI3D')
{

$rnd     = microtime();
$api     = '';

if($_POST['api'] == 'OTHER')
{
$api = basename(constant_config('webpos_cc_other_id'));
}
else
{
if (!(strpos(constant_config('webpos_cc_apis'),$_POST['api'])===false))
{
  $api = $_POST['api'];
}
else
{
  $api = '';
}
}
if (!empty($api))
{
include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
require(DIR_WEBPOS.'webpos/execution/'.basename($api).'.3D.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}
$client = new API();
$client->ReqType = $reqtype;
$client->ExtraProcessid = 0;
$client->DataArray = array(
                        "ip" => GetHostByName($_SERVER['REMOTE_ADDR']),
                        'clientid'  => $ThreeD[$isrealgateway]['clientid'],
                        'storekey'  => $ThreeD[$isrealgateway]['storekey'],
                        'gateway'  => $ThreeD[$isrealgateway]['gateway'],
                        'gatpath'  => $ThreeD[$isrealgateway]['gatpath'],
                        'gatssl'  => $ThreeD[$isrealgateway]['gatssl'],
                        'currency' => $ThreeD[$isrealgateway]['kur'],
                        'SessionInfo'  => session_name().'|'.tep_session_id(),
                        "XID" => $_POST['oid'],
                        "ccno" => $_POST['ccno'],
                        "expyear" =>$_POST['expdy'],
                        "expmonth" => $_POST['expdm'],
                        "cvv" => $_POST['cvv'],
                        "instalment" => $_POST['taksit'],
                        "amount" => $_POST['amount'],
                        "cardType" => $_POST['cardType'],
                        "custName" => utf8_urldecode($_POST['owner']));
$result = $client->HTTPPOSTTDS();

//if (!tep_session_is_registered('transferdata')) tep_session_register('transferdata');
$_SESSION['transferdata'] = array('oid' =>$_POST['oid'],'storetype'=>'mpi3d','api'=>$api);
										
//if (!tep_session_is_registered('asyatransferdata')) tep_session_register('asyatransferdata');
$_SESSION['asyatransferdata'] = array(  'cc_type'=> $_POST['cardType'],
                                        'webpos_cc_owner'=>utf8_urldecode($_POST['owner']),
                                        'SecureCode'=>utf8_urldecode($_POST['SecureCode']),
                                        'taksit' => $_POST['taksit'],
                                        'webpos_taksit'=>$_POST['wpt'],
                                        'payment'=>$_POST['py'],
                                        'oid' => $_POST['oid'],
                                        'storetype'=>'mpi3d',
                                        'api'=>$api,
                                        'webpos_cc_checkcode'=>$_POST['cvv'],
                                        'webpos_cc_number'=>$_POST['ccno'],
                                        'webpos_cc_expires_month'=>$_POST['expdm'],
                                        'webpos_cc_expires_year'=>$_POST['expdy'],
                                        'webpos_amount' => $_POST['amount']
                                        );
if($result['result'] == 1)
{
$_SESSION['asyatransferdata']['ThreeDSecure'] = true;
$PaReq = $result['PaReq'];
$ACSUrl = $result['ACSUrl'];
$TermUrl = $result['TermUrl'];
$MD = $result['MD'];
$Error ='';
$Status=1;
}
else
{
$_SESSION['asyatransferdata']['ThreeDSecure'] = false;
$PaReq = '';
$ACSUrl = api_redirect('redirect');
$TermUrl = '';
$MD = $result['result'];
$Error = rawurlencode($result['msg']);
$Status=1;
}
echo $Status."\n".$Error."\n".$PaReq."\n".$ACSUrl."\n".$TermUrl."\n".$MD;
}
else
{
echo '0'."\n".''."\n".''."\n".''."\n".''."\n".''."\n".'#';
}
}
else
{
$SecureCode = WPS();

$api = requestapi();
if($api == NULL)
{
   redirect('payment',array('error'=> "API NAME ERROR!!!"));
}

$webpos_post = WPT();

$cc_card_type = "";
$cc_card_number = "";
$cc_expiry_month = "";
$cc_expiry_year = "";


if ($SecureCode>0)
{
if ($SecureCode==1)
{
$cc_card_number = $_POST['MaskedPan'];
$cc_expiry_month = $_POST['Ecom_Payment_Card_ExpDate_Month'];
$cc_expiry_year = $_POST['Ecom_Payment_Card_ExpDate_Year'];
$mdStatus = (int)$_POST['mdStatus'];

if($mdStatus <1 || $mdStatus >4)
{
redirect('payment',array(   'error'=>est3D_error_codes($mdStatus).". Hata Kodu:1029" ,
                            'webpos_cc_owner'=>urlencode( $_POST['webpos_cc_owner'] ),
                            'webpos_cc_expires_month'=>$cc_expiry_month,
                            'webpos_cc_expires_year'=>$cc_expiry_year));
}
include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
require(DIR_WEBPOS.'webpos/execution/'.basename($api).'.3D.php');

$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}		  
		  
$hashparams = $_POST["HASHPARAMS"];
$hashparamsval = $_POST["HASHPARAMSVAL"];
$hashparam = $_POST["HASH"];

$paramsval="";
$index1=0;
$index2=0;

while($index1 < strlen($hashparams))
{
$index2 = strpos($hashparams,":",$index1);
$vl = isset($_POST[substr($hashparams,$index1,$index2- $index1)])?$_POST[substr($hashparams,$index1,$index2- $index1)]:null;
if($vl == null)
$vl = "";
$paramsval = $paramsval . $vl;
$index1 = $index2 + 1;
}
$hashval = $paramsval.$ThreeD[$isrealgateway]['storekey'];
$hash = base64_encode(pack('H*',sha1($hashval)));
if($paramsval != $hashparamsval || $hashparam != $hash)
{
redirect('payment',array(   'error'=>"Güvenlik Uyarisi. Sayisal Imza Geçerli Degil" ,
                            'webpos_cc_owner'=>urlencode( $_POST['webpos_cc_owner'] ),
                            'webpos_cc_expires_month'=>$cc_expiry_month,
                            'webpos_cc_expires_year'=>$cc_expiry_year));
}

if(!(isset($_SESSION['ccencodekey']))) redirect('payment',array('error'=>"İşlem Süresi Aşımı. Lütfen Bilgilerinizi girip tekrar deneyin."));
include( DIR_WEBPOS."cc_crypt.php" );
$crypt = new cc_crypt_mod;
$SecureCode = $crypt->Decode(base64_decode($_POST['SecureCode']),$_SESSION['ccencodekey']);
if(strpos($SecureCode,'"\'"'))
{
$SecureCodes = explode('"\'"',$SecureCode);

$taksit = '';
if ($webpos_post[0]>0)
{
$taksit = $webpos_post[0];
}
$client = new API();
$client->ReqType = $reqtype;
$client->ExtraProcessid = 0;
$client->DataArray = array("host" => $ThreeD[$isrealgateway]['gateway'],
                        "path" => $ThreeD[$isrealgateway]['gatpath'],
                        "ip" => GetHostByName($_SERVER['REMOTE_ADDR']),
                        "name" => $ThreeD[$isrealgateway]['apiname'],
                        "password" => $ThreeD[$isrealgateway]['apipass'],
                        "clientid" => $ThreeD[$isrealgateway]['clientid'],
                        "lang" => $ThreeD[$isrealgateway]['lang'],
                        "post" => $ThreeD[$isrealgateway]['3Dgate'],
                        "orderid" => $_POST['oid'],
                        "xid" => $_POST["xid"],
                        "eci" => $_POST["eci"],
                        "cavv" => $_POST["cavv"],
                        "md" => $_POST["md"],
                        "cc_instalment_order" => $taksit,
                        "currency" => '949',
                        "tutar" => number_format( $SecureCodes[0], 2, ".", "" ),
                        "cc_holdername" => $_POST['webpos_cc_owner']);

$result = $client->HTTPPOST();
if ($result['result']==1)
{
    $_SESSION['ccencodekey'] = 1;
    redirect('process',array('api'=>$api,'ottaksitapi'=>implode('x',$webpos_post),'transaction_id'=>urlencode($result['auth_code'])));
}
else
{
    redirect('payment',array('error'=>$result['msg']));
}
}else
{
redirect('payment',array('error'=>'SecureCode Hatası, Hata Kodu:4535'));
}

	
}
else if($SecureCode==2)
{
$cc_card_number = $_POST['webpos_cc_number'];
$cc_expiry_month = $_POST['webpos_cc_expires_month'];
$cc_expiry_year = $_POST['webpos_cc_expires_year'];


if(!(isset($_SESSION['ccencodekey']))) redirect('payment',array('error'=>"İşlem Süresi Aşımı. Lütfen Bilgilerinizi girip tekrar deneyin."));
include( DIR_WEBPOS."cc_crypt.php" );
$crypt = new cc_crypt_mod;
$SecureCode = $crypt->Decode(base64_decode($_POST['SecureCode']),$_SESSION['ccencodekey']);
if(strpos($SecureCode,'"\'"'))
{
$SecureCodes = explode('"\'"',$SecureCode);
require(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
require(DIR_WEBPOS.'webpos/execution/'.basename($api).'.3D.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}

$taksit = '';
if ($webpos_post[0]>0)
{
$taksit = $webpos_post[0];
}
$client = new API();
$client->ReqType = $reqtype;
$client->ExtraProcessid = 0;
$client->DataArray =  array(
                        'username'  => $ThreeD[$isrealgateway]['username'],
                        'password'  => $ThreeD[$isrealgateway]['password'],
                        'mid'       => $ThreeD[$isrealgateway]['mid'],
                        'tid'       => $ThreeD[$isrealgateway]['tid'],
                        'gateway'   => $ThreeD[$isrealgateway]['gateway'],
                        'gatpath'   => $ThreeD[$isrealgateway]['gatpath'],
                        'gatssl'    => $ThreeD[$isrealgateway]['gatssl'],
                        'wpAmount'    => '0',
                        'bankData'  => $_POST['BankPacket'],
                        'merchantData'=> $_POST['MerchantPacket'],
                        'sign'      => $_POST['Sign']
                        );

$result = $client->HTTPPOST();
tep_session_unregister('ykbtransferdata');
if($client->threeDSecureCheck($result['mdStatus'],$ThreeD[$isrealgateway]['td_mask']))
{
if ($result['result']==1)
{
    $_SESSION['ccencodekey'] = 1;
    redirect('process',array('api'=>$api,'ottaksitapi'=>implode('x',$webpos_post),'transaction_id'=>urlencode($result['authCode'])));
}
else
{
    redirect('payment',array('error'=>$result['msg']));
}
}
else
{
  redirect('payment',array('error'=>$client->ykb3D_error_codes($result['mdStatus'])));
}

}else
{
redirect('payment',array('error'=>'SecureCode Hatası, Hata Kodu:4538'));
}
//YKB3D

}
else if($SecureCode==3)
{
$cc_card_number = $_POST['webpos_cc_number'];
$cc_expiry_month = $_POST['webpos_cc_expires_month'];
$cc_expiry_year = $_POST['webpos_cc_expires_year'];
$cc_card_type = isset($_POST['cc_type'])?(($_POST['cc_type']==2)?'Master Card':(($_POST['cc_type']==1)?'Visa':'')):'';

if (!(isset($_SESSION['asyatransferdata']))) {redirect('payment',array('error'=>"İşlem Süresi Aşımı. Lütfen Bilgilerinizi girip tekrar deneyin.(Hata:1018)"));}
if(!(isset($_SESSION['ccencodekey']))) redirect('payment',array('error'=>"İşlem Süresi Aşımı. Lütfen Bilgilerinizi girip tekrar deneyin.(Hata:1019)"));
include( DIR_WEBPOS."cc_crypt.php" );
$crypt = new cc_crypt_mod;
$SecureCode = $crypt->Decode(base64_decode($_POST['SecureCode']),$_SESSION['ccencodekey']);

if(strpos($SecureCode,'"\'"')!==false)     // yeni eklenti hepsine uygula
{
$SecureCodes = explode('"\'"',$SecureCode);
require(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
require(DIR_WEBPOS.'webpos/execution/'.basename($api).'.3D.php');
$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}

$taksit = '';
if ($webpos_post[0]>0)
{
$taksit = $webpos_post[0];
}

$client = new API();
$client->ReqType = $reqtype;
$client->ExtraProcessid = 0;

$client->DataArray = array(
                        "ip" => GetHostByName($_SERVER['REMOTE_ADDR']),
                        'clientid'  => $ThreeD[$isrealgateway]['clientid'],
                        'storekey'  => $ThreeD[$isrealgateway]['storekey'],
                        'gateway'  => $ThreeD[$isrealgateway]['apigateway'],
                        'gatpath'  => $ThreeD[$isrealgateway]['apigatpath'],
                        'gatssl'  => $ThreeD[$isrealgateway]['apigatssl'],
                        'currency' => $ThreeD[$isrealgateway]['kur'],
                        "CAVV" => $_POST['CAVV'],
                        "ECI" => $_POST['ECI'],
                        "PAN" => $_POST['PAN'],
                        "XID" => $_POST['XID'],
                        "Expiry" =>$_POST['Expiry'],
                        "tutar" => $_POST['total'],
                        "cc_instalment_order" => $taksit,
                        "cc_type" => $_POST['cc_type'],
                        "SESSION" => &$_SESSION['asyatransferdata']
                        );

$result = $client->HTTPPOST();
tep_session_unregister('asyatransferdata');
if ($result['result']==1)
{
    $_SESSION['ccencodekey'] = 1;
    redirect('process',array('api'=>$api,'ottaksitapi'=>implode('x',$webpos_post),'transaction_id'=>urlencode($result['auth_code'])));
}
else
{
    redirect('payment',array('error'=>$result['msg']));
}
}else
{
redirect('payment',array('error'=>"SecureCode Hatası, Hata Kodu:4539"));
}
//MPI3D
}
else if($SecureCode==6)
{

if(!(isset($_SESSION['ccencodekey']))) redirect('payment',array('error'=>"İşlem Süresi Aşımı. Lütfen Bilgilerinizi girip tekrar deneyin."));
include( DIR_WEBPOS."cc_crypt.php" );
$crypt = new cc_crypt_mod;
$SecureCode = $crypt->Decode(base64_decode($_POST['SecureCode']),$_SESSION['ccencodekey']);
if(strpos($SecureCode,'"\'"'))
{
$SecureCodes = explode('"\'"',$SecureCode);
}else
{
redirect('payment',array('error'=>"SecureCode Hatası, Hata Kodu:4536"));
}
$PostVars = $_POST;
foreach ($_POST as $k => $v) {
     $PostVars[strtolower($k)] = $v;
}

include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');
require(DIR_WEBPOS.'webpos/execution/'.basename($api).'.3D.php');

$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}

$hashparams = $PostVars["hashparams"];
$hashparamsval = $PostVars["hashparamsval"];
$hashparam = $PostVars["hash"];
$paramsval= "";
$index1=0;
$index2=0;
while($index1 < strlen($hashparams))
{
$index2 = strpos($hashparams,":",$index1);
$vl = isset($PostVars[strtolower(substr($hashparams,$index1,$index2- $index1))])?$PostVars[strtolower(substr($hashparams,$index1,$index2- $index1))]:null;
if($vl == null) $vl = "";
$paramsval = $paramsval . $vl;
$index1 = $index2 + 1;
}
$hashval = $paramsval.$ThreeD[$isrealgateway]['storekey'];
$hash = base64_encode(pack('H*',sha1($hashval)));

if($paramsval != $hashparamsval || $hashparam != $hash) {
redirect('payment',array('error'=>"Güvenlik Uyarisi. Sayisal Imza Geçerli Degil"));
}
else
{
$IS3D = false;
$mdStatus = 0;
if(isset($PostVars['mdstatus']))
{
$mdStatus = (int)$PostVars['mdstatus'];
$IS3D = true;
}
$ErrMsg = $PostVars["errmsg"];

if($IS3D &&($mdStatus <1 || $mdStatus >4)) {
redirect('payment',array('error'=>G3D_error_codes($mdStatus).". Sistem Kodu:1029"));
} else {

$client = new API();
$client->ReqType = $reqtype;
$client->ExtraProcessid = 0;
$client->DataArray = array("host" => $ThreeD[$isrealgateway]['gateway'],
                        "path" => $ThreeD[$isrealgateway]['gatpath'],
                        "ip" => GetHostByName($_SERVER['REMOTE_ADDR']),
                        "propassword" => $ThreeD[$isrealgateway]['propassword'],
                        "tutar" => number_format( $SecureCodes[0], 2, ".", "" ),
                        "SESSION" => array(	"mode" => $_POST['mode'],
											"apiversion" => $_POST['apiversion'],
											"clientid" => $_POST['clientid'],
											"terminalprovuserid" => $_POST['terminalprovuserid'],
											"terminaluserid" => $_POST['terminaluserid'],
											"terminalmerchantid" => $_POST['terminalmerchantid'],
											"customeripaddress" => $_POST['customeripaddress'],
											"customeremailaddress" => $_POST['customeremailaddress'],
											"orderid" => $_POST['orderid'],
											"txnamount" => $_POST['txnamount'],
											"txncurrencycode" => $_POST['txncurrencycode'],
											"txntype" => $_POST['txntype'],
											"cavv" => $_POST['cavv'],
											"eci" => $_POST['eci'],
											"xid" => $_POST['xid'],
											"md" => $_POST['md'],
                                            "cc_instalment_order" => $_POST['txninstallmentcount']
											)
						);

$result = $client->HTTPPOST();
if ($result['result']==1)
{
    $_SESSION['ccencodekey'] = 1;
    redirect('process',array('api'=>$api,'ottaksitapi'=>$_POST['webpos_taksit'],'transaction_id'=>urlencode($result['auth_code'])));
}
else
{
    redirect('payment',array('error'=>$result['msg']));
}

}
}
//GARAN MODEL 3D
}
else if($SecureCode==7 || $SecureCode==8 || $SecureCode==9)
{

if(!(isset($_SESSION['ccencodekey']))) redirect('payment',array('error'=>"İşlem Süresi Aşımı. Lütfen Bilgilerinizi girip tekrar deneyin."));
include( DIR_WEBPOS."cc_crypt.php" );
$crypt = new cc_crypt_mod;
$SecureCode = $crypt->Decode(base64_decode($_POST['SecureCode']),$_SESSION['ccencodekey']);
if(strpos($SecureCode,'"\'"'))
{
$SecureCodes = explode('"\'"',$SecureCode);
}else
{
redirect('payment',array('error'=>"SecureCode Hatası, Hata Kodu:4536"));
}


$PostVars = $_POST;
foreach ($_POST as $k => $v) {
     $PostVars[strtolower($k)] = $v;
}

include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');

$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}

$hashparams = $PostVars["hashparams"];
$hashparamsval = $PostVars["hashparamsval"];
$hashparam = $PostVars["hash"];
$paramsval= "";
$index1=0;
$index2=0;
while($index1 < strlen($hashparams))
{
$index2 = strpos($hashparams,":",$index1);
$vl = isset($PostVars[strtolower(substr($hashparams,$index1,$index2- $index1))])?$PostVars[strtolower(substr($hashparams,$index1,$index2- $index1))]:null;
if($vl == null) $vl = "";
$paramsval = $paramsval . $vl;
$index1 = $index2 + 1;
}
$hashval = $paramsval.$ThreeD[$isrealgateway]['storekey'];
$hash = base64_encode(pack('H*',sha1($hashval)));

if($paramsval != $hashparamsval || $hashparam != $hash) {
redirect('payment',array('error'=>"Güvenlik Uyarisi. Sayisal Imza Geçerli Degil"));
}
else
{
$IS3D = false;
$mdStatus = 0;
if(isset($PostVars['mdstatus']))
{
$mdStatus = (int)$PostVars['mdstatus'];
$IS3D = true;
}
$ErrMsg = $PostVars["errmsg"];

if($IS3D &&($mdStatus <1 || $mdStatus >4)) {
redirect('payment',array('error'=>G3D_error_codes($mdStatus).". Sistem Kodu:1029"));
} else {
$response = $PostVars["response"];
if($response == "Approved")
{
//if (!tep_session_is_registered('ccencodekey')) tep_session_register('ccencodekey');
$_SESSION['ccencodekey'] = 1;
redirect('process',array('api'=>$api,'ottaksitapi'=>$_POST['webpos_taksit'],'transaction_id'=>'00'));

}
else
{
redirect('payment',array('error'=>"Ödeme Islemi Basarisiz. Hata = ".$ErrMsg.". Sistem Kodu:1032" ));
}
}
}

}
else if($SecureCode==10 || $SecureCode==11 || $SecureCode==12)
{
if(!(isset($_SESSION['ccencodekey']))) redirect('payment',array('error'=>"İşlem Süresi Aşımı. Lütfen Bilgilerinizi girip tekrar deneyin."));
include( DIR_WEBPOS."cc_crypt.php" );
$crypt = new cc_crypt_mod;
$SecureCode = $crypt->Decode(base64_decode($_POST['SecureCode']),$_SESSION['ccencodekey']);
if(strpos($SecureCode,'"\'"'))
{
$SecureCodes = explode('"\'"',$SecureCode);
}else
{
redirect('payment',array('error'=>"SecureCode Hatası, Hata Kodu:4536"));
}
$PostVars = $_POST;
foreach ($_POST as $k => $v) {
     $PostVars[strtolower($k)] = $v;
}

include(DIR_WEBPOS.'webpos/'.basename($api).'.3D.php');

$isrealgateway = 'TEST';
if (constant_config('webpos_mode')!=NULL)
{
if (constant_config('webpos_mode')== 'Aktif')
{
$isrealgateway = 'REAL';
}
else
{
$isrealgateway = 'TEST';
}
}

$hashparams = $PostVars["hashparams"];
$hashparamsval = $PostVars["hashparamsval"];
$hashparam = $PostVars["hash"];
$paramsval= "";
$index1=0;
$index2=0;
while($index1 < strlen($hashparams))
{
$index2 = strpos($hashparams,":",$index1);
$vl = isset($PostVars[strtolower(substr($hashparams,$index1,$index2- $index1))])?$PostVars[strtolower(substr($hashparams,$index1,$index2- $index1))]:null;
if($vl == null) $vl = "";
$paramsval = $paramsval . $vl;
$index1 = $index2 + 1;
}
$hashval = $paramsval.$ThreeD[$isrealgateway]['storekey'];
$hash = base64_encode(pack('H*',sha1($hashval)));

if($paramsval != $hashparamsval || $hashparam != $hash) {
redirect('payment',array('error'=>"Güvenlik Uyarisi. Sayisal Imza Geçerli Degil"));
}
else
{
$IS3D = false;
$mdStatus = 0;
if(isset($PostVars['mdstatus']))
{
$mdStatus = (int)$PostVars['mdstatus'];
$IS3D = true;
}
$ErrMsg = $PostVars["errmsg"];

if($IS3D &&($mdStatus <1 || $mdStatus >4)) {
redirect('payment',array('error'=>G3D_error_codes($mdStatus).". Sistem Kodu:1029"));
} else {
$response = $PostVars["response"];
if($response == "Approved")
{
//if (!tep_session_is_registered('ccencodekey')) tep_session_register('ccencodekey');
$_SESSION['ccencodekey'] = 1;
redirect('process',array('api'=>$api,'ottaksitapi'=>$_POST['webpos_taksit'],'transaction_id'=>'00'));
}
else
{
redirect('payment',array('error'=>"Ödeme Islemi Basarisiz. Hata = ".$ErrMsg.". Sistem Kodu:1032"));
}
}
}
}
}
else
{

if(!(isset($_SESSION['ccencodekey']))) redirect('payment',array('error'=>"İşlem Süresi Aşımı. Lütfen Bilgilerinizi girip tekrar deneyin.(Hata:1019)"));
include( DIR_WEBPOS."cc_crypt.php" );
$crypt = new cc_crypt_mod;
$SecureCode = $crypt->Decode(base64_decode($_POST['SecureCode']),$_SESSION['ccencodekey']);

if(strpos($SecureCode,'"\'"')!==false)     // yeni eklenti hepsine uygula
{
$SecureCodes = explode('"\'"',$SecureCode);


require(DIR_WEBPOS.'webpos/execution/'.basename($api).'.php');
require(DIR_WEBPOS.'webpos/'.basename($api).'.php');


include( DIR_WEBPOS."cc_validation.php" );
$cc_validation = new cc_validation( );

$result = $cc_validation->validate( $_POST['webpos_cc_number'], $_POST['webpos_cc_expires_month'], $_POST['webpos_cc_expires_year'] );
$error = "";
switch ( $result )
{
case -1 :
$error = sprintf( TEXT_CCVAL_ERROR_UNKNOWN_CARD, substr( $cc_validation->cc_number, 0, 4 ) );
break;
case -2 :
case -3 :
case -4 :
$error = TEXT_CCVAL_ERROR_INVALID_DATE;
break;
case false :
$error = TEXT_CCVAL_ERROR_INVALID_NUMBER;
}
if ( $result == false || $result < 1 )
{
redirect('payment',array(   'error'=> $error ,
                            'webpos_cc_owner' => urlencode( $_POST['webpos_cc_owner'] ),
                            'webpos_cc_expires_month' => $_POST['webpos_cc_expires_month'],
                            'webpos_cc_expires_year' => $_POST['webpos_cc_expires_year'],
                            'webpos_cc_checkcode' => $_POST['webpos_cc_checkcode']));


}
$webpos_taksit = $webpos_post[0].'x'.$webpos_post[1];
$taksit = '';
if ($webpos_post[0]>0)
{
$taksit = $webpos_post[0];
}
if ( 0 < $taksit )
{
if($api != 'OTHER')
{
if (strpos(constant_config(substr($api,0,5).'_taksit'),str_replace("x", ":", $webpos_taksit))===false)
{
redirect('payment',array(   'error'=>"Taksit girişinde hata var lütfen site yönetimi ile bağlantıya geçin. Hata Kodu:1023" ,
                            'webpos_cc_owner' => urlencode( $_POST['webpos_cc_owner'] ),
                            'webpos_cc_expires_month' => $_POST['webpos_cc_expires_month'],
                            'webpos_cc_expires_year' => $_POST['webpos_cc_expires_year'],
                            'webpos_cc_checkcode' => $_POST['webpos_cc_checkcode']));
}
}
else
{
redirect('payment',array(   'error'=>"Taksit girişinde hata var lütfen site yönetimi ile bağlantıya geçin. Hata Kodu:1024" ,
                            'webpos_cc_owner' => urlencode( $_POST['webpos_cc_owner'] ),
                            'webpos_cc_expires_month' => $_POST['webpos_cc_expires_month'],
                            'webpos_cc_expires_year' => $_POST['webpos_cc_expires_year'],
                            'webpos_cc_checkcode' => $_POST['webpos_cc_checkcode']));
}
}

$cc_card_type = $cc_validation->cc_type;
$cc_card_number = $cc_validation->cc_number;
$cc_expiry_month = $cc_validation->cc_expiry_month;
$cc_expiry_year = ((strlen($cc_validation->cc_expiry_year)>2)?substr($cc_validation->cc_expiry_year,2):$cc_validation->cc_expiry_year);

$client = new API();
$client->ReqType = $reqtype;
$client->ExtraProcessid = 0;
$client->DataArray = array("ip"=>$_SERVER['REMOTE_ADDR'],
                        "orderid" => $SecureCodes[3],     /* time() */
                        "cc_no"=>$cc_card_number,
                        "cc_month"=>$cc_expiry_month,
                        "cc_year"=>$cc_expiry_year,
                        "cc_ccv"=>$_POST['webpos_cc_checkcode'],
                        "tutar"=>number_format( $SecureCodes[0], 2, ".", "" ),
                        "currency"=>'949',
                        "cc_instalment_order" => $taksit,
                        "cc_holdername" => $_POST['webpos_cc_owner'],
						"customeremail" => $SecureCodes[4]);

$result = $client->HTTPPOST();

if ($result['result']==1) {
    $_SESSION['ccencodekey'] = 1;
    redirect('process',array('api'=>$api,'ottaksitapi'=>implode('x',$webpos_post),'transaction_id'=>urlencode($result['auth_code'])));
}
else
{
    redirect('payment',array('error'=>$result['msg']));
}
}else
{
    redirect('payment',array('error'=>'SecureCode Hatası, Hata Kodu:4547'));
}

}


}
my_session_close();
?>