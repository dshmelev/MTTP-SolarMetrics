<?php
# Headers
header('Access-Control-Allow-Origin: *');

$time_start = microtime(true);
include '../settings.php';
include 'helpers.php';

# Constants
$MULTIPLICATOR = 1.53;

# Variables
$num = ( isset($_GET['num']) ? $_GET['num'] : null );
$col = ( isset($_GET['col']) ? $_GET['col'] : 15   );
is_numeric($num) ?: fails_with_json("num is not numeric!");
is_numeric($col) ?: fails_with_json("col is not numeric!");
if ($num < $col) {
    $num = $col;
}

$output = [[1476277202000,182],[1476277503000,120],[1476277803000,111],[1476278104000,108]];
echo_to_json( array_reverse( reduce_array($output, $col) ) );
exit;

# Logics
$link = mysql_connect($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASS)
    or fails_with_json( 'mysql_connect: ' . mysql_error() );

mysql_select_db($MYSQL_DBASE, $link)
    or fails_with_json( 'mysql_select: ' . mysql_error(), $link );

$query = sprintf('SELECT UNIX_TIMESTAMP(timestamp) as timestamp, value FROM %s ORDER BY id DESC LIMIT %s',
  $MYSQL_TABLE_METRICS,
  mysql_real_escape_string($num));
$result = mysql_query($query) or fails_with_json('mysql_query: ' . mysql_error());

$output = [];
while ($r = mysql_fetch_row($result, MYSQL_ASSOC)) {
  $value = $r['value'] * $MULTIPLICATOR;
  array_push($output, array( $r['timestamp'] * 1000, (int) $value ) );
}

mysql_free_result($result);
mysql_close($link);

echo_to_json( array_reverse( reduce_array($output, $col) ) );

$time_end = microtime(true);
$execution_time = ($time_end - $time_start) * 1000;
header('API-Response-Time: ' . round($execution_time,2) . 'ms');
header('API-QStats-count: ' . count($output));
?>
