<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
    <?php if (isset($thanks)) { ?>
    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 5px 8px 10px 8px; margin-bottom: 10px;">
      <div style="text-align: center;"><img src="catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/image/smile.png" width="48" height="48"></div>
      <div style="margin-top: 10px; text-align: center;"><?php echo $text_thanks; ?></div>
    </div>
    <div class="buttons">
      <table>
        <tr>
          <td align="right"><a onclick="location = '<?php echo str_replace('&', '&amp;', $continue); ?>'" class="button"><span><?php echo $button_continue; ?></span></a></td>
        </tr>
      </table>
    </div>
    <?php } else { ?>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 5px 8px 10px 8px; margin-bottom: 10px;">
      <div style="text-align: center; margin-top: 10px; margin-bottom: 20px;"><img src="catalog/view/theme/<?php echo $this->config->get('config_template'); ?>/image/tell.png" align="absmiddle" width="32" height="32" alt="" />&nbsp;<b style="font-size: larger;"><?php echo $text_tell_friends; ?></b></div>
      <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="friends">
        <div style="text-align: left; width: 450px; margin-left: auto; margin-right: auto;">
          <table width="100%" cellpadding="10" cellspacing="0">
            <tr>
              <td class="left" width="30%"><span class="required">*</span> <?php echo $entry_name; ?></td>
              <td class="left"><input type="text" size="30" name="name" maxlength="45" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td class="left"><span class="required">*</span> <?php echo $entry_email; ?></td>
              <td class="left"><input type="text" size="30" name="email" maxlength="45" />
                <?php if ($error_email) { ?>
                <span class="error"><?php echo $error_email; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          <table width="100%" cellpadding="10" cellspacing="0" id="my_friends">
            <tr>
              <th colspan="2" style="text-align: center;"><?php echo $text_enter_friend; ?></th>
            </tr>
            <tr>
              <td class="left" width="30%"><span class="required">*</span> <?php echo $entry_friend; ?></td>
              <td class="left"><input type="text" name="friend" value="<?php echo $friend; ?>" size="30" maxlength="45" />
                <?php if ($error_friend) { ?>
                <span class="error"><?php echo $error_friend; ?></span>
                <?php } ?></td>
            </tr>
            <?php if ($friends) { ?>
            <?php foreach ($friends as $result) { ?>
            <tr>
              <td style="vertical-align: top;"><?php echo $entry_friend; ?></td>
              <td style="vertical-align: top;"><input type="text" name="friends[]" value="<?php echo $result; ?>" size="30" maxlength="45" /></td>
            </tr>
            <?php } ?>
            <?php } ?>
          </table>
          <table width="100%" cellpadding="10" cellspacing="0">
            <tr>
              <td></td>
              <td class="right"><a onclick="addFriend();" class="button"><span><?php echo $button_add_friend; ?></span></a><a onclick="removeFriend();" class="button"><span><?php echo $button_remove; ?></span></a></td>
            </tr>
            <tr>
              <td colspan="2" class="center">
                <p><?php echo $text_message; ?></p>
                <p><a onclick="$('#friends').submit();" class="button"><span><?php echo $text_click; ?></span></a></p>
                <p><?php echo $text_addresses; ?></p>
              </td>
            </tr>
          </table>
        </div>
      </form>
    </div>
    <?php } ?>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<script type="text/javascript"><!--
function addFriend() {
	var tbl = document.getElementById('my_friends');
	var iteration = tbl.tBodies[0].rows.length;
	newRow = tbl.tBodies[0].insertRow(-1);
	var newCell = newRow.insertCell(0);
	newCell.innerHTML = '<?php echo $entry_friend; ?>';
	var newCell1 = newRow.insertCell(1);
	var el = document.createElement('input');
	el.type = 'text';
	el.name = 'friends[]';
	el.size = 30;
	el.maxlength = 45;
	newCell1.appendChild(el);
}

function removeFriend() {
	var tbl = document.getElementById('my_friends');
	var lastRow = tbl.rows.length;
	if (lastRow > 2) tbl.deleteRow(lastRow - 1);
}
//--></script>
<?php echo $footer; ?>
