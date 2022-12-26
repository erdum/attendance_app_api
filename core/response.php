<?php 

function send_response($payload = array(), $status_code = 200) {
  header('Content-Type: application/json');
  http_response_code($status_code);
  exit(json_encode((object) $payload));
};
