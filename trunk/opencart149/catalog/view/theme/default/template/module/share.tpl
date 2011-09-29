<div class="box">
  <div class="top">
  <a href="http://www.siamopencart.com/webboard/" targer="_blank">
  <img src="catalog/view/theme/default/image/share.png" alt="" border="0" /></a><?php echo $title; ?></div>
  <div class="middle">
<?php
 $link=str_replace("http://","",$link);
    $title = urlencode($title);
    $text = urlencode($text);
    $link = urlencode($link);
    $link=str_replace("http://","",$link);
    echo "<span>";
   
    echo "&nbsp;&nbsp;<a href='http://twitter.com/home?status=".$text.": ".$link."' title='Click to send this page to Twitter!' target='_blank'>";
        echo "<img src='catalog/view/theme/default/image/twitter.png' alt='Tweet about it' border=\"0\"/>";
    echo "</a>";
  
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.facebook.com/sharer.php?u=".$link."&t=".$text."' title='Click to share this page on Facebook!' target='_blank'>";
        echo "<img src='catalog/view/theme/default/image/facebook.gif' alt='Face book sharer' border=\"0\"/>";
    echo "</a>";

    //digg.com
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://digg.com/submit?url=".$link."&title=".$title."&bodytext=".$text."' title='Digg it' target='_blank'>";
        echo "<img src='catalog/view/theme/default/image/digg.gif' alt='Digg it' border=\"0\"/>";
    echo "</a>";
    //stumble upon
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.stumbleupon.com/submit?url=".$link."&title=".$title."' title='Stumble upon' target='_blank'>";
        echo "<img src='catalog/view/theme/default/image/stumble.gif' alt='Stumble upon' border=\"0\"/>";
    echo "</a>";
    //Myspace
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.myspace.com/Modules/PostTo/Pages/?u=".$link."t=".$title."' title='Share on myspace' target='_blank'>";
        echo "<img src='catalog/view/theme/default/image/myspace.jpg' alt='Share on myspace' border=\"0\"/>";
    echo "</a><br>";
    //Blogger
    echo "&nbsp;&nbsp;<a href='http://www.blogger.com/blog_this.pyra?t=".$title."&u=".$link."&n=".$text."&pli=1' title='BlogThis' target='_blank'>";
        echo "<img src='catalog/view/theme/default/image/blogger.png' alt='BlogThis' border=\"0\"/>";
    echo "</a>";
    //reddit.com
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.reddit.com/submit?url=".$link."&title=". $title."' title='Reddit' target='_blank'>";
        echo "<img src='catalog/view/theme/default/image/reddit.gif' alt='Reddit' border=\"0\"/>";
    echo "</a>";
    //delicious
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.delicious.com/save?url=".$link."&title=".$title."&notes=".$text."&tags=&noui=no&share=yes&jump=yes' ".
        "title='Bookmark to delicious' target='_blank'>";
        echo "<img src='catalog/view/theme/default/image/delicious.png' alt='Bookmark to delicious' border=\"0\"/>";
    echo "</a>";
    //google buzzz
   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.google.com/buzz/post?url=".$link."' title='Click to buzz on Google!' target='_blank'>";
        echo "<img src='catalog/view/theme/default/image/buzz.png' alt='Buzz on google' border=\"0\"/>";
    echo "</a>";
    //opencart2u.co.cc
 	$link=str_replace("http://","",$link);
	$link=str_replace("http//:","",$link);
	$link=str_replace("http//","",$link);
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://opencart2u.co.cc/share.php?url=".$link."&title=".$title."&text=".$text."' title='Click to this web on Opencart2U.co.cc!' target='_blank'>";
        echo "<img src='catalog/view/theme/default/image/somsak2004.png' alt='See @ opencart2u' border=\"0\"/>";
    echo "</a>";
    
    echo "</span>";
?>

<br>

<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4e82d97a69fb83ca"></script>
<!-- AddThis Button END -->


    </div>
  <div class="bottom">&nbsp;</div>
</div>


