<?php

/**
	Jportal can be used to display all the modules (i.e. bestsellers, featured, latest, stores etc.) in one place. This is first release, I hope I'll get many feature requests
	Developer: Jaswant Tak (http://jaswanttak.elance.com)
**/

class ControllerModuleJportal extends Controller {
	protected function index() {
		$this->language->load('module/jportal');

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['jportal_title'] = $this->config->get('jportal_title');
		$this->data['tab_latest'] = $this->language->get('tab_specials');//changed to specials
		$this->data['tab_best_sellers'] = $this->language->get('tab_next_week_specials');
		$this->data['tab_featured'] = $this->language->get('tab_old_specials');
		$this->data['tab_customers'] = $this->language->get('tab_customers');
		$this->data['tab_stores'] = $this->language->get('tab_stores');
		$this->data['tab_brands'] = $this->language->get('tab_brands');

		$this->data['text_no_latest'] = $this->language->get('text_no_latest');
		$this->data['text_no_best_sellers'] = $this->language->get('text_no_best_sellers');
		$this->data['text_no_featured'] = $this->language->get('text_no_featured');
		$this->data['text_no_customers'] = $this->language->get('text_no_customers');
		$this->data['text_no_stores'] = $this->language->get('text_no_stores');
		$this->data['text_no_brands'] = $this->language->get('text_no_brands');
		$this->data['text_please_disable'] = $this->language->get('text_please_disable');
		
		$this->load->model('catalog/product');
		$this->load->model('catalog/review');
		$this->load->model('tool/seo_url');
		$this->load->model('tool/image');
		$this->load->model('jportal/jportal');
		
		$this->data['jp_current_store_id'] = (int)$this->config->get('config_store_id');
		
		$this->data['jp_latest_status'] = $this->config->get('jp_latest_status');
		$this->data['jp_best_sellers_status'] = $this->config->get('jp_best_sellers_status');
		$this->data['jp_featured_status'] = $this->config->get('jp_featured_status');
		$this->data['jp_customers_status'] = $this->config->get('jp_customers_status');
		$this->data['jp_stores_status'] = $this->config->get('jp_stores_status');
		$this->data['jp_brands_status'] = $this->config->get('jp_brands_status');

		$this->data['jp_latest_sort_order'] = $this->config->get('jp_latest_sort_order');
		$this->data['jp_best_sellers_sort_order'] = $this->config->get('jp_best_sellers_sort_order');
		$this->data['jp_featured_sort_order'] = $this->config->get('jp_featured_sort_order');
		$this->data['jp_customers_sort_order'] = $this->config->get('jp_customers_sort_order');
		$this->data['jp_stores_sort_order'] = $this->config->get('jp_stores_sort_order');
		$this->data['jp_brands_sort_order'] = $this->config->get('jp_brands_sort_order');
		
		if($this->config->get('jp_latest_status'))
			$tabs[$this->data['jp_latest_sort_order']] = array($this->data['tab_latest'], 'tab_latest');
		if($this->config->get('jp_best_sellers_status'))
			$tabs[$this->data['jp_best_sellers_sort_order']] = array($this->data['tab_best_sellers'], 'tab_best_sellers');
		if($this->config->get('jp_featured_status'))
			$tabs[$this->data['jp_featured_sort_order']] = array($this->data['tab_featured'], 'tab_featured');
		if($this->config->get('jp_customers_status'))
			$tabs[$this->data['jp_customers_sort_order']] = array($this->data['tab_customers'], 'tab_customers');
		if($this->config->get('jp_stores_status') && (int)$this->config->get('config_store_id') == 0)
			$tabs[$this->data['jp_stores_sort_order']] = array($this->data['tab_stores'], 'tab_stores');
		if($this->config->get('jp_brands_status'))
			$tabs[$this->data['jp_brands_sort_order']] = array($this->data['tab_brands'], 'tab_brands');

		ksort($tabs);
		
		$this->data['jp_tabs'] = $tabs;
		
		/* JPortal Latest Products Starts */
		
		$this->language->load('module/latest');

		$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');

		$this->data['latest_products'] = array();

		//$results = $this->model_catalog_product->getLatestProducts($this->config->get('jp_latest_limit'));
		$results = $this->model_catalog_product->getProductSpecials($this->config->get('jp_latest_limit'));

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
			
			
			$stores = $this->model_jportal_jportal->getProductStores($result['product_id']);

			$this->data['latest_products'][] = array(
				'product_id'    => $result['product_id'],
				'name'    		=> $result['name'],
				'model'   		=> $result['model'],
				//code start
				'promo_tags_top_right'		=> $promo_tags_top_right,
				'promo_tags_top_left'		=> $promo_tags_top_left,
				'promo_tags_bottom_left'	=> $promo_tags_bottom_left,
				'promo_tags_bottom_right'	=> $promo_tags_bottom_right,
				//code end
				
				'rating'  		=> $rating,
				'stars'   		=> sprintf($this->language->get('text_stars'), $rating),
				'price'   		=> $price,
				'options'   	=> $options,
				'special' 		=> $special,
				'stores'  		=> $stores,
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
		
		/* JPortal Latest Products Ends */
		
		/* JPortal BestSellers Starts */
		
		$this->language->load('module/bestseller');
		
		$this->data['best_sellers_products'] = array();

		//$results = $this->model_catalog_product->getBestSellerProducts($this->config->get('jp_best_sellers_limit'));
        $results = $this->model_catalog_product->getNextWeekCampaigns($this->config->get('jp_best_sellers_limit'));
		
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

			$stores = $this->model_jportal_jportal->getProductStores($result['product_id']);

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
			
			$this->data['best_sellers_products'][] = array(
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
				'options'   		=> $options,
				'special' 		=> $special,
				'stores'  		=> $stores,
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
		
		/* JPortal BestSellers Ends */
		
		/* JPortal Featured Starts */
		
		$this->language->load('module/featured');
		
		$this->data['featured_products'] = array();
         
		//$results = $this->model_catalog_product->getfeaturedProducts($this->config->get('jp_featured_limit'));
        //  $results = $this->model_catalog_product->getOldCampaigns($this->config->get('jp_featured_limit'));
            
		$this->load->model('catalog/product');
	if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
			
		$product_total = $this->model_catalog_product->getTotalProductSpecials();
						
		if ($product_total) {
			$url = '';
				
			$this->load->model('catalog/review');
			$this->load->model('tool/seo_url');
			$this->load->model('tool/image');
			
			$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');
			
       		$this->data['products'] = array();

       		$page_size_limit =20;
			$results = $this->model_catalog_product->getOldCampaigns(($page - 1) * $page_size_limit,$page_size_limit);
			$product_total=$this->model_catalog_product->geOldCampaignCount();
        		
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $result['image'];
				} else {
					$image = 'no_image.jpg';
				}						
					
				if ($this->config->get('config_review')) {
					$rating = $this->model_catalog_review->getAverageRating($result['product_id']);	
				} else {
					$rating = false;
				}
				
				$options = $this->model_catalog_product->getProductOptions($result['product_id']);
					
				if ($options) {
					$add = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $result['product_id']);
				} else {
					$add = HTTPS_SERVER . 'index.php?route=checkout/cart&product_id=' . $result['product_id'];
				}
							
				$this->data['featured_products'][] = array(
           			'name'    => $result['model'],
					'model'   => $result['model'],
					'rating'  => $rating,
					'stars'   => sprintf($this->language->get('text_stars'), $rating),
           			'thumb'   => $this->model_tool_image->resize($image, 35, 35),
           			'price'   => $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))),
					'options' => $options,
           			'special' => $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'))),
					'href'    => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product' . $url . '&product_id=' . $result['product_id']),
					'add'	  => $add,
				    'startDate'	  => $result['date_start'],
				    'endDate'	  => $result['date_end'] 
       			);
        	}

			if (!$this->config->get('config_customer_price')) {
				$this->data['display_price'] = TRUE;
			} elseif ($this->customer->isLogged()) {
				$this->data['display_price'] = TRUE;
			} else {
				$this->data['display_price'] = FALSE;
			}
			
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $page_size_limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = HTTP_SERVER . 'index.php?route=product/oldCampaign' . $url . '&page={page}';
				
			$this->data['pagination'] = $pagination->render();
		}
		/* JPortal Featured Ends */

		/* JPortal Customers Starts */
		
		$results = $this->model_jportal_jportal->jpGetAllCustomers($this->config->get('jp_customers_limit'));
		
		$this->data['jp_customers'] = array();
		
		if($results) {		
			foreach ($results as $result) {
				$this->data['jp_customers'][] = array(
					'customer_id'  => $result['customer_id'],
					'store_id'     => $result['store_id'],
					'firstname'    => $result['firstname'],
					'lastname'     => $result['lastname'],
					'date_added'   => $result['date_added']
				);
			}
		}
		
		/* JPortal Customers Ends */

		/* JPortal Stores Starts */
				
		$results = $this->model_jportal_jportal->jpGetAllStores($this->config->get('jp_stores_limit'));
		
		$this->data['jp_stores'] = array();
		
		if($results) {
			foreach ($results as $result) {
				
				if ($result['logo']) {
					$image = $result['logo'];
				} else {
					$image = 'no_image.jpg';
				}
				
				$this->data['jp_stores'][] = array(
					'store_id' => $result['store_id'],
					'name'     => $result['name'],
					'thumb'    => $this->model_tool_image->resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
					'href'     => $result['url']
				);
			}
		}
		
		/* JPortal Stores Ends */
		
		/* JPortal Brands Starts */
		
		$this->language->load('module/manufacturer');
		
		//$this->load->model('jportal/jportal');
		
		$this->data['jp_manufacturers'] = array();
		
		$results = $this->model_jportal_jportal->jpGetManufacturers($this->config->get('jp_brands_limit'));
		
		if($results) {
			foreach ($results as $result) {
				
				if ($result['image']) {
					$image = $result['image'];
				} else {
					$image = 'no_image.jpg';
				}
				
				$this->data['jp_manufacturers'][] = array(
					'manufacturer_id' => $result['manufacturer_id'],
					'name'            => $result['name'],
					'thumb'           => $this->model_tool_image->resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
					'href'            => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/manufacturer&manufacturer_id=' . $result['manufacturer_id'])
				);
			}
		}
		
		/* JPortal Brands Ends */
		
		$this->id = 'jportal';

		if ($this->config->get('jportal_position') == 'home') {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/jportal.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/jportal.tpl';
			} else {
				$this->template = 'default/template/module/jportal.tpl';
			}
		} else {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/jportal.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/jportal.tpl';
			} else {
				$this->template = 'default/template/module/jportal.tpl';
			}
		}

		$this->render();
	}
}
?>