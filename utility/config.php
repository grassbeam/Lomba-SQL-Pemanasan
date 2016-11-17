<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');
	
	$config['site']['title'] = 'WEBSITE SKRIPSI';
	
	//konfig koneksi MYSQL database jawaban
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBNAME', 'db_main');

	//konfig koneksi ORACLE database 
	define('DBSTRINGCON', 'localhost/XE');
	define('DBUSER2', 'pemanasan');
	define('DBPASS2', 'SQLc2016untar');

	
?>