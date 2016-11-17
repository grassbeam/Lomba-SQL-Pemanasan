<?php
	session_start();
	define('BASE', 'BASE');
	require_once '../utility/config.php';
	require_once '../utility/connection.php';
	require_once '../utility/utility.php';
	require_once './model/scoreboard-oracle.php';
	require_once './controller/scoreboard-controller.php';
	$scoreboard = new SBO();
	$sblist = $scoreboard->getContestantRank();
	$probnum = $scoreboard->getSumProb();
	if(!isset($probnum)) {
		die('ERROR DATABASE PROBLEM!!!');
	}
	if(!isset($sblist)) {
		die('CHECK DATABASE CONTESTANT AND SCOREBOARD!!');
	}
	$starttime = "1478982205.000000000"; // select from db later
	$endtime = "1478992205.000000000"; // select from db later
	$timernow = strtotime("now");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/octicons.css">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/domjudge.js"></script>
</head>
<body>
	<nav>
		<div id="menutop">
			<?php if (!isset($_SESSION['ADMIN_CODE'])) {
				?>
				<a href="login.php">login</a>
			<?php } else {
				?>

				<a target="_top" href="index.php" accesskey="o"><span class="octicon octicon-home"></span> overview</a>
				<a target="_top" href="submissions.php" accesskey="s"><span class="octicon octicon-book"></span> submissions</a>
				<a href="import.php">import user</a>
				<a href="logout.php">logout</a>
				<?php
			}
			?>
		</div>

	<div id="menutopright">
		<div id="clock">
			<span id="timeleft"></span>
		</div>
		<script type="text/javascript">
			var initial = <?php echo $timernow;?>;
			var activatetime = 1195369200.000000000;
			var starttime = <?php echo $starttime;?> ;
			var endtime = <?php echo $endtime;?> ;
			var offset = 0;
			var date = new Date(initial*1000);
			var timeleftelt = document.getElementById("timeleft");
			setInterval(function(){updateClock();},1000);
			updateClock();
		</script>
	</div>
	</nav>
	
	<?php //////////// SCOREBOARD ///////////////////?>

	<h1>Scoreboard SQL Programming Competition UNTAR</h1>
	
	<table class="scoreboard">
		<colgroup><col id="scorerank" /><col id="scoreaffil" /><col id="scoreteamname" /></colgroup><colgroup><col id="scoresolv" /><col id="scoretotal" /></colgroup>
		<colgroup><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /></colgroup>

		<thead>
			<tr class="scoreheader">
				<th title="rank" scope="col">rank</th>
				<th title="team name" scope="col" colspan="2">Name</th>
				<th title="# solved / penalty time" colspan="2" scope="col">score</th>
				<!-- PROBLEM LIST -->
				<?php for($i=0;$i<$probnum;$i++) { ?>
				<th title="Problem <?php echo $i+1; ?>" scope="col">
				<?php
					$huruf = $i+1;
					switch ($huruf) {
					 	case '1':
					 		?> A <div class="circle" style="background: #ff00ff;"><?php
					 		break;
					 	case '2':
					 		?> B <div class="circle" style="background: #6d4ea5;"><?php
					 		break;
					 	case '3':
					 		?> C <div class="circle" style="background: #8b4ec1;"><?php
					 		break;
					 	case '4':
					 		?> D <div class="circle" style="background: #bea0f0;"><?php
					 		break;
					 	case '5':
					 		?> E <div class="circle" style="background: #87011f;"><?php
					 		break;
					 	case '6':
					 		?> F <div class="circle" style="background: #855ef9;"><?php
					 		break;
					 	case '7':
					 		?> G <div class="circle" style="background: #0f077b;"><?php
					 		break;
					 	case '8':
					 		?> H <div class="circle" style="background: #cc78ed;"><?php
					 		break;
					 	case '9':
					 		?> I <div class="circle" style="background: #1a4c38;"><?php
					 		break;
					 	case '10':
					 		?> J <div class="circle" style="background: #da6234;"><?php
					 		break;
					 	case '11':
					 		?> K <div class="circle" style="background: #ff00ff;"><?php
					 		break;
					 	case '12':
					 		?> L <div class="circle" style="background: #10c5e4;"><?php
					 		break;
					 	case '13':
					 		?> M <div class="circle" style="background: #653b72;"><?php
					 		break;
					 	case '14':
					 		?> N <div class="circle" style="background: #5ad9dc;"><?php
					 		break;
					 	case '15':
					 		?> O <div class="circle" style="background: #36e57e;"><?php
					 		break;
					 	case '16':
					 		?> P <div class="circle" style="background: #e0066e;"><?php
					 		break;
					 	case '17':
					 		?> Q <div class="circle" style="background: #98f949;"><?php
					 		break;
					 	case '18':
					 		?> R <div class="circle" style="background: #cea595;"><?php
					 		break;
					 	default:
					 		?> ZZ <div class="circle" style="background: #ef30b3;"><?php
					 		break;
					 } 
				?>
				</div>
				</th>
				<?php } ?>
				<!--END OF PROBLEM LIST-->
			</tr>
		</thead>

		<tbody>
			<?php
				if(isset($sblist)) {
					$counter = 1;
					foreach ($sblist as $scl) {
						$SBdetail = $scoreboard->getProbScore($scl['NAME_CODE']);
						$SBinfo = $scoreboard->getInfo($scl['NAME_CODE']);
						?>
					<tr class="sortorderswitch" id="team:<?php echo $scl['NAME_CODE']?>">
						<td class="scorepl"><?php echo $counter; ?></td>
						<td class="scoreaf"> <img src="../images/IDN.png" alt="IDN" title="IDN" /></td>
						<td class="scoretn">
							<?php echo $SBinfo['NAME']?><br /><span class="univ"><?php echo $SBinfo['SCHOOL']?></span>
						</td>
						<td class="scorenc"><?php echo $scl['TOTAL_AC'];?></td> <!--Total soal submited -->
						<td class="scorett"><?php echo $scl['TOTAL_TIME']?></td>
						<?php 
							for($i=0;$i<$probnum;$i++) {
						?>
						<td class="<?php
								switch ($SBdetail[$i]['VERDICT']) {
								 	case '0':
								 		echo 'score_correct';
								 		break;
								 	case '1':
								 		echo 'score_incorrect';
								 		break;
								 	case '2':
								 		echo 'score_incorrect';
								 		break;
								 	default:
								 		echo 'score_neutral';
								 		break;
								 } 
							 ?>"><?php 
							 	if($SBdetail[$i]['VERDICT'] === 0) {
							 		echo $SBdetail[$i]['SUBMIT_COUNT'] . "/" . $SBdetail[1]['SUBMIT_TIME'] ; 
							 	} else {
							 		echo $SBdetail[$i]['SUBMIT_COUNT'];
							 	}
							 
							 ?></td>
						<?php } ?>
					</tr>
						<?php
						$counter++;
					}	
				
			?>
			<?php } 
			$scoreboard->close();?>
		</tbody>

	</table>

</body>
</html>