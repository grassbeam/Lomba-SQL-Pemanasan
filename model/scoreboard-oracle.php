<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');
	
	Class SBO extends Connection {

		function close(){
			$this->klasclos();
		}

		function getList(){
			$this->check_connection();
			$query = "SELECT c.name_code, c.name, c.school, t.score FROM contestant c, totalscore t WHERE c.name_code = t.name_code ORDER BY t.score DESC";
			// $result = $this->select($query);
			// // var_dump($result);
			// $ress = array(array());
			// $count =0 ;
			// // $row = oci_fetch_assoc($result);
			// // var_dump($row);
			// while(($row = oci_fetch_assoc($result)) != false ){
			// 	$ress[$count] = $row;
			// 	$count++;
			// }
			// $nrows = $count;
			// if ($nrows > 0) {
			//     return $ress;
			// } else {
			//     return NULL;
			// }
		}

		function getProbnum(){
			$this->check_connection();
			$query = "SELECT COUNT(*) KAMPRETOS FROM problem";
			$result = $this->select($query);
			
			$ress = array(array());
			$count =0 ;
			$row = oci_fetch_assoc($result);
			$nrows = $row['KAMPRETOS'];
			if (isset($nrows)) {
			    return $nrows;
			} else {
			    return NULL;
			}
		}

		function getTotalScore($name_code) {
			$this->check_connection();
			$query = "SELECT SUM(time_after_penalty) total_score FROM scoreboard WHERE name_code = '" . $name_code . "'";
			$result = $this->select($query);
			$ress = array(array());
			$counter = 0;
			$row = oci_fetch_assoc($result);

			if(isset($row['TOTAL_SCORE'])){
				return $row['TOTAL_SCORE'];
			} else {
				return 0;
			}
		}

		function getTotalAC($name_code){
			$this->check_connection();
			$query = "SELECT COUNT(*) total_submit FROM scoreboard WHERE name_code = '" . $name_code . "' AND verdict = '1'";
			$result = $this->select($query);
			$ress = array(array());
			$counter = 0;
			$row = oci_fetch_assoc($result);

			if(isset($row['TOTAL_SUBMIT'])){
				return $row['TOTAL_SUBMIT'];
			} else {
				return 0;
			}
		}

		function getContestantDetail($name_code){
			$this->check_connection();
			$query = "SELECT * FROM scoreboard WHERE name_code = '" . $name_code . "'";
			$result = $this->select($query);
			$ress = array(array());
			$counter = 0;
			while(($row = oci_fetch_assoc($result)) != false ){
				$count = $row['PROB_NUM'];
				$ress[$count] = $row;
				$counter++;
			}

			$nrows=$counter;
			if($nrows>0){
				return $ress;
			} else{
				return NULL;
			}

		}

	}


?>