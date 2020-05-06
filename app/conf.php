<?php
define ('DS', DIRECTORY_SEPARATOR); 
$sitePath = realpath(dirname(__FILE__) . DS) . DS;
define ('SITE_PATH', $sitePath);

global $CONF_DB;
$CONF_DB = array (
	'host'      => 'localhost', 
	'username'  => 'task',
	'password'	=> 'Password%34',
	'db_name'	=> 'TaskApp',
    'charset'   => 'utf8' 
 );
        
date_default_timezone_set('America/Los_Angeles'); 

    $JS_conf_arr = array(
    'MyHOSTNAME' => 'http://taskapp'
  
);
  global $JS_conf_arr;