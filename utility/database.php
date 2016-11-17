<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');
	
	class Database {
		protected $conn = NULL;
		
		function __construct() {
			$this->conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
			if (mysqli_connect_error()) {
				$this->conn = NULL;
				die('Error: Failed to connect to database');
			}
		}
		
		protected function sanitize($str) {
			return $this->conn->real_escape_string($str);
		}
		protected function error() {
			return $this->conn->error;
		}
		protected function check_connection() {
			if(is_null($this->conn))
			die('Error. uninitialize database connection');
		}
		protected function query($query) {
			$result = $this->conn->query($query);
			if($result){
				return $result;
			} else {
				return $this->error();
			}
		}
	}
	
?>