<?php
/*
  $Id: OPENCART WEBPOS PRO V.1.0

  Webpos Pro, Open Source E-Commerce Payment Solutions

  Coded by Yavuz Yasin Düzgün (duzgun)
  Copyright (c) http://www.duzgun.com , http://www.opencart.com.tr

  Released under the GNU General Public License
*/
class ModelTotalTaksit extends Model {
public function getTotal(&$total_data, &$total, &$taxes) {
$this->load->language('total/taksit');

if (isset($this->session->data['webpos']['selector']) && $this->session->data['webpos']['selector'][1]>0 && $this->config->get('taksit_status')) {
$api = $this->session->data['webpos']['selector'][0];
$taksitsayisi = $this->session->data['webpos']['selector'][1];
$vadefarki = $this->session->data['webpos']['selector'][2];
$vadefarkivergisi = $this->config->get('webpos_taksit_tax');

$Taksit = (int)$taksitsayisi;
$Taksit_Oran = (float)$vadefarki;
$Taksit_SubTotal = 0;

foreach ($this->cart->getProducts() as $product) {
$VadeFarki = $product['total'] * $Taksit_Oran / 100;
if ($product['tax_class_id'] && $vadefarkivergisi) {
if (!isset($taxes[$product['tax_class_id']])) {
$taxes[$product['tax_class_id']] = ($VadeFarki / 100 * $this->tax->getRate($product['tax_class_id']));
} else {
$taxes[$product['tax_class_id']] += ($VadeFarki / 100 * $this->tax->getRate($product['tax_class_id']));
}
}
$Taksit_SubTotal += $VadeFarki;
}
$total_data[] = array('title'      =>  sprintf($this->language->get('text_extra'), $Taksit),
'text'       => $this->currency->format($Taksit_SubTotal),
'value'      => $Taksit_SubTotal,
'sort_order' => $this->config->get('taksit_sort_order')
);

$total += $Taksit_SubTotal;


}

}

}
?>
