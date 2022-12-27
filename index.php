<?php

require_once __DIR__.'/core/router.php';
require_once __DIR__.'/controllers/AttendanceController.php';

$attendanceController = new AttendanceController();

get('attendance/today/$date', $attendanceController->getAttendanceByDay($date));
get('/attendance/csv/$year/$month', $attendanceController->getMonthlyAttendanceCSV($year, $month));
put('/attendance', $attendanceController->markAttendance());

any('/404', '404.php');