<?php
	session_start();
	define('BASE', 'BASE');
	require_once '../utility/config.php';
	require_once '../utility/connection.php';
	require_once '../utility/utility.php';
	require_once '../model/submits.php';

	$DBSUBS = new DB_SUBMIT();
	
	if(isset($_POST['submit'])){
		$name_code = $_POST['nc'];
		$probnum = $_POST['probid'];
		$username = $_POST['us'];
		if(isset($_FILES['maincode'])){
			// echo "<br/> MASUKKKKK <br/>";
			// print_r($_FILES['maincode']);
			// $isifile = file_get_contents($_FILES['maincode']['tmp_name']);
			// echo "<br/><br/>";
			// echo $isifile;
			
			$sub_id = $DBSUBS->generateCode($probnum,$name_code);
			$times = $DBSUBS->getTime();
			// var_dump($time);
			if(!isset($times)){
				$checker = 000;
				$sbmtime = 000;
			} else {
				$checker = $times['CHECKER'];
				$sbmtime = $times['DIFF'];
			}
			$target_dir = 'C:/jawabanpemanasan/' . $name_code . "/";
			$name_file = $sub_id . "_" . $name_code . "_" . $username . "_" . $probnum . "_" . $sbmtime . ".sql";
			$target_file = $target_dir . $name_file;
			if(!file_exists($target_file)) {
				//check time + write submission
				
				$ress = $DBSUBS->writeSub($sub_id, $name_code, $probnum, $target_file, $sbmtime, $checker);
				$DBSUBS->close(); /// NOT INCLUDED
				if(isset($ress)){
					if($checker<0){
						if(move_uploaded_file($_FILES["maincode"]["tmp_name"] , $target_file)) {
							// die("<h1>SUCCES MOVING TO " . $target_dir);
							redirect('index.php#submitted=' . $sub_id);
						} else {
							die("<h1>INTERNAL SERVER ERROR");
						}
					} else {
						//TOO-LATE CASES///
						redirect('index.php');
					}
				} else {
					die("<h1>DATABASE ERROR</h1>");	
				}
			}else {
				die("<h1>UPLOAD FILES ERROR</h1>");	
			}

		} else {
			die("<h1>FILES NOT UPLOADED</h1>");
		}
	} else {
		redirect('./');
	}

?>