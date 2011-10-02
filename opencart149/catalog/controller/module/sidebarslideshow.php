<?php
#############################################################################
#  โมดูล Slide Show สำหรับ Opencart 1.4.4
#  ภาษาไทยจาก www.siamopencart.com ,www.thaiopencart.com ,www.somsak2004.net
#  โดย Somsak2004 วันที่ 20 มีนาคม 2553
#############################################################################
# โดยการสนับสนุนจาก
# Unitedsme.com : ผู้ให้บริการเช่าพื้นที่เว็บไซต์ จดโดเมน ระบบ Linux
# Net-LifeStyle.com : ผู้ให้บริการเช่าพื้นที่เว็บไซต์์ จดโดเมน ระบบ Linux
# SiamWebThai.com : SEO ขั้นเทพ โปรโมทเว็บขั้นเซียน ออกแบบ พัฒนาเว็บไซต์ / ตามความต้องการ และถูกใจ Google
#############################################################################
//-----------------------------------------
// OpenCart Side Bar Slideshow Module
// Version: 1.0
// Author: imaginetech
// Email: info@imaginetech.com.au
// Web: http://www.shop.imaginetech.com.au/
//-----------------------------------------

class ControllerModuleSideBarSlideshow extends Controller {
	public function index() { 
	
		$this->load->language('module/sidebarslideshow');
		$this->load->model('catalog/sidebarslideshow');
		$this->load->model('catalog/product');
		$this->load->model('catalog/review');
		$this->load->model('tool/seo_url');
		$this->load->model('tool/image');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['products'] = array();

		$this->data['products_limit'] = $this->config->get('sidebarslideshow_limit') -1 ;

		$this->data['products_time'] = $this->config->get('sidebarslideshow_time')  ;

		foreach ($this->model_catalog_sidebarslideshow->getRandomProduct() as $result) {			
			if ($result['image']) {
				$image = $result['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			$rating = $this->model_catalog_review->getAverageRating($result['product_id']);	
			
			$special = FALSE;
			
			$discount = $this->model_catalog_product->getProductDiscount($result['product_id']);
			
			if ($discount) {
				$price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			
				$special = $this->model_catalog_product->getProductSpecial($result['product_id']);
			
				if ($special) {
					$special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
				}						
			}
				
          	$this->data['products'][] = array(
            	'name'    => $result['name'],
				'model'   => $result['model'],
            	'rating'  => $rating,
				'stars'   => sprintf($this->language->get('text_stars'), $rating),
				'thumb'   => $this->model_tool_image->resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
            	'price'   => $price,
				'special' => $special,
				'href'    => $this->model_tool_seo_url->rewrite(HTTPS_SERVER .'index.php?route=product/product&product_id=' . $result['product_id'])
          	);
		}
		
		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = TRUE;
		} elseif ($this->customer->isLogged()) {
			$this->data['display_price'] = TRUE;
		} else {
			$this->data['display_price'] = FALSE;
		}
		
		$this->id       = 'sidebarslideshow';
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/sidebarslideshow.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/sidebarslideshow.tpl';
		} else {
			$this->template = 'default/template/module/sidebarslideshow.tpl';
		}
		$this->render();
	}
}
?>
