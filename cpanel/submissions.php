<?php
	session_start();
	define('BASE', 'BASE');
	require_once '../utility/config.php';
	require_once '../utility/connection.php';
	require_once '../utility/utility.php';
	require_once '../model/submits.php';
	$DBSUBMIT = new DB_SUBMIT();
	$pendings = $DBSUBMIT->getAllPending();
	$special = $DBSUBMIT->getAllManual();
	$confirmed = $DBSUBMIT->getAllConfirmed();
	$DBSUBMIT->close();
	if(!isset($pendings) || !isset($special) || !isset($confirmed)) {
		die("<h1>ERROR DATABASE!</h1>");
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
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/domjudge.js"></script>
</head>
<body>
	<nav>
		<div id="menutop">
			<a href="./">home</a>
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
	</nav>
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
	<h3 id="newrequests">Manual Check Requests:</h3>
	<?php
		if(count($special[0]) > 0){
			$counter = 1;
			foreach ($special as $row) {
			?>
			<table class="list sortable">
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">time</th>
				<th scope="col">code-name</th>
				<th scope="col">name</th>
				<th scope="col">problem</th>
				<th scope="col">result</th>
				<th scope="col">verified-by</th>
			</tr>
		</thead>
	<tbody>
		<tr class="<?php if($counter%2 ==0) echo "roweven"; else echo "rowodd" ?>" data-team-id="<?php echo $row['NAME_CODE']; ?>" data-problem-id="<?php echo $row['PROB_NUM'] ?>" data-language-id="sql" data-submission-id="<?php echo $row['SUB_ID']; ?>">
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['SUB_ID']; ?></a></td>
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>">
			<?php
				$tot = $row['SUBMIT_TIME'];
				$sec = $tot % 60;
				$min = ($tot - $sec) / 60;
				echo sprintf("%02d:%02d", $min,$sec);
			?>
			</a></td>
			<td title="t666"><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['NAME_CODE']; ?></a></td>
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['NAME']; ?></a></td>
			<td class="probid" title="Summits"><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['PROB_NUM']; ?></a></td>
			<td class="result"><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>">
			<span class="sol <?php
			switch ($row['STATUS']) {
				case '0':
					echo 'sol_correct">correct';
					break;
				case '2':
					echo 'sol_incorrect">wrong-answer';
					break;
				case '1':
					echo 'sol_incorrect">syntax-error';
					break;
				case '666':
					echo 'sol_queued">too-late';
					break; 
				default:
					echo 'sol_queued">pending...';
					break;
			}
		?></span></a></td>
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['VERIFIER']; ?></a></td>
		</tr>
	</tbody>
</table>
			<?php $counter++;
			}
		} else {
	?>
	<p class="nodata">No new submission requests.</p>
	<?php } ?>

	<h3 id="newrequests">New Requests:</h3>
	<?php
		if(count($pendings[0]) > 0){
			$counter = 1;
			foreach ($pendings as $row) {
			?>
			<table class="list sortable">
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">time</th>
				<th scope="col">code-name</th>
				<th scope="col">name</th>
				<th scope="col">problem</th>
				<th scope="col">result</th>
				<th scope="col">verified-by</th>
			</tr>
		</thead>
	<tbody>
		<tr class="<?php if($counter%2 ==0) echo "roweven"; else echo "rowodd" ?>" data-team-id="<?php echo $row['NAME_CODE']; ?>" data-problem-id="<?php echo $row['PROB_NUM'] ?>" data-language-id="sql" data-submission-id="<?php echo $row['SUB_ID']; ?>">
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['SUB_ID']; ?></a></td>
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>">
			<?php
				$tot = $row['SUBMIT_TIME'];
				$sec = $tot % 60;
				$min = ($tot - $sec) / 60;
				echo sprintf("%02d:%02d", $min,$sec);
			?>
			</a></td>
			<td title="t666"><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['NAME_CODE']; ?></a></td>
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['NAME']; ?></a></td>
			<td class="probid" title="Summits"><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['PROB_NUM']; ?></a></td>
			<td class="result"><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>">
			<span class="sol <?php
			switch ($row['STATUS']) {
				case '0':
					echo 'sol_correct">correct';
					break;
				case '1':
					echo 'sol_incorrect">wrong-answer';
					break;
				case '2':
					echo 'sol_incorrect">syntax-error';
					break;
				case '666':
					echo 'sol_queued">too-late';
					break; 
				default:
					echo 'sol_queued">pending...';
					break;
			}
		?></span></a></td>
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['VERIFIER']; ?></a></td>
		</tr>
	</tbody>
</table>
			<?php $counter++;
			}
		} else {
	?>
	<p class="nodata">No new clarification requests.</p>
	<?php } ?>

	<h3 id="oldrequests">Verified Requests:</h3>
	<?php
		if(count($confirmed[0]) > 0){
			$counter = 1;
			?>

			<table class="list sortable">
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">time</th>
				<th scope="col">code-name</th>
				<th scope="col">name</th>
				<th scope="col">problem</th>
				<th scope="col">result</th>
				<th scope="col">verified-by</th>
			</tr>
		</thead>
	<tbody>
			<?php
			foreach ($confirmed as $row) {
			?>
		<tr class="<?php if($counter%2 ==0) echo "roweven"; else echo "rowodd" ?>" data-team-id="<?php echo $row['NAME_CODE']; ?>" data-problem-id="<?php echo $row['PROB_NUM'] ?>" data-language-id="sql" data-submission-id="<?php echo $row['SUB_ID']; ?>">
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['SUB_ID']; ?></a></td>
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>">
			<?php
				$tot = $row['SUBMIT_TIME'];
				$sec = $tot % 60;
				$min = ($tot - $sec) / 60;
				echo sprintf("%02d:%02d", $min,$sec);
			?>
			</a></td>
			<td title="t666"><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['NAME_CODE']; ?></a></td>
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['NAME']; ?></a></td>
			<td class="probid" title="Summits"><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['PROB_NUM']; ?></a></td>
			<td class="result"><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>">
			<span class="sol <?php
			switch ($row['STATUS']) {
				case '0':
					echo 'sol_correct">correct';
					break;
				case '1':
					echo 'sol_incorrect">wrong-answer';
					break;
				case '2':
					echo 'sol_incorrect">syntax-error';
					break;
				case '666':
					echo 'sol_queued">too-late';
					break; 
				default:
					echo 'sol_queued">pending...';
					break;
			}
		?></span></a></td>
			<td><a href="<?php echo "submission.php?id=" . $row['SUB_ID']; ?>"><?php echo $row['VERIFIER']; ?></a></td>
		</tr>
	
			<?php $counter++;
			}?>
		</tbody>
</table>
		<?php } else {
	?>
	<p class="nodata">No new clarification requests.</p>
	<?php } ?>


</body>
</html>