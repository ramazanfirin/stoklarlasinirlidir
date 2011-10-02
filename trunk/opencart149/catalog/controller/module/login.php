<?php  
class ControllerModuleLogin extends Controller {
	protected function index() {
		$this->language->load('module/login');

if ($this->customer->isLogged()) {
    $this->data['text_greeting'] = sprintf($this->language->get('text_logged'), $this->customer->getFirstName());
}


      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['entry_email_address'] = $this->language->get('entry_email_address');
		$this->data['entry_password'] = $this->language->get('entry_password');
		
		$this->data['button_login'] = $this->language->get('button_login');
		$this->data['button_logout'] = $this->language->get('button_logout');
		$this->data['button_create'] = $this->language->get('button_create');
		$this->data['text_my_account'] = $this->language->get('text_my_account');
		$this->data['text_my_orders'] = $this->language->get('text_my_orders');
		$this->data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
    	$this->data['text_information'] = $this->language->get('text_information');
    	$this->data['text_password'] = $this->language->get('text_password');
    	$this->data['text_address'] = $this->language->get('text_address');
    	$this->data['text_history'] = $this->language->get('text_history');
    	$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_create'] = $this->language->get('text_create');
		$this->data['text_forgotten'] = $this->language->get('text_forgotten');
		$this->data['text_welcome'] = $this->language->get('text_welcome');

		
		$this->data['action'] = (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?route=account/login');
 		
		$this->id       = 'login';
		//$this->template = $this->config->get('config_template') . 'module/login.tpl';
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/login.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/login.tpl';
        } elseif (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . 'module/login.tpl')) { //v1.3.2
				$this->template = $this->config->get('config_template') . 'module/login.tpl';
		} else {
            $this->template = 'default/template/module/login.tpl';
        }
		
		$this->render();
		
	}
}
?>