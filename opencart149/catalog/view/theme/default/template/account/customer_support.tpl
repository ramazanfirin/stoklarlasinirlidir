<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<style type="text/css">
	.list {
		background-color: #FFFFFF;
		border-collapse: collapse;
		width: 100%;
		border-top: 1px solid #DDDDDD;
		border-left: 1px solid #DDDDDD;
		margin-bottom: 20px;
	}
	.list td {
		border-right: 1px solid #DDDDDD;
		border-bottom: 1px solid #DDDDDD;
	}
	.list thead td {
		background-color: #EFEFEF;
		padding: 0px 5px;
	}
	.list thead td a, .list thead td {
		text-decoration: none;
		color: #222222;
		font-weight: bold;
	}
	.list tbody a {
		text-decoration: underline;
	}
	
	.list tbody th {
		font-weight:bold;
		border-right: 1px solid #DDDDDD;
		border-bottom: 1px solid #DDDDDD;
	}
	
	.list tbody td {
		vertical-align: middle;
		padding: 0px 5px;
	}
	.list tbody tr:odd {
		background: #FFFFFF;
	}
	.list tbody tr:even {
		background: #E4EEF7;
	}
	.list .left {
		text-align: left;
		padding: 7px;
	}
	.list .right {
		text-align: right;
		padding: 7px;
	}
	.list .center {
		text-align: center;
		padding: 7px;
	}
	.list .asc {
		padding-right: 15px;
		background: url('../image/asc.png') right center no-repeat;
	}
	.list .desc {
		padding-right: 15px;
		background: url('../image/desc.png') right center no-repeat;
	}
	.list .filter td {
		padding: 5px;
		background: #E7EFEF;
	}
	.pagination {
		margin-top: 30px;
		border-top: 1px solid #EEEEEE;
		background: #F8F8F8;
		display: inline-block;
		width: 100%;
	}
	.pagination .links, .pagination .results {
		padding: 9px;
	}
	.pagination .links {
		float: left;
	}
	.pagination .links a {
		border: 1px solid #CCCCCC;
		padding: 4px 7px;
		text-decoration: none;
		color: #000000;
	}
	.pagination .links b {
		border: 1px solid #CCCCCC;
		padding: 4px 7px;
		text-decoration: none;
		color: #000000;
		background: #FFFFFF;
	}
	.pagination .results {
		float: right;
	}
	
	.form {
		border-collapse:collapse;
		margin-bottom:20px;
		width:100%;
	}
	
	table.form tr td:first-child {
		width:200px;
	}
	
	.form > * > * > td {
		border-bottom:1px dotted #CCCCCC;
		color:#000000;
		padding:10px;
	}
	.form > * > * > th {
		border-bottom:1px dotted #CCCCCC;
		color:#000000;
		padding:10px;
	}
	.form .left {
		text-align: left;
		padding: 7px;
	}
	.form .right {
		text-align: right;
		padding: 7px;
	}
	.form .center {
		text-align: center;
		padding: 7px;
	}
	#new-enquiry {
		background:none repeat scroll 0 0 #F8F8F8;
		border:1px solid #DDDDDD;
		margin-bottom:10px;
		padding:5px;
	}
	.attention {
		padding: 15px 0px;
		margin-bottom: 15px;
		background: #FEFBCC;
		border: 1px solid #E6DB55;
		font-size: 12px;
		text-align: center;
	}
</style>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="middle">
  		<div class="buttons" style="text-align:right;">
  			<a class="button" href="javascript:fn_open_new_enquiry();"><span><?php echo $button_enquiry; ?></span></a>
  		</div>
  		<div id="new-enquiry" style="display:none;">
			<form action="<?php echo str_replace('&', '&amp;', $new_enquiry_action); ?>" method="post" enctype="multipart/form-data" id="form">
  			<table id="new-enquiry-form" class="form">
  			<tbody>
  				<?php if(!empty($cs_1st_category)){ ?>
  				<tr>
  					<th class="left" style="width:80px;"><?php echo $column_category_1st;?></th>
					<td class="left">
						<select id="t_category_1st" name="t_category_1st">
						<?php foreach($cs_1st_category as $key => $category){ ?>
							<option value="<?php echo $category['customer_support_1st_category_id'];?>" <?php echo $key == 0? 'selected="selected"': '';?>><?php echo $category['customer_support_1st_category'];?></option>
						<?php } ?>
						</select>
					</td>
  				</tr>
				<tr>
  					<th class="left"><?php echo $column_category_2nd;?></th>
					<td class="left">
						<select id="t_category_2nd" name="t_category_2nd">
						<?php if(!empty($cs_2nd_category)){ ?>
						<?php foreach($cs_2nd_category as $key => $category){ ?>
							<option value="<?php echo $category['customer_support_2nd_category_id'];?>" <?php echo $key == 0? 'selected="selected"': '';?>><?php echo $category['customer_support_2nd_category'];?></option>
						<?php } ?>
						<?php }else{ ?>
						<option value=""><?php echo $text_none;?></option>
						<?php } ?>
						</select>
					</td>
  				</tr>
				<?php }?>
  				<tr>
  					<th class="left"><?php echo $column_subject;?></th>
					<td class="left"><input type="text" id="t_subject" name="t_subject" value="" style="width:95%;" /></td>
  				</tr>
				<tr>
					<th class="left"><?php echo $column_enquiry;?></th>
					<td class="left">
						<textarea id="t_enquiry" name="t_enquiry" style="width:95%;height:150px;"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="right">
						<a id="button_submit" class="button" href="javascript:fn_submit_new_enquiry();"><span><?php echo $button_submit;?></span></a>
					</td>
				</tr>
			</tbody>
  			</table>
			</form>
  		</div>
		<table class="list">
    	<thead>
    	<tr>
    		<td class="left" width="5%"><?php echo $column_no;?></td>
    		<td class="left"><?php echo $column_subject;?></td>
			<td class="left" width="10%"><?php echo $column_created_at;?></td>
			<td class="left" width="10%"><?php echo $column_answered;?></td>
    	</tr>
		</thead>
		<tbody>
      	<?php if ($customer_supports) { ?>
      	<?php foreach ($customer_supports as $customer_support) { ?>
      	<tr id="enquiry-<?php echo $customer_support['customer_support_id'];?>" class="<?php echo $customer_support['answer'] == ''? 'attention':'';?>">
        	<td class="center"><?php echo $customer_support['customer_support_id'];?></td>
        	<td class="left"><a href="javascript:fn_enquiry('enquiry-detail-<?php echo $customer_support['customer_support_id'];?>');"><?php echo $customer_support['subject'];?></a></td>
        	<td class="center"><?php echo $customer_support['date_added'];?></td>
        	<td class="center"><?php echo $customer_support['answer']? $text_answer_y:$text_answer_n ;?></td>
        </tr>
		<tr id="enquiry-detail-<?php echo $customer_support['customer_support_id'];?>" style="display:none;"  class="<?php echo $customer_support['answer'] == ''? 'attention':'';?>">
			<td colspan="4" class="left">
				<table id="enquiry-content-<?php echo $customer_support['customer_support_id'];?>" class="list">
				<tbody>
					<tr>
						<th class="left" width="20%"><?php echo $column_category_1st;?></th>
						<td class="left" width="29%"><?php echo $customer_support['customer_support_1st_category'];?></td>
						<th class="left" width="20%"><?php echo $column_category_2nd;?></th>
						<td class="left"><?php echo $customer_support['customer_support_2nd_category'];?></td>
					</tr>
					<tr>
						<th class="left" width="10%"><?php echo $column_enquiry;?></th>
						<td class="left" colspan="3">
							<?php echo nl2br($customer_support['enquiry']);?>
							<br />
							<span style="float:right;font-style:italic;">(<?php echo $text_enquiry_date;?> <?php echo $customer_support['date_added'];?> <?php echo nl2br($customer_support['time_added']);?>)</span>
						</td>
					</tr>
					<?php if ($customer_support['answer']) { ?>
					<tr>
						<th class="left"><?php echo $column_answer;?></th>
						<td class="left" colspan="3">
							<?php echo nl2br($customer_support['answer']);?>
							<br />
							<span style="float:right;font-style:italic;">(<?php echo $text_answer_date;?> <?php echo $customer_support['date_answer'];?> <?php echo nl2br($customer_support['time_answer']);?>)</span>
						</td>
					</tr>
					<?php } else { ?>
					<tr>
						<td class="right" colspan="4"><a id="button_delete_<?php echo $customer_support['customer_support_id'];?>" href="javascript:fn_delete_enquiry('<?php echo $customer_support['customer_support_id'];?>');" class="button"><span><?php echo $button_delete;?></span></a></td>
					</tr>
					<?php } ?>
				</tbody>
				</table>
				
			</td>
		</tr>
		
      	<?php } ?>
      	<?php } else { ?>
      	<tr>
        	<td class="center" colspan="7"><?php echo $text_no_results; ?></td>
      	</tr>
      	<?php } ?>
		</tbody>
  	  	</table>
		<div class="pagination" style="margin-top:0;"><?php echo $pagination; ?></div>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 
<script type="text/javascript">
	$("#t_category_1st").change(function(){
		$('#t_category_2nd').load('index.php?route=account/customer_support/get_2nd_category&1st_category=' + $("#t_category_1st").val());	
	});
	
	
	function fn_enquiry(row_id){
		$("#" + row_id).toggle();
	}

	function fn_open_new_enquiry(){
		$('.success, .warning').remove();
		$("#new-enquiry").toggle();
	}
	
	function fn_submit_new_enquiry(){
		$.ajax({
			type: 'POST',
			url: '<?php echo $new_enquiry_action;?>',
			dataType: 'json',
			data: 'subject=' + encodeURIComponent($('#t_subject').val()) + '&enquiry=' + encodeURIComponent($('#t_enquiry').val()) + '&customer_support_1st_category_id=' + encodeURIComponent($('#t_category_1st').val()) + '&customer_support_2nd_category_id=' + encodeURIComponent($('#t_category_2nd').val()),
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#button_submit').attr('disabled', 'disabled');
				$('#new-enquiry-form').before('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
			},
			complete: function() {
				$('#button_submit').attr('disabled', '');
				$('.wait').remove();
			},
			success: function(data) {
				if (data.error) {
					$('#new-enquiry').before('<div class="warning">' + data.error + '</div>');
				}
				
				if(data.success) {
					$('#new-enquiry').before('<div class="success">' + data.success + '</div>');
					
					$('#t_subject').val('');
					$('#t_enquiry').val('');
					alert(data.success);
					location.reload();
				}
			}
		})
	}
	
	function fn_delete_enquiry(enquiry_id){
		if(confirm("<?php echo $text_confirm_delete;?>") == false) return;
		$.ajax({
			type: 'POST',
			url: '<?php echo $delete_enquiry_action;?>',
			dataType: 'json',
			data: 'enquiry_id=' + enquiry_id,
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#button_delete_' + enquiry_id).attr('disabled', 'disabled');
				$('#enquiry-content-' + enquiry_id).before('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
			},
			complete: function() {
				$('#button_delete_' + enquiry_id).attr('disabled', '');
				$('.wait').remove();
			},
			success: function(data) {
				if (data.error) {
					$('#enquiry-content-'+enquiry_id).before('<div class="warning">' + data.error + '</div>');
				}
				
				if(data.success) {
					$('#new-enquiry').before('<div class="success">' + data.success + '</div>');
					$('#enquiry-' + enquiry_id).remove();
					$('#enquiry-detail-' + enquiry_id).remove();
				}
			}
		});
	}
	
	
</script>
