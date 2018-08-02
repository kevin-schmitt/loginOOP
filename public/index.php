<?php
	// css, js 
	require_once "../views/header.view.php";

	if(isset($_SESSION['user'])){
	
	$user = unserialize($_SESSION['user']);
	if($user->getAuthentification() === true){
		include_once '../views/home.view.php';
		exit;
	}

	}
	//router
	$link = $_SERVER['QUERY_STRING'];
    $link_array = explode('/',$link);
    $route = end($link_array);
	
	switch($route){
		case'home':
			include_once '../views/home.view.php';
			exit;
		case 'registerAdd':
			include_once '../classes/registration.php';
			exit;
		case 'register':
			include_once '../form/register.form.php';
			exit;
		case 'login':
			include_once '../form/login.form.php';
			exit;
		default:
			include_once '../form/login.form.php';
			exit;
		
	}
	


	