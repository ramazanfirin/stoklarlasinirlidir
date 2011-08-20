<?php
/*
  $Id: OPENCART WEBPOS PRO V.1.0

  Webpos Pro, Open Source E-Commerce Payment Solutions

  Coded by Yavuz Yasin Düzgün (duzgun)
  Copyright (c) http://www.duzgun.com , http://www.opencart.com.tr

  Released under the GNU General Public License
*/
require_once('config.php');
define('DIR_WEBPOS', DIR_SYSTEM.'/helper/');
require_once(DIR_SYSTEM . 'library/config.php');
require_once(DIR_SYSTEM . 'library/db.php');
require_once(DIR_SYSTEM . 'library/session.php');
$config = new Config();
$session = new Session();
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting Where `group`='webpos' OR `group`='taksit'");
foreach ($query->rows as $setting) {
	$config->set($setting['key'], $setting['value']);
}
if ($config->get('config_ssl')) {
define('HTTPS_SERVER', 'https://' . substr($config->get('config_url'), 7));
} else {
define('HTTPS_SERVER', $config->get('config_url'));
}
TaksitParse();

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Son kullanma tarihi Hatali. Lütfen Son kullanma tarihini kontrol ederek tekrar deneyin.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Kullandiginiz Kredi Karti numarasi Hatali. Lütfen kontrol ederek tekrar deneyin.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Kullandiginiz kredi kartiniz ile ilgili sorunlar var. Eger dogru yazdiysaniz, kartiniz Internet kullanimina kapali veya magazamizda geçersiz kredi karti olabilir.<br>Lütfen tekrar deneyin.');

function redirect($request,$data=array()) {
if($request=='payment')
{
$_SESSION['error'] = $data['error'];
if (isset($_SESSION['account']) && ($_SESSION['account'] == 'guest'))
header('Location: ' .HTTPS_SERVER. 'index.php?route=checkout/guest_step_2');
else
header('Location: ' .HTTPS_SERVER. 'index.php?route=checkout/payment');
}
else if ($request=='process')
{
$sonuc = "";
foreach($data as $key=>$value)
$sonuc .= $key ." = ". $value. "<br>";
header('Location: ' .HTTPS_SERVER. 'index.php?route=payment/webpos/confirm&sonuc='.urlencode($sonuc));
}
else if ($request=='redirect')
{
header('Location: ' .HTTPS_SERVER. '3dbankasya_redirect.php');
}
else if ($request=='pre')
{
header('Location: ' .HTTPS_SERVER. '3dyapikredi_pre.php');
}
else if ($request=='api')
{
header('Location: ' .HTTPS_SERVER. 'api.php');
}
my_session_close();
}

function api_redirect($request,$data=array())
{
if($request=='payment')
{
if (isset($_SESSION['account']) && ($_SESSION['account'] == 'guest'))
return HTTPS_SERVER.'index.php?route=checkout/guest_step_2';
else
return HTTPS_SERVER.'index.php?route=checkout/payment';
}
else if ($request=='process')
{
return HTTPS_SERVER.'index.php?route=payment/webpos/confirm';
}
else if ($request=='redirect')
{
return HTTPS_SERVER.'3dbankasya_redirect.php';
}
else if ($request=='pre')
{
return HTTPS_SERVER.'3dyapikredi_pre.php';
}
else if ($request=='api')
{
return HTTPS_SERVER.'api.php';
}
}

function constant_config($request)
{
global $config;
return $config->get($request);
}


function TaksitParse()
{
global $config;
$taksit = array();
if(strpos($config->get('webpos_cc_taksit'), "\n") > 0)
{
$taksit_text = explode( "\n", $config->get('webpos_cc_taksit'));
foreach($taksit_text as  $text)
{
if(strpos($text, "=") > 0)
{
list($taksitkey, $taksitvalue) = explode( '=', $text);
if(!empty($taksitkey))$taksit[basename(trim($taksitkey))]=trim($taksitvalue);
}
}
}
else
{
if(strpos($config->get('webpos_cc_taksit'), "=") > 0)
{
list($taksitkey, $taksitvalue) = explode( '=', $config->get('webpos_cc_taksit'));
if(!empty($taksitkey))$taksit[basename(trim($taksitkey))]=trim($taksitvalue);
}
}
foreach($taksit as  $key=>$val)$config->set($key.'_taksit',$val);
}

function my_session_close(){
if (PHP_VERSION >= '4.0.4') {
session_write_close();
} elseif (function_exists('session_close')) {
session_close();
}
exit;
}
?>