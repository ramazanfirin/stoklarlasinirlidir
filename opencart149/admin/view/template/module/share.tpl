<?
#####################################################################################
# โมดูล Share-IT สำหรับ Opencart 1.4.9.x
#  ภาษาไทยจาก www.siamopencart.com ,www.thaiopencart.com,www.opencart2u.co.cc
#  สำหรับ Opencart 1.4.9.x โดย Somsak2004 วันที่ 3 กุมภาพันธ์ 2554
#####################################################################################
# โดยการสนับสนุนจาก
# Somsak2004.com : บริการงาน ออนไลน์ครบวงจร
# Unitedsme.com : ผู้ให้บริการเช่าพื้นที่เว็บไซต์ จดโดเมน ระบบ Linux
# Net-LifeStyle.com : ผู้ให้บริการเช่าพื้นที่เว็บไซต์์ จดโดเมน ระบบ Linux & Windows
# SiamWebThai.com : SEO ขั้นเทพ โปรโมทเว็บขั้นเซียน ออกแบบ พัฒนาเว็บไซต์ / ตามความต้องการ และถูกใจ Google
#####################################################################################
?>
<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/module.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <table class="form">
      <tr>
        <td  bgcolor="#CCCCCC" align="center" ><img src="http://opencart2u.co.cc/logo.gif" ></td>
        <td align="left"  bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td align="right"><?php echo $entry_title; ?></td>
        <td align="left"><input type="text" name="share_title" value="<?php echo $share_title; ?>" size="60"  id="editor1" /> ext. Share my Site
          <br /><?php if ($error_title) { ?>  <span class="error"><?php echo $error_title; ?></span>  <?php } ?>
	</td>
      </tr>
      <tr>
        <td align="right"  bgcolor="#CCCCCC"><?php echo $entry_text; ?></td>
        <td align="left" bgcolor="#CCCCCC"><input type="text" name="share_text" value="<?php echo $share_text; ?>" size="60"  id="editor1" /> ext. Best Shop
          <br /><?php if ($error_text) { ?>  <span class="error"><?php echo $error_text; ?></span>  <?php } ?>
	</td>
      </tr>
      <tr>
        <td align="right"><?php echo $entry_link; ?></td>
        <td align="left"><input type="text" name="share_link" value="<?php echo $share_link; ?>" size="60"  id="editor1" /> ext. http://www.myshop.com
          <br /><?php if ($error_link) { ?>  <span class="error"><?php echo $error_link; ?></span>  <?php } ?>	
	</td>
      </tr>
     <tr>	 
       <td align="right" bgcolor="#CCCCCC"><?php echo $entry_position; ?></td>	   
       <td align="left" bgcolor="#CCCCCC">
	<select name="share_position">
              <?php foreach ($positions as $position) { ?>
              <?php if ($share_position== $position['position']) { ?>
              <option value="<?php echo $position['position']; ?>" selected="selected"><?php echo $position['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $position['position']; ?>"><?php echo $position['title']; ?></option>
              <?php } ?>
        <?php } ?>
	  </td>       
      </tr>
      <tr>
       <td align="right" bgcolor="#CCCCCC"><?php echo $entry_status; ?></td>
       <td align="left" bgcolor="#CCCCCC"><select name="share_status">
            <?php if ($share_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td align="right"><?php echo $entry_sort_order; ?></td>
        <td align="left"><input type="text" name="share_sort_order" value="<?php echo $share_sort_order; ?>" size="1"  id="editor1" />
          <br />
          <?php if ($error_sort_order) { ?>
          <span class="error"><?php echo $error_sort_order; ?></span>
          <?php } ?></td>	
	</td>
      </tr>
         <tr>
        <td align="right" bgcolor="#CCCCCC"><?php echo $entry_version_status ?></td>
	<td style="vertical-align: middle;" bgcolor="#CCCCCC"><a href="http://www.siamopencart.com/webboard/">SiamOpencart Webboard</a></td>
      </tr>

      <tr>
        <td align="right"><?php echo $entry_author; ?></td>
        <td align="left">Somsak2004<br />
 	    Email: <a href="mailto:somsak2004@live.com">somsak2004@live.com</a><br />
	    Web: <a href="http://www.somsak2004.com/">www.somsak2004.com/</a><br />
	</td>
      </tr>
    </table>
  </div>
</form>
  </div>
  </div>
<?php echo $footer; ?>