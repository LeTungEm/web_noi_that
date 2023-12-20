<?php
$configDB = array();
$configDB["host"] 		= "localhost";
$configDB["database"]	= "quanlybankhoahoc";
$configDB["username"] 	= "root";
$configDB["password"] 	= "";
define("HOST", "localhost");
define("DB_NAME", "quanlybankhoahoc");
define("DB_USER", "root");
define("DB_PASS", "");
define('ROOT', dirname(dirname(__FILE__) ) );
//Thu muc tuyet doi truoc cua config; c:/wamp/www/lab/
define("BASE_URL", "http://".$_SERVER['SERVER_NAME']."/lab/");//dia chi website
define("TOP_SELLER", 3);
define("STRLEN_MO_TA", 60);
define("KHOA_HOC_MOT_TRANG", 5);
?>
