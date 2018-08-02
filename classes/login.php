<?php
	/****** loading *************/
	session_start();
	include_once 'class.user.php';
	include_once 'class.database.php';
	
	/***** class **********/
	$database = new Database();
	$user = new User($database);
	
	/***** form submit *************/
	if (isset($_REQUEST['login'])) {

		extract($_REQUEST);
		
		$login = $user->checkLogin($email, $password);
		serialize($_SESSION['user']);
		if ($login) {
			header('location: Homeview.php');
			exit;
		} else {
			header('location: loginView.html');
			exit;
		}
	}