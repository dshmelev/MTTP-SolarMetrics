<?php

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
