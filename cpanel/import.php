<?php
	session_start();
	define('BASE', 'BASE');
	require_once '../utility/config.php';
	// require_once '../utility/database.php';
	require_once '../utility/connection.php';
	require_once '../utility/utility.php';
	require_once './model/admin.php';
    require_once './model/importsoal.php'
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>IMPORT DAFTAR PESERTA</title>
</head>
<body>
	<h2>Input Data Peserta Lomba UNTUK PEMANASAN <<< </h2>
	<br>
	<br>
	<form action="import.php" method="POST" enctype="multipart/form-data">
		<label for="file">Pilih File</label>
		<input type="file" name="file" id="file" accept=".csv" />
		<br>
		<br>
		<input type="hidden" name="const" id="const" value="asd" />
		<input type="submit" name="cluster" id="cluster" value="IMPORT">
	</form>
	<br/>
<?php
if(isset($_POST['const'])) {

	if ( isset($_FILES["file"])) {
        // $jumlahcluster = $_POST['jumclus'];
        // $_SESSION['jumclus'] = $jumlahcluster;
            //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }
        else {
            $arr = null;
            $centro = null;
            $means = null;
            $totmean = null;
            $objekintel = array();
            $objekmedoid = array();
            if (($handle = fopen($_FILES['file']['tmp_name'], 'r')) !== FALSE) {
                $arr = array(array());
                $temparrmed = array(array());
                $ct=0;
                while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // var_dump($data);
                    $row = array();
                    $row['NAME'] = $data[0];
                    $row['SCHOOL'] = $data[1];
                    $arr[$ct] = $row;
                    $ct++;
                }
                $jumlahrowdata = $ct;
                // var_dump($arr);
                $US = new DB_USER();
                $ress = $US->importUser($arr);
                $US->close();
            ?>
            <div>
            <table>
            <thead>
            	<th>Kode Peserta</th>
            	<th>Nama Peserta</th>
            	<th>Asal Sekolah</th>
            	<th>USERNAME</th>
            	<th>PASSWORD</th>
            	<th>Status Import</th>
            </thead>
            <tbody>
			<?php
            // var_dump($ress);
				foreach ($ress as $row) {
                    // var_dump($row);
                    $aesde = new DB_HOBERT($row['USERNAME'], $row['PASSWORD']);
                    $resaesde = $aesde->executeAll();
                    if(!isset($resaesde)) {
                        $row['STATUS'] = -666;
                    }
				?>
				<tr 
                    <?php 
                    $statoe = "SUCCESS";
                    switch ($row['STATUS']) {
                        case 0:
                            echo "style='background-color: #ff3333;'" ;
                            $statoe = "Failed to INSERT CONTESTANT DETAIL";
                            break;
                        case -99:
                             echo "style='background-color: #ff3333;'" ;
                             $statoe = "Failed to INSERT LOGIN";
                             break;
                        case -101:
                             echo "style='background-color: #ff3333;'" ;
                             $statoe = "Failed to CREATE DB USER";
                             break;
                        case -102:
                             echo "style='background-color: #ff3333;'" ;
                             $statoe = "Failed to GRANT ROLE";
                             break;
                        case -103:
                             echo "style='background-color: #ff3333;'" ;
                             $statoe = "Failed to ALTER USER QUOTA";
                             break;
                        case -104:
                            echo "style='background-color: #ff3333;'" ;
                             $statoe = "Failed to INSERT USER SCOREBOARD";
                        case -666:
                            echo "style='background-color: #ff3333;'" ;
                            $statoe = "Failed to CREATE HOBERT NEEDS DB";
                        default:
                             echo "style='background-color: #40ff00;'" ;
                            break;
                    }
                    // if(!$row['STATUS'] > 0) {
                    //     echo "style='background-color: #ff3333;'" ;
                    // } else echo "style='background-color: #40ff00;'" ;
                    ?> 
                >
					<td><?php echo $row['NAME_CODE']; ?></td>
					<td><?php echo $row['NAME']; ?></td>
					<td><?php echo $row['SCHOOL']; ?></td>
					<td><?php echo $row['USERNAME']; ?></td>
					<td><?php echo $row['PASSWORD']; ?></td>
					<td><?php echo $statoe . " (" . $row['STATUS'] . ")"; ?></td>
				</tr>
				<?php
				}
			?>
			</tbody>
			</div>
             <?php
            } else{
                die('<h2>Error file...</h2>');
            }
        }
     } else {
             die("<h2>No file selected<h2/>");
     }


     if($arr == null) {
        die("<h2>Array not created</h2>");
     }
	}

?>
	
</body>
</html>