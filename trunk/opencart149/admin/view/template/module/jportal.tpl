<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/module.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><b><?php echo $entry_jportal_title; ?></b></td>
          <td><b><?php echo $entry_jportal_status; ?></b></td>
          <td><b><?php echo $entry_jportal_position; ?></b></td>
          <td><b><?php echo $entry_jportal_sort_order; ?></b></td>
        </tr>
        <tr>
          <td><input type="text" name="jportal_title" value="<?php echo $jportal_title; ?>" size="15" /></td>
          <td><select name="jportal_status">
              <?php if ($jportal_status) { ?>
              <option value="1" selected="selected"><?php echo $entry_enabled; ?></option>
              <option value="0"><?php echo $entry_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $entry_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $entry_disabled; ?></option>
              <?php } ?>
            </select></td>
          <td><select name="jportal_position">
              <?php foreach ($positions as $position) { ?>
              <?php if ($jportal_position == $position['position']) { ?>
              <option value="<?php echo $position['position']; ?>" selected="selected"><?php echo $position['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $position['position']; ?>"><?php echo $position['title']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td><input type="text" name="jportal_sort_order" value="<?php echo $jportal_sort_order; ?>" size="1" /></td>
        </tr>
      </table>
      <table class="list">
        <tr>
          <td class="left"><?php echo $text_module; ?></td>
          <td><?php echo $entry_status; ?></td>
          <td><?php echo $entry_limit; ?></td>
          <td><?php echo $entry_sort_order; ?></td>
	    </tr>
        <tr>
          <td class="left"><?php echo $text_latest; ?></td>
          <td>
            <select name="jp_latest_status">
              <?php if ($jp_latest_status) { ?>
              <option value="1" selected="selected"><?php echo $entry_enabled; ?></option>
              <option value="0"><?php echo $entry_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $entry_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $entry_disabled; ?></option>
              <?php } ?>
            </select>
          </td>
          <td><input type="text" name="jp_latest_limit" value="<?php echo $jp_latest_limit; ?>" size="1" /></td>
          <td><input type="text" name="jp_latest_sort_order" value="<?php echo $jp_latest_sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
          <td class="left"><?php echo $text_best_sellers; ?></td>
          <td>
            <select name="jp_best_sellers_status">
              <?php if ($jp_best_sellers_status) { ?>
              <option value="1" selected="selected"><?php echo $entry_enabled; ?></option>
              <option value="0"><?php echo $entry_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $entry_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $entry_disabled; ?></option>
              <?php } ?>
            </select>            
          </td>
          <td><input type="text" name="jp_best_sellers_limit" value="<?php echo $jp_best_sellers_limit; ?>" size="1" /></td>
          <td><input type="text" name="jp_best_sellers_sort_order" value="<?php echo $jp_best_sellers_sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
          <td class="left"><?php echo $text_featured; ?></td>
          <td>
             <select name="jp_featured_status">
              <?php if ($jp_featured_status) { ?>
              <option value="1" selected="selected"><?php echo $entry_enabled; ?></option>
              <option value="0"><?php echo $entry_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $entry_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $entry_disabled; ?></option>
              <?php } ?>
            </select>
          </td>
          <td><input type="text" name="jp_featured_limit" value="<?php echo $jp_featured_limit; ?>" size="1" /></td>
          <td><input type="text" name="jp_featured_sort_order" value="<?php echo $jp_featured_sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
          <td class="left"><?php echo $text_stores; ?></td>
          <td>
             <select name="jp_stores_status">
              <?php if ($jp_stores_status) { ?>
              <option value="1" selected="selected"><?php echo $entry_enabled; ?></option>
              <option value="0"><?php echo $entry_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $entry_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $entry_disabled; ?></option>
              <?php } ?>
            </select>            
          </td>
          <td><input type="text" name="jp_stores_limit" value="<?php echo $jp_stores_limit; ?>" size="1" /></td>
          <td><input type="text" name="jp_stores_sort_order" value="<?php echo $jp_stores_sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
          <td class="left"><?php echo $text_customers; ?></td>
          <td>
             <select name="jp_customers_status">
              <?php if ($jp_customers_status) { ?>
              <option value="1" selected="selected"><?php echo $entry_enabled; ?></option>
              <option value="0"><?php echo $entry_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $entry_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $entry_disabled; ?></option>
              <?php } ?>
            </select>
          </td>
          <td><input type="text" name="jp_customers_limit" value="<?php echo $jp_customers_limit; ?>" size="1" /></td>
          <td><input type="text" name="jp_customers_sort_order" value="<?php echo $jp_customers_sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
          <td class="left"><?php echo $text_brands; ?></td>
          <td><!--input type="checkbox" name="jp_brands_status" value="<?php echo $jp_brands_status; ?>" /-->
             <select name="jp_brands_status">
              <?php if ($jp_brands_status) { ?>
              <option value="1" selected="selected"><?php echo $entry_enabled; ?></option>
              <option value="0"><?php echo $entry_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $entry_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $entry_disabled; ?></option>
              <?php } ?>
            </select>
		  </td>
          <td><input type="text" name="jp_brands_limit" value="<?php echo $jp_brands_limit; ?>" size="1" /></td>
          <td><input type="text" name="jp_brands_sort_order" value="<?php echo $jp_brands_sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>