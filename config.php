<?php
	//ini_set('display_errors', '1');

	define('HOST', "localhost");
	define('USERNAME', "root");
	define('PASSWORD', "anas93");
	define('DATABASE', "test");
	$ENCKEY="Classera";
    $db = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    session_start();
?>