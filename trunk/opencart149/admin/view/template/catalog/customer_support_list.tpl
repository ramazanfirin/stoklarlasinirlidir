<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/review.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons">
    	<a href="<?php echo $manage_category;?>" class="button"><span><?php echo $button_manage_category;?></span></a>
    	<a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a>
	</div>
  </div>
  <div class="content">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left" width="3%">
            	<?php echo $column_no; ?></a>
            </td>
			<td class="left" width="10%">
            	<?php echo $column_1st_category; ?></a>
            </td>
			<td class="left" width="10%">
            	<?php echo $column_2nd_category; ?></a>
            </td>
			<td class="left" width="15%">
            	<?php echo $column_customer; ?></a>
            </td>
			<td class="left">
            	<?php echo $column_subject; ?></a>
            </td>
			<td class="left" width="8%">
            	<?php echo $column_date_added; ?></a>
            </td>
			<td class="left" width="8%">
            	<?php echo $column_date_answer; ?></a>
            </td>
            <td class="right" width="10%"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($customer_supports) { ?>
          <?php foreach ($customer_supports as $customer_support) { ?>
          <tr class="<?php echo $customer_support['answer'] == ''? 'attention':'';?>">
            <td style="text-align: center;"><?php if ($customer_support['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $customer_support['customer_support_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $customer_support['customer_support_id']; ?>" />
              <?php } ?>
			 </td>
			<td class="left"><?php echo $customer_support['customer_support_id']; ?></td>
			<td class="left"><?php echo $customer_support['customer_support_1st_category']; ?></td>
			<td class="left"><?php echo $customer_support['customer_support_2nd_category']; ?></td>
            <td class="left"><?php echo $customer_support['lastname']; ?>, <?php echo $customer_support['firstname']; ?></td>
            <td class="left"><?php echo $customer_support['subject']; ?></td>
            <td class="left"><?php echo $customer_support['date_added']; ?></td>
            <td class="left"><?php echo $customer_support['answer'] == '' ? $text_not_answered:$customer_support['date_answer']; ?></td>
            <td class="right"><?php foreach ($customer_support['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
<?php echo $footer; ?>