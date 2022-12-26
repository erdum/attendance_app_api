<?php

require_once __DIR__.'/core/router.php';
require_once __DIR__.'/core/response.php';
require_once __DIR__.'/core/db.php';

get('/attendances', function() {
  send_response(getAllAttendances());
});

post('/attendance', function() {
  exit(print_r($_POST));
});

any('/404', '404.php');