<?php

require_once __DIR__.'/core/router.php';
require_once __DIR__.'/core/response.php';
require_once __DIR__.'/core/db.php';

get('/attendances', function() {
  send_response(getAllAttendances());
});

put('/attendance', function() {
  
  $params = array(
    'uid',
    'name',
    'email',
    'date',
    'time',
    'coordinates',
    'location'
  );

  $data = json_decode(file_get_contents("php://input"), true);

  if (count(array_diff($params, array_keys($data))) > 0) {
    send_response(['message' => 'Missing input parameters'], 400);
  }

  insertCheckIn(
    $data['uid'],
    $data['name'],
    $data['email'],
    $data['date'],
    $data['time'],
    $data['coordinates'],
    $data['location']
  );

  send_response(['message' => 'Attendance successfully saved'], 201);
});

get('/attendance/$id', function($id) {

  $attendance = getAttendance($id);

  if (!$attendance) {
    send_response(['message' => 'Requested resource not found'], 404);
  }
  
  send_response(getAttendance($id));
});

any('/404', '404.php');