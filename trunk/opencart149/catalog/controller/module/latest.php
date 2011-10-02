<?php
class ControllerModuleLatest extends Controller {
	protected function index() {
		$this->language->load('module/latest');

      	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('catalog/product');
		$this->load->model('catalog/review');
		$this->load->model('tool/seo_url');
		$this->load->model('tool/image');

		$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');

		$this->data['products'] = array();

		$results = $this->model_catalog_product->getLatestProducts($this->config->get('latest_limit'));

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $result['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			//code start
			if((strtotime(date('Y-m-d')) >= strtotime($result['promo_date_start'])) && (strtotime(date('Y-m-d')) <= strtotime($result['promo_date_end'])) || (($result['promo_date_start'] == '0000-00-00') && ($result['promo_date_end'] == '0000-00-00'))) {
				$promo_on = TRUE;
			} else {
				$promo_on = FALSE;
            }
			//code end

			if ($this->config->get('config_review')) {
				$rating = $this->model_catalog_review->getAverageRating($result['product_id']);
			} else {
				$rating = false;
			}

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

			$options = $this->model_catalog_product->getProductOptions($result['product_id']);

			if ($options) {
				$add = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&amp;product_id=' . $result['product_id']);
			} else {
				$add = HTTPS_SERVER . 'index.php?route=checkout/cart&amp;product_id=' . $result['product_id'];
			}
			
			//code start
			$promo = $this->model_catalog_product->getPromo($result['product_id'],$result['promo_banner']);
			
			if (!empty($promo['promo_text']) && $promo_on) {
				$promo_tags_top_right = '<span class="promotags" style="width:100%;height:100%;background: url(\'' . 'image/' . $promo['image'] . '\') no-repeat;background-position:top right"></span>';
			} else {
				$promo_tags_top_right = '';
			}
			
			$promo_top_left = $this->model_catalog_product->getPromo($result['product_id'],$result['promo_banner_top_left']);
			if (!empty($promo_top_left['promo_text']) && $promo_on) {
				$promo_tags_top_left = '<span class="promotags" style="width:100%;height:100%;background: url(\'' . 'image/' . $promo_top_left['image'] . '\') no-repeat;background-position:top left"></span>';
			} else {
				$promo_tags_top_left = '';
			}
			
			$promo_bottom_left = $this->model_catalog_product->getPromo($result['product_id'],$result['promo_banner_bottom_left']);
			if (!empty($promo_bottom_left['promo_text']) && $promo_on) {
				$promo_tags_bottom_left = '<span class="promotags" style="width:100%;height:100%;background: url(\'' . 'image/' . $promo_bottom_left['image'] . '\') no-repeat;background-position:bottom left"></span>';
			} else {
				$promo_tags_bottom_left = '';
			}
			
			$promo_bottom_right = $this->model_catalog_product->getPromo($result['product_id'],$result['promo_banner_bottom_right']);
			if (!empty($promo_bottom_right['promo_text']) && $promo_on) {
				$promo_tags_bottom_right = '<span class="promotags" style="width:100%;height:100%;background: url(\'' . 'image/' . $promo_bottom_right['image'] . '\') no-repeat;background-position:bottom right"></span>';
			} else {
				$promo_tags_bottom_right = '';
			}
			//code end

			$this->data['products'][] = array(
				'product_id'    => $result['product_id'],
				'name'    		=> $result['name'],
				'model'   		=> $result['model'],
				'rating'  		=> $rating,
				//code start
				'promo_tags_top_right'		=> $promo_tags_top_right,
				'promo_tags_top_left'		=> $promo_tags_top_left,
				'promo_tags_bottom_left'	=> $promo_tags_bottom_left,
				'promo_tags_bottom_right'	=> $promo_tags_bottom_right,
				//code end
				'stars'   		=> sprintf($this->language->get('text_stars'), $rating),
				'price'   		=> $price,
				'options'   	=> $options,
				'special' 		=> $special,
				'image'   		=> $this->model_tool_image->resize($image, 38, 38),
				'thumb'   		=> $this->model_tool_image->resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
				'href'    		=> $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $result['product_id']),
				'add'    		=> $add
			);
		}

		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = TRUE;
		} elseif ($this->customer->isLogged()) {
			$this->data['display_price'] = TRUE;
		} else {
			$this->data['display_price'] = FALSE;
		}

		$this->id = 'latest';

		if ($this->config->get('latest_position') == 'home') {
			$this->data['heading_title'] .= (' ' . $this->language->get('text_products'));
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/latest_home.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/latest_home.tpl';
			} else {
				$this->template = 'default/template/module/latest_home.tpl';
			}
		} else {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/latest.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/latest.tpl';
			} else {
				$this->template = 'default/template/module/latest.tpl';
			}
		}

		$this->render();
	}
}
?>