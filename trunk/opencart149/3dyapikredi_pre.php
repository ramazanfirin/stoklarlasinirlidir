<?php
/*
  $Id: OPENCART WEBPOS PRO V.1.0

  Webpos Pro, Open Source E-Commerce Payment Solutions

  Coded by Yavuz Yasin Düzgün (duzgun)
  Copyright (c) http://www.duzgun.com , http://www.opencart.com.tr

  Released under the GNU General Public License
*/
  require_once('api_config.php');

  if (!isset($_SESSION['ykbtransferdata'])) {
    redirect('payment',array('error'=>"Session Hatasi"));
  }
  $requestform = &$_SESSION['ykbtransferdata'];
  if(isset($requestform['payment']) && isset($requestform['webpos_taksit']) && isset($requestform['api']))
  {
    $api     = '';

    if($requestform['api'] == 'OTHER')
    {
    $api = basename(constant_config('webpos_cc_other_id'));
    }
    else
    {
    if (!(strpos(constant_config('webpos_cc_apis'),$requestform['api'])===false))
    {
      $api = $requestform['api'];
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
    if (constant_config('webpos_mode') == 'Aktif')
    {
    $isrealgateway = 'REAL';
    }
    else
    {
    $isrealgateway = 'TEST';
    }
    }
        $client = new API();
        $client->ReqType = 'Auth';
        $client->ExtraProcessid = 0;
        $client->DataArray =  array(
                                    'username'  => $ThreeD[$isrealgateway]['username'],
                                    'password'  => $ThreeD[$isrealgateway]['password'],
                                    'mid'       => $ThreeD[$isrealgateway]['mid'],
                                    'tid'       => $ThreeD[$isrealgateway]['tid'],
                                    'gateway'   => $ThreeD[$isrealgateway]['gateway'],
                                    'gatpath'   => $ThreeD[$isrealgateway]['gatpath'],
                                    'gatssl'    => $ThreeD[$isrealgateway]['gatssl'],
                                    'enckey'    => $ThreeD[$isrealgateway]['enckey'],
                                    'bankData'  => $_POST['BankPacket'],
                                    'merchantData'=> $_POST['MerchantPacket'],
                                    'sign'      => $_POST['Sign']
                                    );
        $result = $client->CheckSign();
        if($result['result'] == 1)
        {
           $result2 = $client->HTTPPOSTMCRYPT();
           if($client->threeDSecureCheck($result2['mdStatus'],$ThreeD[$isrealgateway]['td_mask']))
           {
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
YKB - POSNET
</title>
</head>
<body bgcolor="#FFFFFF" OnLoad="submitForm(document.formYKB, '<?php
echo api_redirect('api');
?>');">
<BR>
<form action="<?php echo api_redirect('api');?>" method="post" name="formYKB">
<?php
echo  "<input type=\"hidden\" name=\"BankPacket\" value=\"".$_POST['BankPacket']."\">\r\n";
echo  "<input type=\"hidden\" name=\"MerchantPacket\" value=\"".$_POST['MerchantPacket']."\">\r\n";
echo  "<input type=\"hidden\" name=\"Sign\" value=\"".$_POST['Sign']."\">\r\n";
echo  "<input type=\"hidden\" name=\"xid\" value=\"".$result2['xid']."\">\r\n";
echo  "<input type=\"hidden\" name=\"amount\" value=\"".$result2['amount']."\">\r\n";
echo  "<input type=\"hidden\" name=\"installment\" value=\"".$result2['installment']."\">\r\n";
foreach ($requestform as $key => $value) {
echo  "<input type=\"hidden\" name=\"".$key."\" value=\"".$value."\">\r\n";
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
           else
           {
             redirect('payment',array('error'=>$client->ykb3D_error_codes($result2['mdStatus'])));
           }
        }
        else
        {
          redirect('payment',array('error'=>$result['sign']));
        }


    }
    else
    {
    //error
    exit;
    }
  }
?>

<?php
my_session_close();
?>