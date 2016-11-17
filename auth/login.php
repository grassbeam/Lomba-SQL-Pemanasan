<?php
	session_start();
	define('BASE', 'BASE');
	require_once '../utility/config.php';
	require_once '../utility/connection.php';
	require_once '../utility/utility.php';
	require_once '../model/user.php';
	if(isset($_POST['cmd'])) {
		$username = $_POST['login'];
		$password = $_POST['passwd'];
		if($username === "" || $password === "") {
			$empty = true;
		} else {
			$DBUSER = new DB_USER();
			$logs = $DBUSER->getLogin($username, $password);
			$DBUSER->close();
			// var_dump($logs);
			if(isset($logs)){
				//echo "<script>console.log('masuk loh');</script>";
				$_SESSION['LOMBA'] = 1;
				redirect('../');
			} else {
				$invalid = true;
			}
		}
	}

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scoreboard</title>
	<link rel="stylesheet" href="../css/style.css">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/domjudge.js"></script>
</head>
<body>
	<h1>Not Authenticated</h1>

<?php
	if(isset($invalid)) {
		echo "<p>Invalid username or password supplied. Please try again or contact a staff member.</p>";
	} else if (isset($empty)) {
		echo "<p>Please supply a username and password.</p>";
	} else {
?>
<p>Please supply your credentials below, or contact a staff member for assistance.</p>
<form action="./login.php" method="post">
	<input type="hidden" name="cmd" value="login" />
	<table>
		<tr>
			<td>
				<label for="login">Login:</label>
			</td>
			<td>
				<input type="text" id="login" name="login" value="" size="25" maxlength="25" accesskey="l" autofocus />
				</td>
		</tr>
		<tr>
			<td>
				<label for="passwd">Password:</label>
			</td>
			<td>
				<input type="password" id="passwd" name="passwd" value="" size="25" maxlength="255" accesskey="p" />
			</td>
		</tr>
		<tr><td></td><td><input type="submit" value="Login" /></td></tr>
	</table>
</form>

<hr />
<address>
	Azureblashh2177judge/6.6.6DEV at localhost Port 80, page generated 
	<span id="timecur"> <?php echo date("D d M Y H:i:s") . " WIB";?> </span>
</address>
<?php } ?>
</body>
</html>