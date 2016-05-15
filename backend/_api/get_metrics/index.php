<?php
include '../settings.php';

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

function reduce_array($array, $new_len) {
    $len = count($array);
      if ($len < $new_len) {
            return $array;
              }
      $seperation = $len / $new_len;
      $assoc = array(); // stores result
        for($i = 0; $i < count($array)-1; $i = $i+$seperation ) {
              $calc_value = $array[ceil($i)];
                  array_push($assoc, $calc_value);
                }
        return $assoc;
}

function fails_with_json($str, $link){
    defined($link) or mysql_close($link);
      $msg['error'] = $str;
      echo_to_json($msg);
        die;
}

function echo_to_json($value) {
    echo json_encode($value);
}
?>
