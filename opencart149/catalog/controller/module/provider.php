<?php  
class ControllerModuleProvider extends Controller {
	protected function index() {
		$this->language->load('module/provider');	
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_select'] = $this->language->get('text_select');
		
		$this->load->model('catalog/manufacturer');
		$this->load->model('tool/seo_url');
		//Marka Logolari
		$this->load->model('tool/image'); 
		 
		$this->data['manufacturers'] = array();
				
		$this->data['manufacturers'][0] = array(
				'manufacturer_id' => '500',
				'name'            => 'Arena',
				//Marka logoları resim boyutu
				'preview'         => $this->model_tool_image->resize('data/arena_logo.jpg', 150, 100),
				'href'            => 'www.arena.com.tr'
			);
		
		$this->data['manufacturers'][1] = array(
				'manufacturer_id' => '501',
				'name'            => 'Index Bilgisayar',
				//Marka logolari resim boyutu
				'preview'         => $this->model_tool_image->resize('data/index_logo.jpg', 150, 100),
				'href'            => 'www.index.com.tr'
			);
			
		$this->data['manufacturers'][1] = array(
				'manufacturer_id' => '502',
				'name'            => 'Datagate Bilgisayar',
				//Marka logolari resim boyutu
				'preview'         => $this->model_tool_image->resize('data/datagate_logo.jpg', 150, 100),
				'href'            => 'www.index.com.tr'
			);	
		
		
		$this->data['manufacturers'][1] = array(
				'manufacturer_id' => '503',
				'name'            => 'Exa Bilgisayar',
				//Marka logolari resim boyutu
				'preview'         => $this->model_tool_image->resize('data/exa_logo.jpg', 150, 100),
				'href'            => 'www.index.com.tr'
			);	
	
		$this->id = 'provider';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/provider.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/provider.tpl';
		} else {
			$this->template = 'default/template/module/provider.tpl';
		}
		
		$this->render(); 
	}
}
?>