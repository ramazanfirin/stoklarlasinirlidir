<?php
class ControllerCatalogCustomerSupport extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('catalog/customer_support');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/customer_support');
		
		$this->getList();
	} 

	private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cs.customer_support_id';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=catalog/customer_support&token=' . $this->session->data['token'] . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		$this->data['delete'] = HTTPS_SERVER . 'index.php?route=catalog/customer_support/delete&token=' . $this->session->data['token'] . $url;	

		$this->data['customer_supports'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$customer_support_total = $this->model_catalog_customer_support->getTotalCustomerSupports();
	
		$results = $this->model_catalog_customer_support->getCustomerSupports($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=catalog/customer_support/update&token=' . $this->session->data['token'] . '&customer_support_id=' . $result['customer_support_id'] . $url
			);
						
			$this->data['customer_supports'][] = array(
				'customer_support_id'  	=> $result['customer_support_id'],
				'store_id'       		=> $result['store_id'],
				'store_name'       		=> $result['store_name'],
				'customer_support_1st_category'     		=> $result['customer_support_1st_category'],
				'customer_support_2nd_category'     		=> $result['customer_support_2nd_category'],
				'customer_id'     		=> $result['customer_id'],
				'firstname'     		=> $result['firstname'],
				'lastname'     			=> $result['lastname'],
				'subject'     			=> $result['subject'],
				'enquiry'     			=> $result['enquiry'],
				'answer'     			=> $result['answer'],
				'date_added' 			=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_answer' 			=> date($this->language->get('date_format_short'), strtotime($result['date_answer'])),
				'selected'   			=> isset($this->request->post['selected']) && in_array($result['customer_support_id'], $this->request->post['selected']),
				'action'     			=> $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_not_answered'] = $this->language->get('text_not_answered');

		$this->data['column_no'] 			= $this->language->get('column_no');
		$this->data['column_store'] 		= $this->language->get('column_store');
		$this->data['column_1st_category'] 		= $this->language->get('column_1st_category');
		$this->data['column_2nd_category'] 		= $this->language->get('column_2nd_category');
		$this->data['column_customer'] 		= $this->language->get('column_customer');
		$this->data['column_subject'] 		= $this->language->get('column_subject');
		$this->data['column_enquiry'] 		= $this->language->get('column_enquiry');
		$this->data['column_answer'] 		= $this->language->get('column_answer');
		$this->data['column_date_added'] 	= $this->language->get('column_date_added');
		$this->data['column_date_answer'] 	= $this->language->get('column_date_answer');
		$this->data['column_action'] 		= $this->language->get('column_action');		
		
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_manage_category'] = $this->language->get('button_manage_category');
 
		$this->data['manage_category'] = HTTPS_SERVER . 'index.php?route=catalog/customer_support_category&token=' . $this->session->data['token'];
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$pagination 			= new Pagination();
		$pagination->total 		= $customer_support_total;
		$pagination->page 		= $page;
		$pagination->limit 		= $this->config->get('config_admin_limit');
		$pagination->text 		= $this->language->get('text_pagination');
		$pagination->url 		= HTTPS_SERVER . 'index.php?route=catalog/customer_support&token=' . $this->session->data['token'] . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/customer_support_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	public function update() {
		$this->load->language('catalog/customer_support');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/customer_support');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_customer_support->editCustomerSupport($this->request->get['customer_support_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
						
			$this->redirect(HTTPS_SERVER . 'index.php?route=catalog/customer_support&token=' . $this->session->data['token'] . $url);
		}

		$this->getForm();
	}

	public function delete() { 
		$this->load->language('catalog/customer_support');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/customer_support');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $customer_support_id) {
				$this->model_catalog_customer_support->deleteCustomerSupport($customer_support_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
						
			$this->redirect(HTTPS_SERVER . 'index.php?route=catalog/customer_support&token=' . $this->session->data['token'] . $url);
		}

		$this->getList();
	}
	
	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_no'] = $this->language->get('entry_no');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_1st_category'] = $this->language->get('entry_1st_category');
		$this->data['entry_2nd_category'] = $this->language->get('entry_2nd_category');
		$this->data['entry_customer'] = $this->language->get('entry_customer');
		$this->data['entry_subject'] = $this->language->get('entry_subject');
		$this->data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$this->data['entry_answer'] = $this->language->get('entry_answer');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
 		
		if (isset($this->error['answer'])) {
			$this->data['error_answer'] = $this->error['answer'];
		} else {
			$this->data['error_answer'] = '';
		}

		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
   		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=catalog/customer_support&token=' . $this->session->data['token'] . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
										
		if (!isset($this->request->get['customer_support_id'])) { 
			die;
		} else {
			$this->data['action'] = HTTPS_SERVER . 'index.php?route=catalog/customer_support/update&token=' . $this->session->data['token'] . '&customer_support_id=' . $this->request->get['customer_support_id'] . $url;
		}
		
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=catalog/customer_support&token=' . $this->session->data['token'] . $url;

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['customer_support_id'])) {
			$customer_support_info = $this->model_catalog_customer_support->getCustomerSupport($this->request->get['customer_support_id']);
		}
		
				
		$this->data['customer_support_id'] 	= $customer_support_info['customer_support_id'];
		$this->data['store_id'] 			= $customer_support_info['store_id'];
		$this->data['store_name'] 			= $customer_support_info['store_name'] ? $customer_support_info['store_name'] : $this->config->get('config_name');
		$this->data['customer_support_1st_category'] 			= $customer_support_info['customer_support_1st_category'];
		$this->data['customer_support_2nd_category'] 			= $customer_support_info['customer_support_2nd_category'];
		$this->data['customer_id'] 			= $customer_support_info['customer_id'];
		$this->data['firstname'] 			= $customer_support_info['firstname'];
		$this->data['lastname'] 			= $customer_support_info['lastname'];
		$this->data['subject'] 				= $customer_support_info['subject'];
		$this->data['enquiry'] 				= $customer_support_info['enquiry'];
		$this->data['date_added'] 			= $customer_support_info['date_added'];
		$this->data['date_answer'] 			= $customer_support_info['date_answer'];
		
		if (isset($this->request->post['answer'])) {
			$this->data['answer'] = $this->request->post['answer'];
		} elseif (isset($customer_support_info)) {
			$this->data['answer'] = $customer_support_info['answer'];
		} else {
			$this->data['answer'] = '';
		}
		
		$this->template = 'catalog/customer_support_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/customer_support')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['answer']) {
			$this->error['answer'] = $this->language->get('error_answer');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/customer_support')) {
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