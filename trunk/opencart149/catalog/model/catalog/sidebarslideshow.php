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
class ModelCatalogSideBarSlideshow extends Model {
	public function getRandomProduct() {

		$query = $this->db->query("SELECT *, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.product_id GROUP BY r.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) WHERE p.status = '1' AND p.date_available <= NOW() AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY RAND() LIMIT ".$this->config->get('sidebarslideshow_limit') );
		 	 
		$product_data = $query->rows;
		
		return $product_data;
	}
}
?>