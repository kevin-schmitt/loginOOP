<?php
	ini_set('display_errors', 1);
	
	class User
	{	
		private $db = null;
		private $auth = false;
		
		public function __construct(\Database $db)
		{
		    $this->db = $db->getDb();

		}
		
		/*** for registration process with password hash ***/
		public function register(string $email, string $password, string $pseudo) :  bool
		{
		
			$emailVerif = $this->checkMail($email);
			if($emailVerif['error'] === false) return false;
			
			$email = $emailVerif['content'];
			
			$password = filter_var($password, FILTER_SANITIZE_STRING);
			$pseudo = filter_var($pseudo, FILTER_SANITIZE_STRING);
			
			//security
			$options = array("cost"=>4);
			$hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);
			
			$sql="SELECT id_user FROM user WHERE pseudo=:pseudo OR user_email=:email";
			$userStatement = $this->db->prepare($sql);
			$userStatement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
			$userStatement->bindParam(':email', $email, PDO::PARAM_STR);
			
			$userStatement->execute();
			$count = $userStatement->rowCount();
			
			if($count < 1)
			{
				$response = $this->insertUser($pseudo,  $hashPassword,  $email);
				if($response === true) return true;
				$userStatement->close();
				return false;
			}
			else
			{
				$userStatement->close();
				return false;
			}
		}
		
		/***
		* return Array[ error bool, string mail or no if mail is not valid]
		* param string mail to check
		**/
		private function checkMail(string $email) : Array
		{		
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);
			
		    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				return $error = [ 'error' => true,
								  'content' => $email
								];
			}
			
			return $error = [ 'error' => false ];
		}
		/********** insert register user in database **************/
		private function insertUser( string $pseudo, string $password, string $email) :  bool
		{
			try
			{
				
				$sql="INSERT INTO user (user_pseudo, user_pass, user_email) VALUES ( :pseudo, :password, :email)";
				$stm = $this->db->prepare($sql);
				$stm->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
				$stm->bindParam(':password', $password, PDO::PARAM_STR);
				$stm->bindParam(':email', $email, PDO::PARAM_STR);
				
				$insertSuccess = $stm->execute();
				return 	$insertSuccess;
			}
			catch(Exeption $e)
			{
				return false;
			}
		}
			
		
		/*** for login process ***/
		public function checkLogin(string $email, string $password) : bool
		{
			//check  mail variable
			$emailVerif = $this->checkMail($email);
			if($emailVerif['error'] === false) return false;			
			$email = $emailVerif['content'];
			
        	// check if mail exist
			$sql = "select * from user where user_email = :email";
			
			$userStatement = $this->db->prepare($sql);
			$userStatement->bindParam(':email', $email, PDO::PARAM_STR);
			$userStatement->execute();
			$count = $userStatement->rowCount();
		
			if($count > 0)
			{				
				$user = $userStatement->fetch();
				if(!empty($user['user_pass']))
				{
					if(password_verify($password, $user['user_pass']))
					{
						$_SESSION['login'] = true;
						$_SESSION['uid'] = $user['user_id'];
						$this->auth = true;
						return true;
					}
				}

			}
			return false;
    	}
		
	
		
		/******** already log? *********/
		 public function getAuthentification(): bool{
	        return $this->auth;
	    }

	}
		
		
