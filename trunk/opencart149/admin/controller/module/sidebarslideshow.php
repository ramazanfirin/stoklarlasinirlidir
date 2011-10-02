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
class ControllerModuleSideBarSlideshow extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/sidebarslideshow');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('sidebarslideshow', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect(HTTPS_SERVER .'index.php?token=' . $this->session->data['token'] . '&route=extension/module');
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right');
		
		$this->data['entry_version_status'] = $this->language->get('entry_version_status');
		$this->data['entry_author'] = $this->language->get('entry_author');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_time'] = $this->language->get('entry_time');
		$this->data['entry_time2'] = $this->language->get('entry_time2');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

 	    $this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['time'])) {
			$this->data['error_time'] = $this->error['time'];
		} else {
			$this->data['error_time'] = '';
		}

		if (isset($this->error['sort'])) {
			$this->data['error_sort'] = $this->error['sort'];
		} else {
			$this->data['error_sort'] = '';
		}

		if (isset($this->error['limit'])) {
			$this->data['error_limit'] = $this->error['limit'];
		} else {
			$this->data['error_limit'] = '';
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
       		'href'      => HTTPS_SERVER .'index.php?token=' . $this->session->data['token'] . '&route=module/sidebarslideshow',
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = HTTPS_SERVER .'index.php?token=' . $this->session->data['token'] . '&route=module/sidebarslideshow';
		
		$this->data['cancel'] = HTTPS_SERVER .'index.php?token=' . $this->session->data['token'] . '&route=extension/module';

		if (isset($this->request->post['sidebarslideshow_limit'])) {
			$this->data['sidebarslideshow_limit'] = $this->request->post['sidebarslideshow_limit'];
		} else {
			$this->data['sidebarslideshow_limit'] = $this->config->get('sidebarslideshow_limit');
		}	

		if (isset($this->request->post['sidebarslideshow_time2'])) {
			$this->data['sidebarslideshow_time2'] = $this->request->post['sidebarslideshow_time2'];
		} else {
			$this->data['sidebarslideshow_time2'] = $this->config->get('sidebarslideshow_time2');
		}	
		
		if (isset($this->request->post['sidebarslideshow_position'])) {
			$this->data['sidebarslideshow_position'] = $this->request->post['sidebarslideshow_position'];
		} else {
			$this->data['sidebarslideshow_position'] = $this->config->get('sidebarslideshow_position');
		}
		
		if (isset($this->request->post['sidebarslideshow_status'])) {
			$this->data['sidebarslideshow_status'] = $this->request->post['sidebarslideshow_status'];
		} else {
			$this->data['sidebarslideshow_status'] = $this->config->get('sidebarslideshow_status');
		}
		
		if (isset($this->request->post['sidebarslideshow_sort_order'])) {
			$this->data['sidebarslideshow_sort_order'] = $this->request->post['sidebarslideshow_sort_order'];
		} else {
			$this->data['sidebarslideshow_sort_order'] = $this->config->get('sidebarslideshow_sort_order');
		}				
		
		$this->template = 'module/sidebarslideshow.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/sidebarslideshow')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		if (!$this->request->post['sidebarslideshow_time2']) {
			$this->error['time'] = $this->language->get('error_time');
		}
		if (!$this->request->post['sidebarslideshow_limit']) {
			$this->error['limit'] = $this->language->get('error_limit');
		}
		if (!$this->request->post['sidebarslideshow_sort_order']) {
			$this->error['sort'] = $this->language->get('error_sort_order');
		}

		

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>