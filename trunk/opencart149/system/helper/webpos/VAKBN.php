<?php

$reqtype = 'Auth';
/*Ger�ek Hesap ��lemleri*/
/*<Aktif>*/
API::$real_apiname = '';   //API KULLANICI KODU
API::$real_apipass = '';  //API KULLANICI ��FRE
API::$real_apiclient = ''; //��YER� NO
API::$real_apiposno = ''; //POS NO
API::$real_apixcip = ''; //G�VENL�K KODU
API::$real_gateway = 'domain';
API::$real_gatpath = '/subfolders/?';
/*</Aktif>*/
/*Test, Sahte Hesap ��lemleri*/
/*<Test>*/
API::$test_gateway = 'domain';
API::$test_gatpath = '/subfolders/?';
API::$test_apiname = '';
API::$test_apipass = '';
API::$test_apiclient = '';
API::$test_apiposno = '';
API::$test_apixcip = '';
API::$timeout = 90;

?>