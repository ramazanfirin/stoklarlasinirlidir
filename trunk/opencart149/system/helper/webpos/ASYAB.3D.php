<?php

$reqtype = 'Auth';

$secure3ds      = 'MPI3D';
/*Ger�ek Hesap ��lemleri*/
/*<Aktif>*/
$ThreeD['REAL'] = array( 'clientid'  => '',
                                'storekey'  => '',
                                'gateway'   => 'domain',
                                'gatpath'   => '/subfolders',
                                'gatssl'    => true,
                                'apigateway'=> 'domain',
                                'apigatpath'=> '/subfolders',
                                'apigatssl'    => true,
                                'kur'    => '949'
                        );
/*</Aktif>*/
/*Test, Sahte Hesap ��lemleri*/
/*<Test>*/
$ThreeD['TEST'] = array( 'clientid'  => '',
                                'storekey'  => '',
                                'gateway'   => 'domain',
                                'gatpath'   => '/subfolders',
                                'gatssl'    => false,
                                'apigateway'=> 'domain',
                                'apigatpath'=> '/subfolders',
                                'apigatssl'    => false,
                                'kur'    => '840'
                        );
?>