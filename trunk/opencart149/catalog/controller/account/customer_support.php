<?php
class ControllerAccountCustomerSupport extends Controller {	
	private $error = array(); 
	
	public function index() {
    	if (!$this->customer->isLogged()) {
      		$this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=account/customer_support';

	  		$this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
    	}
    	
    	$this->language->load('account/customer_support');
    	
    	$this->document->title = $this->language->get('heading_title');

      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTPS_SERVER . 'index.php?route=account/account',
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTPS_SERVER . 'index.php?route=account/customer_support',
        	'text'      => $this->language->get('text_customer_support'),
        	'separator' => $this->language->get('text_separator')
      	);
      	
      	$this->data['heading_title'] = $this->language->get('heading_title');
      	
      	$this->data['button_enquiry'] = $this->language->get('button_enquiry');
      	$this->data['button_delete'] = $this->language->get('button_delete');
      	$this->data['button_submit'] = $this->language->get('button_submit');
      	
      	$this->data['column_no'] = $this->language->get('column_no');
      	$this->data['column_subject'] = $this->language->get('column_subject');
      	$this->data['column_created_at'] = $this->language->get('column_created_at');
      	$this->data['column_answer'] = $this->language->get('column_answer');
      	$this->data['column_answered'] = $this->language->get('column_answered');
      	$this->data['column_enquiry'] = $this->language->get('column_enquiry');
      	$this->data['column_category_1st'] = $this->language->get('column_category_1st');
      	$this->data['column_category_2nd'] = $this->language->get('column_category_2nd');
      	$this->data['column_action'] = $this->language->get('column_action');
      	
      	$this->data['text_answer_y'] = $this->language->get('text_answer_y');
      	$this->data['text_answer_n'] = $this->language->get('text_answer_n');
      	$this->data['text_no_answer'] = $this->language->get('text_no_answer');
      	$this->data['text_answer_date'] = $this->language->get('text_answer_date');
      	$this->data['text_enquiry_date'] = $this->language->get('text_enquiry_date');
      	$this->data['text_wait'] = $this->language->get('text_wait');
      	$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');
      	$this->data['text_no_results'] = $this->language->get('text_no_results');
      	$this->data['text_none'] = $this->language->get('text_none');
      	
      	$this->data['error_no_subject'] = $this->language->get('error_no_subject');
      	$this->data['error_no_enquiry'] = $this->language->get('error_no_enquiry');
      	
      	$this->data['new_enquiry_action'] = HTTPS_SERVER . 'index.php?route=account/customer_support/new_enquiry';
      	$this->data['delete_enquiry_action'] = HTTPS_SERVER . 'index.php?route=account/customer_support/delete_enquiry';
      	
		$this->load->model('account/customer_support');
      		
		if (isset($this->request->get['page'])) 
		{
			$page = $this->request->get['page'];
		} 
		else 
		{
			$page = 1;
		}

		if (isset($this->request->get['sort'])) 
		{
			$sort = $this->request->get['sort'];
		} 
		else 
		{
			$sort = 'cs.customer_support_id';
		}

		if (isset($this->request->get['order'])) 
		{
			$order = $this->request->get['order'];
		} 
		else 
		{
			$order = 'DESC';
		}
		
		$url = '';
		if (isset($this->request->get['page'])) 
		{
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) 
		{
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) 
		{
			$url .= '&order=' . $this->request->get['order'];
		}
      	$data = array(
      		'customer_id'			 => $this->customer->getId(),	
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$this->data['customer_supports'] = array();

		$customer_support_total = $this->model_account_customer_support->getTotalCustomerSupports($data);
		
		$customer_support_results = $this->model_account_customer_support->getCustomerSupports($data);

		foreach ($customer_support_results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => HTTPS_SERVER . 'index.php?route=account/customer_support/view&customer_support_id=' . $result['customer_support_id'] . $url
			);

			$this->data['customer_supports'][] = array(
				'customer_support_id'   => $result['customer_support_id'],
				'customer_support_1st_category'       		=> $result['customer_support_1st_category'],
				'customer_support_2nd_category'       		=> $result['customer_support_2nd_category'],
				'subject'       		=> $result['subject'],
				'enquiry'     			=> $result['enquiry'],
				'answer'     			=> $result['answer'],
				'date_added' 			=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'time_added' 			=> date($this->language->get('time_format'), strtotime($result['date_added'])),
				'date_answer' 			=> date($this->language->get('date_format_short'), strtotime($result['date_answer'])),
				'time_answer' 			=> date($this->language->get('time_format'), strtotime($result['date_answer'])),
				'action'     			=> $action
			);
		}
		
		$pagination = new Pagination();
		$pagination->total = $customer_support_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=account/customer_support' . $url . '&page={page}';

		$this->data['pagination'] = $pagination->render();
		
		$cs_1st_category = $this->model_account_customer_support->getCustomerSupport1stCategory();
		
		$cs_2nd_category = array();
		
		if(!empty($cs_1st_category))
		{
			$data = array(
				'customer_support_1st_category_id' => $cs_1st_category[0]['customer_support_1st_category_id']
			);
			$cs_2nd_category = $this->model_account_customer_support->getCustomerSupport2ndCategory($data);
		}
		$this->data['cs_1st_category'] = $cs_1st_category;
		$this->data['cs_2nd_category'] = $cs_2nd_category;
      	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/customer_support.tpl')) 
      	{
			$this->template = $this->config->get('config_template') . '/template/account/customer_support.tpl';
		} 
		else 
		{
			$this->template = 'default/template/account/customer_support.tpl';
		}
		$this->children = array(
			'common/column_right',
			'common/footer',
			'common/column_left',
			'common/header'
		);	
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));	
    	
	}
	
	public function new_enquiry() {
		$json = array();
		
		$this->language->load('account/customer_support');
		
		$this->load->model('account/customer_support');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->new_enquiry_validate()) {
			$this->model_account_customer_support->addCustomerSupport($this->request->post);
			
			$json['success'] = $this->language->get('text_success');
		} else {
			$json['error'] = $this->error['message'];
		}	
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	private function new_enquiry_validate() {
		if (!$this->customer->isLogged()) 
		{
			$this->error['message'] = $this->language->get('error_no_login');
    	}
    	
		if ((strlen(utf8_decode($this->request->post['subject'])) < 3) || (strlen(utf8_decode($this->request->post['subject'])) > 250)) 
		{
			$this->error['message'] = $this->language->get('error_no_subject');
		}
		
		if ((strlen(utf8_decode($this->request->post['enquiry'])) < 25) || (strlen(utf8_decode($this->request->post['enquiry'])) > 2000)) 
		{
			$this->error['message'] = $this->language->get('error_no_enquiry');
		}
		
		if(!($this->error)) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
	
	public function delete_enquiry() {
		$json = array();
		
		$this->language->load('account/customer_support');
		
		$this->load->model('account/customer_support');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->delete_enquiry_validate()) {
			$data = array(
				'customer_support_id'	=>	$this->request->post['enquiry_id']
			);
			$this->model_account_customer_support->deleteCustomerSupport($data);
			
			$json['success'] = $this->language->get('text_success_delete');
		} else {
			$json['error'] = $this->error['message'];
		}	
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($json));
	}
	
	private function delete_enquiry_validate(){
		if (!$this->customer->isLogged()) 
		{
			$this->error['message'] = $this->language->get('error_no_login');
    	}
    	
		if (!isset($this->request->post['enquiry_id']) ||  $this->request->post['enquiry_id'] == "") 
		{
			$this->error['message'] = $this->language->get('error_no_enquiry_id');
		}
		
		$data = array(
			'customer_support_id'	=>	$this->request->post['enquiry_id']
		);
		
		$customer_support = $this->model_account_customer_support->getCustomerSupports($data);
		
		if(empty($customer_support))
		{
			$this->error['message'] = $this->language->get('error_not_found_enquiry');	
		}
		else
		{
			$customer_support = $customer_support[0];
			if($customer_support['customer_id'] != $this->customer->getId())
			{
				$this->error['message'] = $this->language->get('error_no_permission');
			}
			if($customer_support['answer'] != "")
			{
				$this->error['message'] = $this->language->get('error_already_answered');
			}
		}
		
		if(!($this->error)) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_2nd_category(){
		if (!$this->customer->isLogged()) 
		{
			$this->error['message'] = $this->language->get('error_no_login');
    	}
    	
    	$this->language->load('account/customer_support');
		
		$this->load->model('account/customer_support');
		
		
		$output = "";
		
		$data = array(
			'customer_support_1st_category_id'	=>	$this->request->get['1st_category']
		);
		
		$cs_2nd_category_result = $this->model_account_customer_support->getCustomerSupport2ndCategory($data);
		
		foreach($cs_2nd_category_result as $result)
		{
			$output .= '<option value="'. $result['customer_support_2nd_category_id']. '"';
			
			if (isset($this->request->get['2nd_category']) && ($this->request->get['2nd_category'] == $result['customer_support_2nd_category_id'])) {
	      		$output .= ' selected="selected"';
	    	}
	
	    	$output .= '>' . $result['customer_support_2nd_category'] . '</option>';
		}
		
		if (!$cs_2nd_category_result) {
			if (isset($this->request->get['2nd_category']) && !$this->request->get['2nd_category']) {
		  		$output .= '<option value="" selected="selected">' . $this->language->get('text_none') . '</option>';
			} else {
				$output .= '<option value="">' . $this->language->get('text_none') . '</option>';
			}
		}
		$this->response->setOutput($output, $this->config->get('config_compression'));
	}
	
}
?>