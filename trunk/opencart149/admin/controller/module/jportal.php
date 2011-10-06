<?php

/**
	Jportal can be used to display all the modules (i.e. bestsellers, featured, latest, stores etc.) in one place. This is first release, I hope I'll get many feature requests
	Developer: Jaswant Tak (http://jaswanttak.elance.com)
**/

class ControllerModuleJportal extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/jportal');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('jportal', $this->request->post);		
			
			$this->cache->delete('product');
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['entry_jportal_title'] = $this->language->get('entry_jportal_title');
		$this->data['jportal_title'] = $this->config->get('jportal_title');

		$this->data['text_module'] = $this->language->get('text_module');

		$this->data['text_latest'] = $this->language->get('text_latest');
		$this->data['text_best_sellers'] = $this->language->get('text_best_sellers');
		$this->data['text_featured'] = $this->language->get('text_featured');
		$this->data['text_stores'] = $this->language->get('text_stores');
		$this->data['text_customers'] = $this->language->get('text_customers');
		$this->data['text_brands'] = $this->language->get('text_brands');
		
		$this->data['entry_jportal_status'] = $this->language->get('entry_jportal_status');
		$this->data['entry_jportal_position'] = $this->language->get('entry_jportal_position');
		$this->data['entry_jportal_sort_order'] = $this->language->get('entry_jportal_sort_order');

		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_enabled'] = $this->language->get('entry_enabled');
		$this->data['entry_disabled'] = $this->language->get('entry_disabled');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=module/jportal&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=module/jportal&token=' . $this->session->data['token'];
		
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token'];

		if (isset($this->request->post['jportal_status'])) {
			$this->data['jportal_status'] = $this->request->post['jportal_status'];
		} else {
			$this->data['jportal_status'] = $this->config->get('jportal_status');
		}
		
		$this->data['positions'] = array();
		
		/* Right Now only supports Home position :: JT
		$this->data['positions'][] = array(
			'position' => 'left',
			'title'    => $this->language->get('text_left'),
		);
		
		$this->data['positions'][] = array(
			'position' => 'right',
			'title'    => $this->language->get('text_right'),
		);
		*/
		
		$this->data['positions'][] = array(
			'position' => 'home',
			'title'    => $this->language->get('text_home'),
		);
		
		// ----------------------------
		
		if (isset($this->request->post['jportal_position'])) {
			$this->data['jportal_position'] = $this->request->post['jportal_position'];
		} else {
			$this->data['jportal_position'] = $this->config->get('jportal_position');
		}

		if (isset($this->request->post['jportal_sort_order'])) {
			$this->data['jportal_sort_order'] = $this->request->post['jportal_sort_order'];
		} else {
			$this->data['jportal_sort_order'] = $this->config->get('jportal_sort_order');
		}
		
		// ---------------------------
		
		if (isset($this->request->post['jp_latest_status'])) {
			$this->data['jp_latest_status'] = $this->request->post['jp_latest_status'];
		} else {
			$this->data['jp_latest_status'] = $this->config->get('jp_latest_status');
		}

		if (isset($this->request->post['jp_latest_limit'])) {
			$this->data['jp_latest_limit'] = $this->request->post['jp_latest_limit'];
		} else {
			$this->data['jp_latest_limit'] = $this->config->get('jp_latest_limit');
		}
		
		if (isset($this->request->post['jp_latest_sort_order'])) {
			$this->data['jp_latest_sort_order'] = $this->request->post['jp_latest_sort_order'];
		} else {
			$this->data['jp_latest_sort_order'] = $this->config->get('jp_latest_sort_order');
		}	
		
		// ----------------------------

		if (isset($this->request->post['jp_best_sellers_status'])) {
			$this->data['jp_best_sellers_status'] = $this->request->post['jp_best_sellers_status'];
		} else {
			$this->data['jp_best_sellers_status'] = $this->config->get('jp_best_sellers_status');
		}

		if (isset($this->request->post['jp_best_sellers_limit'])) {
			$this->data['jp_best_sellers_limit'] = $this->request->post['jp_best_sellers_limit'];
		} else {
			$this->data['jp_best_sellers_limit'] = $this->config->get('jp_best_sellers_limit');
		}

		if (isset($this->request->post['jp_best_sellers_sort_order'])) {
			$this->data['jp_best_sellers_sort_order'] = $this->request->post['jp_best_sellers_sort_order'];
		} else {
			$this->data['jp_best_sellers_sort_order'] = $this->config->get('jp_best_sellers_sort_order');
		}
		
		// ----------------------------

		if (isset($this->request->post['jp_featured_status'])) {
			$this->data['jp_featured_status'] = $this->request->post['jp_featured_status'];
		} else {
			$this->data['jp_featured_status'] = $this->config->get('jp_featured_status');
		}

		if (isset($this->request->post['jp_featured_limit'])) {
			$this->data['jp_featured_limit'] = $this->request->post['jp_featured_limit'];
		} else {
			$this->data['jp_featured_limit'] = $this->config->get('jp_featured_limit');
		}

		if (isset($this->request->post['jp_featured_sort_order'])) {
			$this->data['jp_featured_sort_order'] = $this->request->post['jp_featured_sort_order'];
		} else {
			$this->data['jp_featured_sort_order'] = $this->config->get('jp_featured_sort_order');
		}
		
		
		// ----------------------------

		if (isset($this->request->post['jp_customers_status'])) {
			$this->data['jp_customers_status'] = $this->request->post['jp_customers_status'];
		} else {
			$this->data['jp_customers_status'] = $this->config->get('jp_customers_status');
		}

		if (isset($this->request->post['jp_customers_limit'])) {
			$this->data['jp_customers_limit'] = $this->request->post['jp_customers_limit'];
		} else {
			$this->data['jp_customers_limit'] = $this->config->get('jp_customers_limit');
		}

		if (isset($this->request->post['jp_customers_sort_order'])) {
			$this->data['jp_customers_sort_order'] = $this->request->post['jp_customers_sort_order'];
		} else {
			$this->data['jp_customers_sort_order'] = $this->config->get('jp_customers_sort_order');
		}
		
		// ----------------------------

		if (isset($this->request->post['jp_stores_status'])) {
			$this->data['jp_stores_status'] = $this->request->post['jp_stores_status'];
		} else {
			$this->data['jp_stores_status'] = $this->config->get('jp_stores_status');
		}
		
		if (isset($this->request->post['jp_stores_limit'])) {
			$this->data['jp_stores_limit'] = $this->request->post['jp_stores_limit'];
		} else {
			$this->data['jp_stores_limit'] = $this->config->get('jp_stores_limit');
		}

		if (isset($this->request->post['jp_stores_sort_order'])) {
			$this->data['jp_stores_sort_order'] = $this->request->post['jp_stores_sort_order'];
		} else {
			$this->data['jp_stores_sort_order'] = $this->config->get('jp_stores_sort_order');
		}

		// ----------------------------

		if (isset($this->request->post['jp_brands_status'])) {
			$this->data['jp_brands_status'] = $this->request->post['jp_brands_status'];
		} else {
			$this->data['jp_brands_status'] = $this->config->get('jp_brands_status');
		}

		if (isset($this->request->post['jp_brands_limit'])) {
			$this->data['jp_brands_limit'] = $this->request->post['jp_brands_limit'];
		} else {
			$this->data['jp_brands_limit'] = $this->config->get('jp_brands_limit');
		}
		
		if (isset($this->request->post['jp_brands_sort_order'])) {
			$this->data['jp_brands_sort_order'] = $this->request->post['jp_brands_sort_order'];
		} else {
			$this->data['jp_brands_sort_order'] = $this->config->get('jp_brands_sort_order');
		}
			
		
		$this->template = 'module/jportal.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/jportal')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>