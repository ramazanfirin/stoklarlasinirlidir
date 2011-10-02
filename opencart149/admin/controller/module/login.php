<?php
class ControllerModuleLogin extends Controller {
	private $error = array(); 
	
	public function index() {
		if (!isset($this->session->data['token'])) {
			$this->session->data['token'] = 0;
		}		
		$this->data['token'] = $this->session->data['token'];
	
		$this->load->language('module/login');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('login', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect((((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=extension/module'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right');
		
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=extension/module'),
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=module/login'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=module/login');
		
		$this->data['cancel'] = (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=extension/module');
		
		if (isset($this->request->post['login_position'])) {
			$this->data['login_position'] = $this->request->post['login_position'];
		} else {
			$this->data['login_position'] = $this->config->get('login_position');
		}
		
		if (isset($this->request->post['login_status'])) {
			$this->data['login_status'] = $this->request->post['login_status'];
		} else {
			$this->data['login_status'] = $this->config->get('login_status');
		}
		
		if (isset($this->request->post['login_sort_order'])) {
			$this->data['login_sort_order'] = $this->request->post['login_sort_order'];
		} else {
			$this->data['login_sort_order'] = $this->config->get('login_sort_order');
		}				
		
		$this->id       = 'content';
		$this->template = 'module/login.tpl';
		if (file_exists(DIR_SYSTEM . 'engine/action.php')) { //v1.4.0
            $this->children = array(
                'common/header',
                'common/footer'
            );
            $this->response->setOutput($this->render(TRUE));
        } elseif ($this->config->get('config_guest_checkout') != null) { //v1.3.4
            $this->children = array(
                'common/header',
                'common/menu',
                'common/footer'
            );
            $this->response->setOutput($this->render(TRUE));
        } else { //v1.3.2 or less
            $this->layout   = 'common/layout';
            $this->render();
        }
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/login')) {
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