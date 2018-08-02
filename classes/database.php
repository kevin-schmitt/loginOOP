<?php
	
    class Database
	{	
		private $db;
		
		public function __construct()
		{
			try {
				$this->db = new PDO('mysql:host='.$GLOBALS["config"]["host"] .';
									dbname='.$GLOBALS["config"]["db"],
									$GLOBALS["config"]["username"], 
									$GLOBALS["config"]["password"]);
			 }
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}  
		}

		
		 public function getDb() {
			   if ($this->db instanceof PDO) {
					return $this->db;
			   }
		 }
		
	}