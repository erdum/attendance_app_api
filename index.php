<?php

require_once __DIR__.'/core/router.php';
require_once __DIR__.'/core/response.php';
require_once __DIR__.'/core/db.php';

get('/users', function() {
  send_response(getAllUsers());
});

any('/404', '404.php');
