<?php
	if (!defined('BASE')) die('<h1 class="try-hack">Restricted access!</h1>');

	class TIMER extends Connection {

		function close(){
			$this->klasclos();
		}

		function getInit(){
			$this->check_connection();
// 			$query = "select ((extract(day from int_val)
//   + extract(hour from int_val) / 24
//   + extract(minute from int_val) / (24 * 60)
//   + extract(second from int_val) / (24 * 60 * 60))
//   * power(2,44)) + power(2,60)
// as i
// from (
// select systimestamp - timestamp '1970-01-01 00:00:00' as int_val from dual)
// ";
			$query = "SELECT round((SYSDATE - TO_DATE('01-01-1970 00:00:00', 'DD-MM-YYYY HH24:MI:SS')) , 9) * 24 * 60 * 60  AS I FROM DUAL";
			$stmt = $this->select($query);
			$row = oci_fetch_assoc($stmt);
			if(isset($row['I'])){
				return $row['I'];
			} else {
				return 0;
			}
		}

		function getStart(){
			$this->check_connection();
// 			$query = "select ((extract(day from int_val)
//   + extract(hour from int_val) / 24
//   + extract(minute from int_val) / (24 * 60)
//   + extract(second from int_val) / (24 * 60 * 60))
//   * power(2,44)) + power(2,60)
// as x
// from (
// select start_time - timestamp '1970-01-01 00:00:00' as int_val from time_table)
// ";

			// $query = "SELECT (TO_DATE (TO_CHAR (start_time, 'YYYY-MON-DD HH24:MI:SS'),
   //              'YYYY-MON-DD HH24:MI:SS'
   //             ) - TO_DATE('01-01-1970 00:00:00', 'DD-MM-YYYY HH24:MI:SS')) * 24 * 60 * 60 AS x FROM time_table";
			$query = "SELECT TO_CHAR (start_time, 'YYYY-MON-DD HH24:MI:SS') as X FROM time_table";
			$stmt = $this->select($query);
			$row = oci_fetch_assoc($stmt);
			if(isset($row['X'])){
				return $row['X'];
			} else {
				return 0;
			}
		}

		function getEnd(){
			$this->check_connection();
// 			$query = "select ((extract(day from int_val)
//   + extract(hour from int_val) / 24
//   + extract(minute from int_val) / (24 * 60)
//   + extract(second from int_val) / (24 * 60 * 60))
//   * power(2,44)) + power(2,60)
// as y
// from (
// select end_time - timestamp '1970-01-01 00:00:00' as int_val from time_table)
// ";
// 			$query = "SELECT (TO_DATE (TO_CHAR (end_time, 'YYYY-MON-DD HH24:MI:SS'),
//                 'YYYY-MON-DD HH24:MI:SS'
//                ) - TO_DATE('01-01-1970 00:00:00', 'DD-MM-YYYY HH24:MI:SS')) * 24 * 60 * 60 AS y FROM time_table";
			$query = "SELECT TO_CHAR (end_time, 'YYYY-MON-DD HH24:MI:SS') as Y FROM time_table";
			$stmt = $this->select($query);
			$row = oci_fetch_assoc($stmt);
			if(isset($row['Y'])){
				return $row['Y'];
			} else {
				return 0;
			}
		}

		function getActivate(){
			$this->check_connection();
// 			$query = "select ((extract(day from int_val)
//   + extract(hour from int_val) / 24
//   + extract(minute from int_val) / (24 * 60)
//   + extract(second from int_val) / (24 * 60 * 60))
//   * power(2,44)) + power(2,60)
// as z
// from (
// select activate_time - timestamp '1970-01-01 00:00:00' as int_val from time_table)
// ";
			// $query = "SELECT (TO_DATE (TO_CHAR (activate_time, 'YYYY-MON-DD HH24:MI:SS'),
   //              'YYYY-MON-DD HH24:MI:SS'
   //             ) - TO_DATE('01-01-1970 00:00:00', 'DD-MM-YYYY HH24:MI:SS')) * 24 * 60 * 60 AS z FROM time_table";
			$query = "SELECT TO_CHAR (activate_time, 'YYYY-MON-DD HH24:MI:SS') as Z FROM time_table";

			$stmt = $this->select($query);
			$row = oci_fetch_assoc($stmt);
			if(isset($row['Z'])){
				return $row['Z'];
			} else {
				return 0;
			}
		}

	}

?>