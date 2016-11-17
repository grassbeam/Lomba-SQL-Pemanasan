<?php
	session_start();
	define('BASE', 'BASE');
	require_once '../utility/config.php';
	// require_once '../utility/database.php';
	require_once '../utility/connection.php';
	require_once '../utility/utility.php';
	// require_once '../model/scoreboard.php';
	require_once '../model/scoreboard-oracle.php';
	require_once './controller/scoreboard-controller.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../css/style.css">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/domjudge.js"></script>
</head>
<body>
	<nav>
		<div id="menutop">
			<a href="./">home</a>
			<?php if (!isset($_SESSION['login-id'])) {
				?>
				<a href="login.php/">login</a>
			<?php } else {
				?>
				<a href="submission.php/">submission</a>
				<a href="import.php/">import user</a>
				<a href="logout.php/">logout</a>
				<?php
			}
			?>
		</div>
		<div id="menutopright">
		<div id="clock">
			<span id="timeleft"></span>
		</div>
		<script type="text/javascript">
			
		</script>
	</div>
	</nav>
	
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
				<th title="Problem 1" scope="col">
					A <div class="circle" style="background: #ff0000;"></div>
				</th>
				<th title="Problem 2" scope="col">
					B <div class="circle" style="background: #00ff00;"></div>
				</th>
				<th title="problem 'Stress Factor'" scope="col">
					C <div class="circle" style="background: #0000ff;"></div>
				</th>
				<th title="problem 'Pay Day'" scope="col">
					D <div class="circle" style="background: #ffff00;"></div>
				</th>
				<th title="problem 'Guessing Game'" scope="col">
					E <div class="circle" style="background: #ff00ff;"></div>
				</th>
				<th title="problem 'The Cure'" scope="col">
					F <div class="circle" style="background: #00ffff;"></div>
				</th>
				<th title="problem 'All Are Equal'" scope="col">
					G <div class="circle" style="background: #ff9000;"></div>
				</th>
				<th title="problem 'National Disaster II'" scope="col">
					H <div class="circle" style="background: #ff0090;"></div>
				</th>
				<th title="problem 'Peculiar Microwave'" scope="col">
					I <div class="circle" style="background: #00ff90;"></div>
				</th>
				<th title="problem 'Super Sum'" scope="col">
					J <div class="circle" style="background: #ff3000;"></div>
				</th>
				<th title="problem '2-ME Set'" scope="col">
					K <div class="circle" style="background: #ff0030;"></div>
				</th>
				<th title="problem 'Tale of A Happy Man'" scope="col">
					L <div class="circle" style="background: #00ff30;"></div>
				</th>
				<!--END OF PROBLEM LIST-->
			</tr>
		</thead>

		<tbody>
			<?php
				if(isset($sblist)) {
					$counter = 1;
					foreach ($sblist as $scl) {
						?>
					<tr class="sortorderswitch" id="team:<?php echo $scl['NAME_CODE']?>">
						<td class="scorepl"><?php echo $counter; ?></td>
						<td class="scoreaf"> <img src="../images/IDN.png" alt="IDN" title="IDN" /></td>
						<td class="scoretn">
							<?php echo $scl['NAME']?><br /><span class="univ"><?php echo $scl['SCHOOL']?></span>
						</td>
						<td class="scorenc">12</td> <!--Total soal submited -->
						<td class="scorett"><?php echo $scl['SCORE']?></td>
						<td class="score_correct">3/29</td>
						<td class="score_correct">9/191</td>
						<td class="score_correct">3/111</td>
						<td class="score_correct">1/39</td>
						<td class="score_correct">1/50</td>
						<td class="score_correct">2/275</td>
						<td class="score_correct score_first">1/156</td>
						<td class="score_correct score_first">3/227</td>
						<td class="score_neutral">0</td>
						<td class="score_neutral">0</td>
						<td class="score_correct score_first">2/71</td>
						<td class="score_neutral">0</td>
					</tr>
						<?php
						$counter++;
					}	
				
			?>
			<?php } ?>
		</tbody>

	</table>

</body>
</html>