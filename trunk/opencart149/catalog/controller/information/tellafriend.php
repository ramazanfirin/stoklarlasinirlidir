<?php
class ControllerInformationTellafriend extends Controller {
	private $error = array(); 

	public function index() {
		$this->language->load('information/tellafriend');
    	$this->document->title = $this->language->get('heading_title');  

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('catalog/tellafriend');
			$this->model_catalog_tellafriend->sendMail($this->request->post);
			$this->data['thanks'] = TRUE;
		}

		$this->document->breadcrumbs = array();
		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=common/home',
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		);
		$this->document->breadcrumbs[] = array(
			'href'      => HTTP_SERVER . 'index.php?route=information/tellafriend',
			'text'      => $this->language->get('heading_title'),
			'separator' => $this->language->get('text_separator')
		);
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_tell_friends'] = $this->language->get('text_tell_friends');
		$this->data['text_enter_friend'] = $this->language->get('text_enter_friend');
		$this->data['text_message'] = $this->language->get('text_message');
		$this->data['text_addresses'] = $this->language->get('text_addresses');
		$this->data['text_click'] = $this->language->get('text_click');
    	$this->data['text_thanks'] = $this->language->get('text_thanks');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_friend'] = $this->language->get('entry_friend');
    	$this->data['button_add_friend'] = $this->language->get('button_add_friend');
    	$this->data['button_remove'] = $this->language->get('button_remove');
    	$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['continue'] = HTTP_SERVER . 'index.php?route=common/home';

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}
		if (isset($this->error['friend'])) {
			$this->data['error_friend'] = $this->error['friend'];
		} else {
			$this->data['error_friend'] = '';
		}

		$this->data['action'] = HTTP_SERVER . 'index.php?route=information/tellafriend';

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} else {
			$this->data['name'] = '';
		}
		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}
		if (isset($this->request->post['friend'])) {
			$this->data['friend'] = $this->request->post['friend'];
		} else {
			$this->data['friend'] = '';
		}
		if (isset($this->request->post['friends'])) {
			$this->data['friends'] = $this->request->post['friends'];
		} else {
			$this->data['friends'] = array();
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/tellafriend.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/tellafriend.tpl';
		} else {
			$this->template = 'default/template/information/tellafriend.tpl';
		}
		$this->children = array(
			'common/header',
			'common/footer',
			'common/column_left',
			'common/column_right'
		);
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->request->post['name']) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!preg_match(EMAIL_PATTERN, $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (!$this->request->post['friend']) {
			$this->error['friend'] = $this->language->get('error_friend');
		} elseif (!preg_match(EMAIL_PATTERN, $this->request->post['friend'])) {
			$this->error['friend'] = $this->language->get('error_email');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>