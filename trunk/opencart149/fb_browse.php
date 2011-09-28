<?php
/*

	Facebook Catalog Browser - Zencart Plugin
	This modules allow Bright Software Solutions Facebook App to collect
	a list of products and categories. To allow access to this functionality
	the user needs to enter a secure key in the Module settings.
	This key is then used when setting up the App on your Facebook page.
	
	Copyright (C) 2011 Bright Software Solutions
						http://www.brightsoftwaresolutions.com
	
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 
 */
 
/* 
This script redirects traffic to the component called com_fb_browse. 
This can alternatively be performed via .htaccess file with :

Options +FollowSymlinks
 RewriteEngine on
 RewriteRule ^fb_browse.php?(.*)$ index.php?option=com_fb_browse&$1 [NC]

 */
 
$folder =  $_SERVER['REQUEST_URI'];
$pos = strrpos($folder,'fb_browse.php');
if ($pos !== false) {
	$folder =substr($folder,0,$pos);
 } else {
	$folder ='/';
 } 
 $URL =  $folder . "index.php?route=feed/fb_browse&" . $_SERVER['QUERY_STRING']; 
 header("Location:" .$URL); 
 ?>