<?php

require_once __DIR__.'/core/router.php';
require_once __DIR__.'/core/response.php';
require_once __DIR__.'/core/db.php';

get('/attendances', function() {
  send_response(getAllAttendances());
});

post('/attendance', function() {
  
  $params = array(
    'uid',
    'name',
    'email',
    'date',
    'time',
    'coordinates',
    'location'
  );

  if (count(array_diff($params, array_keys($_POST))) > 0) {
    send_response(['message' => 'Missing input parameters'], 400);
  }

  insertCheckIn(
    $_POST['uid'],
    $_POST['name'],
    $_POST['email'],
    $_POST['date'],
    $_POST['time'],
    $_POST['coordinates'],
    $_POST['location']
  );
});

get('/attendance/$id', function($id) {
  send_response(getAttendance($id));
});

any('/404', '404.php');