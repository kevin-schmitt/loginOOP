<?php

	/****** loading *************/
	require '../core/init.php';

	/***** class **********/
	$database = new Database();
	$user = new User($database);
	
	/***** form submit *************/
	if (isset($_REQUEST['loginSubmit'])) {

		extract($_REQUEST);
		
		$login = $user->checkLogin($email, $password);
		//serialize($_SESSION['user']);
		if ($login) {
			header('location: home');
			exit;
		} 

	}


?>
<body class = "container"> 
	<form action="login.php" method="post" class = "card-panel hoverable z-depth-5">
		<h2 class="center-align "> <i class="large material-icons">security</i></h2>
		<div class="input-field col s6">
			<input type="text" type="email" name="email" value="" class="validate">
			<label for="email">Email</label>
        </div>
		<div class="input-field col s6">
			<input type="password" name="password" value="" class="validate">
			<label for="password">Password</label>
		</div>
		<button type="submit"  class="btn waves-effect waves-light" name="loginSubmit">
			<i class="large material-icons">send</i>
		</button>
	</form>
	<a href="register">For register</a>
</body>