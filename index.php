<?php

require_once __DIR__.'/core/router.php';
require_once __DIR__.'/controllers/AttendanceController.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
  header('Access-Control-Allow-Headers: apikey, Content-Type');
  header('Access-Control-Max-Age: 300');
  header('Content-Length: 0');
  header('Content-Type: application/json');
  die();
}

$config = array(
  'db_path' => __DIR__.'/database/database.db'
);

$attendanceController = new AttendanceController($config['db_path']);

get('/attendance/today/$date', array($attendanceController, 'getAttendanceByDay'));
get('/attendance/csv/$year/$month', array($attendanceController, 'getMonthlyAttendanceCSV'));
get('/attendance/$date/$uid', array($attendanceController, 'getUserTodayAttendance'));
post('/attendance/$uid', array($attendanceController, 'markCheckout'));
post('/attendance', array($attendanceController, 'markAttendance'));

any('/404', '404.php');