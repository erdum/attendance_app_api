<?php 

function send_response($payload, $status_code = 200) {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header("HTTP/1.0 $status_code");
  exit(json_encode((object) $payload));
};
