<?php
class ModelShippingRoyalMail extends Model {
	function getQuote($address) {
		$this->load->language('shipping/royal_mail');
		
		if ($this->config->get('royal_mail_status')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('royal_mail_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
      		if (!$this->config->get('royal_mail_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
        		$status = TRUE;
      		} else {
        		$status = FALSE;
      		}
		} else {
			$status = FALSE;
		}

		$quote_data = array();
	
		if ($status) {
			$weight = $this->cart->getWeight();
			$sub_total = $this->cart->getSubTotal();
			
			if ($this->config->get('royal_mail_1st_class_standard') && $address['iso_code_2'] == 'GB') {
				$cost = 0;
				$compensation = 0;
				$rates = explode(',', '.1:1.58,.25:1.96,.5:2.48,.75:3.05,1:3.71,1.25:4.90,1.5:5.66,1.75:6.42,2:7.18,4:8.95,6:12.00,8:15.05,10:18.10');
				
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}
				
				$rates = explode(',', '46:0');
				
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $sub_total) {
						if (isset($data[1])) {
							$compensation = $data[1];
						}
				
						break;
					}
				}
				
				if ((float)$cost) {
					$title = $this->language->get('text_1st_class_standard');
					
					if ($this->config->get('royal_mail_display_weight')) {
						$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class')) . ')';
					}
				
					if ($this->config->get('royal_mail_display_insurance') && (float)$compensation) {
						$title .= ' (' . $this->language->get('text_insurance') . ' ' . $this->currency->format($compensation) . ')';
					}		
		
					if ($this->config->get('royal_mail_display_time')) {
						$title .= ' (' . $this->language->get('text_eta') . ')';
					}	
					
					$quote_data['1st_class_standard'] = array(
						'id'           => 'royal_mail.1st_class_standard',
						'title'        => $title,
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('royal_mail_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('royal_mail_tax_class_id'), $this->config->get('config_tax')))
					);
				}
			}
			 
			if ($this->config->get('royal_mail_1st_class_recorded') && $address['iso_code_2'] == 'GB') {
				$cost = 0;
				$compensation = 0;
				$rates = explode(',', '.1:2.35,.25:2.73,.5:3.25,.75:3.82,1:4.48,1.25:5.67,1.5:6.43,1.75:7.19,2:7.95,4:9.72,6:12.77,8:15.82,10:18.87');
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}
				
				$rates = explode(',', '46:0');
				
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $sub_total) {
						if (isset($data[1])) {
							$compensation = $data[1];
						}
				
						break;
					}
				}
				
				if ((float)$cost) {
					$title = $this->language->get('text_1st_class_recorded');
					
					if ($this->config->get('royal_mail_display_weight')) {
						$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class')) . ')';
					}
				
					if ($this->config->get('royal_mail_display_insurance') && (float)$compensation) {
						$title .= ' (' . $this->language->get('text_insurance') . ' ' . $this->currency->format($compensation) . ')';
					}		
		
					if ($this->config->get('royal_mail_display_time')) {
						$title .= ' (' . $this->language->get('text_eta') . ')';
					}	
						
					$quote_data['1st_class_recorded'] = array(
						'id'           => 'royal_mail.1st_class_recorded',
						'title'        => $title,
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('royal_mail_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('royal_mail_tax_class_id'), $this->config->get('config_tax')))
					);
				}
			}

			if ($this->config->get('royal_mail_2nd_class_standard') && $address['iso_code_2'] == 'GB') {
				$cost = 0;
				$rates = explode(',', '.1:1.33,.25:1.72,.5:2.16,.75:2.61,1:3.15');
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}
				
				if ((float)$cost) {
					$title = $this->language->get('text_2nd_class_standard');
					
					if ($this->config->get('royal_mail_display_weight')) {
						$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class')) . ')';
					}
		
					if ($this->config->get('royal_mail_display_time')) {
						$title .= ' (' . $this->language->get('text_eta') . ')';
					}					
					
					$quote_data['2nd_class_standard'] = array(
						'id'           => 'royal_mail.2nd_class_standard',
						'title'        => $title,
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('royal_mail_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('royal_mail_tax_class_id'), $this->config->get('config_tax')))
					);
				}
			}
			
			if ($this->config->get('royal_mail_2nd_class_recorded') && $address['iso_code_2'] == 'GB') {
				$cost = 0;
				$compensation = 0;
				$rates = explode(',', '.1:2.10,.25:2.49,.5:2.93,.75:3.38,1:3.92');
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}
				
				$rates = explode(',', '46:0');
				
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $sub_total) {
						if (isset($data[1])) {
							$compensation = $data[1];
						}
				
						break;
					}
				}
				
				if ((float)$cost) {
					$title = $this->language->get('text_2nd_class_recorded');
					
					if ($this->config->get('royal_mail_display_weight')) {
						$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class')) . ')';
					}
				
					if ($this->config->get('royal_mail_display_insurance') && (float)$compensation) {
						$title .= ' (' . $this->language->get('text_insurance') . ' ' . $this->currency->format($compensation) . ')';
					}		
		
					if ($this->config->get('royal_mail_display_time')) {
						$title .= ' (' . $this->language->get('text_eta') . ')';
					}						
					
					$quote_data['2nd_class_recorded'] = array(
						'id'           => 'royal_mail.2nd_class_recorded',
						'title'        => $title,
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('royal_mail_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('royal_mail_tax_class_id'), $this->config->get('config_tax')))
					);
				}
			}
			
			if ($this->config->get('royal_mail_standard_parcels') && $address['iso_code_2'] == 'GB') {
				$cost = 0;
				$compensation = 0;
				$rates = explode(',', '2:4.41,4:7.62,6:10.34,8:12.67,10:13.61,20:15.86');
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}
				
				$rates = explode(',', '46:0,100:1,250:2.25,500:3.5');
				
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $sub_total) {
						if (isset($data[1])) {
							$compensation = $data[1];
						}
				
						break;
					}
				}				
				
				if ((float)$cost) {
					$title = $this->language->get('text_standard_parcels');
					
					if ($this->config->get('royal_mail_display_weight')) {
						$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class')) . ')';
					}
				
					if ($this->config->get('royal_mail_display_insurance') && (float)$compensation) {
						$title .= ' (' . $this->language->get('text_insurance') . ' ' . $this->currency->format($compensation) . ')';
					}		
		
					if ($this->config->get('royal_mail_display_time')) {
						$title .= ' (' . $this->language->get('text_eta') . ')';
					}						
									
					$quote_data['standard_parcels'] = array(
						'id'           => 'royal_mail.standard_parcels',
						'title'        => $title,
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('royal_mail_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('royal_mail_tax_class_id'), $this->config->get('config_tax')))
					);
				}
			}
			
			if ($this->config->get('royal_mail_airmail')) {
				$cost = 0;
				
				$countries = explode(',', 'AL,AD,AM,AT,AZ,BY,BE,BA,BG,HR,CY,CZ,DK,EE,FO,FI,FR,FX,GE,DE,GI,GR,GL,HU,IS,IE,IT,KZ,KG,LV,LI,LT,LU,MK,MT,MD,MC,NL,NO,PL,PT,RO,RU,SM,SK,SI,ES,SE,CH,TJ,TR,TM,UA,UZ,VA');
				
				if (in_array($address['iso_code_2'], $countries)) {
					$rates = explode(',', '0.01:1.49,0.02:1.49,0.04:1.49,0.06:1.49,0.08:1.49,0.1:1.49,0.12:1.61,0.14:1.79,0.16:1.93,0.18:2.11,0.2:2.19,0.22');
				} else {
					$rates = explode(',', '0.01:2.07,0.02:2.07,0.04:2.07,0.06:2.07,0.08:2.07,0.1:2.07,0.12:2.32,0.14:2.6,0.16:2.9,0.18:3.2,0.2:3.5,0.22');
				}

				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}	
				
				if ((float)$cost) {
					$title = $this->language->get('text_airmail');
					
					if ($this->config->get('royal_mail_display_weight')) {
						$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class')) . ')';
					}
		
					if ($this->config->get('royal_mail_display_time')) {
						$title .= ' (' . $this->language->get('text_eta') . ')';
					}
					
					$quote_data['airmail'] = array(
						'id'           => 'royal_mail.airmail',
						'title'        => $title,
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('royal_mail_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('royal_mail_tax_class_id'), $this->config->get('config_tax')))
					);
				}
			}
			
			if ($this->config->get('royal_mail_international_signed')) {
				$cost = 0;
				$compensation = 0;
				
				$countries = explode(',', 'AD,AL,AM,AT,AZ,BA,BE,BG,BY,CH,CY,CZ,DE,DK,EE,ES,FI,FO,FR,FX,GE,GI,GL,GR,HR,HU,IE,IS,IT,KG,KZ,LI,LT,LU,LV,MC,MD,MK,MT,NL,NO,PL,PT,RO,RU,SE,SI,SK,SM,TJ,TM,TR,UA,UZ,VA');
				
				if (in_array($address['iso_code_2'], $countries)) {
					$rates = explode(',', '0.1:6.44,0.12:6.56,0.14:6.74,0.16:6.88,0.18:7.06,0.2:7.14,0.22:7.24,0.24:7.34,0.26:7.44,0.28:7.51,0.3:7.56,0.4:8.11,0.5:8.66,0.6:9.21,0.7:9.76,0.8:10.31,0.9:10.86,1:11.41,1.1:11.96,1.2:12.51,1.3:13.06,1.4:13.61,1.5:14.16,1.6:14.71,1.7:15.26,1.8:15.81,1.9:16.36,2:16.91');
				} else {
					$rates = explode(',', '0.1:7.02,0.12:7.27,0.14:7.55,0.16:7.85,0.18:8.15,0.2:8.45,0.22:8.75,0.24:8.91,0.26:9.01,0.28:9.11,0.3:9.21,0.4:10.32,0.5:11.43,0.6:12.54,0.7:13.65,0.8:14.76,0.9:15.87,1:16.98,1.1:18.09,1.2:19.2,1.3:20.31,1.4:21.42,1.5:22.53,1.6:23.64,1.7:24.75,1.8:25.86,1.9:26.97,2:28.08');
				}

				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}
				
				if (in_array($address['iso_code_2'], $countries)) {
					$rates = explode(',', '46:0,250:2.20');
				} else {
					$rates = explode(',', '46:0,250:2.50');
				}
				
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $sub_total) {
						if (isset($data[1])) {
							$compensation = $data[1];
						}
				
						break;
					}
				}				
				
				if ((float)$cost) {
					$title = $this->language->get('text_international_signed');
					
					if ($this->config->get('royal_mail_display_weight')) {
						$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class')) . ')';
					}
				
					if ($this->config->get('royal_mail_display_insurance') && (float)$compensation) {
						$title .= ' (' . $this->language->get('text_insurance') . ' ' . $this->currency->format($compensation) . ')';
					}		
		
					if ($this->config->get('royal_mail_display_time')) {
						$title .= ' (' . $this->language->get('text_eta') . ')';
					}	
					
					$quote_data['international_signed'] = array(
						'id'           => 'royal_mail.international_signed',
						'title'        => $title,
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('royal_mail_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('royal_mail_tax_class_id'), $this->config->get('config_tax')))
					);
				}
			}
			
			if ($this->config->get('royal_mail_airsure')) {
				$cost = 0;
				$compensation = 0;
				
				$rates = array();

				$countries = explode(',', 'AT,BE,DE,DK,EE,ES,FI,FR,FX,IE,LU,MC,NL,PT,SE');
				
				if (in_array($address['iso_code_2'], $countries)) {
				     $rates = explode(',', '.1:7.67,.12:7.81,.14:8.03,.16:8.20,.18:8.41,.20:8.51,.22:8.63,.24:8.75,.26:8.87,.28:8.95,.30:9.01,.40:9.67,.50:10.33,.60:10.99,.70:11.65,.80:12.31,.90:12.97,1:13.63,1.1:14.29,1.2:14.95,1.3:15.61,1.4:16.27,1.5:16.93,1.6:17.59,1.7:18.25,1.8:18.91,1.9:19.57,2:20.23');
				}

                //Non-EU European Countries (No Vat)
				$countries = explode(',', 'AD,CH,FO,IS,LI');
				
				if (in_array($address['iso_code_2'], $countries)) {
					$rates = explode(',', '.1:6.79,.12:6.91,.14:7.09,.16:7.23,.18:7.41,.2:7.49,.22:7.59,.24:7.69,.26:7.79,.28:7.86,.3:7.91,.4:8.46,.5:9.01,.6:9.56,.7:10.11,.8:10.66,.9:11.21,1:11.76,1.1:12.31,1.2:12.86,1.3:13.41,1.4:13.96,1.5:14.51,1.6:15.06,1.7:15.61,1.8:16.16,1.9:16.71,2:17.26');				
                } 

				//Non-European Countries (No Vat)
				$countries = explode(',', 'BR,CA,HK,MY,NZ,SG,US');
				
				if (in_array($address['iso_code_2'], $countries)) {
					$rates = explode(',', '.1:7.37,.12:7.62,.14:7.90,.16:8.20,.18:8.50,.2:8.80,.22:9.10,.24:9.26,.26:9.36,.28:9.46,.3:9.56,.4:10.90,.5:12.24,.6:13.58,.7:14.92,.8:16.26,.9:17.60,1:18.94,1.1:20.28,1.2:21.62,1.3:22.96,1.4:24.30,1.5:25.64,1.6:26.98,1.7:28.32,1.8:29.66,1.9:31.00,2:32.34');				
                }
				

				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}
				
				$rates = array();
				
				$countries = explode(',', 'AT,BE,DE,DK,EE,ES,FI,FR,FX,IE,LU,MC,NL,PT,SE');
				
				if (in_array($address['iso_code_2'], $countries)) {
					$rates = explode(',', '46:0,500:3.0');
				} 

				$countries = explode(',', 'AD,CH,FO,IS,LI');
				
				if (in_array($address['iso_code_2'], $countries)) {
					$rates = explode(',', '46:0,500:2.5');
				}
				
				$countries = explode(',', 'BR,CA,HK,MY,NZ,SG,US');
				
				if (in_array($address['iso_code_2'], $countries)) {
					$rates = explode(',', '46:0,500:2.5');
				}				
				
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $sub_total) {
						if (isset($data[1])) {
							$compensation = $data[1];
						}
				
						break;
					}
				}					
				
				if ((float)$cost) {
					$title = $this->language->get('text_airsure');
					
					if ($this->config->get('royal_mail_display_weight')) {
						$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class')) . ')';
					}
				
					if ($this->config->get('royal_mail_display_insurance') && (float)$compensation) {
						$title .= ' (' . $this->language->get('text_insurance') . ' ' . $this->currency->format($compensation) . ')';
					}		
		
					if ($this->config->get('royal_mail_display_time')) {
						$title .= ' (' . $this->language->get('text_eta') . ')';
					}	
					
					$quote_data['airsure'] = array(
						'id'           => 'royal_mail.airsure',
						'title'        => $title,
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('royal_mail_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('royal_mail_tax_class_id'), $this->config->get('config_tax')))
					);
				}
			}
			
			if ($this->config->get('royal_mail_surface')) {
				$cost = 0;
				$compensation = 0;

				$rates = explode(',', '0.1:1.12,0.15:1.5,0.2:1.89,0.25:2.28,0.3:2.64,0.35:3.02,0.4:3.42,0.45:3.79,0.5:4.16,0.55:4.5,0.6:4.84,0.65:5.18,0.7:5.52,0.75:5.86,0.8:6.2,0.85:6.54,0.9:6.88,0.95:7.22,1:7.56,1.05:7.9,1.1:8.24,1.15:8.58,1.2:8.92,1.25:9.26,1.3:9.6,1.35:9.94,1.4:10.28,1.45:10.62,1.5:10.96,1.55:11.3,1.6:11.64,1.65:11.98,1.7:12.32,1.75:12.66,1.8:13,1.85:13.34,1.9:13.68,1.95:14.02,2:14.36');

				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])) {
							$cost = $data[1];
						}
				
						break;
					}
				}
				
				if ((float)$cost) {
					$title = $this->language->get('text_surface');
					
					if ($this->config->get('royal_mail_display_weight')) {
						$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class')) . ')';
					}
				
					if ($this->config->get('royal_mail_display_insurance') && (float)$compensation) {
						$title .= ' (' . $this->language->get('text_insurance') . ' ' . $this->currency->format($compensation) . ')';
					}		
		
					if ($this->config->get('royal_mail_display_time')) {
						$title .= ' (' . $this->language->get('text_eta') . ')';
					}	

					$quote_data['surface'] = array(
						'id'           => 'royal_mail.surface',
						'title'        => $title,
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('royal_mail_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('royal_mail_tax_class_id'), $this->config->get('config_tax')))
					);
				}
			}
		}
		
		$method_data = array();
		
		if ($quote_data) {
			$method_data = array(
				'id'         => 'royal_mail',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('royal_mail_sort_order'),
				'error'      => FALSE
			);
		}
			
		return $method_data;
	}
}
?>