<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title; echo $next_week_end_date;echo "  ";echo $next_week_start_date; echo $tempString;?></h1>
    </div>
  </div>
  <div class="middle">
    <div class="sort">
      <div class="div1">
        <select name="sort" onchange="location = this.value">
          <?php foreach ($sorts as $sorts) { ?>
          <?php if (($sort . '-' . $order) == $sorts['value']) { ?>
          <option value="<?php echo str_replace('&', '&amp;', $sorts['href']); ?>" selected="selected"><?php echo $sorts['text']; ?></option>
          <?php } else { ?>
          <option value="<?php echo str_replace('&', '&amp;', $sorts['href']); ?>"><?php echo $sorts['text']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="div2"><?php echo $text_sort; ?></div>
    </div>
    <?php echo  "BUgün:"; echo $tempString;?><br>
    <?php echo $next_week_start_date; echo "---"; echo $next_week_end_date; echo " tarihleri arasındaki kampanyalar";?>
    <table class="list">
   <?php for ($i = 0; $i < sizeof($products); $i = $i + 4) { ?>
    <tr>
      <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
	  <td style="width: 25%;"><?php if (isset($products[$j])) { ?><!-- code start --><div class="banner"><!-- code end -->
      <a href="<?php echo str_replace('&', '&amp;', $products[$j]['href']); ?>">
	  <!-- code start -->
	  <?php echo $products[$j]['promo_tags_top_right']; ?>
	  <?php echo $products[$j]['promo_tags_top_left']; ?>
	  <?php echo $products[$j]['promo_tags_bottom_left']; ?>
	  <?php echo $products[$j]['promo_tags_bottom_right']; ?>
	  <!-- code end -->
	  <img src="<?php echo $products[$j]['thumb']; ?>" title="<?php echo $products[$j]['name']; ?>" alt="<?php echo $products[$j]['name']; ?>" /></a><!-- code start --></div><!-- code end -->
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
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 