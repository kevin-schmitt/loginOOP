<?php 
	if(empty($_SESSION)) session_start();
	
	
	// config
	$GLOBALS['config'] = array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'db' => 'login_oop'	
	);

	// autoload classes
	spl_autoload_register(function(string $class){
		require __DIR__.'/../classes/' . $class . '.php';
	});