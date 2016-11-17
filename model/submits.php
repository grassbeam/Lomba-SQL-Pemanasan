<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');

	Class DB_SUBMIT extends Connection{

		function close(){
			$this->klasclos();
		}

		function updateSubmission($sub_id, $newstat, $changer){
			$this->check_connection();
			$query = "UPDATE submission SET status = " . $newstat . ", verifier = '" . $changer . "' WHERE sub_id = '" . $sub_id . '\'';
			// var_dump($query);
			$result = $this->update($query);
			if($result > 0) {
				return $result;
			} else {
				return NULL;
			}
		}

		function getSubmission($name_code) {
			$this->check_connection();

			$query = "select s.sub_id, s.prob_num, s.status, s.submit_time, p.solution_query from submission s , problem p WHERE s.prob_num = p.prob_num AND s.name_code = '" . $name_code . "' ORDER BY s.submit_time DESC";
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

		function getDetail($sub_id){
			$this->check_connection();

			$query = "SELECT * FROM submission WHERE sub_id = '" . $sub_id . "'";
			$result = $this->select($query);
			
			$ress = array(array());
			$count =0 ;
			$row = oci_fetch_assoc($result);
			$nrows = count($row);
			if ($nrows > 0) {
			    return $row;
			} else {
			    return NULL;
			}
		}

		function getAllPending(){
			$this->check_connection();

			$query = "SELECT s.*, c.name FROM submission s, contestant c WHERE s.name_code = c.name_code AND status = '3'";
			$result = $this->select($query);
			
			$ress = array(array());
			$count =0 ;
			while(($row = oci_fetch_assoc($result)) != false ){
				$ress[$count] = $row;
				$count++;
			}
			$nrows = $count;
			return $ress;

		}

		function getAllManual(){
			$this->check_connection();

			$query = "SELECT s.*, c.name FROM submission s, contestant c WHERE s.name_code = c.name_code AND status = '999'";
			$result = $this->select($query);
			
			$ress = array(array());
			$count =0 ;
			while(($row = oci_fetch_assoc($result)) != false ){
				$ress[$count] = $row;
				$count++;
			}
			$nrows = $count;
			return $ress;

		}

		function getAllConfirmed(){
			$this->check_connection();

			$query = "SELECT s.*, c.name FROM submission s, contestant c WHERE s.name_code = c.name_code AND status != '999' AND status != '3'";
			$result = $this->select($query);
			
			$ress = array(array());
			$count =0 ;
			while(($row = oci_fetch_assoc($result)) != false ){
				$ress[$count] = $row;
				$count++;
			}
			$nrows = $count;
			return $ress;

		}



		function generateCode($probnum, $name_code) {
			$this->check_connection();

			$times = date('Y/m/d h:i:s:u', time());
			$seeds = $probnum . $name_code . $times;
			$codes = substr(md5($seeds), 0, 11);

			$cons = $this->getConn();
			$stid = oci_parse($cons, 'SELECT * FROM submission where sub_id = :bus');
			oci_bind_by_name($stid, ':bus', $codes);
			@oci_execute($stid);
			$nr = oci_num_rows($stid);
			oci_free_statement($stid);

			if($nr>0){
				return $this>generateCode($probnum, $name_code);
			} else {
				return $codes;
			}
		}

		function getTime() {
			$this->check_connection();
					$query = "SELECT (select extract( day from diff )*24*60*60 +
 extract( hour from diff )*60*60 +
  extract( minute from diff ) *60+
  round(extract( second from diff )) total_SECONDS
  from (select systimestamp - end_time diff from time_table)) CHECKER, (select extract( day from diff )*24*60*60 +
 extract( hour from diff )*60*60 +
  extract( minute from diff ) *60+
  round(extract( second from diff )) total_SECONDS
  from (select systimestamp - start_time diff from time_table)) DIFF FROM time_table";

  			// $query = "SELECT * from kampret";
  			$result = $this->select($query);
			// // var_dump($result);
			$row = oci_fetch_assoc($result);
			if(isset($row)){
				return $row;
			} else {
				return NULL;
			}
		}

		function writeSub($sub_id, $name_code, $probnum, $targetfile, $timesubmits, $timechecker) {
			$this->check_connection();
			$defaultstat = 666;
			if($timechecker < 0) {
				$defaultstat = 3;
			} 
			$submit_time = $timesubmits;
			$cons = $this->getConn();
			$stid = oci_parse($cons, "INSERT INTO submission (sub_id, name_code, submitted_text, prob_num, status, submit_time, verifier) VALUES ( :subid , :nc , :trgtfl , :prob , :statdef , :sbmt, :vrf )");
			oci_bind_by_name($stid, ':subid', $sub_id);
			oci_bind_by_name($stid, ':nc', $name_code);
			oci_bind_by_name($stid, ':trgtfl', $targetfile);
			oci_bind_by_name($stid, ':prob', $probnum);
			oci_bind_by_name($stid, ':statdef', $defaultstat);
			oci_bind_by_name($stid, ':sbmt', $submit_time );
			$verifier = "hobert_machines";
			oci_bind_by_name($stid, ':vrf', $verifier);

			
			oci_execute($stid);
			$nr = oci_num_rows($stid);
			oci_free_statement($stid);

			if($nr>0 ){
				return $defaultstat;
			} else {
				return NULL;
			}	
		}


	}


?>