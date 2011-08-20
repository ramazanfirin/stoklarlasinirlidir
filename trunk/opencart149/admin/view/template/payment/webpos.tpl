<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/payment.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
	    <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="webpos_status">
              <?php if ($webpos_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
		<tr>
          <td><?php echo $entry_webpos_mode; ?></td>
          <td><?php if ($webpos_mode) { ?>
            <input type="radio" name="webpos_mode" id="real" value="1" checked="checked" />
            <label for="real"><?php echo $entry_webpos_mode_real; ?></label>
            <input type="radio" name="webpos_mode" id="test" value="0" />
            <label for="test"><?php echo $entry_webpos_mode_test; ?></label>
            <?php } else { ?>
            <input type="radio" name="webpos_mode" id="real" value="1" />
            <label for="real"><?php echo $entry_webpos_mode_real; ?></label>
            <input type="radio" name="webpos_mode" id="test" value="0" checked="checked" />
            <label for="test"><?php echo $entry_webpos_mode_test; ?></label>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_order_status; ?></td>
          <td><select name="webpos_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $webpos_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?></td>
          <td><select name="webpos_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $webpos_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
		
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="webpos_sort_order" value="<?php echo $webpos_sort_order; ?>" size="1" /></td>
        </tr>
		<tr>
          <td><?php echo $entry_webpos_cc_apis; ?></td>
          <td><input type="text" name="webpos_cc_apis" value="<?php echo $webpos_cc_apis; ?>" size="75" /></td>
        </tr>
		<tr>
          <td><?php echo $entry_webpos_cc_3dsecure_apis; ?></td>
          <td><input type="text" name="webpos_cc_3dsecure_apis" value="<?php echo $webpos_cc_3dsecure_apis; ?>" size="75" /></td>
        </tr>
		<tr>
          <td><?php echo $entry_webpos_cc_other_id; ?></td>
          <td><input type="text" name="webpos_cc_other_id" value="<?php echo $webpos_cc_other_id; ?>" size="15" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_webpos_cc_taksit; ?></td>
          <td><textarea name="webpos_cc_taksit" cols="80" rows="10"><?php echo $webpos_cc_taksit; ?></textarea></td>
        </tr>
		<tr>
          <td><?php echo $entry_webpos_taksit_tax; ?></td>
          <td><select name="webpos_taksit_tax">
              <option value="0"<?php echo ((int)$webpos_taksit_tax===0)?' selected="selected"':'';?>><?php echo $text_none; ?></option>
              <option value="1"<?php echo ((int)$webpos_taksit_tax===1)?' selected="selected"':'';?>><?php echo $entry_webpos_taksit_tax_default; ?></option>
              <?php /*foreach ($tax_classes as $tax_class) { ?>
              <?php if ($tax_class['tax_class_id'] == $webpos_taksit_tax) { ?>
              <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
              <?php } ?>
              <?php } */?>
            </select></td>
        </tr>
		<tr>
            <td><?php echo $entry_webpos_currency_convert; ?></td>
            <td><select name="webpos_currency_convert">
                <option value=""><?php echo $text_none; ?></option>
                <?php foreach ($currencies as $currency) { ?>
                <?php if ($currency['code'] == $webpos_currency_convert) { ?>
                <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
         </tr>
        <tr>
          <td><?php echo $entry_webpos_cc_numpad; ?></td>
          <td><select name="webpos_cc_numpad">
              <?php if ($webpos_cc_numpad) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
		<tr>
          <td><?php echo $entry_webpos_cc_models; ?></td>
          <td><input type="text" name="webpos_cc_models" value="<?php echo $webpos_cc_models; ?>" size="75" /></td>
        </tr>
		<tr>
          <td><?php echo $entry_webpos_cc_debug; ?></td>
          <td><select name="webpos_cc_debug">
              <?php if ($webpos_cc_debug) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>