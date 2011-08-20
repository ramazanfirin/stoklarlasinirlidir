<?php
$reqtype = 'Sale';
$webpos_ykbnk_static_ip ='';
$secure3ds      = 'YKB3D';
/*Gerçek Hesap Ýþlemleri*/
/*<Aktif>*/
$ThreeD['REAL'] = array( 'td_check'  => 'true',
                                'username'  => '',
                                'password'  => '',
                                'mid'       => '',
                                'tid'       => '',
                                'posnetid'  => '',
                                '3Dgate'    => 'https://domain/subfolders',
                                'gateway'   => 'domain',
                                'gatpath'   => '/subfolders',
                                'gatssl'    => true,
                                'enckey'    => '',
                                'lang'      => 'tr',
                                'mcrypt'    => 'false',
                                'td_mask'   => '1:2:4:9'
                        );
/*</Aktif>*/
/*Test, Sahte Hesap Ýþlemleri*/
/*<Test>*/
$ThreeD['TEST'] = array( 'td_check'  => 'true',
                                'username'  => '',
                                'password'  => '',
                                'mid'       => '',
                                'tid'       => '',
                                'posnetid'  => '',
                                '3Dgate'    => 'http://domain/subfolders',
                                'gateway'   => 'domain',
                                'gatpath'   => '/subfolders',
                                'gatssl'    => false,
                                'enckey'    => '10,10,10,10,10,10,10,10',
                                'lang'      => 'tr',
                                'mcrypt'    => 'false',
                                'td_mask'   => '1:2:4:9'
                        );



?>