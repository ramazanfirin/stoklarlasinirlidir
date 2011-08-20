<?php

$reqtype = 'Auth';

$secure3ds      = '';

/*Gerçek Hesap Ýþlemleri*/
/*<Aktif>*/
$ThreeD['REAL'] = array( 'clientid'  => '',
                                'apiname'   => '',
                                'apipass'   => '',
                                'savegate'    => 'https://domain/subfolders',// 'https://yonetim-test.ziraatbank.com.tr/IPOSMerchant_UserInterface/save_transaction.aspx',
                                'sendgate'    => 'https://domain/subfolders'//'https://yonetim-test.ziraatbank.com.tr/IposMerchant_UserInterface/SendTransaction.aspx'
                        );
/*</Aktif>*/
/*Test, Sahte Hesap Ýþlemleri*/
/*<Test>*/


$ThreeD['TEST'] = array( 'clientid'  => '',
                                'apiname'   => '',
                                'apipass'   => '',
                                'savegate'    => 'https://domain/subfolders',
                                'sendgate'    => 'https://domain/subfolders'
                        );

?>