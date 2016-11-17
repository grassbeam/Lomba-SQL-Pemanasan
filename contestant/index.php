<?php
	session_start();
	define('BASE', 'BASE');
	require_once '../utility/config.php';
	require_once '../utility/connection.php';
	require_once '../utility/utility.php';
	require_once '../model/submits.php';
	require_once '../model/scoreboard-oracle.php';
	require_once '../model/timer.php';

	
	if(isset($_SESSION['NAME_CODE'])) {
		if(!isset($_SESSION['LOMBA']) || $_SESSION['LOMBA'] != 1 ) {
			redirect('../auth/logout.php');
		}
		$hidvalform = $_SESSION['NAME_CODE'];
		$ussr = $_SESSION['USERNAME'];
		
		$DBSUBS = new DB_SUBMIT();
		$TIMER = new TIMER();

		$submitlist = $DBSUBS->getSubmission($hidvalform);
		$kosong = true;
		if(isset($submitlist)){
			$kosong = false;
		}
		$starttime = "1478982205.000000000"; // select from db later
		$endtime = "1478992277.000000000"; // select from db later
		$activatetime = "147892105.000000000";
		$timernow = strtotime("now");
		$stm = $TIMER->getStart();
		$etm = $TIMER->getEnd();
		$atm = $TIMER->getActivate();
		$itm = $TIMER->getInit();


		

		$TIMER->close();
		if(isset($stm)) {
			$stm = strtotime($stm);
			$starttime = $stm;
		}
		if(isset($etm)) {
			$etm = strtotime($etm);	
			$endtime = $etm;
		}
		if(isset($atm)) {
			$atm = strtotime($atm);
			$activatetime = $atm;
		}
		if(isset($itm)) {
			$timernow = $itm;
		}

		$isstart = true;
		// if($starttime < $timernow && $endtime > $timernow){
		// 	$isstart = true;
		// }
		// var_dump($isstart);
		$DBSBO = new SBO();
		$SBdetail = $DBSBO->getContestantDetail($hidvalform);
		$totalscore = $DBSBO->getTotalScore($hidvalform);
		$totalac = $DBSBO->getTotalAC($hidvalform);
		$probSums = $DBSBO->getProbnum();

		$DBSBO->close();
		if(!isset($SBdetail) || !isset($probSums) ){
			die('<h1>ERROR DATABASE</h1>');
			exit();
		}
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../css/style.css">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/domjudge.js"></script>
	<script type="text/javascript">
		function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('timer').innerHTML = "Jam: " + 
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
	</script>
</head>
<body onload="startTime()">
	<nav>
	<div id="menutop">
		<a target="_top" href="index.php" accesskey="o"><span class="octicon octicon-home"></span> overview</a>
		<a target="_top" href="../problem/" accesskey="t"><span class="octicon octicon-book"></span> problems</a>
	</div>

<div id="menutopright">
<div id="clock"><span id="timer"></span><div id="username">logged in as <abbr title="team">Contestant user</abbr> <a href="../auth/logout.php">×</a></div></div>
<script type="text/javascript">
	var initial = <?php echo $timernow;?>;
	var activatetime = <?php echo $activatetime;?>;
	var starttime = <?php echo $starttime ;?> ;
	var endtime = <?php echo $endtime ;?> ;
	var offset = 0;
	var date = new Date(initial*1000);
	var timeleftelt = document.getElementById("timeleft");

	// setInterval(function(){updateClock();},1000);
	// updateClock();
</script>
</div></nav>

<script type="text/javascript">
<!--
function getMainExtension(ext)
{
	switch(ext) {
		case 'sql': return 'sql';
		case 'txt': return 'txt';
		default: return '';
	}
}

function getProbDescription(probid)
{
	switch(probid) {
		case 'A': return 'Assemble';
		case 'B': return 'March of the Penguins';
		case 'C': return 'Containers';
		case 'D': return 'Youth Hostel Dorm';
		case 'E': return 'Escape from Enemy Territory';
		case 'F': return 'Flight Safety';
		case 'G': return 'Summits';
		case 'H': return 'Obfuscation';
		case 'I': return 'Tower Parking';
		case 'J': return 'Walk';
		default: return '';
	}
}
</script>
<h2 id="teamwelcome">Welcome <?php if(isset($_SESSION['NAME'])) echo $_SESSION['USERNAME']; else "NO_NAME"; ?></h2>
	<?php if($isstart) {?>
	<div class="teamscoresummary">
		<table class="scoreboard center">
			<colgroup><col id="scorerank" /><col id="scoreaffil" /><col id="scoreteamname" /></colgroup><colgroup><col id="scoresolv" /><col id="scoretotal" /></colgroup>
			<colgroup><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /><col class="scoreprob" /></colgroup>

			<thead>
				<tr class="scoreheader">
					<th title="rank" scope="col">rank</th>
					<th title="team name" scope="col" colspan="2">Name</th>
					<th title="# solved / penalty time" colspan="2" scope="col">score</th>
					<!-- PROBLEM LIST -->
				<?php for($i=0;$i<$probSums;$i++) { ?>
				<th title="Problem <?php echo $i+1; ?>" scope="col">
				
				<?php
					$huruf = $i+1;
					switch ($huruf) {
					 	case '1':
					 		$str = "A";
					 		?><a href="../problem/<?php echo $str?>.pdf"> A <div class="circle" style="background: #ff00ff;"><?php
					 		break;
					 	case '2':
					 		$str = "B";
					 		?><a href="../problem/<?php echo $str?>.pdf">B <div class="circle" style="background: #ef30b3;"><?php
					 		break;
					 	case '3':
					 		$str = "C";
					 		?><a href="../problem/<?php echo $str?>.pdf">C <div class="circle" style="background: #8b4ec1;"><?php
					 		break;
					 	case '4':
					 		$str = "D";
					 		?><a href="../problem/<?php echo $str?>.pdf"> D <div class="circle" style="background: #bea0f0;"><?php
					 		break;
					 	case '5':
					 		$str = "E";
					 		?><a href="../problem/<?php echo $str?>.pdf"> E <div class="circle" style="background: #87011f;"><?php
					 		break;
					 	case '6':
					 		$str = "F";
					 		?><a href="../problem/<?php echo $str?>.pdf"> F <div class="circle" style="background: #855ef9;"><?php
					 		break;
					 	case '7':
					 		$str = "G";
					 		?><a href="../problem/<?php echo $str?>.pdf">G <div class="circle" style="background: #0f077b;"><?php
					 		break;
					 	case '8':
					 		$str = "H";
					 		?><a href="../problem/<?php echo $str?>.pdf">H <div class="circle" style="background: #cc78ed;"><?php
					 		break;
					 	case '9':
					 		$str = "I";
					 		?><a href="../problem/<?php echo $str?>.pdf">I <div class="circle" style="background: #1a4c38;"><?php
					 		break;
					 	case '10':
					 		$str = "J";
					 		?><a href="../problem/<?php echo $str?>.pdf">J <div class="circle" style="background: #da6234;"><?php
					 		break;
					 	case '11':
					 		$str = "K";
					 		?><a href="../problem/<?php echo $str?>.pdf">K <div class="circle" style="background: #ff00ff;"><?php
					 		break;
					 	case '12':
					 		$str = "L";
					 		?><a href="../problem/<?php echo $str?>.pdf">L <div class="circle" style="background: #10c5e4;"><?php
					 		break;
					 	case '13':
					 		$str = "M";
					 		?><a href="../problem/<?php echo $str?>.pdf">M <div class="circle" style="background: #653b72;"><?php
					 		break;
					 	case '14':
					 		$str = "N";
					 		?><a href="../problem/<?php echo $str?>.pdf">N <div class="circle" style="background: #5ad9dc;"><?php
					 		break;
					 	case '15':
					 		$str = "O";
					 		?><a href="../problem/<?php echo $str?>.pdf">O <div class="circle" style="background: #36e57e;"><?php
					 		break;
					 	case '16':
					 		$str = "P";
					 		?><a href="../problem/<?php echo $str?>.pdf">P <div class="circle" style="background: #e0066e;"><?php
					 		break;
					 	case '17':
					 		$str = "Q";
					 		?><a href="../problem/<?php echo $str?>.pdf">Q <div class="circle" style="background: #98f949;"><?php
					 		break;
					 	case '18':
					 		$str = "R";
					 		?><a href="../problem/<?php echo $str?>.pdf">R <div class="circle" style="background: #cea595;"><?php
					 		break;
					 	case '19':
					 		$str = "S";
					 		?><a href="../problem/<?php echo $str?>.pdf">S <div class="circle" style="background: #cea515;"><?php
					 		break;
					 	default:
					 		$str = "ZZ";
					 		?><a href="../problem/<?php echo $str?>.pdf">ZZ <div class="circle" style="background: #ef30b3;"><?php
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
							?>
						<tr class="sortorderswitch" id="team:<?php if(isset($_SESSION['NAME_CODE'])) echo $_SESSION['NAME_CODE']; else echo "666"; ?>">
							<td class="scorepl">?<?php //echo $counter; ?></td>
							<td class="scoreaf"> <img src="../images/IDN.png" alt="IDN" title="IDN" /></td>
							<td class="scoretn">
								<?php if(isset($_SESSION['NAME'])) echo $_SESSION['USERNAME']; else "NO_NAME"; ?> <br /><span class="univ"><?php if(isset($_SESSION['SCHOOL'])) echo $_SESSION['NAME_CODE']; else "UNKNOWN"; ?></span>
							</td>
							<td class="scorenc"><?php echo $totalac; ?></td> <!--Total soal submited -->
							<td class="scorett"><?php echo $totalscore; ?></td>
							<?php for($i=1; $i<=$probSums; $i++){ ?>
							<td class="
							<?php
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
							 ?>">
							 <?php 
							 	if($SBdetail[$i]['VERDICT'] === 0) {
							 		echo $SBdetail[$i]['SUBMIT_COUNT'] . "/" . $SBdetail[1]['SUBMIT_TIME'] ; 
							 	} else {
							 		echo $SBdetail[$i]['SUBMIT_COUNT'];
							 	}
							 }
							 ?>
							 	
							 </td>
						</tr>
							<?php				
				?>
			</tbody>	
		</table>
	</div>
	

	<div id="submitlist" <?php if(!$isstart) {echo "style='display:none'";} ?>>
		<h3 class="teamoverview">Submissions</h3>

	<script type="text/javascript">
	$(function() {
		var matches = location.hash.match(/submitted=(\d+)/);
		if (matches) {
			var $p = $('<p class="submissiondone" />').html('submission done <a href="#">x</a>');
			$('#submitlist > .teamoverview').after($p);
			$('table.submissions tr[data-submission-id=' + matches[1] + ']').addClass('highlight');

			$('.submissiondone a').on('click', function() {
				$(this).parent().remove();
				$('table.submissions tr.highlight').removeClass('highlight');
				reloadLocation = 'index.php';
			});
		}
	});
	</script>
	
	<form style="display:<?php if($isstart) echo "inline"; else echo "hidden";?>;" action="upload.php" method="post" enctype="multipart/form-data" onreset="resetUploadForm(30, 100);">
	<p id="submitform">
	<input type="hidden" name="nc" value="<?php echo $hidvalform; ?>">
	<input type="hidden" name="us" value="<?php echo $ussr; ?>">
	<input type="file" name="maincode" id="maincode" required accept=".sql" />
	<select name="probid" id="probid">
	<?php for($i=0;$i<$probSums;$i++) { 
			$huruf = $i+1;?>
		<option value="<?php echo $huruf ;?>">
				<?php
					
					switch ($huruf) {
					 	case '1':
					 		?>A</option><?php
					 		break;
					 	case '2':
					 		?>B</option><?php
					 		break;
					 	case '3':
					 		?>C</option><?php
					 		break;
					 	case '4':
					 		?>D</option><?php
					 		break;
					 	case '5':
					 		?>E</option><?php
					 		break;
					 	case '6':
					 		?>F</option><?php
					 		break;
					 	case '7':
					 		?>G</option><?php
					 		break;
					 	case '8':
					 		?>H</option><?php
					 		break;
					 	case '9':
					 		?>I</option><?php
					 		break;
					 	case '10':
					 		?>J</option><?php
					 		break;
					 	case '11':
					 		?>K</option><?php
					 		break;
					 	case '12':
					 		?>L</option><?php
					 		break;
					 	case '13':
					 		?>M</option><?php
					 		break;
					 	case '14':
					 		?>N</option><?php
					 		break;
					 	case '15':
					 		?>O</option><?php
					 		break;
					 	case '16':
					 		?>P</option><?php
					 		break;
					 	case '17':
					 		?>Q</option><?php
					 		break;
					 	case '18':
					 		?>R</option><?php
					 		break;
					 	default:
					 		?>ZZ</option><?php
					 		break;
					 } 
				?>
			<?php } ?>
	<option value="" selected="selected">problem</option>
	</select>
	<select name="langid" id="langid">
	<option value="sql">SQL</option>
	<option value="" selected="selected">file format</option>
	</select>
	<input type="submit" name="submit" id="submit" value="submit"  onclick="return checkUploadForm();" />
	<input type="reset" value="cancel"  />
	<br /><span id="auxfiles"></span>
	<input type="button" name="addfile" id="addfile" value="Add another file" onclick="addFileUpload();" disabled="false"/>
	<script type="text/javascript">initFileUploads(100);</script>

	</p>
	</form>
	<table class="list sortable submissions">
<thead>
<tr><th scope="col">time</th><th scope="col">problem</th><th scope="col">file</th><th scope="col">result</th></tr>
</thead>
<tbody>
<?php
	if(!$kosong){

	$counter = 1;
	foreach ($submitlist as $row) {
		
?>
	<tr class="<?php if($counter %2 == 0) echo "roweven "; else echo "rowodd "?>unseen" data-team-id="<?php echo $row['NAME_CODE'];?>" data-problem-id="<?php echo $row['PROB_NUM'];?>" data-language-id="sql" data-submission-id="<?php echo $row['SUB_ID'];?>">
		<td>
			<a>
			<?php
				$tot = $row['SUBMIT_TIME'];
				$sec = $tot % 60;
				$min = ($tot - $sec) / 60;
				echo sprintf("%02d:%02d", $min,$sec);
			?>
			</a>
		</td>
		<td class="probid" title="<?php echo $row['SOLUTION_QUERY'];?>"><a><?php echo $row['PROB_NUM'];?></a></td>
		<td class="langid" title="SQL"><a>SQL</a></td>
		<td class="result">
		<a><span class="sol 
		<?php
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
		?>
		</span></a></td>
	</tr>
<?php
	$counter++;
		}
	}
?>
</tbody>
</table>



	</div>
	<?php }?>
</body>
</html>