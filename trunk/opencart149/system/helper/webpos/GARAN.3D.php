<?php

$reqtype = 'sales';   // Satis için "sales", Önotorizasyon için "preAuth"

$secure3ds      = 'GRN3D';
/*Gerçek Hesap Ýþlemleri*/
/*<Aktif>*/
$ThreeD['REAL'] = array( 'merchantid'  => '',   // isyeri no
                                'terminalid' => '',
                                'storekey'  => '',
                                'storetype' => '3D',
                                'mode' => 'PROD',   // PROD - TEST
                                'provuserid' => '', //Terminal provizyon kullanici kodu
                                'propassword' => '', //Terminal provizyon kullanici sifresi
                                'currency' => '949',
                                'agentuserid' => '',    //Ýþlemi yapan kullanýcýnýn (Agent - Satýþ Temsilcisi) yollandýðý alandýr.
                                '3Dgate'    => 'https://domain/subfolders',
                                'gateway'   => 'domain',
                                'gatpath'   => '/subfolders',
                                'lang'      => 'tr'
                        );
/*</Aktif>*/
/*Test, Sahte Hesap Ýþlemleri*/
/*<Test>*/
$ThreeD['TEST'] = array( 'merchantid'  => '',   // isyeri no
                                'terminalid' => '',
                                'storekey'  => '',
                                'storetype' => '3D',
                                'mode' => 'TEST',   // PROD - TEST
                                'provuserid' => 'PROVAUT', //Terminal provizyon kullanici kodu
                                'propassword' => '', //Terminal provizyon kullanici sifresi
                                'currency' => '949',
                                'agentuserid' => 'PROVAUT',    //Ýþlemi yapan kullanýcýnýn (Agent - Satýþ Temsilcisi) yollandýðý alandýr.
                                '3Dgate'    => 'https://domain/subfolders',
                                'gateway'   => 'domain',
                                'gatpath'   => '/subfolders',
                                'lang'      => 'tr'
                        );

?>