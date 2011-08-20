<?php

$reqtype = 'sales';   // Satis i�in "sales", �notorizasyon i�in "preAuth"

$secure3ds      = 'GRN3D';
/*Ger�ek Hesap ��lemleri*/
/*<Aktif>*/
$ThreeD['REAL'] = array( 'merchantid'  => '',   // isyeri no
                                'terminalid' => '',
                                'storekey'  => '',
                                'storetype' => '3D',
                                'mode' => 'PROD',   // PROD - TEST
                                'provuserid' => '', //Terminal provizyon kullanici kodu
                                'propassword' => '', //Terminal provizyon kullanici sifresi
                                'currency' => '949',
                                'agentuserid' => '',    //��lemi yapan kullan�c�n�n (Agent - Sat�� Temsilcisi) yolland��� aland�r.
                                '3Dgate'    => 'https://domain/subfolders',
                                'gateway'   => 'domain',
                                'gatpath'   => '/subfolders',
                                'lang'      => 'tr'
                        );
/*</Aktif>*/
/*Test, Sahte Hesap ��lemleri*/
/*<Test>*/
$ThreeD['TEST'] = array( 'merchantid'  => '',   // isyeri no
                                'terminalid' => '',
                                'storekey'  => '',
                                'storetype' => '3D',
                                'mode' => 'TEST',   // PROD - TEST
                                'provuserid' => 'PROVAUT', //Terminal provizyon kullanici kodu
                                'propassword' => '', //Terminal provizyon kullanici sifresi
                                'currency' => '949',
                                'agentuserid' => 'PROVAUT',    //��lemi yapan kullan�c�n�n (Agent - Sat�� Temsilcisi) yolland��� aland�r.
                                '3Dgate'    => 'https://domain/subfolders',
                                'gateway'   => 'domain',
                                'gatpath'   => '/subfolders',
                                'lang'      => 'tr'
                        );

?>