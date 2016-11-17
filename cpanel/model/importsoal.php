<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');

	Class DB_HOBERT {

		private $query = array();
		private $conn = NULL;

		

	 	function __construct($user_name , $password) {
	 		// var_dump($user_name);
	 		// var_dump($password);
	 		// KALO ERROR DI SINI BERARTI DATABASE NYA BELUM DI BERSIHIN
	 		$this->conn = oci_connect($user_name, $password, DBSTRINGCON);
			if(!$this->conn) {
				$this->conn = NULL;
				die(oci_error());
			}
	 		$this->query[0] = "create table jabataninsert(
    id_jabatan char(6) not null,
	nama_jabatan varchar2(20) not null,
	honor_jabatan  number not null,
	primary key(id_jabatan)
)";
			$this->query[1] = "create table Cabanginsert(
   id_cabang char(3) not null,
   nama_cabang varchar2(15) not null,
   alamat_cabang varchar2(30) not null,
   telepon_cabang number not null,
   primary key(id_cabang)
 )";
			$this->query[2] = "create table Stafinsert(
   id_pegawai number not null,
   nama_pegawai varchar2(15) not null,
   jenis_kelamin char(1) not null,
   alamat_pegawai varchar2(20) not null,
   telepon_pegawai number not null,
   kode_jabatan char(6) not null,
   kode_cabang char(3) not null,
   primary key(id_pegawai)
 )";

	 	}

	 	protected function check_connection() {
			if(is_null($this->conn))
			die('Error. uninitialize database connection');
		}

		function commit(){
			$this->check_connection();
			$stmt = oci_parse($this->conn, "commit");
			$r = oci_execute($stmt);
			if($r) {
				return 1;
			} else {
				return NULL;
			}
		}

	 	function executeAll(){
	 		$flags = true;
	 		for($i=0; $i<count($this->query); $i++){
	 			$quers = $this->query[$i];
	 			// var_dump($quers);
				$stmt = oci_parse($this->conn, $quers);
				$r = oci_execute($stmt);
				if($r) {
					$ress =  777;
				} else {
					$ress = NULL;
				}
	 			if(!isset($ress)) {
	 				$flags = false;
	 			}
	 		}
	 		
	 		if($flags) {
	 			$committing = $this->commit();
	 			if(!isset($committing)) {
	 				oci_close($this->conn);
	 				return NULL;
	 			} else {
	 				oci_close($this->conn);
	 				return 666;
	 			}
	 		} else {
	 			oci_close($this->conn);
	 			return NULL;
	 		}
	 	}

	}


?>