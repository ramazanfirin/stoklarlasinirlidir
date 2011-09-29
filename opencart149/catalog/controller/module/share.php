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
	private $tmp;
	protected function index() {
		$this->language->load('module/share');

      	$this->data['text'] = html_entity_decode($this->config->get('share_text'));

		$this->data['link'] = html_entity_decode($this->config->get('share_link'));

		if($this->config->get('share_title')!=''){
			$this->data['title'] = html_entity_decode($this->config->get('share_title'));
		}else{
            $this->data['title']=$this->language->get('heading_title');
		}
		
		$this->id = 'share';



			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/share.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/share.tpl';
			} else {
				$this->template = 'default/template/module/share.tpl';
			}

		
		$this->render();
	}
}
?>