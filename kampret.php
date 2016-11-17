<?php

$date = date_create('2014-11-15 00:30:00');
$tm = strtotime('2016-11-15 00:30:00');
$now = strtotime("now");
echo "tm => " . $tm . " now => " . $now;


?>