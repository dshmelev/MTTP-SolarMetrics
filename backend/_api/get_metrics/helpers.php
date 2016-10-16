<?php

function reduce_array($array, $new_len) {
  $len = count($array);
  if ($len <= $new_len) {
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

function fails_with_json($str, $link = null){
  is_null($link) ?: mysql_close($link);
  $msg['error'] = $str;
  echo_to_json($msg);
  die;
}

function echo_to_json($value) {
  echo json_encode($value);
}

?>
