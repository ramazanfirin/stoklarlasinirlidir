<div class="box">
  <div class="top"><img src="catalog/view/theme/default/image/bestsellers.png" alt="" /><?php echo $heading_title; ?></div>
  <div class="middle" style="text-align:center;height:190px">
  
  <?php 
  	for($j = 0; $j <= $products_limit; $j++){
    	if(isset($products[$j])){
	    	?>
    	    <div class="slide" id="slide<?php echo $j; ?>" <?php if($j == 0) { ?> style="display:visible;height:190px" <?php } else { ?> style="display:none;height:190px" <?php } ?>>
	    	<a href="<?php echo $products[$j]['href']; ?>"><img src="<?php echo $products[$j]['thumb']; ?>" title="<?php echo $products[$j]['name']; ?>" alt="<?php echo $products[$j]['name']; ?>" /></a><br />
	    	<a href="<?php echo $products[$j]['href']; ?>"><?php echo $products[$j]['name']; ?></a><br />
		    <span style="color: #999; font-size: 11px;"><?php echo $products[$j]['model']; ?></span><br />
    		<?php if ($display_price) { ?>
		    	<?php if (!$products[$j]['special']) { ?>
    				<span style="color: #900; font-weight: bold;"><?php echo $products[$j]['price']; ?></span><br />
	   			<?php } else { ?>
	   				<span style="color: #900; font-weight: bold; text-decoration: line-through;"><?php echo $products[$j]['price']; ?></span> <span style="color: #F00;"><?php echo $products[$j]['special']; ?></span>
		   		<?php } ?>
    		<?php } ?>
	    	<?php if ($products[$j]['rating']) { ?>
    			<img src="catalog/view/theme/default/image/stars_<?php echo $products[$j]['rating'] . '.png'; ?>" alt="<?php echo $products[$j]['stars']; ?>" />
		    <?php } ?>
    	    </div>
        	<?php
    	}
    }
  ?>
  </div>
  <div class="bottom">&nbsp;</div>
 </div>

<script>
  $(document).ready(function() {
		//SET TO DESIRED SECONDS BETWEEN SLIDES
		var timer = 9;
	
		//SET TO DESIRED SLIDE FADE IN/OUT TIME
		var fadeTime = '<?php $products_time; ?>';
		
		//NUMBER OF ELEMENTS IN SLIDE CLASS RENDERED
  		var i = $('.slide').length;
		
		var x = 0;
		
		showSlide();
	
		function showSlide(){
			curSlide = "#slide" + x;
			
			if(x == 0){
				prevSlide = "#slide" + (i - 1);
			} else {
				prevSlide = "#slide" + (x - 1);
			}
			
			$(prevSlide).fadeOut(fadeTime, function(){
				$(curSlide).fadeIn(fadeTime);
				if(x == (i - 1)){
					x = 0;
				} else {
					x++;
				}
			});
			
			setTimeout(showSlide, timer * 1000);
		}
 });
</script>

