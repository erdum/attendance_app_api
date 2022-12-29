<?php

require_once __DIR__.'/core/router.php';
require_once __DIR__.'/controllers/AttendanceController.php';

$config = array(
  'db_path' => __DIR__.'/database/database.db'
);

$attendanceController = new AttendanceController($config['db_path']);

get('/attendance/today/$date', array($attendanceController, 'getAttendanceByDay'));
get('/attendance/csv/$year/$month', array($attendanceController, 'getMonthlyAttendanceCSV'));
post('/attendance/checkout', array($attendanceController, 'markCheckout'));
post('/attendance', array($attendanceController, 'markAttendance'));

any('/404', '404.php');