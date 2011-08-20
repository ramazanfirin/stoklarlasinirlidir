<?php
/*
  $Id: OPENCART WEBPOS PRO V.1.0

  Webpos Pro, Open Source E-Commerce Payment Solutions

  Coded by Yavuz Yasin Düzgün (duzgun)
  Copyright (c) http://www.duzgun.com , http://www.opencart.com.tr

  Released under the GNU General Public License
*/
class ControllerPaymentWebpos extends Controller {
    /*Configurations*/
    private $oos = array('oos_pay','3d_oos_pay','3d_oos_full','3d_oos_half','zrt_oos');
    private $est = array('AKBNK','ISCTR','GABNK','TEBNK','FINBN','HALKB','DENIZ','FORTS','ANDLB','KUVTR');
    private $tds = array("AKBNK"=>"EST3D", "GABNK"=>"EST3D", "GARAN"=>"GRN3D", "ISCTR"=>"EST3D", "TEBNK"=>"EST3D", "FINBN"=>"EST3D", "HALKB"=>"EST3D", "FORTS"=>"EST3D", "ANDLB"=>"EST3D", "DENIZ"=>"EST3D", "YKBNK"=>"YKB3D", "KUVTR"=>"EST3D", "ASYAB"=>"MPI3D");
    /*Caching*/
    private $secure3d = array();
    private $models3d = array();
    private $featured = array();
    private $controls = array();
    /*Functions*/
	protected function index() {
	    $post = HTTPS_SERVER .'api.php'; // user defined

        $this->language->load('payment/webpos');
	    $this->data['webpos_mode'] = $this->config->get('webpos_mode');
        $this->data['webpos_cc_apis'] = $this->config->get('webpos_cc_apis');
        $this->data['webpos_cc_3dsecure_apis'] = $this->config->get('webpos_cc_3dsecure_apis');
        $this->data['webpos_cc_other_id'] = $this->config->get('webpos_cc_other_id');
        $this->data['webpos_cc_taksit'] = $this->config->get('webpos_cc_taksit');
        $this->data['webpos_taksit_tax'] = $this->config->get('webpos_taksit_tax');
        $this->data['webpos_currency_convert'] = $this->config->get('webpos_currency_convert');
        $this->data['webpos_cc_numpad'] = $this->config->get('webpos_cc_numpad');
        $this->data['webpos_cc_models'] = $this->config->get('webpos_cc_models');
        $this->data['webpos_cc_debug'] = $this->config->get('webpos_cc_debug');

        $verified = $this->language->get('TEXT_WEBPOS_TEXT_VERIFIED');
        $this->data['SelectText'] = $this->language->get('TEXT_WEBPOS_CC_SELECT');
        $this->data['OtherText'] = $this->language->get('TEXT_WEBPOS_CC_OTHER');
        $this->data['BankName'] = $this->language->get('TEXT_WEBPOS_CC_BNAME');
        $this->data['TaksitName'] = $this->language->get('TEXT_WEBPOS_CC_TNAME');
        $this->data['TekcekimText'] = $this->language->get('TEXT_WEBPOS_TEXT_TEKCEKIM');
        $this->data['ErrorText'] = $this->language->get('TEXT_WEBPOS_TEXT_ERROR');
        $this->data['ErrorTextCCOwner'] = $this->language->get('TEXT_WEBPOS_TEXT_ERROR_CC_OWNER');
        $this->data['ErrorTextCCNumber'] = $this->language->get('TEXT_WEBPOS_TEXT_ERROR_CC_NUMBER');
        $this->data['ErrorTextCVVNumber'] = $this->language->get('TEXT_WEBPOS_TEXT_ERROR_CVVNUMBER');
        $this->data['OOSWar'] = $this->language->get('TEXT_WEBPOS_OOS_WAR');
        $this->data['CCVWar'] = $this->language->get('TEXT_WEBPOS_CCV_WAR');
        $this->data['LOGO3d'] = $this->language->get('TEXT_WEBPOS_LOGO_3D');
        $this->data['TextOwner'] = $this->language->get('TEXT_WEBPOS_CC_NAMEOWNER');
        $this->data['TextCC'] = $this->language->get('TEXT_WEBPOS_CC_NAMECC');
        $this->data['TextCCDate'] = $this->language->get('TEXT_WEBPOS_CC_NAMECCDATE');
        $this->data['TextCCV'] = $this->language->get('TEXT_WEBPOS_CC_NAMECCV');
        $this->data['TextClear'] = $this->language->get('TEXT_WEBPOS_NUMPAD_CLEAR');

        $this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $this->data['order_info'] = $order_info;
        $email = $order_info['email']; //customers email address
        $store = $order_info['store_name'];
        $fismi = $order_info['payment_firstname']." ".$order_info['payment_lastname'];

        $Control = $this->Control();
        $this->load->library('json');
        $this->data['WebposConfig'] = $Control;
        $this->data['WebposConfigJSON'] = Json::encode($Control);

        $this->data['TDSjs'] = array();
        foreach($Control as $TDSjs)
        {
        if (($TDSjs['3dID'] =='YKB3D') && ($TDSjs['isMODEL']==false))
        {if (!isset($this->data['TDSjs']["YKB3D"]))$this->data['TDSjs']["YKB3D"]= $this->YKB3D($verified,$post);}                   //YKB3D($verified,$post)  //  MODULE_PAYMENT_WEBPOS_TEXT_VERIFIED_VM, $this->form_action_url_api
        else if (($TDSjs['3dID'] =='MPI3D') && ($TDSjs['isMODEL']==false))
        {if (!isset($this->data['TDSjs']["MPI3D"]))$this->data['TDSjs']["MPI3D"]= $this->MPI3D($verified,$post);}                   //MPI3D($verified,$post)   //  MODULE_PAYMENT_WEBPOS_TEXT_VERIFIED_VM, $this->form_action_url_api
        else if (($TDSjs['3dID'] =='GRN3D') && ($TDSjs['isMODEL']==false))
        {if (!isset($this->data['TDSjs']["GRN3D"]))$this->data['TDSjs']["GRN3D"]= $this->GRN3D($verified,$post,$email);}                //GRN3D($verified,$post,$email)   //  MODULE_PAYMENT_WEBPOS_TEXT_VERIFIED_VM, $this->form_action_url_api,(isset($order->customer["email_address"])?$order->customer["email_address"]:STORE_OWNER_EMAIL_ADDRESS)
        else if (($TDSjs['isEST'] ==true) && ($TDSjs['isMODEL']==false))
        {if (!isset($this->data['TDSjs']["EST3D"]))$this->data['TDSjs']["EST3D"]= $this->EST3D($verified,$post);}                        // EST3D($verified,$post) MODULE_PAYMENT_WEBPOS_TEXT_VERIFIED_VM, $this->form_action_url_api
        else if (($TDSjs['isMODEL'] ==true) && ($TDSjs['isEST'] ==true) && ($TDSjs['modelID']=="3d_pay"))
        {if (!isset($this->data['TDSjs']["EST3D_PAY"]))$this->data['TDSjs']["EST3D_PAY"]= $this->EST3D_PAY($verified,$post);}
        else if (($TDSjs['isMODEL'] ==true) && ($TDSjs['3dID'] =='GRN3D') && ($TDSjs['modelID']=="3d_pay"))
        {if (!isset($this->data['TDSjs']["GRN3D"]))$this->data['TDSjs']["GRN3D"]= $this->GRN3D($verified,$post,$email);}
        else if (($TDSjs['isMODEL'] ==true) && ($TDSjs['isEST'] ==true) && ($TDSjs['modelID']=="3d_oos_pay"))
        {if (!isset($this->data['TDSjs']["EST3D_OOS_PAY"]))$this->data['TDSjs']["EST3D_OOS_PAY"]= $this->EST3D_OOS_PAY($verified,$post,$store,$fismi); }
        else if (($TDSjs['isMODEL'] ==true) && ($TDSjs['3dID'] =='GRN3D') && ($TDSjs['modelID']=="3d_oos_pay"))
        {if (!isset($this->data['TDSjs']["GRN3D_OOS_PAY"]))$this->data['TDSjs']["GRN3D_OOS_PAY"]= $this->GRN3D_OOS_PAY($verified,$post,$email,$store);}
        else if (($TDSjs['isMODEL'] ==true) && ($TDSjs['modelID']=="zrt_oos"))
        {if (!isset($this->data['TDSjs']["ZRAAT_OOS"]))$this->data['TDSjs']["ZRAAT_OOS"]= $this->ZRAAT_OOS($verified,$post);}
        }
        if ($Control['isNotOOS'] ==true)
        {if (!isset($this->data['TDSjs']["CLASSIC"]))$this->data['TDSjs']["CLASSIC"]= $this->CLASSIC($verified,$post);}

        $featured = $this->FeatureParse();
        $this->data['Apis'] = $featured;

        $this->data['total'] = $this->currency->format($order_info['total'], $this->data['webpos_currency_convert'], FALSE, FALSE);
        $this->data['totalformat'] = $this->currency->format($order_info['total'], $this->data['webpos_currency_convert'], FALSE, TRUE);

        $this->session->data['webpos']['total'] = $this->data['total']; // iþlem yapýlacak tutar.
        $this->session->data['webpos']['currency'] = $this->data['webpos_currency_convert'];
        $this->session->data['webpos']['cart'] = array($order_info['total'],$order_info['currency']);
        $this->session->data['webpos']['taksit'] = '';

        $this->data['webpos_callback'] = HTTPS_SERVER . 'index.php?route=payment/webpos/callback';

        $this->data['SecureCode'] = $this->SecureCode($this->data['total'],'',$Control['OTHER']['api'],$this->session->data['order_id'],$email);

        //$this->currency->format($this->cart->getSubTotal(), 'TRY', FALSE, FALSE)
        //$this->currency->format($order_info['total'], $this->data['webpos_currency_convert'], FALSE, FALSE),

        //var_dump($this->currency->format($order_info['total'], $this->data['webpos_currency_convert'], FALSE, FALSE));

        //echo $this->language->get('TEXT_WEBPOS_CC_OTHER');


    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['continue'] = HTTPS_SERVER . 'index.php?route=checkout/success';

		if ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
		} else {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}

        $this->session->data['taksit'] = true;


		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/webpos.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/webpos.tpl';
		} else {
			$this->template = 'default/template/payment/webpos.tpl';
		}

		$this->render();
	}

	public function confirm() {
    if (isset($this->session->data['order_id'])) {
    }else
    {
      $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
    }

		$this->load->model('checkout/order');
        //$order_info = $this->model_checkout_order->getOrder($this->request->post['cart_order_id']);
        //$our_total = $this->currency->format($order_info['total'], $order_info['currency'], $order_info['value'], FALSE);
        //$this->session->data['error'] ="hata olustu";
        if($_SESSION['ccencodekey']===1)
        {
		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('webpos_order_status_id'));
        $this->model_checkout_order->update($this->session->data['order_id'], $this->config->get('webpos_order_status_id'), htmlspecialchars_decode($this->request->get['sonuc']), FALSE);
        $this->redirect(HTTPS_SERVER . 'index.php?route=checkout/success');
        }
        unset($_SESSION['ccencodekey']);
           /*	} else {
				$this->session->data['error'] = $data['StatusDetail'];

				if ($this->request->get['route'] != 'checkout/guest_step_3') {
					$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/payment');
				} else {
					$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/guest_step_2');
				}
			}*/
	}

    	public function callback() {

        $this->language->load('payment/webpos');
		$this->language->load('module/cart');
 		$this->load->model('tool/seo_url');
        $this->load->library('json');
        $json = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
        if ((strpos($this->config->get('webpos_cc_apis'),$this->request->post['api'])!==false) && (strpos($this->request->post['taksit'],'x') !== false))
        {
        $api = basename($this->request->post['api']);
        $taksit = (int)substr($this->request->post['taksit'],0,strpos($this->request->post['taksit'],'x'));

        $featured = $this->FeatureParse();
        $this->language->load('checkout/confirm');

        $output2 = '<table width="100%"><tr>
          <th align="left">'.$this->language->get('column_product').'</th>
          <th align="left">'.$this->language->get('column_model').'</th>
          <th align="right">'.$this->language->get('column_quantity').'</th>
          <th align="right">'.$this->language->get('column_price').'</th>
          <th align="right">'.$this->language->get('column_total').'</th>
        </tr>';

		$output = '<table id="tempSelect" cellpadding="2" cellspacing="0" style="width: 100%;">';

		if ($this->cart->getProducts()) {

    		foreach ($this->cart->getProducts() as $product) {
                $output2 .= '<tr><td align="left" valign="top"><a href="' . $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $product['product_id']) . '">'.$product['name'].'</a>';
      			$output .= '<tr>';
        		$output .= '<td width="1" valign="top" align="left"><span class="cart_remove" id="remove_ ' . $product['key'] . '" />&nbsp;</span></td><td width="1" valign="top" align="right">' . $product['quantity'] . '&nbsp;x&nbsp;</td>';
        		$output .= '<td align="left" valign="top"><a href="' . $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $product['product_id']) . '">' . $product['name'] . '</a>';
          		$output .= '<div>';

				foreach ($product['option'] as $option) {
            		$output .= ' - <small style="color: #999;">' . $option['name'] . ' ' . $option['value'] . '</small><br />';
                    $output2 .= '<br />&nbsp;<small> - '.$option['name'].' '.$option['value'].'</small>';


	            }
                $output2 .= '</td><td align="left" valign="top">'.$product['model'].'</td><td align="right" valign="top">'.$product['quantity'].'</td><td align="right" valign="top">'.$this->currency->format($product['price']).'</td><td align="right" valign="top">'.$this->currency->format($product['total']).'</td></tr>';

				$output .= '</div></td>';
				$output .= '</tr>';
      		}

            $output2 .='</table><br />';

			$output .= '</table>';
    		$output .= '<br />';

    		$total = 0;
			$taxes = $this->cart->getTaxes();

			$this->load->model('checkout/extension');

			$sort_order = array();

			$view = HTTP_SERVER . 'index.php?route=checkout/cart';
			$checkout = HTTPS_SERVER . 'index.php?route=checkout/shipping';

			$results = $this->model_checkout_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

            $hesapmakinasi = array();

            $hesapmakinasi['taxes'][0] = $taxes;
            if($featured[$api]['EXTRA'])
            {
            foreach ($featured[$api]['TAKSIT'] as $key=>$val)
            {
            $hesapmakinasi['taxes'][$key]=$taxes;
            }
            }
            $selector = array($api,0,0);
            foreach ($results as $result) {
				$this->load->model('total/' . $result['key']);
                $key=0;$val=0;
                $this->session->data['webpos']['selector'] = array($api,$key,$val);
                $this->{'model_total_' . $result['key']}->getTotal($hesapmakinasi['total_data'][0],$hesapmakinasi['total'][0],$hesapmakinasi['taxes'][0]);
                if($taksit==$key) $selector = $this->session->data['webpos']['selector'];
                if($featured[$api]['EXTRA'])
                {
                    foreach ($featured[$api]['TAKSIT'] as $key=>$val)
                    {
                        $this->session->data['webpos']['selector'] = array($api,$key,$val);
                        if($taksit==$key) $selector = $this->session->data['webpos']['selector'];
                        $this->{'model_total_' . $result['key']}->getTotal($hesapmakinasi['total_data'][$key],$hesapmakinasi['total'][$key],$hesapmakinasi['taxes'][$key]);
                    }
                }
                $this->session->data['webpos']['selector']=array(null,0,0);
			}
            $this->session->data['webpos']['selector']=$selector;

			$total_data = $hesapmakinasi['total_data'][$selector[1]];
            $total = $hesapmakinasi['total'][$selector[1]];
            $sort_order = array();

			foreach ($total_data as $key => $value) {
      			$sort_order[$key] = $value['sort_order'];
    		}

    		array_multisort($sort_order, SORT_ASC, $total_data);
            $output2 .= '<div style="width: 100%; display: inline-block;"><table style="float: right; display: inline-block;">';
    		$output .= '<table cellpadding="0" cellspacing="0" align="right" style="display:inline-block;">';
      		foreach ($total_data as $total) {
      			$output .= '<tr>';
		        $output .= '<td align="right"><span class="cart_module_total"><b>' . $total['title'] . '</b></span></td>';
		        $output .= '<td align="right"><span class="cart_module_total">' . $total['text'] . '</span></td>';
      			$output .= '</tr>';


                $output2 .= '<tr><td align="right">'.$total['title'].'</td><td align="right">'.$total['text'].'</td></tr>';


      		}
            $output2 .= '</table><br/></div>';
      		$output .= '</table>';
      		$output .= '<div style="padding-top:5px;text-align:center;clear:both;"><a href="' . $view . '">' . $this->language->get('text_view') . '</a> | <a href="' . $checkout . '">' . $this->language->get('text_checkout') . '</a></div>';
		} else {
			$output .= '<div style="text-align: center;">' . $this->language->get('text_empty') . '</div>';
		}

        if (isset($this->session->data['account']) && ($this->session->data['account'] == 'guest')) {
		    $this->ajax_render('checkout/guest_step_3');
		} else {
		    $this->ajax_render('checkout/confirm');
		}

        $json['ApiValue'] = $api;

        $json['OrderID'] = $this->session->data['order_id'];

        $this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $json['SecureCode'] = $this->SecureCode($this->currency->format($order_info['total'], $this->config->get('webpos_currency_convert'), FALSE, FALSE),'',$featured[$api]['ID'],$this->session->data['order_id'],$order_info['email']);

        $json['TaksitValue'] = "0x0x".$this->currency->format($order_info['total'], $this->config->get('webpos_currency_convert'), FALSE, FALSE);
        foreach ($hesapmakinasi['total'] as $key=>$val) {
        if($key==0)
        {
          $json['taksit'][] = array($key."x0x".$this->currency->format($val,$this->config->get('webpos_currency_convert'),FALSE,FALSE),sprintf($this->language->get('TEXT_WEBPOS_TEXT_TEKCEKIM'),$this->currency->format($val,$this->config->get('webpos_currency_convert'), FALSE, TRUE)));
          if($selector[1]==$key) $json['TaksitValue']=$key."x0x".$this->currency->format($val,$this->config->get('webpos_currency_convert'),FALSE,FALSE);
        }
        else
        {
          $json['taksit'][] = array($key."x".$featured[$api]['TAKSIT'][$key]."x".$this->currency->format($val,$this->config->get('webpos_currency_convert'),FALSE,FALSE),$key." x ".$this->currency->format(round($val/$key,2),$this->config->get('webpos_currency_convert'), FALSE, TRUE)." - Toplam = ".$this->currency->format($val,$this->config->get('webpos_currency_convert'), FALSE, TRUE));
          if($selector[1]==$key)$json['TaksitValue']=$key."x".$featured[$api]['TAKSIT'][$key]."x".$this->currency->format($val,$this->config->get('webpos_currency_convert'),FALSE,FALSE);
        }
        }
        $json['cart'] = $output;
        $json['invoice'] = $output2;

        unset($this->session->data['webpos']['selector']);
        $this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
        }
        }
	}
    protected function ajax_render($child) {
			$action = new Action($child);
			$file   = $action->getFile();
			$class  = $action->getClass();
			$method = $action->getMethod();
			$args   = $action->getArgs();
			if (file_exists($file)) {
				require_once($file);
				$controller = new $class($this->registry);
				$controller->index();
			} else {
				exit('Error: Could not load controller ' . $child . '!');
			}
    }


	function requestapi(){
		$api = NULL;
		if($this->request->server['REQUEST_METHOD'] == 'POST')
		{
        	if($this->request->post['api'] == 'OTHER')
        	{
				$api = basename($this->config->get('webpos_cc_other_id'));
        	}
        	else
        	{
        		if (!(strpos($this->config->get('webpos_cc_apis'),$this->request->post['api'])===false))
        		{
					$api = $this->request->post['api'];
        		}
        		else
        		{
        			$api = NULL;
				}
        	}
		}
		return $api;
	}
    private function Control()
    {
        $isOOS = false;
        $isNotOOS = false;
        $isTaksit = false;
        $ModFeatureArray = $this->FeatureParse();    // preinstall
        $models3d = $this->MODELS3D();
        $secure3d = $this->SECURE3D();
        $ControlArray = array();
        foreach ($ModFeatureArray as $key=>$val) {
        $ControlArray[$key]['api'] = $val['ID'];
        if (isset($secure3d[$val['ID']])){
        $ControlArray[$key]['is3D'] = true;
        if(isset($this->tds[$val['ID']]))
        {
        $ControlArray[$key]['3dID'] = $this->tds[$val['ID']];
        } else {
        $ControlArray[$key]['3dID'] = "";
        }
        } else {
        $ControlArray[$key]['is3D'] = false;
        if(isset($this->tds[$val['ID']]))
        {
        $ControlArray[$key]['3dID'] = $this->tds[$val['ID']];
        } else {
        $ControlArray[$key]['3dID'] = "";
        }
        }
        if (isset($models3d[$val['ID']])){
        $ControlArray[$key]['isMODEL'] = true;
        $ControlArray[$key]['modelID'] = $models3d[$val['ID']];
        if(in_array($models3d[$val['ID']],$this->oos))
        {
        $ControlArray[$key]['isOOS'] = true;
        $isOOS = true;
        } else {
        $ControlArray[$key]['isOOS'] = false;
        $isNotOOS = true;
        }
        } else {
        $ControlArray[$key]['isMODEL'] = false;
        $ControlArray[$key]['modelID'] = "";
        $ControlArray[$key]['isOOS'] = false;
        $isNotOOS = true;
        }
        if (in_array($val['ID'],$this->est)){
        $ControlArray[$key]['isEST'] = true;
        } else {
        $ControlArray[$key]['isEST'] = false;
        }
        if($val['EXTRA'])$isTaksit=true;
        }
        $ControlArray["isOOS"] = $isOOS;
        $ControlArray["isNotOOS"] = $isNotOOS;
        if($isTaksit&&$this->config->get('taksit_status'))$isTaksit=true;
        else $isTaksit=false;
        $ControlArray["isTaksit"] = $isTaksit;

    return $ControlArray;
    }

    private function FeatureParse()
    {
      $ModFeatureArray = array();
        $taksit = array();
        if(strpos($this->config->get('webpos_cc_taksit'), "\n") > 0)
        {
          $taksit_text = explode( "\n", $this->config->get('webpos_cc_taksit'));
          foreach($taksit_text as  $text)
          {
            if(strpos($text, "=") > 0)
            {
              list($taksitkey, $taksitvalue) = explode( '=', $text);
              if(!empty($taksitkey))$taksit[basename(trim($taksitkey))]=trim($taksitvalue);
            }
          }
        }
        else
        {
          if(strpos($this->config->get('webpos_cc_taksit'), "=") > 0)
          {
            list($taksitkey, $taksitvalue) = explode( '=', $this->config->get('webpos_cc_taksit'));
            if(!empty($taksitkey))$taksit[basename(trim($taksitkey))]=trim($taksitvalue);
          }
        }
        if(strpos($this->config->get('webpos_cc_apis'), ',') > 0)
        {
          $ApiArray = explode( ',', $this->config->get('webpos_cc_apis') );
          foreach($ApiArray as  $apiID)
          {
             $apiID = basename(trim($apiID));
             if($apiID == 'OTHER')
             {
                $ModFeatureArray['OTHER']['ID']= basename($this->config->get('webpos_cc_other_id'));
                $ModFeatureArray['OTHER']['TEXT']= $this->language->get('TEXT_WEBPOS_CC_OTHER');
                $ModFeatureArray['OTHER']['TAKSIT'] = '';
                $ModFeatureArray['OTHER']['EXTRA'] = false;
             }
             else
             {
                $ModFeatureArray[$apiID]['ID']= $apiID;
                $ModFeatureArray[$apiID]['TEXT']= $this->language->get('TEXT_WEBPOS_CC_'.$apiID);
                $ModFeatureArray[$apiID]['EXTRA'] = true;
                $TaksitStr = isset($taksit[$apiID])?$taksit[$apiID]:null;
                if (!empty($TaksitStr))
                {
                    if(strpos($TaksitStr, ',') > 0)
                    {
                        if(strpos($TaksitStr, ':') > 0)
                        {
                            foreach(explode(',', $TaksitStr) as  $val)
                            {
                                $pos = strpos($val,':');
                                $key = substr($val,0,$pos);
                                $ModFeatureArray[$apiID]['TAKSIT'][trim($key)] =substr($val,$pos+1,strlen($val));
                            }
                        }
                        else
                        {
                            $ModFeatureArray[$apiID]['TAKSIT'] = '';
                        }
                    }
                    else
                    {
                        if(strpos($TaksitStr, ':') > 0)
                        {
                            list($key, $val) = explode(":", $TaksitStr);
                            $ModFeatureArray[$apiID]['TAKSIT'][trim($key)] = $val;
                        }
                        else
                        {
                            $ModFeatureArray[$apiID]['TAKSIT'] = '';
                        }
                    }
                    }
                    else
                    {
                      $ModFeatureArray[$apiID]['TAKSIT'] = '';
                    }
                }
            }
        }
        else
        {
            $apiID = basename(trim($this->config->get('webpos_cc_apis')));
            if($apiID == 'OTHER')
            {
             $ModFeatureArray['OTHER']['ID']= basename($this->config->get('webpos_cc_other_id'));
             $ModFeatureArray['OTHER']['TEXT']= $this->language->get('TEXT_WEBPOS_CC_OTHER');
             $ModFeatureArray['OTHER']['TAKSIT'] = '';
             $ModFeatureArray['OTHER']['EXTRA'] = false;
            }
            else
            {
             $ModFeatureArray[$apiID]['ID']= $apiID;
             $ModFeatureArray[$apiID]['TEXT']= $this->language->get('TEXT_WEBPOS_CC_'.$apiID);
             $ModFeatureArray[$apiID]['EXTRA'] = true;
             $TaksitStr = isset($taksit[$apiID])?$taksit[$apiID]:null;
             if (!empty($TaksitStr))
             {
                if(strpos($TaksitStr, ',') > 0)
                {
                    if(strpos($TaksitStr, ':') > 0)
                    {
                        foreach(explode(',', $TaksitStr) as  $val)
                        {
                            $pos = strpos($val,':');
                            $key = substr($val,0,$pos);
                            $ModFeatureArray[$apiID]['TAKSIT'][trim($key)] =substr($val,$pos+1,strlen($val));
                        }
                    }
                    else
                    {
                        $ModFeatureArray[$apiID]['TAKSIT'] = '';
                    }
                }
                else
                {
                    if(strpos($TaksitStr, ':') > 0)
                    {
                        list($key, $val) = explode(":", $TaksitStr);
                        $ModFeatureArray[$apiID]['TAKSIT'][trim($key)] = $val;
                    }
                    else
                    {
                        $ModFeatureArray[$apiID]['TAKSIT'] = '';
                    }
                }
                }
                else
                {
                    $ModFeatureArray[$apiID]['TAKSIT'] = '';
                }
             }
        }
        return $ModFeatureArray;
    }

    private function MODELS3D()
    {
        $Model3DArray = array();
        if(strpos($this->config->get('webpos_cc_models'), ',') > 0)
        {
          $ApiArray = explode( ',', $this->config->get('webpos_cc_models') );
          foreach($ApiArray as  $apiID)
          {
            if(strpos($apiID, ':') > 0)
            {
              list($key, $val) = explode(":", $apiID);
              $Model3DArray[trim($key)]=trim(strtolower($val));
            }
          }
        }
        else
        {
          $apiID = $this->config->get('webpos_cc_models');
          if(strpos($apiID, ':') > 0)
            {
              list($key, $val) = explode(":", $apiID);
              $Model3DArray[trim($key)]=trim(strtolower($val));
            }
        }
        return $Model3DArray;
    }

	private function SECURE3D()
    {
		$Secure3DArray = array();
        if(strpos($this->config->get('webpos_cc_3dsecure_apis'), ',') > 0)
        {
          $ApiArray = explode( ',', $this->config->get('webpos_cc_3dsecure_apis') );
          foreach($ApiArray as  $apiID)
          {
            $apiID = basename(trim($apiID));
            if($apiID == 'OTHER')
            {
                $Secure3DArray['OTHER']= basename($this->config->get('webpos_cc_other_id'));
            }
            else
            {
                $Secure3DArray[$apiID]= $apiID;
            }
          }
        }
        else
        {
          $apiID = basename(trim($this->config->get('webpos_cc_3dsecure_apis')));
          if($apiID == 'OTHER')
          {
              $Secure3DArray['OTHER']= basename($this->config->get('webpos_cc_other_id'));
          }else
          {
              $Secure3DArray[$apiID]= $apiID;
          }
        }
		return $Secure3DArray;
	}

    private function API3DMODEL($api="")
    {
      if($this->config->get('webpos_cc_models')!='')
      {
        $Model3DArray = $this->MODELS3D();  // preinstall
		if ($api!="")
		{
			if (isset($Model3DArray[$api])){
				return 'var model3ds = {'.'"'.$api.'":'.'"'.$Model3DArray[$api].'"'.'};'."\n";
			}
			else
			{
				return 'var model3ds = {};'."\n";
			}
		}
        $s3d = '';
        foreach( $Model3DArray as $key => $value)
        {
              if($s3d==''){
                $s3d = '"'.$key.'":'.'"'.$value.'"';
              }
              else
              {
                $s3d .= ',"'.$key.'":'.'"'.$value.'"';
              }
        }
        return 'var model3ds = {'.$s3d.'};'."\n";
      }else
      {
        return 'var model3ds = {};'."\n";
      }
    }

    private function API3D($api="")
    {
    if($this->config->get('webpos_cc_3dsecure_apis')!='')
      {
        $Secure3DArray = $this->SECURE3D(); // preinstall
        if ($api!="")
		{
			if (isset($Secure3DArray[$api])){
				return 'var secure3ds = {'.'"'.$api.'":'.'"'.$this->tds[$Secure3DArray[$api]].'"'.'};'."\n";
			}
			else
			{
				return 'var secure3ds = {};'."\n";
			}
		}
		$s3d = '';
        foreach( $Secure3DArray as $key => $value)
        {
            if(isset($this->tds[$value]))
            {
              if($s3d==''){
                $s3d = '"'.$key.'":'.'"'.$this->tds[$value].'"';
              }
              else
              {
                $s3d .= ',"'.$key.'":'.'"'.$this->tds[$value].'"';
              }
            }

        }
        return 'var secure3ds = {'.$s3d.'};'."\n";
      }else
      {
        return 'var secure3ds = {};'."\n";
      }
    }

    private function CLASSIC($verified,$post)
    {
        return  'function CLASSIC(payment,oid,api,tkp,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,securecode) {'.//"\n".
                'function FormElement(inputForm, elementName, elementValue){var newElement=document.createElement("input");newElement.type="hidden";newElement.name=elementName;newElement.value=elementValue;inputForm.appendChild(newElement);return newElement;};'.//"\n".
                'var visa = /^4[0-9]{12}([0-9]{3})?$/;'.//"\n".
                'var master = /^5[1-5][0-9]{14}$/;'.//"\n".
                'var cardType = 0;'.//"\n".
                'if (visa.test(cc_number))cardType=1;else if(master.test(cc_number))cardType = 2;else{return "'.$verified.'\n";}'.//"\n".
                'var amount=0;var taksit=0;var tkpResult = new Array();if(tkp.indexOf("x")>0){tkpResult = tkp.split("x");}'.//"\n".
                'if(tkpResult.length>2){taksit=tkpResult[0];amount=tkpResult[2];};if(taksit==0)taksit="";'.//"\n".
                'var submitForm = document.createElement("FORM");'.//"\n".
                'submitForm.method = "POST";'.//"\n".
                'submitForm.action = "'.$post.'";'.//"\n".
                'FormElement(submitForm, "payment", payment);'.//"\n".
                'FormElement(submitForm, "SecureCode", securecode);'.//"\n".
                'FormElement(submitForm, "oid", oid);'.//"\n".
                'FormElement(submitForm, "api", api);'.//"\n".
                'FormElement(submitForm, "webpos_taksit", tkp);'.//"\n".
                'FormElement(submitForm, "webpos_cc_number", cc_number);'.//"\n".
                'FormElement(submitForm, "webpos_cc_checkcode", cvvnumber);'.//"\n".
                'FormElement(submitForm, "webpos_cc_owner", cc_owner);'.//"\n".
                'FormElement(submitForm, "webpos_cc_expires_month", ExpDM);'.//"\n".
                'FormElement(submitForm, "webpos_cc_expires_year", ExpDY);'.//"\n".
                'document.body.appendChild(submitForm);'.//"\n".
                'submitForm.submit();'./*"\n".*/'return true;}'/*."\n"*/;//.'/'.'/--></script>'."\n"
    }

    private function ZRAAT_OOS($verified,$post)
    {
        return  'function ZRAAT_OOS(payment,oid,api,tkp,securecode) {'.//"\n".
                'function ajaxRequest(){var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];if (window.ActiveXObject){for (var i=0; i<activexmodes.length; i++){try{return new ActiveXObject(activexmodes[i]);}catch(e){}}}else if (window.XMLHttpRequest){return new XMLHttpRequest();} else return false;};'.//"\n".
                'var amount=0;var taksit=0;var tkpResult = new Array();if(tkp.indexOf("x")>0){tkpResult = tkp.split("x");}'.//"\n".
                'if(tkpResult.length>2){taksit=tkpResult[0];amount=tkpResult[2];};if(taksit==0)taksit="";'.//"\n".
                'var myrequest= new ajaxRequest();var parameters="go=ZRAAT_OOS&oid="+oid+"&amount="+amount+"&api="+api+"&taksit="+taksit+"&SecureCode="+escape(securecode);myrequest.open("POST", "'.$post.'", false);myrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded; latin5_turkish_ci");myrequest.send(parameters);var conarray=myrequest.responseText.replace(/^\s*|\s*$/g,"").split("\n");'.//"\n".
                'var error = conarray[0];'.//"\n".
                'var post = conarray[1];'.//"\n".
                'if (error!=1){return post;}else{window.location.href=post;}'.//"\n".
                'return true;}'/*."\n"*/;
    }

    private function YKB3D($verified,$post)  //  MODULE_PAYMENT_WEBPOS_TEXT_VERIFIED_VM, $this->form_action_url_api
    {                                            //'<script language="javascript"><!--'.//"\n".
        return  'function YKB3D(payment,oid,api,tkp,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,securecode) {'.//"\n".
                'function ajaxRequest(){var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];if (window.ActiveXObject){for (var i=0; i<activexmodes.length; i++){try{return new ActiveXObject(activexmodes[i]);}catch(e){}}}else if (window.XMLHttpRequest){return new XMLHttpRequest();} else return false;};'.//"\n".
                'function FormElement(inputForm, elementName, elementValue){var newElement=document.createElement("input");newElement.type="hidden";newElement.name=elementName;newElement.value=elementValue;inputForm.appendChild(newElement);return newElement;};'.//"\n".
                'var visa = /^4[0-9]{12}([0-9]{3})?$/;'.//"\n".
                'var master = /^5[1-5][0-9]{14}$/;'.//"\n".
                'var cardType = 0;'.//"\n".
                'if (visa.test(cc_number))cardType=1;else if(master.test(cc_number))cardType = 2;else{return "'.$verified.'\n";}'.//"\n".
                'var amount=0;var taksit=0;var tkpResult = new Array();if(tkp.indexOf("x")>0){tkpResult = tkp.split("x");}'.//"\n".
                'if(tkpResult.length>2){taksit=tkpResult[0];amount=tkpResult[2];};if(taksit==0)taksit="";'.//"\n".
                'var myrequest= new ajaxRequest();var parameters="go=YKB3D&py="+payment+"&wpt="+tkp+"&owner="+escape(cc_owner)+"&expdm="+ExpDM+"&expdy="+ExpDY+"&ccno="+cc_number+"&cvv="+cvvnumber+"&taksit="+taksit+"&oid="+oid+"&amount="+amount+"&api="+api+"&SecureCode="+escape(securecode);myrequest.open("POST", "'.$post.'", false);myrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded; latin5_turkish_ci");myrequest.send(parameters);var conarray=myrequest.responseText.replace(/^\s*|\s*$/g,"").split("\n");'.//"\n".
                'var posnetData = conarray[0];'.//"\n".
                'var posnetData2 = conarray[1];'.//"\n".
                'var digest = conarray[2];'.//"\n".
                'var mid = conarray[3];'.//"\n".
                'var posnetID = conarray[4];'.//"\n".
                'var vftCode = conarray[5];'.//"\n".
                'var merchantReturnURL = conarray[6];'.//"\n".
                'var lang = conarray[7];'.//"\n".
                'var url = conarray[8];'.//"\n".
                'var openANewWindow = conarray[9];'.//"\n".
                'var post = conarray[10];'.//"\n".
                'var submitForm = document.createElement("FORM");'.//"\n".
                'submitForm.method = "POST";'.//"\n".
                'submitForm.action = post;'.//"\n".
                'FormElement(submitForm, "posnetData", posnetData);'.//"\n".
                'FormElement(submitForm, "posnetData2", posnetData2);'.//"\n".
                'FormElement(submitForm, "digest", digest);'.//"\n".
                'FormElement(submitForm, "mid", mid);'.//"\n".
                'FormElement(submitForm, "posnetID", posnetID);'.//"\n".
                'FormElement(submitForm, "vftCode", vftCode);'.//"\n".
                'FormElement(submitForm, "merchantReturnURL", merchantReturnURL);'.//"\n".
                'FormElement(submitForm, "lang", lang);'.//"\n".
                'FormElement(submitForm, "url", url);'.//"\n".
                'FormElement(submitForm, "openANewWindow", openANewWindow);'.//"\n".
                'document.body.appendChild(submitForm);'.//"\n".
                'submitForm.submit();'./*"\n".*/'return true;}'/*."\n"*/;//.'/'.'/--></script>'."\n"
    }

    private function EST3D($verified,$post)
    {
        return  'function EST3D(payment,oid,api,tkp,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,securecode) {'.//"\n".
                'function ajaxRequest(){var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];if (window.ActiveXObject){for (var i=0; i<activexmodes.length; i++){try{return new ActiveXObject(activexmodes[i]);}catch(e){}}}else if (window.XMLHttpRequest){return new XMLHttpRequest();} else return false;};'.//"\n".
                'function FormElement(inputForm, elementName, elementValue){var newElement=document.createElement("input");newElement.type="hidden";newElement.name=elementName;newElement.value=elementValue;inputForm.appendChild(newElement);return newElement;};'.//"\n".
                'var visa = /^4[0-9]{12}([0-9]{3})?$/;'.//"\n".
                'var master = /^5[1-5][0-9]{14}$/;'.//"\n".
                'var cardType = 0;'.//"\n".
                'if (visa.test(cc_number))cardType=1;else if(master.test(cc_number))cardType = 2;else{return "'.$verified.'\n";}'.//"\n".
                'var amount=0;var taksit=0;var tkpResult = new Array();if(tkp.indexOf("x")>0){tkpResult = tkp.split("x");}'.//"\n".
                'if(tkpResult.length>2){taksit=tkpResult[0];amount=tkpResult[2];};if(taksit==0)taksit="";'.//"\n".
                'var myrequest= new ajaxRequest();var parameters="go=EST3D&oid="+oid+"&amount="+amount+"&api="+api+"&SecureCode="+escape(securecode);myrequest.open("POST", "'.$post.'", false);myrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded; latin5_turkish_ci");myrequest.send(parameters);var conarray=myrequest.responseText.replace(/^\s*|\s*$/g,"").split("\n");'.//"\n".
                'var hash = conarray[0];'.//"\n".
                'var clientId = conarray[1];'.//"\n".
                'var okUrl = conarray[2];'.//"\n".
                'var failUrl = conarray[3];'.//"\n".
                'var rnd = conarray[4];'.//"\n".
                'var storetype = conarray[5];'.//"\n".
                'var lang = conarray[6];'.//"\n".
                'var post = conarray[7];'.//"\n".
                'var submitForm = document.createElement("FORM");'.//"\n".
                'submitForm.method = "POST";'.//"\n".
                'submitForm.action = post;'.//"\n".
                'FormElement(submitForm, "pan", cc_number);'.//"\n".
                'FormElement(submitForm, "cv2", cvvnumber);'.//"\n".
                'FormElement(submitForm, "Ecom_Payment_Card_ExpDate_Year", ExpDY);'.//"\n".
                'FormElement(submitForm, "Ecom_Payment_Card_ExpDate_Month", ExpDM);'.//"\n".
                'FormElement(submitForm, "cardType", cardType);'.//"\n".
                'FormElement(submitForm, "clientid", clientId);'.//"\n".
                'FormElement(submitForm, "amount", amount);'.//"\n".
                'FormElement(submitForm, "oid", oid);'.//"\n".
                'FormElement(submitForm, "okUrl", okUrl);'.//"\n".
                'FormElement(submitForm, "failUrl", failUrl);'.//"\n".
                'FormElement(submitForm, "rnd", rnd);'.//"\n".
                'FormElement(submitForm, "hash", hash);'.//"\n".
                'FormElement(submitForm, "storetype", storetype);'.//"\n".
                'FormElement(submitForm, "lang", lang);'.//"\n".
                'FormElement(submitForm, "payment", payment);'.//"\n".
                'FormElement(submitForm, "api", api);'.//"\n".
                'FormElement(submitForm, "webpos_taksit", tkp);'.//"\n".
                'FormElement(submitForm, "webpos_cc_owner", cc_owner);'.//"\n".
                'FormElement(submitForm, "SecureCode", securecode);'.//"\n".
                'document.body.appendChild(submitForm);'.//"\n".
                'submitForm.submit();'./*"\n".*/'return true;}'/*."\n"*/;
    }

    private function EST3D_PAY($verified,$post)
    {
        return  'function EST3D_PAY(payment,oid,api,tkp,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,securecode) {'.//"\n".
                'function ajaxRequest(){var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];if (window.ActiveXObject){for (var i=0; i<activexmodes.length; i++){try{return new ActiveXObject(activexmodes[i]);}catch(e){}}}else if (window.XMLHttpRequest){return new XMLHttpRequest();} else return false;};'.//"\n".
                'function FormElement(inputForm, elementName, elementValue){var newElement=document.createElement("input");newElement.type="hidden";newElement.name=elementName;newElement.value=elementValue;inputForm.appendChild(newElement);return newElement;};'.//"\n".
                'var visa = /^4[0-9]{12}([0-9]{3})?$/;'.//"\n".
                'var master = /^5[1-5][0-9]{14}$/;'.//"\n".
                'var cardType = 0;'.//"\n".
                'if (visa.test(cc_number))cardType=1;else if(master.test(cc_number))cardType = 2;else{return "'.$verified.'\n";}'.//"\n".
                'var amount=0;var taksit=0;var tkpResult = new Array();if(tkp.indexOf("x")>0){tkpResult = tkp.split("x");}'.//"\n".
                'if(tkpResult.length>2){taksit=tkpResult[0];amount=tkpResult[2];};if(taksit==0)taksit="";'.//"\n".
                'var myrequest= new ajaxRequest();var parameters="go=EST3D_PAY&oid="+oid+"&taksit="+taksit+"&amount="+amount+"&api="+api+"&SecureCode="+escape(securecode);myrequest.open("POST", "'.$post.'", false);myrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded; latin5_turkish_ci");myrequest.send(parameters);var conarray=myrequest.responseText.replace(/^\s*|\s*$/g,"").split("\n");'.//"\n".
                'var hash = conarray[0];'.//"\n".
                'var clientId = conarray[1];'.//"\n".
                'var okUrl = conarray[2];'.//"\n".
                'var failUrl = conarray[3];'.//"\n".
                'var rnd = conarray[4];'.//"\n".
                'var storetype = conarray[5];'.//"\n".
                'var lang = conarray[6];'.//"\n".
                'var islemtipi = conarray[7];'.//"\n".
                'var taksit2 = conarray[8];'.//"\n".
                'var post = conarray[9];'.//"\n".
                'var submitForm = document.createElement("FORM");'.//"\n".
                'submitForm.method = "POST";'.//"\n".
                'submitForm.action = post;'.//"\n".
                'FormElement(submitForm, "pan", cc_number);'.//"\n".
                'FormElement(submitForm, "cv2", cvvnumber);'.//"\n".
                'FormElement(submitForm, "Ecom_Payment_Card_ExpDate_Year", ExpDY);'.//"\n".
                'FormElement(submitForm, "Ecom_Payment_Card_ExpDate_Month", ExpDM);'.//"\n".
                'FormElement(submitForm, "cardType", cardType);'.//"\n".
                'FormElement(submitForm, "clientid", clientId);'.//"\n".
                'FormElement(submitForm, "amount", amount);'.//"\n".
                'FormElement(submitForm, "oid", oid);'.//"\n".
                'FormElement(submitForm, "okUrl", okUrl);'.//"\n".
                'FormElement(submitForm, "failUrl", failUrl);'.//"\n".
                'FormElement(submitForm, "rnd", rnd);'.//"\n".
                'FormElement(submitForm, "hash", hash);'.//"\n".
                'FormElement(submitForm, "storetype", storetype);'.//"\n".
                'FormElement(submitForm, "lang", lang);'.//"\n".
                'FormElement(submitForm, "payment", payment);'.//"\n".
                'FormElement(submitForm, "api", api);'.//"\n".
                'FormElement(submitForm, "webpos_taksit", tkp);'.//"\n".
                'FormElement(submitForm, "webpos_cc_owner", cc_owner);'.//"\n".
                'FormElement(submitForm, "SecureCode", securecode);'.//"\n".
                'FormElement(submitForm, "islemtipi", islemtipi);'.//"\n".
                'FormElement(submitForm, "taksit", taksit2);'.//"\n".
                'FormElement(submitForm, "firmaadi", cc_owner);'.//"\n".
                'document.body.appendChild(submitForm);'.//"\n".
                'submitForm.submit();'./*"\n".*/'return true;}'/*."\n"*/;
    }

    private function EST3D_OOS_PAY($verified,$post,$store,$fismi)
    {
        return  'function EST3D_OOS_PAY(payment,oid,api,tkp,securecode) {'.//"\n".
                'function ajaxRequest(){var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];if (window.ActiveXObject){for (var i=0; i<activexmodes.length; i++){try{return new ActiveXObject(activexmodes[i]);}catch(e){}}}else if (window.XMLHttpRequest){return new XMLHttpRequest();} else return false;};'.//"\n".
                'function FormElement(inputForm, elementName, elementValue){var newElement=document.createElement("input");newElement.type="hidden";newElement.name=elementName;newElement.value=elementValue;inputForm.appendChild(newElement);return newElement;};'.//"\n".
                'var amount=0;var taksit=0;var tkpResult = new Array();if(tkp.indexOf("x")>0){tkpResult = tkp.split("x");}'.//"\n".
                'if(tkpResult.length>2){taksit=tkpResult[0];amount=tkpResult[2];};if(taksit==0)taksit="";'.//"\n".
                'var myrequest= new ajaxRequest();var parameters="go=EST3D_OOS_PAY&oid="+oid+"&taksit="+taksit+"&amount="+amount+"&api="+api+"&SecureCode="+escape(securecode);myrequest.open("POST", "'.$post.'", false);myrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded; latin5_turkish_ci");myrequest.send(parameters);var conarray=myrequest.responseText.replace(/^\s*|\s*$/g,"").split("\n");'.//"\n".
                'var hash = conarray[0];'.//"\n".
                'var clientId = conarray[1];'.//"\n".
                'var okUrl = conarray[2];'.//"\n".
                'var failUrl = conarray[3];'.//"\n".
                'var rnd = conarray[4];'.//"\n".
                'var storetype = conarray[5];'.//"\n".
                'var lang = conarray[6];'.//"\n".
                'var islemtipi = conarray[7];'.//"\n".
                'var taksit2 = conarray[8];'.//"\n".
                'var post = conarray[9];'.//"\n".
                'var submitForm = document.createElement("FORM");'.//"\n".
                'submitForm.method = "POST";'.//"\n".
                'submitForm.action = post;'.//"\n".
                'FormElement(submitForm, "SecureCode", securecode);'.//"\n".
                'FormElement(submitForm, "go", "3d_oos_pay");'.//"\n".
                'FormElement(submitForm, "api", api);'.//"\n".
                'FormElement(submitForm, "webpos_taksit", tkp);'.//"\n".
                'FormElement(submitForm, "clientid", clientId);'.//"\n".
                'FormElement(submitForm, "amount", amount);'.//"\n".
                'FormElement(submitForm, "oid", oid);'.//"\n".
                'FormElement(submitForm, "okUrl", okUrl);'.//"\n".
                'FormElement(submitForm, "failUrl", failUrl);'.//"\n".
                'FormElement(submitForm, "islemtipi", islemtipi);'.//"\n".
                'FormElement(submitForm, "taksit", taksit2);'.//"\n".
                'FormElement(submitForm, "rnd", rnd);'.//"\n".
                'FormElement(submitForm, "hash", hash);'.//"\n".
                'FormElement(submitForm, "storetype", storetype);'.//"\n".
                'FormElement(submitForm, "firmaadi", "'.$store.'");'.//"\n".
                'FormElement(submitForm, "refreshtime", "0");'.//"\n".
                'FormElement(submitForm, "lang", lang);'.//"\n".
                'FormElement(submitForm, "Fismi", "'.$fismi.'");'.//"\n".
                'document.body.appendChild(submitForm);'.//"\n".
                //'alert(myrequest.responseText);return false;'.//"\n".
                'submitForm.submit();'./*"\n".*/'return true;}'/*."\n"*/;
    }

    private function GRN3D_OOS_PAY($verified,$post,$email,$store)
    {

        return  'function GRN3D_OOS_PAY(payment,oid,api,tkp,securecode) {'.//"\n".
                'function ajaxRequest(){var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];if (window.ActiveXObject){for (var i=0; i<activexmodes.length; i++){try{return new ActiveXObject(activexmodes[i]);}catch(e){}}}else if (window.XMLHttpRequest){return new XMLHttpRequest();} else return false;};'.//"\n".
                'function FormElement(inputForm, elementName, elementValue){var newElement=document.createElement("input");newElement.type="hidden";newElement.name=elementName;newElement.value=elementValue;inputForm.appendChild(newElement);return newElement;};'.//"\n".
                'var amount=0;var taksit=0;var tkpResult = new Array();if(tkp.indexOf("x")>0){tkpResult = tkp.split("x");}'.//"\n".
                'if(tkpResult.length>2){taksit=tkpResult[0];amount=tkpResult[2];};if(taksit==0)taksit="";'.//"\n".
                'var myrequest= new ajaxRequest();var parameters="go=GRN3D_OOS_PAY&oid="+oid+"&taksit="+taksit+"&amount="+amount+"&api="+api+"&SecureCode="+escape(securecode);myrequest.open("POST", "'.$post.'", false);myrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded; latin5_turkish_ci");myrequest.send(parameters);var conarray=myrequest.responseText.replace(/^\s*|\s*$/g,"").split("\n");'.//"\n".
                'var storetype = conarray[0];'.//"\n".
                'var mode = conarray[1];'.//"\n".
                'var apiversion = conarray[2];'.//"\n".
                'var terminalprovuserid = conarray[3];'.//"\n".
                'var terminaluserid = conarray[4];'.//"\n".
                'var terminalmerchantid = conarray[5];'.//"\n".
                'var txntype = conarray[6];'.//"\n".
                'var txnamount = conarray[7];'.//"\n".
                'var txncurrencycode = conarray[8];'.//"\n".
                'var txninstallmentcount = conarray[9];'.//"\n".
                'var orderid = conarray[10];'.//"\n".
                'var terminalid = conarray[11];'.//"\n".
                'var okUrl = conarray[12];'.//"\n".
                'var failUrl = conarray[13];'.//"\n".
                'var customeripaddress = conarray[14];'.//"\n".
                'var secure3dhash = conarray[15];'.//"\n".
                'var post = conarray[16];'.//"\n".
                'var lang = conarray[17];'.//"\n".
                'var rnd = conarray[18];'.//"\n".
                'var submitForm = document.createElement("FORM");'.//"\n".
                'submitForm.method = "POST";'.//"\n".
                'submitForm.action = post;'.//"\n".
                'FormElement(submitForm, "secure3dsecuritylevel", storetype);'.//"\n".
                'FormElement(submitForm, "refreshtime", "0");'.//"\n".
                'FormElement(submitForm, "mode", mode);'.//"\n".
                'FormElement(submitForm, "api", api);'.//"\n".
                'FormElement(submitForm, "webpos_taksit", tkp);'.//"\n".
                'FormElement(submitForm, "apiversion", apiversion);'.//"\n".
                'FormElement(submitForm, "terminalprovuserid", terminalprovuserid);'.//"\n".
                'FormElement(submitForm, "terminaluserid", terminaluserid);'.//"\n".
                'FormElement(submitForm, "terminalid", terminalid);'.//"\n".
                'FormElement(submitForm, "terminalmerchantid", terminalmerchantid);'.//"\n".
                'FormElement(submitForm, "orderid", orderid);'.//"\n".
                'FormElement(submitForm, "customeremailaddress", "'.$email.'");'.//"\n".
                'FormElement(submitForm, "customeripaddress", customeripaddress);'.//"\n".
                'FormElement(submitForm, "txntype", txntype);'.//"\n".
                'FormElement(submitForm, "txnamount", txnamount);'.//"\n".
                'FormElement(submitForm, "txncurrencycode", txncurrencycode);'.//"\n".
                'FormElement(submitForm, "companyname", "'.$store.'");'.//"\n".
                'FormElement(submitForm, "txninstallmentcount", txninstallmentcount);'.//"\n".
                'FormElement(submitForm, "successurl", okUrl);'.//"\n".
                'FormElement(submitForm, "errorurl", failUrl);'.//"\n".
                'FormElement(submitForm, "secure3dhash", secure3dhash);'.//"\n".
                'FormElement(submitForm, "lang", lang);'.//"\n".
                'FormElement(submitForm, "txntimestamp", rnd);'.//"\n".
                'FormElement(submitForm, "SecureCode", securecode);'.//"\n".
                'document.body.appendChild(submitForm);'.//"\n".
                //'alert(myrequest.responseText);return false;'.//"\n".
                'submitForm.submit();'./*"\n".*/'return true;}'/*."\n"*/;
    }

    private function GRN3D($verified,$post,$email)
    {

        return  'function GRN3D(payment,oid,api,tkp,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,securecode) {'.//"\n".
                'function ajaxRequest(){var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];if (window.ActiveXObject){for (var i=0; i<activexmodes.length; i++){try{return new ActiveXObject(activexmodes[i]);}catch(e){}}}else if (window.XMLHttpRequest){return new XMLHttpRequest();} else return false;};'.//"\n".
                'function FormElement(inputForm, elementName, elementValue){var newElement=document.createElement("input");newElement.type="hidden";newElement.name=elementName;newElement.value=elementValue;inputForm.appendChild(newElement);return newElement;};'.//"\n".
                'var visa = /^4[0-9]{12}([0-9]{3})?$/;'.//"\n".
                'var master = /^5[1-5][0-9]{14}$/;'.//"\n".
                'var cardType = 0;'.//"\n".
                'if (visa.test(cc_number))cardType=1;else if(master.test(cc_number))cardType = 2;else{return "'.$verified.'\n";}'.//"\n".
                'var amount=0;var taksit=0;var tkpResult = new Array();if(tkp.indexOf("x")>0){tkpResult = tkp.split("x");}'.//"\n".
                'if(tkpResult.length>2){taksit=tkpResult[0];amount=tkpResult[2];};if(taksit==0)taksit="";'.//"\n".
                'var myrequest= new ajaxRequest();var parameters="go=GRN3D&oid="+oid+"&taksit="+taksit+"&amount="+amount+"&api="+api+"&SecureCode="+escape(securecode);myrequest.open("POST", "'.$post.'", false);myrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded; latin5_turkish_ci");myrequest.send(parameters);var conarray=myrequest.responseText.replace(/^\s*|\s*$/g,"").split("\n");'.//"\n".
                'var storetype = conarray[0];'.//"\n".
                'var mode = conarray[1];'.//"\n".
                'var apiversion = conarray[2];'.//"\n".
                'var terminalprovuserid = conarray[3];'.//"\n".
                'var terminaluserid = conarray[4];'.//"\n".
                'var terminalmerchantid = conarray[5];'.//"\n".
                'var txntype = conarray[6];'.//"\n".
                'var txnamount = conarray[7];'.//"\n".
                'var txncurrencycode = conarray[8];'.//"\n".
                'var txninstallmentcount = conarray[9];'.//"\n".
                'var orderid = conarray[10];'.//"\n".
                'var terminalid = conarray[11];'.//"\n".
                'var okUrl = conarray[12];'.//"\n".
                'var failUrl = conarray[13];'.//"\n".
                'var customeripaddress = conarray[14];'.//"\n".
                'var secure3dhash = conarray[15];'.//"\n".
                'var post = conarray[16];'.//"\n".
                'var submitForm = document.createElement("FORM");'.//"\n".
                'submitForm.method = "POST";'.//"\n".
                'submitForm.action = post;'.//"\n".
                'FormElement(submitForm, "secure3dsecuritylevel", storetype);'.//"\n".
                'FormElement(submitForm, "cardnumber", cc_number);'.//"\n".
                'FormElement(submitForm, "cardexpiredatemonth", ExpDM);'.//"\n".
                'FormElement(submitForm, "cardexpiredateyear", ExpDY);'.//"\n".
                'FormElement(submitForm, "cardcvv2", cvvnumber);'.//"\n".
                'FormElement(submitForm, "mode", mode);'.//"\n".
                'FormElement(submitForm, "apiversion", apiversion);'.//"\n".
                'FormElement(submitForm, "terminalprovuserid", terminalprovuserid);'.//"\n".
                'FormElement(submitForm, "terminaluserid", terminaluserid);'.//"\n".
                'FormElement(submitForm, "terminalmerchantid", terminalmerchantid);'.//"\n".
                'FormElement(submitForm, "txntype", txntype);'.//"\n".
                'FormElement(submitForm, "txnamount", txnamount);'.//"\n".
                'FormElement(submitForm, "txncurrencycode", txncurrencycode);'.//"\n".
                'FormElement(submitForm, "txninstallmentcount", txninstallmentcount);'.//"\n".
                'FormElement(submitForm, "orderid", orderid);'.//"\n".
                'FormElement(submitForm, "terminalid", terminalid);'.//"\n".
                'FormElement(submitForm, "successurl", okUrl);'.//"\n".
                'FormElement(submitForm, "errorurl", failUrl);'.//"\n".
                'FormElement(submitForm, "customeremailaddress", "'.$email.'");'.//"\n".
                'FormElement(submitForm, "customeripaddress", customeripaddress);'.//"\n".
                'FormElement(submitForm, "secure3dhash", secure3dhash);'.//"\n".
                'FormElement(submitForm, "api", api);'.//"\n".
                'FormElement(submitForm, "payment", payment);'.//"\n".
                'FormElement(submitForm, "webpos_taksit", tkp);'.//"\n".
                'FormElement(submitForm, "webpos_cc_owner", cc_owner);'.//"\n".
                'FormElement(submitForm, "SecureCode", securecode);'.//"\n".
                'document.body.appendChild(submitForm);'.//"\n".
                'submitForm.submit();'./*"\n".*/'return true;}'/*."\n"*/;
    }

    private function MPI3D($verified,$post)   //  MODULE_PAYMENT_WEBPOS_TEXT_VERIFIED_VM, $this->form_action_url_api
    {
        return  'function MPI3D(payment,oid,api,tkp,cc_number,cvvnumber,cc_owner,ExpDM,ExpDY,securecode) {'.//"\n".
                'function ajaxRequest(){var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];if (window.ActiveXObject){for (var i=0; i<activexmodes.length; i++){try{return new ActiveXObject(activexmodes[i]);}catch(e){}}}else if (window.XMLHttpRequest){return new XMLHttpRequest();} else return false;};'.//"\n".
                'function FormElement(inputForm, elementName, elementValue){var newElement=document.createElement("input");newElement.type="hidden";newElement.name=elementName;newElement.value=elementValue;inputForm.appendChild(newElement);return newElement;};'.//"\n".
                'var visa = /^4[0-9]{12}([0-9]{3})?$/;'.//"\n".
                'var master = /^5[1-5][0-9]{14}$/;'.//"\n".
                'var cardType = 0;'.//"\n".
                'if (visa.test(cc_number))cardType=1;else if(master.test(cc_number))cardType = 2;else{return "'.$verified.'\n";}'.//"\n".
                'var amount=0;var taksit=0;var tkpResult = new Array();if(tkp.indexOf("x")>0){tkpResult = tkp.split("x");}'.//"\n".
                'if(tkpResult.length>2){taksit=tkpResult[0];amount=tkpResult[2];};if(taksit==0)taksit="";'.//"\n".
                'var myrequest= new ajaxRequest();var parameters="go=MPI3D&py="+payment+"&wpt="+tkp+"&owner="+escape(cc_owner)+"&expdm="+ExpDM+"&expdy="+ExpDY+"&ccno="+cc_number+"&cvv="+cvvnumber+"&taksit="+taksit+"&oid="+oid+"&amount="+amount+"&api="+api+"&cardType="+cardType+"&SecureCode="+escape(securecode);myrequest.open("POST", "'.$post.'", false);myrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded; latin5_turkish_ci");myrequest.send(parameters);var conarray=myrequest.responseText.replace(/^\s*|\s*$/g,"").split("\n");'.//"\n".
               /* 'alert(myrequest.responseText);return false;'.//"\n".   */
                'var status = conarray[0];'.//"\n".
                'var error = unescape(conarray[1]);'.//"\n".
                'var pareq = conarray[2];'.//"\n".
                'var acsurl = conarray[3];'.//"\n".
                'var termurl = conarray[4];'.//"\n".
                'var merchantdata = conarray[5];'.//"\n".
                'if(status==0) return error+"\n";'.//"\n".
                'var submitForm = document.createElement("FORM");'.//"\n".
                'submitForm.method = "POST";'.//"\n".
                'submitForm.action = acsurl;'.//"\n".
                'FormElement(submitForm, "PaReq", pareq);'.//"\n".
                'FormElement(submitForm, "TermUrl", termurl);'.//"\n".
                'FormElement(submitForm, "MD", merchantdata);'.//"\n".
                'document.body.appendChild(submitForm);'.//"\n".
                'submitForm.submit();'./*"\n".*/'return true;}'/*."\n"*/;
    }

    private function WPT()
    {
        $webpos_taksit = 0;
        $webpos_amount = 0;
        $webpos_storetype = 0;
        if(isset($this->request->post['storetype']))
        {
          if ($this->request->post['storetype']=='3d')
          {
             $webpos_storetype =1;
          }
          else if ($this->request->post['storetype']=='ykb3d')
          {
             $webpos_storetype =2;
          }
          else if ($this->request->post['storetype']=='mpi3d')
          {
             $webpos_storetype =3;
          }
          else if ($this->request->post['storetype']=='3d_pay')
          {
             $webpos_storetype =4;
          }
          else if ($this->request->post['storetype']=='3d_oos_pay')
          {
             $webpos_storetype =5;
          }
          else if ($this->request->post['secure3dsecuritylevel']=='3d')
          {
             $webpos_storetype =6;
          }
          else if ($this->request->post['secure3dsecuritylevel']=='3d_pay')
          {
             $webpos_storetype =7;
          }
          else if ($this->request->post['secure3dsecuritylevel']=='3d_oos_pay')
          {
             $webpos_storetype =8;
          }
        }
        if(isset($this->request->post['webpos_taksit']))
        {
          if (strpos($this->request->post['webpos_taksit'], 'x') !== false)
          {
            $webpos_taksit_pieces = explode('x', $this->request->post['webpos_taksit']);
            if(count($webpos_taksit_pieces)==3)
            {
              if($webpos_taksit_pieces[0]==0)
              {
                 $webpos_taksit =0;
                 $webpos_amount = $webpos_taksit_pieces[2];
              }
              else
              {
                 $webpos_taksit = $webpos_taksit_pieces[0].'x'.$webpos_taksit_pieces[1];
                 $webpos_amount = $webpos_taksit_pieces[2];
              }
            }
            else
            {
              $webpos_taksit =0;
            }
          }
        }
        return array($webpos_taksit,$webpos_amount,$webpos_storetype);
    }

    private function est3D_error_codes( $Status )
    {
    switch ( $Status )
    {
        case "1" :
            $msg = "Tam do?rulama";
            return $msg;
        case "2" :
            $msg = "Kartsahibi veya bankasy sisteme kayytly de?il";
            return $msg;
        case "3" :
            $msg = "Kartyn bankasy sisteme kayytly de?il (önbellekten)";
            return $msg;
        case "4" :
            $msg = "Do?rulama denemesi, kartsahibi sisteme daha sonra kayyt olmayy seçmi?";
            return $msg;
        case "5" :
            $msg = "Kredi Karty Do?rulama yapylamyyor.";
            return $msg;
        case "6" :
            $msg = "3-D Secure Hatasy, Hata mesajy veya i?yeri 3-D Secure sistemine kayytly de?il";
            return $msg;
        case "7" :
            $msg = "Sistem Hatasy";
            return $msg;
        case "8" :
            $msg = "Bilinmeyen kartno, Visa veya MasterCard tanymsyz";
            return $msg;
        case "0" :
            $msg = "3-D secure imzasy geçersiz veya Do?rulama ba?arysyz";
            return $msg;

    }
    $msg = "Lütfen bilgilerinizi kontrol ediniz..";
    return $msg;
    }

    private function SecureCode($tutar,$taksit,$apiref,$orderid,$email)
    {
      $_SESSION['transferdata'] = null;
      if (!class_exists('cc_crypt_mod')) {
        include( DIR_SYSTEM.'/helper/'."cc_crypt.php" );
      }
      $this->crypt = new cc_crypt_mod;
      $this->cryptcode = $this->crypt->randomstring();
      $_SESSION['ccencodekey'] = $this->cryptcode;
      return base64_encode($this->crypt->Encode($tutar.'"'."'".'"'.$taksit.'"'."'".'"'.$apiref.'"'."'".'"'. $orderid.'"'."'".'"'.$email,$this->cryptcode));
    }


    public function test()
    {
    $output= '{"posts":[{
    "title":"9lessons | Programming Blog",
    "url":"http://9lessons.blogspot.com"
    },
    {
    "title":"jQuery and Ajax Demos Pard - 3",
    "url":"jquery-and-ajax-best-demos-part-3.html"
    },
    ]
    }';
    srand ( (double) microtime() * 10000000);


    $this->response->setOutput("var myfunc = function(a){alert('".rand(1,100000)."');return a;};list = '".$this->request->post['id']."';", $this->config->get('config_compression'));
    }

}
?>