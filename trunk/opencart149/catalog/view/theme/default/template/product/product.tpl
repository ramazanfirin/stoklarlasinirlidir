
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.4.1.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.lwtCountdown-1.0.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/misc.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/main.css" />

<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.jqzoom-core.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/jquery.jqzoom.css" />
 
       
       
		

<script language="javascript" type="text/javascript">
			jQuery(document).ready(function() {
				$('#countdown_dashboard').countDown({
					targetDate: {
						'day': 		<?php echo date("d", strtotime($special_date_end)); ?> ,
						'month': 	 <?php echo date("m", strtotime($special_date_end)); ?>,
						'year': 	 <?php echo date("Y", strtotime($special_date_end)); ?>  ,
						'hour': 	'0',
						'min': 		'0',
						'sec': 		'0'
					}
				});
				
				
				
			});
		</script>
		
	<script type="text/javascript">

	jQuery(document).ready(function() {
	$('.jqzoom').jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false
        });
	
});


</script>	
		
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
    <div style="width: 100%; margin-bottom: 30px;">
      <table style="width: 100%; border-collapse: collapse;">
        <!-- code start -->
		 <div class="banner">
		 <?php echo $promo_tags_on_product_top_right; ?>
		 <?php echo $promo_tags_on_product_top_left; ?>
		 <?php echo $promo_tags_on_product_bottom_left; ?>
		 <?php echo $promo_tags_on_product_bottom_right; ?>
		 
		 <!-- 
		 <span style="width:70px;height:70px;top:2px;left:188px;background: url('image/data/tags/specialprice.png') no-repeat" class="promotags"></span>		 		 
		 <span style="width:70px;height:70px;top:190px;left:0px;background: url('image/data/tags/indirimpatlangac.gif') no-repeat" class="promotags"></span>		 
		   -->
		
		 <!-- code end -->
        
        <tr>
          <td style="text-align: center; width: 250px; vertical-align: top;">
          <a href="<?php echo $popup; ?>"  title="<?php echo $heading_title; ?>" class="jqzoom thickbox" rel="gallery">
          <img src="<?php echo $thumb; ?>"  title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" 
              style="margin-bottom: 3px;border :1px solid #CCCCCC;background:none repeat scroll 0 0 #F3F3F3;padding:3px" /></a>
          <!-- code start --></div><!-- code end --><br />
            <span style="font-size: 11px;"><?php echo $text_enlarge; ?></span></td>
          <td style="padding-left: 15px; width: 296px; vertical-align: top;"><table width="100%">
              <?php if ($display_price) { ?>
              <tr>
                <td><b><?php echo $text_price; ?></b></td>
                <td><?php if (!$special) { ?>
                  <?php echo $price; ?>
                  <?php } else { ?>
                  <span style="text-decoration: line-through;"><?php echo $price; ?></span> <span style="color: #F00;"><?php echo $special; ?></span>
                  <?php } ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><b><?php echo $text_availability; ?></b></td>
                <td><?php echo $stock; ?></td>
              </tr>
              <tr>
                <td><b><?php echo $text_model; ?></b></td>
                <td><?php echo $model; ?></td>
              </tr>
              <?php if ($manufacturer) { ?>
              <tr>
                <td><b><?php echo $text_manufacturer; ?></b></td>
                <td><a href="<?php echo str_replace('&', '&amp;', $manufacturers); ?>"><?php echo $manufacturer; ?></a></td>
              </tr>
              <?php } ?>
              <?php if ($review_status) { ?>
			  <tr>
                <td><b><?php echo $text_average; ?></b></td>
                <td><?php if ($average) { ?>
                  <img src="catalog/view/theme/default/image/stars_<?php echo $average . '.png'; ?>" alt="<?php echo $text_stars; ?>" style="margin-top: 2px;" />
                  <?php } else { ?>
                  <?php echo $text_no_rating; ?>
                  <?php } ?></td>
              </tr>
			  <?php } ?>
            
            <!-- code start --><?php echo $promo_tags; ?>
			  <tr><td colspan="2">
				  <div class="addthis_toolbox addthis_default_style">
				  <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4cb894fd274c4f84" class="addthis_button_compact">Share</a>
				  <span class="addthis_separator">|</span>
				  <a class="addthis_button_preferred_1"></a>
				  <a class="addthis_button_preferred_2"></a>
				  <a class="addthis_button_preferred_3"></a>
				  <a class="addthis_button_preferred_4"></a>
				  </div><br/>
				<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4cb894fd274c4f84"></script>
			  </td></tr>
			  <tr><td colspan="2">
			  <div><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id='.$this->request->get['product_id']); ?>&amp;layout=standard&amp;show_faces=false&amp;width=280&amp;action=like&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:270px; height:35px;" allowTransparency="true"></iframe>
			  </div></td></tr><!-- code end -->
            
            </table>
            
            <br />
            <?php if ($display_price) { ?>
            <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="product">
              <?php if ($options) { ?>
              <b><?php echo $text_options; ?></b><br />
              <div style="background: #FFFFCC; border: 1px solid #FFCC33; padding: 10px; margin-top: 2px; margin-bottom: 15px;">
                <table style="width: 100%;">
                  <?php foreach ($options as $option) { ?>
                  <tr>
                    <td><?php echo $option['name']; ?>:<br />
                      <select name="option[<?php echo $option['option_id']; ?>]">
                        <?php foreach ($option['option_value'] as $option_value) { ?>
                        <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?>
                        <?php if ($option_value['price']) { ?>
                        <?php echo $option_value['prefix']; ?><?php echo $option_value['price']; ?>
                        <?php } ?>
                        </option>
                        <?php } ?>
                      </select></td>
                  </tr>
                  <?php } ?>
                </table>
              </div>
              <?php } ?>
              <?php if ($display_price) { ?>
              <?php if ($discounts) { ?>
              <b><?php echo $text_discount; ?></b><br />
              <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-top: 2px; margin-bottom: 15px;">
                <table style="width: 100%;">
                  <tr>
                    <td style="text-align: right;"><b><?php echo $text_order_quantity; ?></b></td>
                    <td style="text-align: right;"><b><?php echo $text_price_per_item; ?></b></td>
                  </tr>
                  <?php foreach ($discounts as $discount) { ?>
                  <tr>
                    <td style="text-align: right;"><?php echo $discount['quantity']; ?></td>
                    <td style="text-align: right;"><?php echo $discount['price']; ?></td>
                  </tr>
                  <?php } ?>
                </table>
              </div>
              <?php } ?>
              <?php } ?>
              <div class="content">
                <?php echo $text_qty; ?>
                <input type="text" name="quantity" size="3" value="<?php echo $minimum; ?>" />
                <a onclick="$('#product').submit();" id="add_to_cart" class="button"><span><?php echo $button_add_to_cart; ?></span></a>
                <?php if ($minimum > 1) { ?><br/><small><?php echo $text_minimum; ?></small><?php } ?>
				<?php if (!empty($maximum)) { ?><br/><small><?php echo $text_maximum; ?></small><?php } ?>
              </div>
              <div>
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                <input type="hidden" name="redirect" value="<?php echo str_replace('&', '&amp;', $redirect); ?>" />                
              </div>
           
           <!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4e82d97a69fb83ca"></script>
<!-- AddThis Button END -->
           
            </form>
            <?php } ?></td>
        </tr>
         </table>
    </div>
  
  <?php if ($special) { ?>  
     <div id="container_countdown">
     <center>Kampanya Bitimine kalan süre</center><br>
 <center>
         
       <!-- Countdown dashboard start -->
		<div id="countdown_dashboard">
			
			<div class="temp">
				
			</div>
			
			<div class="dash weeks_dash">
				<span class="dash_title">Hafta</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash days_dash">
				<span class="dash_title">Gün</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash hours_dash">
				<span class="dash_title">Saat</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash minutes_dash">
				<span class="dash_title">Dakika</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

			<div class="dash seconds_dash">
				<span class="dash_title">Saniye</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>

		</div>
		 </center>
    </div>
    <?php } ?>
    
    <div class="tabs">
      <a tab="#tab_description"><?php echo $tab_description; ?></a>
      <a tab="#tab_image"><?php echo $tab_image; ?>  (<?php echo count($images); ?>)</a>
      <?php if ($review_status) { ?><a tab="#tab_review"><?php echo $tab_review; ?></a><?php } ?>
      <a tab="#tab_related"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a>
    </div>
    <div id="tab_description" class="tab_page"><?php echo $description; ?></div>
    <?php if ($review_status) { ?>
    <div id="tab_review" class="tab_page">
      <div id="review"></div>
      <div class="heading" id="review_title"><?php echo $text_write; ?></div>
      <div class="content"><b><?php echo $entry_name; ?></b><br />
        <input type="text" name="name" value="" />
        <br />
        <br />
        <b><?php echo $entry_review; ?></b>
        <textarea name="text" style="width: 98%;" rows="8"></textarea>
        <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
        <br />
        <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
        <input type="radio" name="rating" value="1" style="margin: 0;" />
        &nbsp;
        <input type="radio" name="rating" value="2" style="margin: 0;" />
        &nbsp;
        <input type="radio" name="rating" value="3" style="margin: 0;" />
        &nbsp;
        <input type="radio" name="rating" value="4" style="margin: 0;" />
        &nbsp;
        <input type="radio" name="rating" value="5" style="margin: 0;" />
        &nbsp; <span><?php echo $entry_good; ?></span><br />
        <br />
        <b><?php echo $entry_captcha; ?></b><br />
        <input type="text" name="captcha" value="" autocomplete="off" />
        <br />
        <img src="index.php?route=product/product/captcha" id="captcha" /></div>
      <div class="buttons">
        <table>
          <tr>
            <td align="right"><a onclick="review();" class="button"><span><?php echo $button_continue; ?></span></a></td>
          </tr>
        </table>
      </div>
    </div>
    <?php } ?>
    <div id="tab_image" class="tab_page">
      <?php if ($images) { ?>
      <div style="display: inline-block;">
        <?php foreach ($images as $image) { ?>
        <div style="display: inline-block; float: left; text-align: center; margin-left: 5px; margin-right: 5px; margin-bottom: 10px;"><a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="thickbox" rel="gallery"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" style="border: 1px solid #DDDDDD; margin-bottom: 3px;" /></a><br />
          <span style="font-size: 11px;"><?php echo $text_enlarge; ?></span></div>
        <?php } ?>
      </div>
      <?php } else { ?>
      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;"><?php echo $text_no_images; ?></div>
      <?php } ?>
    </div>
    <div id="tab_related" class="tab_page">
      <?php if ($products) { ?>
      <table class="list">
        <?php for ($i = 0; $i < sizeof($products); $i = $i + 4) { ?>
        <tr>
          <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
          <td width="25%"><?php if (isset($products[$j])) { ?>
            <a href="<?php echo str_replace('&', '&amp;', $products[$j]['href']); ?>"><img src="<?php echo $products[$j]['thumb']; ?>" title="<?php echo $products[$j]['name']; ?>" alt="<?php echo $products[$j]['name']; ?>" /></a><br />
            <a href="<?php echo str_replace('&', '&amp;', $products[$j]['href']); ?>"><?php echo $products[$j]['name']; ?></a><br />
            <span style="color: #999; font-size: 11px;"><?php echo $products[$j]['model']; ?></span><br />
            <?php if ($display_price) { ?>
            <?php if (!$products[$j]['special']) { ?>
            <span style="color: #900; font-weight: bold;"><?php echo $products[$j]['price']; ?></span>
            <?php } else { ?>
            <span style="color: #900; font-weight: bold; text-decoration: line-through;"><?php echo $products[$j]['price']; ?></span> <span style="color: #F00;"><?php echo $products[$j]['special']; ?></span>
            <?php } ?>
			<a class="button_add_small" href="<?php echo $products[$j]['add']; ?>" title="<?php echo $button_add_to_cart; ?>" >&nbsp;</a>
            <?php } ?>
            <br />
            <?php if ($products[$j]['rating']) { ?>
            <img src="catalog/view/theme/default/image/stars_<?php echo $products[$j]['rating'] . '.png'; ?>" alt="<?php echo $products[$j]['stars']; ?>" />
            <?php } ?>
            <?php } ?></td>
          <?php } ?>
        </tr>
        <?php } ?>
      </table>
      <?php } else { ?>
      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;"><?php echo $text_no_related; ?></div>
      <?php } ?>
    </div>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
  <?php if ($tags) { ?>
  <div class="tags"><?php echo $text_tags; ?>
  <?php foreach ($tags as $tag) { ?>
  <a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a>, 
  <?php } ?>
  </div>
  <?php } ?>
</div>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').slideUp('slow');
		
	$('#review').load(this.href);
	
	$('#review').slideDown('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

function review() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#review_button').attr('disabled', 'disabled');
			$('#review_title').after('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#review_button').attr('disabled', '');
			$('.wait').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#review_title').after('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success) {
				$('#review_title').after('<div class="success">' + data.success + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
}
//--></script>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?> 