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

  try {
    insertCheckIn(
      $data['uid'],
      $data['name'],
      $data['email'],
      $data['date'],
      $data['time'],
      $data['coordinates'],
      $data['location']
    );

    send_response(['message' => 'Attendance successfully saved', 'data' => $data], 201);
  } catch (Exception $err) {
    send_response(['message' => 'Unable to save attendance, error occurred', 'error' => $err], 500);
  }
  
});

get('/attendance/$id/$date', function($id, $date) {

  $attendance = getUserAttendanceByDate($id, $date);

  if (!$attendance) {
    send_response(['message' => 'Requested resource not found'], 404);
  }

  send_response(getAttendance($id));
});

any('/404', '404.php');