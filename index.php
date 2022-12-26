<?php

include 'vendor/autoload.php';

require_once __DIR__.'/core/router.php';
require_once __DIR__.'/core/response.php';
require_once __DIR__.'/core/db.php';

get('/attendances', function() {
  send_response(getAllAttendances());
});

any('/404', '404.php');