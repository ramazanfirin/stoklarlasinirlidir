<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/review.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><?php echo $entry_no; ?></td>
          <td><?php echo $customer_support_id;?></td>
        </tr>
		
        <tr>
          <td><?php echo $entry_store; ?></td>
          <td>
          	<?php echo $store_name;?>
          </td>
        </tr>
		
        <tr>
          <td><?php echo $entry_1st_category; ?></td>
          <td>
          	<?php echo $customer_support_1st_category;?>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_2nd_category; ?></td>
          <td>
          	<?php echo $customer_support_2nd_category;?>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_customer; ?></td>
          <td>
          	<?php echo $lastname;?>, <?php echo $firstname;?>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_subject; ?></td>
          <td>
          	<?php echo $subject;?>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_enquiry; ?></td>
          <td>
          	<?php echo nl2br($enquiry);?>
          </td>
        </tr>
		<tr>
          <td><span class="required">*</span> <?php echo $entry_answer; ?></td>
          <td><textarea name="answer" style="width:95%;height:150px;"><?php echo $answer; ?></textarea>
            <?php if ($error_answer) { ?>
            <span class="error"><?php echo $error_answer; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>