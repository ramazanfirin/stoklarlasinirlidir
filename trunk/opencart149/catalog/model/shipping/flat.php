<?php
class ModelShippingFlat extends Model {
	function getQuote($address) {
		$this->load->language('shipping/flat');

		if ($this->config->get('flat_status')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('flat_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

      		if (!$this->config->get('flat_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
        		$status = TRUE;
      		} else {
        		$status = FALSE;
      		}
		} else {
			$status = FALSE;
		}

		// If any products in the cart are not eligible for this shipping, then don't show free shipping option
		if ($this->config->get('flat_product')) {
			$products = unserialize($this->config->get('flat_product'));

			foreach ($this->cart->getProducts() as $product) {
				if (!in_array($product['product_id'], $products)) {
					if ($this->config->get('flat_inclusive')) {
						$status = false;
						break;
					} else {
						$status = true;
					}
				} else {
					if ($this->config->get('flat_inclusive')) {
						$status = true;
					} else {
						$status = false;
						break;
					}
				}
			}
		}

		$method_data = array();

		if ($status) {
			$quote_data = array();

      		$quote_data['flat'] = array(
        		'id'           => 'flat.flat',
        		'title'        => $this->language->get('text_description'),
        		'cost'         => $this->config->get('flat_cost'),
        		'tax_class_id' => $this->config->get('flat_tax_class_id'),
				'text'         => $this->currency->format($this->tax->calculate($this->config->get('flat_cost'), $this->config->get('flat_tax_class_id'), $this->config->get('config_tax')))
      		);

      		$method_data = array(
        		'id'         => 'flat',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('flat_sort_order'),
        		'error'      => FALSE
      		);
		}

		return $method_data;
	}
}
?>