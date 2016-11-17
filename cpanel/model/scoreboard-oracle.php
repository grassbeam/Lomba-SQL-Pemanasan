<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');
	
	Class SBO extends Connection {

		function close(){
			$this->klasclos();
		}

		function getContestantRank(){
			$this->check_connection();
			$query = "select s.name_code, (select count(*) from scoreboard sc where verdict = 0 and  sc.name_code = s.name_code) as total_AC, (select sum(sco.time_after_penalty) from scoreboard sco where sco.name_code = s.name_code) as total_Time from scoreboard s group by name_code order by total_ac desc, total_time asc";
			$result = $this->select($query);
			// var_dump($result);
			$ress = array(array());
			$count =0 ;
			// $row = oci_fetch_assoc($result);
			// var_dump($row);
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

		function getSumProb(){
			$this->check_connection();
			$query = "SELECT COUNT(*) NUM FROM problem";
			$result = $this->select($query);
			$row = oci_fetch_assoc($result);
			$nr = $row['NUM'];
			if($nr > 0) {
				return $nr;
			} else {
				return NULL;
			}
		}

		function getProbScore($name_code){
			$this->check_connection();
			$query = "Select * from scoreboard WHERE name_code = '" . $name_code . "' ORDER BY prob_num asc";
			$result = $this->select($query);
			// var_dump($result);
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

		function getInfo($name_code){
			$this->check_connection();
			$query = "SELECT * FROM contestant WHERE name_code = '" . $name_code . "'";
			$result = $this->select($query);
			$row = oci_fetch_assoc($result);
			if(isset($row)){
				return $row;
			} else {
				return NULL;
			}
		}

		function getScore($name_code, $prob_num){
			$this->check_connection();
			$query = "SELECT * FROM scoreboard WHERE name_code = '" . $name_code . "' AND prob_num = '" . $prob_num . "'";
			$result = $this->select($query);
			// var_dump($result);
			$ress = array(array());
			$count =0 ;
			// $row = oci_fetch_assoc($result);
			// var_dump($row);
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

	}


?>