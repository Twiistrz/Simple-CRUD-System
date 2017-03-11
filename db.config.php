<?php

// session_start();
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','db_projectone');
define('ROOTPATH',$_SERVER['DOCUMENT_ROOT']);
define('THISPATH',dirname($_SERVER['PHP_SELF']));
define('ONLYPATH',str_replace(ROOTPATH, '', THISPATH));
define('HTTPHOST',(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".ONLYPATH."/");

try {
	$DBCONN = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
	$DBCONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo $e->getMessage();
}

include_once 'classes/class.user.php';
$user = new User($DBCONN);