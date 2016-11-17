<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');

	Class DB_USER extends Connection{

		function close(){
			$this->klasclos();
		}
		
		function getLogin($username, $password) {
			$this->check_connection();
			$cons = $this->getConn();
			$stid = oci_parse($cons, 'SELECT * FROM login where username = :bus');
			oci_bind_by_name($stid, ':bus', $username);
			oci_execute($stid);
			$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
			oci_free_statement($stid);
			$ussrs = $row['USERNAME'];
			// var_dump($row['PASSWORD']);
			// var_dump($password);
			if($row['PASSWORD'] == $password){
				$_SESSION['NAME_CODE'] = $row['NAME_CODE'];
				$stid = oci_parse($cons, 'SELECT * FROM contestant where name_code = :bus');
				oci_bind_by_name($stid, ':bus', $_SESSION['NAME_CODE']);
				oci_execute($stid);
				$info = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
				oci_free_statement($stid);
				$_SESSION['NAME'] = $info['NAME'];
				$_SESSION['USERNAME'] = $ussrs;
				$_SESSION['SCHOOL'] = $info['SCHOOL'];
				// var_dump($_SESSION['SCHOOL']);
				return true;
			} else {
				return NULL;
			}
		}


	}


?>