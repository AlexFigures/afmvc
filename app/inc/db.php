<?php
 include_once ("app/conf.php");
 global $dbConnection;
 global $CONF_DB;

try { 
 $dbConnection = new PDO('mysql:host=' . $CONF_DB['host'] . ';dbname=' . $CONF_DB['db_name'], $CONF_DB['username'], $CONF_DB['password'], array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
));

$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $ex){
	echo 'Error';
	print_r($ex);
}