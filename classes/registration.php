<?php

	session_start();
	include_once '../core/init.php';
	
	/********** class  */////////
	$database = new Database();
	$user = new User($database);

	/********** form *******************/
	if (isset($_REQUEST['register'])) {

		extract($_REQUEST);
		$userRegistered = $user->register($email, $password, $username);
		if($userRegistered){
			$_SESSION['message'] = "you has been successfull registered";
			header("location: home");
			exit;
		}
		else
		{
			$_SESSION['message'] = "Problem with register try again.";
		}
	}
	// Registration Failed
	header('location: ../public/');
	exit;
