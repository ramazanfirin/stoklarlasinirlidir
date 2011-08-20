<?php

$reqtype = 'Auth';

$secure3ds      = 'EST3D';

/*Gerçek Hesap Ýþlemleri*/
/*<Aktif>*/
$ThreeD['REAL'] = array( 'clientid'  => '',
                                'storekey'  => '',
                                'storetype' => '3d',
                                'apiname'   => '',
                                'apipass'   => '',
                                '3Dgate'    => 'https://domain/subfolders',
                                'gateway'   => 'domain',
                                'gatpath'   => '/subfolders',
                                'lang'      => 'tr'
                        );
/*</Aktif>*/
/*Test, Sahte Hesap Ýþlemleri*/
/*<Test>*/


$ThreeD['TEST'] = array( 'clientid'  => '',
                                'storekey'  => '',
                                'storetype' => '3d',
                                'apiname'   => '',
                                'apipass'   => '',
                                '3Dgate'    => 'https://domain/subfolders',
                                'gateway'   => 'domain',
                                'gatpath'   => '/subfolders',
                                'lang'      => 'tr'
                        );


?>