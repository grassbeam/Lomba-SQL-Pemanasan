<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');

	Class DB_USER extends Connection{

		function close(){
			$this->klasclos();
		}

		function getLogin($username, $password) {
			$this->check_connection();
			$cons = $this->getConn();
			$stid = oci_parse($cons, 'SELECT * FROM login_cpanel where username = :bus');
			oci_bind_by_name($stid, ':bus', $username);
			oci_execute($stid);
			$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
			oci_free_statement($stid);
			if($row['PASSWORD'] == $password){
				$_SESSION['ADMIN_CODE'] = $row['ADMIN_CODE'];
				$_SESSION['NAME'] = $row['NAMA_ADMIN'];
				// var_dump($_SESSION['SCHOOL']);
				return true;
			} else {
				return NULL;
			}
		}

		function getProbnum(){
			$this->check_connection();
			$query = "SELECT * FROM problem";
			$result = $this->select($query);
			
			$ress = array(array());
			$count =0 ;
			while(($row = oci_fetch_assoc($result)) != false ){
				$ress[$count] = $row;
				$count++;
			}
			$nrows = $count;
			if ($nrows > 0) {
			    return $ress;
			} else {
			    return NULL;
			}
		}

		function insertScoreboard($name_code, $probnumarr){
			$this->check_connection();
			$flagnoins = false;
			foreach ($probnumarr as $probnum) {
				// var_dump($probnum);
				$query = "INSERT INTO scoreboard (name_code, prob_num, submit_count, submit_time, verdict) VALUES ('" . $name_code . "', '" . $probnum['PROB_NUM'] . "', '0', '0', '3')";
				$result = $this->insertUser($query);
				if(!$result > 0){
					$flagnoins = true;
				}
			}
			if($flagnoins) {
				return 0;
			} else {
				return 1;
			}
		}


		function importUser($arr){
			$ress = array(array());
			$ct = 1;
			$counter = 0;
			foreach ($arr as $row ) {
				# code..
				$resrow = array();
				if($ct < 10){
					$namecode = "sql-00" . $ct;
				} else {
					if($ct < 100) {
						$namecode = "sql-0" . $ct;
					} else {
						$namecode = "sql-" . $ct;
					}
				}

				
				$query = "INSERT INTO contestant (name_code, name, school) VALUES ('" . $namecode . "', '" . $row['NAME'] . "', '" . $row['SCHOOL'] . "')";
				// var_dump($query);
				// echo "<br/>";
				$ressz = $this->insertUser($query);
				if($ressz > 0){
					if($ct < 10){
						$uname = "sqltest00" . $ct;
					} else {
						if($ct < 100) {
							$uname = "sqltest0" . $ct;
						} else {
							$uname = "sqltest" . $ct;
						}
					}

					$times = date('Y/m/d h:i:s:u', time());
					$seeds = $uname . $times;
					$pswrd = substr(md5($seeds), 0, 5);
					$query = "INSERT INTO login (username, password, name_code) VALUES ('" . $uname . "', '" . $pswrd . "', '" . $namecode . "')";
					$ressz2 = $this->insertLogin($query);
					if($ressz2 > 0){
						$stat = -101;
						$query = "CREATE USER " . $uname . " IDENTIFIED BY " . $pswrd;
						// var_dump($query);
						// echo "<br/>";
						$cruser = $this->createUser($uname, $pswrd);
						if($cruser > 0) {
							$stat = -102;
							$query = "GRANT peserta TO " . $uname;
							$grant = $this->grantRole($query);
							if($grant > 0) {
								$stat = -103;
								$query = "ALTER user " . $uname . " quota 50m on users";
								$altuser = $this->alterUser($query);
								if($altuser >0){
									$stat = -104;
									$probnumarrs = $this->getProbnum();
									if(isset($probnumarrs)){
										//Writing Scoreboard
										$resins = $this->insertScoreboard($namecode, $probnumarrs);
										if($resins >0){
											$stat = $resins;
										}
									}
								}
							}
						}

						$resrow['STATUS'] = $stat;
						$resrow['NAME'] = $row['NAME'];
						$resrow['SCHOOL'] = $row['SCHOOL'];
						$resrow['NAME_CODE'] = $namecode;
						$resrow['USERNAME'] = $uname;
						$resrow['PASSWORD'] = $pswrd;
						$ress[$counter] = $resrow;
						$ct++;
					} else {
						$resrow['STATUS'] = $ressz2;
						$resrow['NAME'] = $row['NAME'];
						$resrow['SCHOOL'] = $row['SCHOOL'];
						$resrow['NAME_CODE'] = $namecode;
						$resrow['USERNAME'] = "-";
						$resrow['PASSWORD'] = "-";
						$ress[$counter] = $resrow;
					}
				} else {
					$resrow['STATUS'] = $ressz;
					$resrow['NAME'] = $row['NAME'];
					$resrow['SCHOOL'] = $row['SCHOOL'];
					$resrow['NAME_CODE'] = $namecode;
					$resrow['USERNAME'] = "-";
					$resrow['PASSWORD'] = "-";
					$ress[$counter] = $resrow;
				}
				$counter++;
			}
			return $ress;
		}

	}


?>