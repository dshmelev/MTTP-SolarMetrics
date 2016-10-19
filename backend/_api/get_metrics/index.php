<?php
# Headers
header('Access-Control-Allow-Origin: *');

$time_start = microtime(true);
include '../settings.php';
include 'helpers.php';

# Constants
$MULTIPLICATOR = 1.53;

# Variables
$offset = ( isset($_GET['offset']) ? $_GET['offset'] : 'last' );
if ($offset == 'last') {
  $num = '1 HOUR';  $group = 'day';
} elseif ($offset == 'day(timestamp)') {
  $num = '3 DAY';   $group = 'day(timestamp), hour(timestamp)';
} elseif ($offset == 'month') {
  $num = '1 MONTH'; $group = 'day(timestamp)';
} elseif ($offset == 'year') {
  $num = '1 YEAR';  $group = 'month(timestamp)';
} else {
  fails_with_json("offset is not valid!");
}

# Logics
$link = mysql_connect($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASS)
    or fails_with_json( 'mysql_connect: ' . mysql_error() );

mysql_select_db($MYSQL_DBASE, $link)
    or fails_with_json( 'mysql_select: ' . mysql_error(), $link );

$query = sprintf('SELECT UNIX_TIMESTAMP(timestamp) as timestamp, SUM(value) as value FROM %s WHERE (`timestamp` > DATE_SUB(now(), INTERVAL %s)) GROUP BY %s ORDER BY id DESC',
  $MYSQL_TABLE_METRICS,
  mysql_real_escape_string($num),
  mysql_real_escape_string($group));
$result = mysql_query($query) or fails_with_json('mysql_query: ' . mysql_error());

$output = [];
while ($r = mysql_fetch_row($result, MYSQL_ASSOC)) {
  $value = $r['value'] * $MULTIPLICATOR;
  array_push($output, array( $r['timestamp'] * 1000, (int) $value ) );
}

mysql_free_result($result);
mysql_close($link);

echo_to_json( array_reverse( $output ) );

$time_end = microtime(true);
$execution_time = ($time_end - $time_start) * 1000;
header('API-Response-Time: ' . round($execution_time,2) . 'ms');
?>
