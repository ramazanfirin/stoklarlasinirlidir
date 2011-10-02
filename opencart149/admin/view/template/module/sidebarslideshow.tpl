<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/module.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><?php echo $entry_limit; ?></td>
          <td><input type="text" name="sidebarslideshow_limit" value="<?php echo $sidebarslideshow_limit; ?>" size="1" />
	  <br />
          <?php if ($error_limit) { ?>
          <span class="error"><?php echo $error_limit; ?></span>
          <?php } ?>
	  </td>
        </tr>
        <tr>
          <td><?php echo $entry_position; ?></td>
          <td><select name="sidebarslideshow_position">
              <?php if ($sidebarslideshow_position == 'left') { ?>
              <option value="left" selected="selected"><?php echo $text_left; ?></option>
              <?php } else { ?>
              <option value="left"><?php echo $text_left; ?></option>
              <?php } ?>
              <?php if ($sidebarslideshow_position == 'right') { ?>
              <option value="right" selected="selected"><?php echo $text_right; ?></option>
              <?php } else { ?>
              <option value="right"><?php echo $text_right; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="sidebarslideshow_status">
              <?php if ($sidebarslideshow_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_time; ?></td>
          <td><input type="text" name="sidebarslideshow_time2" value="<?php echo $sidebarslideshow_time2; ?>" size="8" /> <?php echo $entry_time2; ?>
	  <br />
          <?php if ($error_time) { ?>
          <span class="error"><?php echo $error_time; ?></span>
          <?php } ?>
	  </td>	  
	  </td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="sidebarslideshow_sort_order" value="<?php echo $sidebarslideshow_sort_order; ?>" size="1" />
	  <br />
          <?php if ($error_sort) { ?>
          <span class="error"><?php echo $error_sort; ?></span>
          <?php } ?>
          </td>
        </tr>
      </tr>
         <tr>
        <td style="vertical-align: middle;"><?php echo $entry_version_status ?></td>
	<td style="vertical-align: middle;"><a href="http://www.opencart-tr.com/">Opencart-tr.com</a> </td>
      </tr>
      <tr>
        <td><?php echo $entry_author; ?></td>
        <td>Düzenleyici Adı: <a href="http://www.opencart-tr.com/member.php?action=profile&uid=671/">  mirac</a><br />
	    Web Adresi: <a href="http://www.analizburo.com/">  AnalizBuro.com</a><br />
	</td>
      </tr>

      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>