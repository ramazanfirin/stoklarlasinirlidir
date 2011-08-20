<?php
/*
  $Id: OPENCART WEBPOS PRO V.1.0

  Webpos Pro, Open Source E-Commerce Payment Solutions

  Coded by Yavuz Yasin Düzgün (duzgun)
  Copyright (c) http://www.duzgun.com , http://www.opencart.com.tr

  Released under the GNU General Public License
*/
$MerchantID     = '';
$PAN            = '';
$Expiry         = '';
$PurchAmount    = '';
$PurchCurrency  = '';
$XID            = '';
$Status         = '';
$PAResVerified  = '';
$PAResSyntaxOK  = '';
$ARV            = '';
$CAVV           = '';
$ECI            = '';

$session_name = '';
$session_id = '';
if(isset($_POST["SessionInfo"])){
$SessionInfo    = $_POST["SessionInfo"];
if(strpos($SessionInfo,'|')!==false)
{
list($session_name,$session_id) = explode('|',$SessionInfo);
session_id($session_id); //session_regenerate_id(false);session_write_close();
}
$MerchantID     = $_POST["MerchantID"];
$PAN            = $_POST["PAN"];
$Expiry         = $_POST["Expiry"];
$PurchAmount    = $_POST["PurchAmount"];
$PurchCurrency  = $_POST["PurchCurrency"];
$XID            = $_POST["XID"];
$Status         = $_POST["Status"];
$PAResVerified  = $_POST["PAResVerified"];
$PAResSyntaxOK  = $_POST["PAResSyntaxOK"];
$ARV            = $_POST["ARV"];
$CAVV           = $_POST["CAVV"];
$ECI            = $_POST["ECI"];
}

require_once('api_config.php');

if (!isset($_SESSION['asyatransferdata'])) {
  redirect('payment',array('error'=>"Session Hatasi"));
}
$requestform = &$_SESSION['asyatransferdata'];
if(isset($requestform['payment']) && isset($requestform['webpos_taksit']) && isset($requestform['api']))
{
if($XID ==''){
$XID = (strlen($requestform['oid'])>20)? substr(str_replace('.','0',$requestform['oid']),0,20):substr('00000000000000000000',0,(20-strlen($requestform['oid']))).str_replace('.','0',$requestform['oid']);
}
if($requestform['ThreeDSecure'] == true)    // !isset($_POST['MD'])
{
if($Status == 'N'){
redirect('payment',array('error'=>'3D Şifresini yanlış girdiniz. Lütfen bankanız ile iletişime geçiniz.'));
}
else
{
if($requestform['cc_type']==1)
{
if($Status == 'Y')
{
$ECI = '5';
}
else if($Status == 'A')
{
$ECI = '6';
}
else if($Status == 'U')
{
$ECI = '7';
}
}
else if ($requestform['cc_type']==2)
{
if($Status == 'Y')
{
$ECI = '02';
}
else if($Status == 'A')
{
$ECI = '01';
}
else if($Status == 'U')
{
$ECI = '01';
}
}
?>
<html>
<style type="text/css">
BODY {
	FONT-SIZE: 11px; BACKGROUND-REPEAT: repeat-y; FONT-FAMILY: Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #ffffff
}
INPUT {
	FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
TD {
	FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif
}

</style>
<head>
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="cache-control" CONTENT="no-cache">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=windows-1254">
<script language="JavaScript">
//<!--
function submitForm(form, url) {
    var agt=navigator.userAgent.toLowerCase();
    var is_firefox  = (agt.indexOf('firefox')!=-1)
    var is_opera  = (agt.indexOf('opera')!=-1)
		form.target = '_self';
	   	form.submit();
}
//-->
</script>
<title>
BANKASYA - IPAY
</title>
</head>
<body bgcolor="#FFFFFF" OnLoad="submitForm(document.formMPI, '<?php
echo api_redirect('api');
?>');">
<BR>
<form action="<?php echo api_redirect('api');?>" method="post" name="formMPI">
<?php
echo  "<input type=\"hidden\" name=\"MerchantID\" value=\"".$MerchantID."\">\r\n";
echo  "<input type=\"hidden\" name=\"PAN\" value=\"".$PAN."\">\r\n";
echo  "<input type=\"hidden\" name=\"Expiry\" value=\"".$Expiry."\">\r\n";
echo  "<input type=\"hidden\" name=\"PurchAmount\" value=\"".$PurchAmount."\">\r\n";
echo  "<input type=\"hidden\" name=\"PurchCurrency\" value=\"".$PurchCurrency."\">\r\n";
echo  "<input type=\"hidden\" name=\"XID\" value=\"".$XID."\">\r\n";
echo  "<input type=\"hidden\" name=\"Status\" value=\"".$Status."\">\r\n";
echo  "<input type=\"hidden\" name=\"PAResVerified\" value=\"".$PAResVerified."\">\r\n";
echo  "<input type=\"hidden\" name=\"PAResSyntaxOK\" value=\"".$PAResSyntaxOK."\">\r\n";
echo  "<input type=\"hidden\" name=\"ARV\" value=\"".$ARV."\">\r\n";
echo  "<input type=\"hidden\" name=\"CAVV\" value=\"".$CAVV."\">\r\n";
echo  "<input type=\"hidden\" name=\"ECI\" value=\"".$ECI."\">\r\n";
foreach ($requestform as $key => $value) {
if($key == 'webpos_cc_number')
{
$ccno = substr( $value, 0, 4 ).str_repeat( "*", strlen( $value ) - 8 ).substr( $value, -4 );
echo  "<input type=\"hidden\" name=\"".$key."\" value=\"".$ccno."\">\r\n";
}
else if($key == 'webpos_cc_checkcode')
{
$cvv = '**'.substr( $value,-1 );
echo  "<input type=\"hidden\" name=\"".$key."\" value=\"".$cvv."\">\r\n";
}
else
{
echo  "<input type=\"hidden\" name=\"".$key."\" value=\"".$value."\">\r\n";
}
}
?>
<input type="hidden" name="payment" value="webpos">
<TABLE WIDTH="100%" HEIGHT="70%" border="0" CELLPADDING="0" CELLSPACING="0">
	<TR>
		<TD><!-- To support javascript unaware/disabled browsers --> <noscript>
		<BR>
		<BR>
		<CENTER>
		<H1>Processing your 3-D Secure Transaction</H1>
		<H2>JavaScript is currently disabled or is not supperted by your
		browser.</H2>
		<BR>
		<H3>Please click on the Submit button to continue the processing of
		your 3-D secure transaction.</H3>
		<P><input type="submit" name="submit" value="Lütfen Tıklayınız !"></P>
		<P>&nbsp;</P>
		</CENTER>
		</noscript>
		<CENTER><FONT SIZE="4">İşleminiz yapılıyor...</FONT></CENTER>
		</TD>
	</TR>
</TABLE>
</form>
</body>
</html>
<?php
}
/*else
{
redirect('payment',array('error'=>'3D İşlemi Başarısız.'));
} */
}
else
{
$ECI ='';
$Status = $_POST["MD"];
if($requestform['cc_type']==1)
{
if($Status == 'E')
{
$ECI = '7';
}
else if($Status == 'U')
{
$ECI = '7';
}
else if($Status == 'N')
{
$ECI = '6';
}
}
else if ($requestform['cc_type']==2)
{
if($Status == 'E')
{
$ECI = '01';
}
else if($Status == 'U')
{
$ECI = '01';
}
else if($Status == 'N')
{
$ECI = '01';
}
}
?>
<html>
<style type="text/css">
BODY {
	FONT-SIZE: 11px; BACKGROUND-REPEAT: repeat-y; FONT-FAMILY: Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #ffffff
}
INPUT {
	FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif
}
TD {
	FONT-SIZE: 11px; FONT-FAMILY: Arial, Helvetica, sans-serif
}

</style>
<head>
<META HTTP-EQUIV="expires" CONTENT="0">
<META HTTP-EQUIV="cache-control" CONTENT="no-cache">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=windows-1254">
<script language="JavaScript">
//<!--
function submitForm(form, url) {
    var agt=navigator.userAgent.toLowerCase();
    var is_firefox  = (agt.indexOf('firefox')!=-1)
    var is_opera  = (agt.indexOf('opera')!=-1)
		form.target = '_self';
	   	form.submit();
}
//-->
</script>
<title>
BANKASYA - IPAY
</title>
</head>
<body bgcolor="#FFFFFF" OnLoad="submitForm(document.formMPI, '<?php
echo api_redirect('api');
?>');">
<BR>
<form action="<?php echo api_redirect('api');?>" method="post" name="formMPI">
<?php
echo  "<input type=\"hidden\" name=\"MerchantID\" value=\"\">\r\n";
echo  "<input type=\"hidden\" name=\"PAN\" value=\"\">\r\n";
echo  "<input type=\"hidden\" name=\"Expiry\" value=\"\">\r\n";
echo  "<input type=\"hidden\" name=\"PurchAmount\" value=\"\">\r\n";
echo  "<input type=\"hidden\" name=\"PurchCurrency\" value=\"\">\r\n";
echo  "<input type=\"hidden\" name=\"XID\" value=\"".$XID."\">\r\n";
echo  "<input type=\"hidden\" name=\"Status\" value=\"\">\r\n";
echo  "<input type=\"hidden\" name=\"PAResVerified\" value=\"\">\r\n";
echo  "<input type=\"hidden\" name=\"PAResSyntaxOK\" value=\"\">\r\n";
echo  "<input type=\"hidden\" name=\"ARV\" value=\"\">\r\n";
echo  "<input type=\"hidden\" name=\"CAVV\" value=\"\">\r\n";
echo  "<input type=\"hidden\" name=\"ECI\" value=\"".$ECI."\">\r\n";
foreach ($requestform as $key => $value) {
if($key == 'webpos_cc_number')
{
$ccno = substr( $value, 0, 4 ).str_repeat( "*", strlen( $value ) - 8 ).substr( $value, -4 );
echo  "<input type=\"hidden\" name=\"".$key."\" value=\"".$ccno."\">\r\n";
}
else if($key == 'webpos_cc_checkcode')
{
$cvv = '**'.substr( $value,-1 );
echo  "<input type=\"hidden\" name=\"".$key."\" value=\"".$cvv."\">\r\n";
}
else
{
echo  "<input type=\"hidden\" name=\"".$key."\" value=\"".$value."\">\r\n";
}
}
?>
<input type="hidden" name="payment" value="webpos">
<TABLE WIDTH="100%" HEIGHT="70%" border="0" CELLPADDING="0" CELLSPACING="0">
	<TR>
		<TD><!-- To support javascript unaware/disabled browsers --> <noscript>
		<BR>
		<BR>
		<CENTER>
		<H1>Processing your 3-D Secure Transaction</H1>
		<H2>JavaScript is currently disabled or is not supperted by your
		browser.</H2>
		<BR>
		<H3>Please click on the Submit button to continue the processing of
		your 3-D secure transaction.</H3>
		<P><input type="submit" name="submit" value="Lütfen Tıklayınız !"></P>
		<P>&nbsp;</P>
		</CENTER>
		</noscript>
		<CENTER><FONT SIZE="4">İşleminiz yapılıyor...</FONT></CENTER>
		</TD>
	</TR>
</TABLE>
</form>
</body>
</html>
<?php
}
}
my_session_close();
?>