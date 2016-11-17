<?php
	session_start();
	define('BASE', 'BASE');
	require_once '../utility/config.php';
	require_once '../utility/connection.php';
	require_once '../utility/utility.php';
	require_once '../model/submits.php';
	$DBSUBMIT = new DB_SUBMIT();

		if(!isset($_GET['id'])){
			die("<fieldset class='error'><legend>ERROR</legend> error: Missing or invalid submission id</fieldset><!-- trigger HTML validator error: --><b>");
		}
		$subid = $_GET['id'];
		$subdetail = $DBSUBMIT->getDetail($subid);
		$DBSUBMIT->close(); // CLOSE CONNECTION
		$path = $subdetail['SUBMITTED_TEXT'];
		$queryans = file_get_contents($path);
		if(!isset($subdetail)) {
			die("<fieldset class='error'><legend>ERROR</legend> error: Missing or invalid submission id</fieldset><!-- trigger HTML validator error: --><b>");
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
	

	<h1>Send Clarification Request</h1>


<script type="text/javascript">
<!--
function confirmClar() {
	return confirm("Send clarification request to Jury?");
}
// -->
</script>
<?php
	if(isset($_GET['id'])){

?>
<form style="display:inline;" action="updater.php" method="post" id="sendclar">
<table>
<tr><td><b>SUBMISSION ID:</b></td><td><?php echo $subdetail['SUB_ID']; ?></td></tr>
<tr><td><b>Subject:</b></td><td>
<input type="hidden" name="subid" value="<?php echo $subdetail['SUB_ID']; ?>">
<select name="problem" id="problem">
<option value="">Select Verification</option>
<option value="0"><span class="sol sol_correct">Correct</span></option>
<option value="1"><span class="sol sol_incorrect">Wrong Answer</span></option>
</select>
</td></tr>
<tr>
<td><b><label for="">Query</label>:</b></td>
<td><p id="bodytext"><?php echo $queryans;?></p>
</td></tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="submit" id="submit" value="Send"  onclick="return confirmClar()" disabled />
</td>
</tr>
</table>
</form>
<script type="text/javascript">
<!--
document.forms['sendclar'].bodytext.focus();
document.forms['sendclar'].bodytext.select();
// -->
</script>
<?php
	}
?>

</body>
</html>