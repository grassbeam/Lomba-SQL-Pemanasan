<?php
	session_start();
	define('BASE', 'BASE');
	require_once '../utility/utility.php';
	session_destroy();
	redirect('index.php');
?>