<?php

/**
	Jportal can be used to display all the modules (i.e. bestsellers, featured, latest, stores etc.) in one place. This is first release, I hope I'll get many feature requests
	Developer: Jaswant Tak (http://jaswanttak.elance.com)
**/

class ModelJportalJportal extends Model {
	
	public function jpGetAllStores($limit) {
		
		if((int)$this->config->get('config_store_id')== 0)
		{
		    $query = $this->db->query("SELECT store_id, name, url, logo FROM " . DB_PREFIX . "store ORDER BY RAND() LIMIT ". (int)$limit);
	    
			return $query->rows;
		}
		else
			return false;
	}
	
	public function jpGetAllCustomers($limit) {
		
		$customer = $this->cache->get('customer.' . (int)$this->config->get('config_store_id'));
		
		if (!$customer) {
			$query = $this->db->query("SELECT customer_id, store_id, firstname, lastname, email, telephone, status, approved, ip, date_added FROM " . DB_PREFIX . "customer WHERE status = 1 AND approved = 1 AND store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY date_added DESC, RAND() LIMIT ". (int)$limit);
				
			$customer = $query->rows;
		
			$this->cache->set('$customer.' . (int)$this->config->get('config_store_id'), $customer);
		}
				
		return $customer;
	}
	
	public function jpGetManufacturers($limit) {
		$manufacturer = $this->cache->get('manufacturer.' . (int)$this->config->get('config_store_id'));
		
		if (!$manufacturer) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY sort_order, LCASE(m.name) ASC");
	
			$manufacturer = $query->rows;
			
			$this->cache->set('manufacturer.' . (int)$this->config->get('config_store_id'), $manufacturer);
		}
		
		return $manufacturer;
	} 
	
		
	// get the stores details which avail this product
	public function getProductStores($product_id) {
	    $query = $this->db->query("SELECT st.name, st.url, st.logo FROM " . DB_PREFIX . "store st, product_to_store p2s WHERE st.store_id = p2s.store_id AND p2s.product_id = '". (int)$product_id ."'ORDER BY st.name");
	    
	    return $query->rows;
	}
}
?>