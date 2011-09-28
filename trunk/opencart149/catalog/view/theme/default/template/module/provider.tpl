<script type="text/javascript" src="catalog/view/javascript/jquery/innerfade.js"></script>
<script type="text/javascript">
	$(document).ready(
		function(){
			$('ul#brands_slide').innerfade({
				speed: 1000,
				timeout: 9000,
				type: 'random',
				containerheight: '100px'
			});
		});
</script>

<div class="box">
	<div class="top"><img src="catalog/view/theme/default/image/brands.png" alt="" /><?php echo $heading_title; ?></div>
	<div class="middle" style="text-align: center;">
		<div class="brands_logo">
        	<ul id="brands_slide">
  				<?php foreach($manufacturers as $manufacturer): ?>
        		<li><a href="<?php echo str_replace('&', '&amp;', $manufacturer['href']); ?>"><img src="<?php echo $manufacturer['preview']?>" alt="<?php echo $manufacturer['name']; ?>" /></a></li>
        		<?php endforeach; ?>
        	</ul>
		</div>
    
	</div>
	<div class="bottom">&nbsp;</div>
</div>

<style type="text/css">
.brands_logo { margin-left:-31px; }
.brands_logo img { border-radius:5px 5px; -moz-border-radius:5px 5px; }
.box .brands_logo { margin-top:5px; }
.box .brands_logo ol,ul { list-style:none; }
ul#brands_slide li img{ padding: 0px; margin-left:0; }
</style>
<!--[if lte IE 7]>
<style type="text/css"> .brands_logo { margin-left:-195px; } .box .brands_logo { margin-top:-5px; } .box .brands_logo ol,ul { list-style:none; } ul#brands_slide li img { padding: 0px; margin-left:0; } </style>
<![endif]-->