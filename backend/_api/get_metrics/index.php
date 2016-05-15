<?php
include '../settings.php';
include 'helpers.php';

$num = $_GET['num'];
$col = $_GET['col'];
isset($col) OR $col = 15;

if (!is_numeric($num)) {
    fails_with_json("num is not numeric!");
}
if (!is_numeric($col)) {
    fails_with_json("col is not numeric!");
}
if ($num < $col) {
    $num = $col;
}

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
    array_push($output, array( $r['timestamp'] * 1000, (int) $r['value']  ) );
}

mysql_free_result($result);
mysql_close($link);

echo_to_json( array_reverse( reduce_array($output, $col) ) );

?>
