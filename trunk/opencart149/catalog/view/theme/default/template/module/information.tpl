<div class="box">
  <div class="top"><img src="catalog/view/theme/default/image/information.png" alt="" /><?php echo $heading_title; ?></div>
  <div id="information" class="middle">
    <ul>
      <?php foreach ($informations as $information) { ?>
      <li><a href="<?php echo str_replace('&', '&amp;', $information['href']); ?>"><?php echo $information['title']; ?></a></li>
      <?php } ?>
      <li><a href="<?php echo str_replace('&', '&amp;', $contact); ?>"><?php echo $text_contact; ?></a></li>
      <li><a href="<?php echo str_replace('&', '&amp;', $sitemap); ?>"><?php echo $text_sitemap; ?></a></li>
   	  <li><a href="<?php echo str_replace('&', '&amp;', $customer_support); ?>"><?php echo $text_customer_support; ?></a>	
    </ul>
  </div>
  <div class="bottom">&nbsp;</div>
</div>