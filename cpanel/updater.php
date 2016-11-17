<?php
	session_start();
	define('BASE', 'BASE');
	require_once '../utility/config.php';
	require_once '../utility/connection.php';
	require_once '../utility/utility.php';
	require_once '../model/submits.php';
	$DBSUBMIT = new DB_SUBMIT();


	if(isset($_POST['problem'])) {
		$stat = $_POST['problem'];
		$postedid = $_POST['subid'];
		$namechanger = $_SESSION['NAME'];
		$resolt = $DBSUBMIT->updateSubmission($postedid, $stat, $namechanger);
		$DBSUBMIT->close();
		if(isset($resolt)) {
			alert('SUBMISSION STATUS CHANGED!!');
			redirect('submissions.php');
		} else {
			alert('FAILED TO CHANGE STATUS!!');
			redirect('submissions.php');
		}
	} 

?>