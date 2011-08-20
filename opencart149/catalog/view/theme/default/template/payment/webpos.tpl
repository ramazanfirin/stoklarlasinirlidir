<?php if($webpos_cc_numpad){?>
<script type="text/javascript" src="<?php echo HTTPS_SERVER;?>catalog/view/javascript/keypad/jquery.jqfnumkeypad.js"></script>
<link href="<?php echo HTTPS_SERVER;?>catalog/view/javascript/keypad/jqfnumkeypad.css" type="text/css" rel="stylesheet" media="screen" />
<?php }?>
<script language="Javascript">
var Payment = "webpos";
var OrderID = <?php echo $order_info['order_id'];?>;
var ApiValue = "OTHER";
var TaksitValue = "0x0x<?php echo $total;?>";
var SecureCode = "<?php echo $SecureCode;?>";
var WebposConfig = <?php echo $WebposConfigJSON;?>;
<?php foreach($TDSjs as $js)echo $js;?>
$(document).ready(function () {
<?php if($WebposConfig["isNotOOS"] && $webpos_cc_numpad){echo '$(\'#webpos_cc_number\').JQFNumKeypad({clearText: \''.$TextClear.'\',fadeSpeed: 1});';  } ?>
$('#api').change(function(){return get_webpos_taksit(this);});
$('#webpos_taksit').change(function(){return change_webpos_taksit(this);});
$('#checkout').click(function() {
var error = 0;
var error_message = "<?php echo $ErrorText;?>";
if($('#webpos_cc_owner').is("input") && $('#ccowner').is(":visible") && $('#ccowner').css('display') != "none"){
var cc_owner = $('#webpos_cc_owner').val();
var cc_number = $('#webpos_cc_number').val();
var ExpDM = $('#webpos_cc_expires_month').val();
var ExpDY = $('#webpos_cc_expires_year').val();
var cvvnumber = $('#webpos_cc_checkcode').val();
if (cc_owner == "" || cc_owner.length < 3) {
error_message = error_message + "<?php echo sprintf($ErrorTextCCOwner,3);?>";
error = 1;
}
if (cc_number == "" || cc_number.length < 15) {
error_message = error_message + "<?php echo sprintf($ErrorTextCCNumber,15);?>";
error = 1;
}
if (cvvnumber == ""|| cvvnumber.length < 3) {
error_message = error_message + "<?php echo sprintf($ErrorTextCVVNumber,3);?>";
error = 1;;
}
}

if(false){}
<?php if(isset($TDSjs["CLASSIC"])){?>
else if(WebposConfig[ApiValue]['is3D']==false&&WebposConfig[ApiValue]['isMODEL']==false&&WebposConfig[ApiValue]['isOOS']==false)
{
if (error != 1){var jserror = CLASSIC(Payment,OrderID,ApiValue,TaksitValue,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,SecureCode);if(jserror!==true){error_message = error_message + jserror +"\n";error = 1;}}if(error==1){alert(error_message);}return false;
}
<?php } ?>
<?php if(isset($TDSjs["GRN3D_OOS_PAY"])){?>
else if(WebposConfig[ApiValue]['3dID']=="GRN3D"&&WebposConfig[ApiValue]['isMODEL']==true&&WebposConfig[ApiValue]['modelID']=="3d_oos_pay")
{
if (error != 1){var jserror = GRN3D_OOS_PAY(Payment,OrderID,ApiValue,TaksitValue,SecureCode);if(jserror!==true){error_message = error_message + jserror +"\n";error = 1;}}if(error==1){alert(error_message);}return false;
}
<?php } ?>
<?php if(isset($TDSjs["EST3D_OOS_PAY"])){?>
else if(WebposConfig[ApiValue]['isEST']==true&&WebposConfig[ApiValue]['isMODEL']==true&&WebposConfig[ApiValue]['modelID']=="3d_oos_pay")
{
if (error != 1){var jserror = EST3D_OOS_PAY(Payment,OrderID,ApiValue,TaksitValue,SecureCode);if(jserror!==true){error_message = error_message + jserror +"\n";error = 1;}}if(error==1){alert(error_message);}return false;
}
<?php } ?>
<?php if(isset($TDSjs["ZRAAT_OOS"])){?>
else if(WebposConfig[ApiValue]['modelID']=="zrt_oos"&&WebposConfig[ApiValue]['isMODEL']==true&&WebposConfig[ApiValue]['isOOS']==true)
{
if (error != 1){var jserror = ZRAAT_OOS(Payment,OrderID,ApiValue,TaksitValue,SecureCode);if(jserror!==true){error_message = error_message + jserror +"\n";error = 1;}}if(error==1){alert(error_message);}return false;
}
<?php } ?>
<?php if(isset($TDSjs["EST3D_PAY"])){?>
else if(WebposConfig[ApiValue]['isEST']==true&&WebposConfig[ApiValue]['isMODEL']==true&&WebposConfig[ApiValue]['modelID']=="3d_pay")
{
if (error != 1){var jserror = EST3D_PAY(Payment,OrderID,ApiValue,TaksitValue,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,SecureCode);if(jserror!==true){error_message = error_message + jserror +"\n";error = 1;}}if(error==1){alert(error_message);}return false;
}
<?php } ?>
<?php if(isset($TDSjs["GRN3D"])){?>
else if(WebposConfig[ApiValue]['3dID']=="GRN3D"&&WebposConfig[ApiValue]['isMODEL']==true&&WebposConfig[ApiValue]['modelID']=="3d_pay")
{
if (error != 1){var jserror = GRN3D(Payment,OrderID,ApiValue,TaksitValue,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,SecureCode);if(jserror!==true){error_message = error_message + jserror +"\n";error = 1;}}if(error==1){alert(error_message);}return false;
}
<?php } ?>
<?php if(isset($TDSjs["EST3D"])){?>
else if(WebposConfig[ApiValue]['isEST']==true&&WebposConfig[ApiValue]['is3D']==true&&WebposConfig[ApiValue]['isMODEL']==false)
{
if (error != 1){var jserror = EST3D(Payment,OrderID,ApiValue,TaksitValue,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,SecureCode);if(jserror!==true){error_message = error_message + jserror +"\n";error = 1;}}if(error==1){alert(error_message);}return false;
}
<?php } ?>
<?php if(isset($TDSjs["GRN3D"])){?>
else if(WebposConfig[ApiValue]['3dID']=="GRN3D"&&WebposConfig[ApiValue]['is3D']==true&&WebposConfig[ApiValue]['isMODEL']==false)
{
if (error != 1){var jserror = GRN3D(Payment,OrderID,ApiValue,TaksitValue,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,SecureCode);if(jserror!==true){error_message = error_message + jserror +"\n";error = 1;}}if(error==1){alert(error_message);}return false;
}
<?php } ?>
<?php if(isset($TDSjs["MPI3D"])){?>
else if(WebposConfig[ApiValue]['3dID']=="MPI3D"&&WebposConfig[ApiValue]['is3D']==true&&WebposConfig[ApiValue]['isMODEL']==false)
{
if (error != 1){var jserror = MPI3D(Payment,OrderID,ApiValue,TaksitValue,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,SecureCode);if(jserror!==true){error_message = error_message + jserror +"\n";error = 1;}}if(error==1){alert(error_message);}return false;
}
<?php } ?>
<?php if(isset($TDSjs["YKB3D"])){?>
else if(WebposConfig[ApiValue]['3dID']=="YKB3D"&&WebposConfig[ApiValue]['is3D']==true&&WebposConfig[ApiValue]['isMODEL']==false)
{
if (error != 1){var jserror = YKB3D(Payment,OrderID,ApiValue,TaksitValue,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,SecureCode);if(jserror!==true){error_message = error_message + jserror +"\n";error = 1;}}if(error==1){alert(error_message);}return false;
}
<?php } ?>
return false;
});

});

function change_webpos_taksit(element){
$.ajax({
type: 'post',
url: '<?php echo $webpos_callback;?>',
dataType: 'json',
data: 'api='+$('#api').val()+'&taksit='+$(element).val(),
beforeSend: function() {
$('#foobar img.loading2').show();
disable_form();
},
success: function (data) {
OrderID = data.OrderID;
ApiValue = data.ApiValue;
TaksitValue = data.TaksitValue;
SecureCode = data.SecureCode;
$('#module_cart .middle').html(data.cart);
$('#module_cart_confirm').html(data.invoice);
},
complete: function () {
var cart  = $('#module_cart').offset();
var cart2  = $('#module_cart_confirm').offset();
$('#foobar img.loading2').hide();
enable_form();
}
});
}

function disable_form(){
$('#api').attr("disabled","disabled");
$('#webpos_taksit').attr("disabled","disabled");

//loading = false;
}
function enable_form(){
$('#api').removeAttr("disabled");
$('#webpos_taksit').removeAttr("disabled");

//loading = true;
}
function disable_webposcc(){
$('#ccowner').hide();
$('#ccnumber').hide();
$('#ccdate').hide();
$('#ccv').hide();
}
function enable_webposcc(){
$('#ccowner').show();
$('#ccnumber').show();
$('#ccdate').show();
$('#ccv').show();
}
function disable_webposIs3D(){
$('#webpos_is3D').hide();
}
function enable_webposIs3D(){
$('#webpos_is3D').show();
}

function get_webpos_taksit(element){
if(WebposConfig[$(element).val()]['isOOS']){
disable_webposcc();
$('#WebposIsOOS').show();
}else{
enable_webposcc();
$('#WebposIsOOS').hide();
}
if(WebposConfig[$(element).val()]['is3D']){
enable_webposIs3D();
}else{
disable_webposIs3D();
}
//alert($('#webpos_taksit option:selected').val());
//alert($(element).val());
//alert($(element).children("option:selected").text());
$.ajax({
type: 'post',
url: '<?php echo $webpos_callback;?>',
dataType: 'json',
data: 'api='+$(element).val()+'&taksit=0x',
beforeSend: function() {
$('#foobar img.loading1').show();
disable_form();
},
success: function (data) {
OrderID = data.OrderID;
ApiValue = data.ApiValue;
TaksitValue = data.TaksitValue;
SecureCode = data.SecureCode;
ApiProperties(data.taksit);
$('#module_cart .middle').html(data.cart);
$('#module_cart_confirm').html(data.invoice);
},
complete: function () {
var cart  = $('#module_cart').offset();
var cart2  = $('#module_cart_confirm').offset();
$('#foobar img.loading1').hide();
enable_form();
}
});
}

function ApiProperties(taksit){
//var BankApi = myApi.options[myApi.selectedIndex].value;
var select = $('#webpos_taksit');
var options = select.attr('options');
$('option', select).each(function(i, option){ $(option).remove(); });
$.each(taksit, function(key,val) {
options[options.length] = new Option(val[1], val[0]);
});
}
</script>


<?php if(!($WebposConfig["isTaksit"]==false && $WebposConfig["OTHER"]["isOOS"]==true)){ ?>
<div id="foobar"  class="content">
<table border="0" cellspacing="0" cellpadding="2" id="webpos">
<?php if($WebposConfig["isTaksit"]){ ?>
<tr id="banknames">
    <td style="width: 120px;"><span class="help"><?php echo $BankName;?></span></td>  <!--  onChange="ApiProperties(this);"  -->
    <td><select name="api" ID="api"><option value="OTHER"><?php echo $SelectText;?></option><option value="OTHER"><?php echo $OtherText;?></option><?php foreach($Apis as $api=>$apitext)if($api!='OTHER')echo '<option value="'.$api.'">'.$apitext['TEXT'].'</option>';?></select><img class="loading1" src="<?php echo HTTPS_SERVER;?>catalog/view/theme/default/image/ajax_load.gif" style="display:none"/></td>
</tr>
<tr id="intallments">
    <td><?php echo $TaksitName;?></td>
    <td><select name="webpos_taksit" id="webpos_taksit"><option value="0x0x<?php echo $total;?>"><?php echo sprintf($TekcekimText,$totalformat);?></option></select><img class="loading2" src="<?php echo HTTPS_SERVER;?>catalog/view/theme/default/image/ajax_load.gif" style="display:none"/></td>
</tr>
<?php } //isTaksit ?>
<?php if($WebposConfig["isNotOOS"]){ ?>
<tr style="display:<?php echo ($WebposConfig["OTHER"]["isOOS"])?'none':'table-row'; ?>" id="ccowner">
    <td style="width: 120px;" class="main"><?php echo $TextOwner;?></td>
    <td class="main">
        <div  ID="webpos_is3D" style="display:<?php echo ($WebposConfig["OTHER"]["is3D"])?'inline':'none'; ?>;float:right;position:absolute;margin-left:150px"><img src="<?php echo HTTPS_SERVER;?>image/guvenli_alisveris.gif" alt="<?php echo $LOGO3d;?>" title=" <?php echo $LOGO3d;?> " width="168" height="66" /></div>
        <input type="text" name="webpos_cc_owner" value="" ID="webpos_cc_owner"/></td>
</tr>
<tr style="display:<?php echo ($WebposConfig["OTHER"]["isOOS"])?'none':'table-row'; ?>" id="ccnumber">
    <td class="main"><?php echo $TextCC;?></td>
    <td class="main"><input type="text" name="webpos_cc_number" ID="webpos_cc_number" maxlength="16"/></td>
</tr>
<tr style="display:<?php echo ($WebposConfig["OTHER"]["isOOS"])?'none':'table-row'; ?>" id="ccdate">
    <td class="main"><?php echo $TextCCDate;?></td>
    <td class="main"><select name="webpos_cc_expires_month" ID="webpos_cc_expires_month"><?php for ($increment=1;$increment<13; ++$increment){echo '<option value="'.sprintf("%02d",$increment).'">'.sprintf("%02d",$increment).'</option>';}?></select>&nbsp;<select name="webpos_cc_expires_year" ID="webpos_cc_expires_year"><?php for ($today=getdate(),$increment=$today['year'];$increment<$today['year']+10;++$increment ){echo '<option value="'.strftime( "%y", mktime( 0, 0, 0, 1, 1, $increment ) ).'">'.strftime( "%Y", mktime( 0, 0, 0, 1, 1, $increment ) ).'</option>';}?></select></td>
</tr>
<tr style="display:<?php echo ($WebposConfig["OTHER"]["isOOS"])?'none':'table-row'; ?>" id="ccv">
    <td class="main"><?php echo $TextCCV;?></td>
    <td class="main"><input type="text" name="webpos_cc_checkcode" size="4" maxlength="3" ID="webpos_cc_checkcode"/>&nbsp;<small><?php echo $CCVWar;?></small></td>
</tr>
<?php } //isNotOOS ?>
<?php if($WebposConfig["isOOS"]){ ?>
<tr style="display:<?php echo ($WebposConfig["OTHER"]["isOOS"])?'table-row':'none'; ?>" id="WebposIsOOS">
    <td colspan="2"><span style="padding-top:10px;"><?php echo sprintf($OOSWar,$button_confirm); ?></span></td>
</tr>
<?php } //isOOS ?>
</table>
</div>
<?php } //is Not [isTaksit=false && OTHER->isOOS==true] ?>

<div class="buttons">
  <table>
    <tr>
      <td align="left"><a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
      <td align="right"><a id="checkout" class="button"><span><?php echo $button_confirm; ?></span></a></td>
    </tr>
  </table>
</div>
