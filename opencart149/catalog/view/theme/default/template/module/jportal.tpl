<div class="top">
  <div class="left"></div>
  <div class="right"></div>
  <div class="center">
    <div class="heading"><?php if(trim($jportal_title)){ echo $jportal_title; } else { echo "&nbsp;"; } ?></div>
  </div>
</div>

<div class="middle">
<?php if ($jp_latest_status || $jp_best_sellers_status || $jp_featured_status || $jp_customers_status || $jp_stores_status || $jp_brands_status) { ?>
	<div class="tabs">
		<?php foreach($jp_tabs as $jp_tab) {?>
			<a tab="#<?php echo $jp_tab[1]; ?>"><?php echo $jp_tab[0]; ?></a>
		<?php } ?>
    </div>
	<?php if ($jp_latest_status) { ?>
		<div id="tab_latest" class="tab_page">
		  <?php if($latest_products) { ?>
			<table class="list">
  
  <?php for ($i = 0; $i < sizeof($latest_products); $i = $i + 4) { ?>
    <tr>
      <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
	  <td style="width: 25%;"><?php if (isset($latest_products[$j])) { ?><!-- code start --><div class="banner"><!-- code end -->
      <a href="<?php echo str_replace('&', '&amp;', $latest_products[$j]['href']); ?>">
	  <!-- code start -->
	  <?php echo $latest_products[$j]['promo_tags_top_right']; ?>
	  <?php echo $latest_products[$j]['promo_tags_top_left']; ?>
	  <?php echo $latest_products[$j]['promo_tags_bottom_left']; ?>
	  <?php echo $latest_products[$j]['promo_tags_bottom_right']; ?>
	  <!-- code end -->
	  <img src="<?php echo $latest_products[$j]['thumb']; ?>" title="<?php echo $latest_products[$j]['name']; ?>" alt="<?php echo $latest_products[$j]['name']; ?>" /></a><!-- code start --></div><!-- code end -->
      <a href="<?php echo str_replace('&', '&amp;', $latest_products[$j]['href']); ?>"><?php echo $latest_products[$j]['name']; ?></a><br />
      <span style="color: #999; font-size: 11px;"><?php echo $latest_products[$j]['model']; ?></span><br />
      
	  <?php if ($display_price) { ?>
      <?php if (!$latest_products[$j]['special']) { ?>
      <span style="color: #900; font-weight: bold;"><?php echo $latest_products[$j]['price']; ?></span>
      <?php } else { ?>
      <span style="color: #900; font-weight: bold; text-decoration: line-through;"><?php echo $latest_products[$j]['price']; ?></span> <span style="color: #F00;"><?php echo $latest_products[$j]['special']; ?></span>
      <?php } ?>
      <a class="button_add_small" href="<?php echo $latest_products[$j]['add']; ?>" title="<?php echo $button_add_to_cart; ?>" >&nbsp;</a>
      <?php } ?>
      <br />
	  <?php if ($latest_products[$j]['rating']) { ?>
      <img src="catalog/view/theme/default/image/stars_<?php echo $latest_products[$j]['rating'] . '.png'; ?>" alt="<?php echo $latest_products[$j]['stars']; ?>" />
      <?php } ?>
      <?php } ?></td>
      <?php } ?>
    </tr>
    <?php } ?>
  </table>
		  <?php } else { ?>
			<div class="noavailmsg"><?php echo $text_no_latest; ?></div>
		  <?php } ?>
		  
		</div>
	<?php } ?>
	
	<?php if ($jp_best_sellers_status) { ?>
		<div id="tab_best_sellers" class="tab_page">
		  <?php if ($best_sellers_products) { ?>
			  <table class="list">
   <?php for ($i = 0; $i < sizeof($best_sellers_products); $i = $i + 4) { ?>
    <tr>
      <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
	  <td style="width: 25%;"><?php if (isset($best_sellers_products[$j])) { ?><!-- code start --><div class="banner"><!-- code end -->
      <a href="<?php echo str_replace('&', '&amp;', $best_sellers_products[$j]['href']); ?>">
	  <!-- code start -->
	  <?php echo $best_sellers_products[$j]['promo_tags_top_right']; ?>
	  <?php echo $best_sellers_products[$j]['promo_tags_top_left']; ?>
	  <?php echo $best_sellers_products[$j]['promo_tags_bottom_left']; ?>
	  <?php echo $best_sellers_products[$j]['promo_tags_bottom_right']; ?>
	  <!-- code end -->
	  <img src="<?php echo $best_sellers_products[$j]['thumb']; ?>" title="<?php echo $best_sellers_products[$j]['name']; ?>" alt="<?php echo $best_sellers_products[$j]['name']; ?>" /></a><!-- code start --></div><!-- code end -->
      <a href="<?php echo str_replace('&', '&amp;', $best_sellers_products[$j]['href']); ?>"><?php echo $best_sellers_products[$j]['name']; ?></a><br />
      <span style="color: #999; font-size: 11px;"><?php echo $best_sellers_products[$j]['model']; ?></span><br />
      <?php if ($display_price) { ?>
      <?php if (!$best_sellers_products[$j]['special']) { ?>
      <span style="color: #900; font-weight: bold;"><?php echo $best_sellers_products[$j]['price']; ?></span>
      <?php } else { ?>
      <span style="color: #900; font-weight: bold; text-decoration: line-through;"><?php echo $best_sellers_products[$j]['price']; ?></span> <span style="color: #F00;"><?php echo $best_sellers_products[$j]['special']; ?></span>
      <?php } ?>
      <a class="button_add_small" href="<?php echo $best_sellers_products[$j]['add']; ?>" title="<?php echo $button_add_to_cart; ?>" >&nbsp;</a>
      <?php } ?>
      <br />
	  <?php if ($best_sellers_products[$j]['rating']) { ?>
      <img src="catalog/view/theme/default/image/stars_<?php echo $best_sellers_products[$j]['rating'] . '.png'; ?>" alt="<?php echo $best_sellers_products[$j]['stars']; ?>" />
      <?php } ?>
      <?php } ?></td>
      <?php } ?>
    </tr>
    <?php } ?>
  </table>
		  <?php } else { ?>
			<div class="noavailmsg"><?php echo $text_no_best_sellers; ?></div>
		  <?php } ?> 
		</div>
	<?php } ?>

	
	
	
	<?php if ($jp_featured_status) { ?>
		<div id="tab_featured" class="tab_page">
		<?php if ($featured_products) { ?>
			<table id="productList" RULES=GROUPS frame="void">
    <thead>  
            <tr>  
                <th ></th>
                <th align="center">Ürün İsmi</th>
                <th align="center">Başlangıç Tarihi</th>
                <th align="center">Bitiş Tarihi</th>        
                <th align="center">Fiyat</th>  
            </tr>  
        </thead>  
   <tbody>  
   <?php foreach ($featured_products as $product) { ?>
    <tr align="left"> 
       <td>  
    <?php if ($product['thumb']) { ?>
     <img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" />
      
      <?php } ?>
       </td>
      <td width="200">
      <?php echo $product['name']; ?>
      </td> 
       <td width="150" align="center">
       <?php echo $product['startDate']; ?>
      </td>
       <td width="100" align="center">
       <?php echo $product['endDate']; ?>
      </td>
      <td align="right">
      <?php if ($product['price']) { ?>
         <?php if ($product['special']) { ?>
                 <?php echo $product['price']; ?>
        <?php } else {} ?>
        <!-- 
        <?php if ($product['tax']) { ?>
         -->
        <br />
        <!-- Kdvsi fiyat 
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
        <?php } ?>
        -->
     <?php } ?>
   <?php } ?>
    </td>
    </tbody> 
  </table>
	 <div class="pagination"><?php echo $pagination; ?></div>	 
		  <?php } else { ?>
			<div class="noavailmsg"><?php echo $text_no_featured; ?></div>
		  <?php } ?> 
	  </div>
	<?php } ?>

	<?php if ($jp_customers_status) { ?>
		<div id="tab_customers" class="tab_page">
			<?php if ($jp_customers) { ?>
			<table class="list">
				<?php for ($i = 0; $i < sizeof($jp_customers); $i = $i + 4) { ?>
				<tr>
				  <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
				  <td style="width: 25%; text-align:left;"><?php if (isset($jp_customers[$j])) { ?>
				  <img src="catalog/view/theme/default/image/customer.png" style="vertical-align:middle;">
				  <span>
					<?php echo $jp_customers[$j]['firstname'].' '.$jp_customers[$j]['lastname']; ?><br />
					<span style='color:#666;'>Since: <?php echo date ("M j, Y", strtotime($jp_customers[$j]['date_added'])); ?></span>
				  </span>
				  <br />
				  <?php } ?></td>
				  <?php } ?>
				</tr>
				<?php } ?>
			</table>
		  <?php } else { ?>
			<div class="noavailmsg"><?php echo $text_no_customers; ?></div>
		  <?php } ?> 
		</div>
	<?php } ?>
	
	<?php if ($jp_stores_status && $jp_current_store_id == '0') { ?>
		<div id="tab_stores" class="tab_page">
			<?php if ($jp_stores) { ?>
			<table class="list">
			<?php for ($i = 0; $i < sizeof($jp_stores); $i = $i + 4) { ?>
			<tr>
			  <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
			  <td style="width: 25%;"><?php if (isset($jp_stores[$j])) { ?>
			  <a href="<?php echo str_replace('&', '&amp;', $jp_stores[$j]['href']); ?>"><img src="<?php echo $jp_stores[$j]['thumb']; ?>" title="<?php echo $jp_stores[$j]['name']; ?>" alt="<?php echo $jp_stores[$j]['name']; ?>" /></a><br />
			  <a href="<?php echo str_replace('&', '&amp;', $jp_stores[$j]['href']); ?>"><?php echo $jp_stores[$j]['name']; ?></a><br />
			  <br />
			  <?php } ?></td>
			  <?php } ?>
			</tr>
			<?php } ?>
			</table>
		  <?php } else { ?>
			<div class="noavailmsg"><?php echo $text_no_stores; ?></div>
		  <?php } ?>    
		</div>
	<?php } ?>

	<?php if ($jp_brands_status) { ?>
		<div id="tab_brands" class="tab_page">
			<?php if ($jp_manufacturers) { ?>
			<table class="list">
				<?php for ($i = 0; $i < sizeof($jp_manufacturers); $i = $i + 4) { ?>
				<tr>
				  <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
				  <td style="width: 25%;"><?php if (isset($jp_manufacturers[$j])) { ?>
				  <a href="<?php echo str_replace('&', '&amp;', $jp_manufacturers[$j]['href']); ?>"><img src="<?php echo $jp_manufacturers[$j]['thumb']; ?>" title="<?php echo $jp_manufacturers[$j]['name']; ?>" alt="<?php echo $jp_manufacturers[$j]['name']; ?>" /></a><br />
				  <a href="<?php echo str_replace('&', '&amp;', $jp_manufacturers[$j]['href']); ?>"><?php echo $jp_manufacturers[$j]['name']; ?></a><br />
				  <br />
				  <?php } ?></td>
				  <?php } ?>
				</tr>
				<?php } ?>
			</table>
		  <?php } else { ?>
			<div class="noavailmsg"><?php echo $text_no_brands; ?></div>
		  <?php } ?>    
		</div>	
	<?php } ?>
<?php } else { ?>
	<div class="noavailmsg"><?php echo $text_please_disable; ?></div>
<?php } ?>

</div>

<div class="bottom">
  <div class="left"></div>
  <div class="right"></div>
  <div class="center"></div>
</div>

<script type="text/javascript"><!--
$.tabs('.tabs a');
//--></script>