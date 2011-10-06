<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <div class="top">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center">
      <h1><?php echo $heading_title;?></h1>
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
   
    <?php echo  "Eski Kampanyalar:"; ?><br>
   
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
   <?php foreach ($products as $product) { ?>
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
 <!--  
   
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
     -->
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div>
<?php echo $footer; ?> 