<?php if (isset($this->request->get['route']) && ($this->request->get['route'] == 'account/account' || $this->request->get['route'] == 'account/login' || $this->request->get['route'] == 'account/logout')) { ?>
<?php } elseif ($this->customer->isLogged()) { ?>
      <div class="box">
  <div class="top"><img src="catalog/view/theme/default/image/icon_user_login.png" alt="" /><?php echo $text_welcome; ?></div>
  <div class="middle" id="information" style="text-align: left;">
	<?php echo $text_greeting; ?>
 
  <div style="text-align: center;border-bottom:1px solid #ccc;padding: 15px 0;"><a href="index.php?route=account/logout" class="button"><span><?php echo $button_logout; ?></span></a></div>
  <div id="information" style="margin-top: 10px;>
<p style="margin:0;"><b><?php echo $text_my_account; ?></b></p>
    <ul>
      <li><a href="<?php echo (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=account/edit');?>"><?php echo $text_information; ?></a></li>
      <li><a href="<?php echo (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=account/password');?>"><?php echo $text_password; ?></a></li>
      <li><a href="<?php echo (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=account/address');?>"><?php echo $text_address; ?></a></li>
    </ul>
    &nbsp;
    <p style="margin:0;"><b><?php echo $text_my_orders; ?></b></p>
    <ul>
      <li><a href="<?php echo (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=account/history');?>"><?php echo $text_history; ?></a></li>
      <li><a href="<?php echo (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=account/download');?>"><?php echo $text_download; ?></a></li>
    </ul>
    &nbsp;
    <p style="margin:0;"><b><?php echo $text_my_newsletter; ?></b></p>
    <ul>
      <li><a href="<?php echo (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=account/newsletter');?>"><?php echo $text_newsletter; ?></a></li>
    </ul>
    </div> </div>
  <div class="bottom">&nbsp;</div>
</div>

	<?php } else { ?>
	<div class="box">
  <div class="top"><img src="catalog/view/theme/default/image/icon_user_logout.png" alt="" /><?php echo $heading_title; ?></div>
  <div class="middle" id="information" style="text-align: left;">
	
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="module_login"> 
	<b><?php echo $entry_email_address; ?></b><br />
    <span style="text-align: left;"><input type="text" name="email" style="width:150px;" /></span>
    <br />
    <b><?php echo $entry_password; ?></b><br />
    <input type="password" name="password" style="width:150px;" />
        <br />
		<br />
	<div style="text-align: center;"><a onclick="$('#module_login').submit();" class="button"><span><?php echo $button_login; ?></span></a></div>
	 <ul style="margin-top:15px">
    <li><a href="<?php echo (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=account/create');?>" class=""><span><?php echo $text_create; ?></span></a></li>
	<li><a href="<?php echo (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=account/forgotten');?>" class=""><span><?php echo $text_forgotten; ?></span></a></li>
	</ul>
    </form>
    
  </div>
	
  <script type="text/javascript"><!--
  $('#module_login input').keydown(function(e) {
	  if (e.keyCode == 13) {
		  $('#module_login').submit();
	  }
  });
  //--></script>
  <div class="bottom">&nbsp;</div>
</div>	
    <?php } ?>




