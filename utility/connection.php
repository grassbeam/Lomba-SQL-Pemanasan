<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');
	
	Class Connection {
		private $conn = NULL;

		function __construct(){
			$this->conn = oci_connect(DBUSER2, DBPASS2, DBSTRINGCON);
			if(!$this->conn) {
				$this->conn = NULL;
				var_dump(oci_error());
			}
		}

		protected function check_connection() {
			if(is_null($this->conn))
			die('Error. uninitialize database connection');
		}

		function getConn(){
			return $this->conn;
		}

		function commit(){
		}

		function klasclos(){
			oci_close($this->conn);
		}

		//INSERT NEW USER//
		function insertUser($query){
			$this->check_connection();
			$stmt = oci_parse($this->conn, $query);
			@oci_execute($stmt, OCI_DEFAULT); // KASIH OCI_DEFAULT KALO ERROR
			$nr = oci_num_rows($stmt);
			oci_free_statement($stmt);
			if($nr>0){
				return $nr;
			} else {
				return 0;
			}
		}

		function alterUser($query){
			$this->check_connection();
			$stmt = oci_parse($this->conn, $query);
			// var_dump($query);
			$r = oci_execute($stmt);
			oci_free_statement($stmt);
			if($r){
				return 1;
			} else {
				return 0;
			}
		}

		function createUser($username, $password){
			$this->check_connection();
			$query = "DROP USER " . $username . " CASCADE";
			$stmt = oci_parse($this->conn, $query);
			// var_dump($query);
			@oci_execute($stmt);
			// $nr = oci_num_rows($stmt);
			oci_free_statement($stmt);
			$query = "CREATE USER " . $username . " IDENTIFIED BY \"" . $password . "\"";
			$stmt = oci_parse($this->conn, $query);
			$r = @oci_execute($stmt);
			if($r){
				return 1;
			} else {
				return 0;
			}
		}

		function grantRole($query){
			$this->check_connection();
			$stmt = oci_parse($this->conn, $query);
			// var_dump($query);
			$r = oci_execute($stmt);
			oci_free_statement($stmt);
			if($r){
				return 1;
			} else {
				return 0;
			}
		}

		function createTable($query){
			$this->check_connection();
			$stmt = oci_parse($this->conn, $query);
			$r = oci_execute($stmt);
			oci_free_statement($r);
			if($r) {
				return 777;
			} else {
				return NULL;
			}
		}

		function update($query) {
			$this->check_connection();
			$stmt = oci_parse($this->conn, $query);
			oci_execute($stmt);
			$nr = oci_num_rows($stmt);
			oci_free_statement($stmt);
			if($nr>0){
				return $nr;
			} else {
				return -99;
			}
		}

		function insertLogin($query){
			$this->check_connection();
			$stmt = oci_parse($this->conn, $query);
			oci_execute($stmt);
			$nr = oci_num_rows($stmt);
			oci_free_statement($stmt);
			if($nr>0){
				return $nr;
			} else {
				return -99;
			}
		}

		function select($query){
			$this->check_connection();
			$stid = oci_parse($this->conn, $query);
			// var_dump($stid);
			oci_execute($stid);
			return $stid;
		}

	}


?>