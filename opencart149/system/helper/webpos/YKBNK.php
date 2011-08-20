<?php
$reqtype = 'Auth';
/*Gerçek Hesap Ýþlemleri*/
/*<Aktif>*/
API::$real_apiname = '';
API::$real_apipass = '';
API::$real_mid = '';
API::$real_tid = '';
API::$real_gateway = 'domain';
API::$real_gatpath = '/subfolders';
/*</Aktif>*/
/*Test, Sahte Hesap Ýþlemleri*/
/*<Test>*/
API::$test_gateway = 'domain';
API::$test_gatpath = '/subfolders';
API::$test_apiname = '';
API::$test_apipass = '';
API::$test_mid = '';
API::$test_tid = '';
API::$timeout = 90;
?>