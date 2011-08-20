<?php
/* OpenCart 1.4.9.5 Turkish Ceviren eka7a - http://www.opencart-tr.com */

// Heading
$_['heading_title']							= 'PayPal Website Payments Standart';

// Text
$_['text_payment']							= 'Ödeme Metodları';
$_['text_success']							= 'Success: You have modified PayPal account details!';
$_['text_pp_standard']						= '<a onclick="window.open(\'https://www.paypal.com/uk/mrb/pal=YS4L83BNSEC6A\');"><img src="view/image/payment/paypal.png" alt="PayPal" title="PayPal" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization']					= 'Onaylı Ödeme';
$_['text_sale']								= 'Direk Ödeme';

// Entry
$_['entry_email']							= 'E-Posta:';
$_['entry_test']							= 'Test Modu:';
$_['entry_transaction']						= 'Ödeme Metodu:';
$_['entry_geo_zone']						= 'Genel Bölge:';
$_['entry_status']							= 'Durumu:';
$_['entry_sort_order']						= 'Sıralama:';
$_['entry_pdt_token']						= 'PDT Kimlik Simgesi:<br/><span class="help">PDT Kimlik Simge sistemi Ödeme Veri Transferi(PDT) sırasında ek güvenlik ve güvenirlik sağlar. Nasıl etkinleştireceğinizi <a href="https://cms.paypal.com/us/cgi-bin/?&cmd=_render-content&content_ID=developer/howto_html_paymentdatatransfer" alt="">burada</a> bulabilirsiniz.</span>';
$_['entry_itemized']						= 'Ürün Ayrıntıları:<br/><span class="help">PayPal ödeme sayfasında ürün ayrıntılarını gösterilir.</span>';
$_['entry_debug']							= 'Hata Ayıklama Modu:<br/><span class="help">Sistem kayıtlarına hata bilgilerini ekler.</span>';
$_['entry_order_status']					= 'Sipariş Tamamlandı Durumu:<br /><span class="help">Sipariş başarıyla tamamlandığında bu durum ayarlanır.</span>';
$_['entry_order_status_pending']			= 'Sipariş Bekliyor Durumu:<br /><span class="help">Ödeme bekliyor; daha fazla bilgi için pending_reason değişkenine bakınız. Unutmayın ki, Eğer başka Anında Ödeme Bildirimi alanacağınız zaman Tamamlandı durumunu değiştiriniz, Başarısız ya da Reddedildi.</span>';
$_['entry_order_status_denied']				= 'Sipariş Reddedildi Durumu:<br /><span class="help">Ödeme reddedildi. This will only happen if the payment was previously pending due to one of the following pending reasons.</span>';
$_['entry_order_status_failed']				= 'Sipariş Başarısız Durumu:<br /><span class="help">Ödeme Başarısız. Bu sadece müşteri tanımlı banka hesabından ödeme yapmak istediğinde olur.</span>';
$_['entry_order_status_refunded']			= 'Sipariş Geri Ödeme Durumu:<br /><span class="help">Geri Ödeme</span>';
$_['entry_order_status_canceled_reversal']	= 'Sipariş Değişim İptal Durumu:<br /><span class="help">This means a reversal has been canceled; for example, you, the merchant, won a dispute with the customer and the funds for the transaction that was reversed have been returned to you.</span>';
$_['entry_order_status_reversed']			= 'Sipariş Geri Ödeme:<br /><span class="help">This means that a payment was reversed due to a chargeback or other type of reversal. The funds have been debited from your account balance and returned to the customer. The reason for the reversal is given by the reason_code variable.</span>';
$_['entry_order_status_unspecified']		= 'Sipariş Bilinmeyen Hata Durumu:';

// Error
$_['error_permission']						= 'Uyarı: PayPal ödeme metodunu düzenleme iznine sahip değilsiniz!';
$_['error_email']							= 'E-Posta Gerekli!'; 
?>