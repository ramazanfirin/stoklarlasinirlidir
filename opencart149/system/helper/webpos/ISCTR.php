<?php

$reqtype = 'Auth';

/*Ger�ek Hesap ��lemleri*/
/*<Aktif>*/
API::$real_apiname = '';
API::$real_apipass = '';
API::$real_apiclient = '';
API::$real_gateway = 'domain';
API::$real_gatpath = '/subfolders';
/*</Aktif>*/
/*Test, Sahte Hesap ��lemleri*/
/*<Test>*/
API::$test_gateway = 'domain';
API::$test_gatpath = '/subfolders';
API::$test_apiname = '';
API::$test_apipass = '';
API::$test_apiclient = '';
API::$timeout = 90;
?>