<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');
	
	Class SB extends Database {

		function close(){
			$this->klasclos();
		}

		function getList(){
			$this->check_connection();
			$query = "SELECT s.name_code, s.score, c.name, c.school FROM `totalscore` s, contestant c WHERE s.name_code = c.name_code ORDER BY s.score DESC";
			$result = $this->query($query);
			if ($result->num_rows > 0) {
			    // output data of each row
			    $ress = array(array());
			    $counter = 0;
			    while($row = $result->fetch_assoc()) {
			        $ress[$counter] = $row;
			        $counter += 1;
			    }
			    return $ress;
			} else {
			    return NULL;
			}
		}

	}


?>