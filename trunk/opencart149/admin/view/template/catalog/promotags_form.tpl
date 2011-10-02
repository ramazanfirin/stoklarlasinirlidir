<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/shipping.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_promo_text; ?></td>
          <td><input name="promo_text" value="<?php echo $promo_text; ?>" size="30" />
            <?php if ($error_promo_text) { ?>
            <span class="error"><?php echo $error_promo_text; ?></span>
            <?php } ?> 
		<span><select name="promo_direction">
		<?php if ($promo_direction) { ?>
			<option value="0" <?php if ($promo_direction == '0') { ?> selected="selected" <?php } ?> >Default : Top-Right</option>
			<option value="1" <?php if ($promo_direction == '1') { ?> selected="selected" <?php } ?> >Top-Left</option>
			<option value="2" <?php if ($promo_direction == '2') { ?> selected="selected" <?php } ?> >Bottom-Left</option>
			<option value="3" <?php if ($promo_direction == '3') { ?> selected="selected" <?php } ?> >Bottom-Right</option>
		<?php } else { ?>
			<option value="0" selected="selected">Default : Top-Right</option>
			<option value="1">Top-Left</option>
			<option value="2">Bottom-Left</option>
			<option value="3">Bottom-Right</option>
		<?php } ?>
        </select></span></td>
	    </tr>
        <tr>
          <td><?php echo $entry_promo_link; ?></td>
          <td><input type="text" name="promo_link" value="<?php echo $promo_link; ?>" size="100" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_image; ?></td>
          <td><input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
            <img src="<?php echo $preview; ?>" alt="" id="preview" class="image" onclick="image_upload('image', 'preview');" /></td>
        </tr>
		 <tr>
          <td><?php echo $entry_pimage; ?></td>
          <td><input type="hidden" name="pimage" value="<?php echo $pimage; ?>" id="pimage" />
            <img src="<?php echo $preview1; ?>" alt="" id="preview1" class="image" onclick="image_upload('pimage', 'preview1');" /><br />
			<a onclick="RemoveImage();" class="button"><span><?php echo $button_remove; ?></span></a></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.draggable.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.resizable.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.dialog.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/external/bgiframe/jquery.bgiframe.js"></script>

<script type="text/javascript"><!--
	function RemoveImage() {
		document.getElementById('pimage').value = '';
		$('#preview1').replaceWith('<img src="../image/cache/no_image-100x100.jpg" alt="" id="preview1" class="image" onclick="image_upload(\'pimage\',\'preview1\')" />');
	}
//--></script>

<script type="text/javascript"><!--
function image_upload(field, preview) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>',
					type: 'POST',
					data: 'image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + preview).replaceWith('<img src="' + data + '" alt="" id="' + preview + '" class="image" onclick="image_upload(\'' + field + '\', \'' + preview + '\');" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>
<?php echo $footer; ?>