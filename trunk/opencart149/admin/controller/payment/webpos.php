<?php
/*
  $Id: OPENCART WEBPOS PRO V.1.0

  Webpos Pro, Open Source E-Commerce Payment Solutions

  Coded by Yavuz Yasin Düzgün (duzgun)
  Copyright (c) http://www.duzgun.com , http://www.opencart.com.tr

  Released under the GNU General Public License
*/
class ControllerPaymentWebpos extends Controller {
	private $error = array(); 

	public function index() { 
		$this->load->language('payment/webpos');

		$this->document->title = $this->language->get('heading_title');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('webpos', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
            /*
            if (isset($this->request->post['webpos_status'])) {
			    $this->load->model('setting/webpos');
                if($this->request->post['webpos_status']=="1"){
                    $this->model_setting_webpos->install();
                } else {
                    $this->model_setting_webpos->uninstall();
                }
		    }
            */
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
				
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		
		
		/*webpos begin*/
		$this->data['entry_webpos_mode'] = $this->language->get('entry_webpos_mode');
		$this->data['entry_webpos_cc_apis'] = $this->language->get('entry_webpos_cc_apis');
		$this->data['entry_webpos_cc_3dsecure_apis'] = $this->language->get('entry_webpos_cc_3dsecure_apis');
		$this->data['entry_webpos_cc_other_id'] = $this->language->get('entry_webpos_cc_other_id');
		$this->data['entry_webpos_cc_taksit'] = $this->language->get('entry_webpos_cc_taksit');
		$this->data['entry_webpos_taksit_tax'] = $this->language->get('entry_webpos_taksit_tax');
		$this->data['entry_webpos_without_ototal'] = $this->language->get('entry_webpos_without_ototal');
		$this->data['entry_webpos_select_version'] = $this->language->get('entry_webpos_select_version');
		$this->data['entry_webpos_firend_price'] = $this->language->get('entry_webpos_firend_price');
		$this->data['entry_webpos_currency_convert'] = $this->language->get('entry_webpos_currency_convert');
		$this->data['entry_webpos_cc_numpad'] = $this->language->get('entry_webpos_cc_numpad');
		$this->data['entry_webpos_cc_models'] = $this->language->get('entry_webpos_cc_models');
		$this->data['entry_webpos_mode_real'] = $this->language->get('entry_webpos_mode_real');
		$this->data['entry_webpos_mode_test'] = $this->language->get('entry_webpos_mode_test');
		$this->data['text_none'] = $this->language->get('text_none');
        $this->data['entry_webpos_cc_debug'] = $this->language->get('entry_webpos_cc_debug');
        $this->data['entry_webpos_taksit_tax_default'] = $this->language->get('entry_webpos_taksit_tax_default');
		/*webpos end*/

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
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=payment/webpos&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/webpos&token=' . $this->session->data['token'];

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];	
		
		if (isset($this->request->post['webpos_order_status_id'])) {
			$this->data['webpos_order_status_id'] = $this->request->post['webpos_order_status_id'];
		} else {
			$this->data['webpos_order_status_id'] = $this->config->get('webpos_order_status_id');
		} 
		
		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['webpos_geo_zone_id'])) {
			$this->data['webpos_geo_zone_id'] = $this->request->post['webpos_geo_zone_id'];
		} else {
			$this->data['webpos_geo_zone_id'] = $this->config->get('webpos_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['webpos_status'])) {
			$this->data['webpos_status'] = $this->request->post['webpos_status'];
		} else {
			$this->data['webpos_status'] = $this->config->get('webpos_status');
		}

		if (isset($this->request->post['webpos_sort_order'])) {
			$this->data['webpos_sort_order'] = $this->request->post['webpos_sort_order'];
		} else {
			$this->data['webpos_sort_order'] = $this->config->get('webpos_sort_order');
		}

		/*webpos begin*/
		
		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/currency');

		$this->data['currencies'] = $this->model_localisation_currency->getCurrencies();
		
		
		if (isset($this->request->post['webpos_mode'])) {
			$this->data['webpos_mode'] = $this->request->post['webpos_mode'];
		} else {
			$this->data['webpos_mode'] = $this->config->get('webpos_mode');
		}
		if (isset($this->request->post['webpos_cc_apis'])) {
			$this->data['webpos_cc_apis'] = $this->request->post['webpos_cc_apis'];
		} else {
			$this->data['webpos_cc_apis'] = $this->config->get('webpos_cc_apis');
		}
		if (isset($this->request->post['webpos_cc_3dsecure_apis'])) {
			$this->data['webpos_cc_3dsecure_apis'] = $this->request->post['webpos_cc_3dsecure_apis'];
		} else {
			$this->data['webpos_cc_3dsecure_apis'] = $this->config->get('webpos_cc_3dsecure_apis');
		}
		if (isset($this->request->post['webpos_cc_other_id'])) {
			$this->data['webpos_cc_other_id'] = $this->request->post['webpos_cc_other_id'];
		} else {
			$this->data['webpos_cc_other_id'] = $this->config->get('webpos_cc_other_id');
		}
		if (isset($this->request->post['webpos_cc_taksit'])) {
			$this->data['webpos_cc_taksit'] = $this->request->post['webpos_cc_taksit'];
		} else {
			$this->data['webpos_cc_taksit'] = $this->config->get('webpos_cc_taksit');
		}
		if (isset($this->request->post['webpos_taksit_tax'])) {
			$this->data['webpos_taksit_tax'] = $this->request->post['webpos_taksit_tax'];
		} else {
			$this->data['webpos_taksit_tax'] = $this->config->get('webpos_taksit_tax');
		}
		if (isset($this->request->post['webpos_currency_convert'])) {
			$this->data['webpos_currency_convert'] = $this->request->post['webpos_currency_convert'];
		} else {
			$this->data['webpos_currency_convert'] = $this->config->get('webpos_currency_convert');
		}
		if (isset($this->request->post['webpos_cc_numpad'])) {
			$this->data['webpos_cc_numpad'] = $this->request->post['webpos_cc_numpad'];
		} else {
			$this->data['webpos_cc_numpad'] = $this->config->get('webpos_cc_numpad');
		}
		if (isset($this->request->post['webpos_cc_models'])) {
			$this->data['webpos_cc_models'] = $this->request->post['webpos_cc_models'];
		} else {
			$this->data['webpos_cc_models'] = $this->config->get('webpos_cc_models');
		}
        if (isset($this->request->post['webpos_cc_debug'])) {
			$this->data['webpos_cc_debug'] = $this->request->post['webpos_cc_debug'];
		} else {
			$this->data['webpos_cc_debug'] = $this->config->get('webpos_cc_debug');
		}
		/*webpos end*/
		
		$this->template = 'payment/webpos.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/webpos')) {
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