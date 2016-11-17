<?php?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php
		$to_time = strtotime('13-NOV-2016 04:50:00');
		$from_time = strtotime("now");
		echo round(abs($to_time - $from_time) / 60). " minute";
	?>
</body>
</html>