<?php
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
class ControllerModuleShare extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/share');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('share', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');

			//ทำการส่งข้อมูล
						
			$this->redirect(HTTPS_SERVER .'index.php?token=' . $this->session->data['token'] . '&route=extension/module');
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right');
		
		$this->data['entry_version_status'] = $this->language->get('entry_version_status');
		$this->data['entry_author'] = $this->language->get('entry_author');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_text'] = $this->language->get('entry_text');
		$this->data['entry_link'] = $this->language->get('entry_link');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
        
		$this->data['token'] = $this->session->data['token'];


 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}
 		if (isset($this->error['text'])) {
			$this->data['error_text'] = $this->error['text'];
		} else {
			$this->data['error_text'] = '';
		}
 		if (isset($this->error['link'])) {
			$this->data['error_link'] = $this->error['link'];
		} else {
			$this->data['error_link'] = '';
		}
		if (isset($this->error['error_sort_order'])) {
			$this->data['error_sort_order'] = $this->error['error_sort_order'];
		} else {
			$this->data['error_sort_order'] = '';
		}
		
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER .'index.php?token=' . $this->session->data['token'] . '&route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER .'index.php?token=' . $this->session->data['token'] . '&route=extension/module',
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER .'index.php?token=' . $this->session->data['token'] . '&route=module/share',
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = HTTPS_SERVER .'index.php?token=' . $this->session->data['token'] . '&route=module/share';
		
		$this->data['cancel'] = HTTPS_SERVER .'index.php?token=' . $this->session->data['token'] . '&route=extension/module';

		if (isset($this->request->post['share_title'])) {
			$this->data['share_title'] = $this->request->post['share_title'];
		} else {
			$this->data['share_title'] = $this->config->get('share_title');
		}	
		if (isset($this->request->post['share_text'])) {
			$this->data['share_text'] = $this->request->post['share_text'];
		} else {
			$this->data['share_text'] = $this->config->get('share_text');
		}	
		if (isset($this->request->post['share_link'])) {
			$this->data['share_link'] = $this->request->post['share_link'];
		} else {
			$this->data['share_link'] = $this->config->get('share_link');
		}	
		
	   $this->data['positions'] = array();
		
		$this->data['positions'][] = array(
			'position' => 'left',
			'title'    => $this->language->get('text_left'),
		);
		
		$this->data['positions'][] = array(
			'position' => 'right',
			'title'    => $this->language->get('text_right'),
		);
		

		if (isset($this->request->post['share_position'])) {
			$this->data['share_position'] = $this->request->post['share_position'];
		} else {
			$this->data['share_position'] = $this->config->get('share_position');
		}
		
		if (isset($this->request->post['share_status'])) {
			$this->data['share_status'] = $this->request->post['share_status'];
		} else {
			$this->data['share_status'] = $this->config->get('share_status');
		}
		
		if (isset($this->request->post['share_sort_order'])) {
			$this->data['share_sort_order'] = $this->request->post['share_sort_order'];
		} else {
			$this->data['share_sort_order'] = $this->config->get('share_sort_order');
		}				
		
		$this->template = 'module/share.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/share')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['share_text']) {
			$this->error['text'] = $this->language->get('error_text');
		}
		if (!$this->request->post['share_title']) {
			$this->error['title'] = $this->language->get('error_title');
		}
		if (!$this->request->post['share_link']) {
			$this->error['link'] = $this->language->get('error_link');
		}
		if (!$this->request->post['share_sort_order']) {
			$this->error['error_sort_order'] = $this->language->get('error_sort_order');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>