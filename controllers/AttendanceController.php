<?php

require_once __DIR__.'/../database/AttendanceModel.php';

class AttendanceController {

    public function __construct($db_file_path) {
        $this->model = new AttendanceModel($db_file_path);
    }

    public function getUserTodayAttendance($date, $uid) {

        if (!checkInputDate($date)) {
            send_response(array('message' => 'Invalid input parameters expected input DD-MM-YYYY'), 400);
        }

        $attendance = $this->model->userByDay($uid, $date);

        if (!$attendance) {
            send_response(array('message' => 'Requested resource not found'), 404);
        }

        send_response(array('data' => $attendance));
    }

    public function getAttendanceByDay($date) {

        if (!checkInputDate($date)) {
            send_response(array('message' => 'Invalid input parameters expected input DD-MM-YYYY'), 400);
        }

        $attendances = $this->model->byDay($date);

        $data = array();

        while($row = $attendances->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }

        send_response(array('data' => $data));
    }

    public function getMonthlyAttendanceCSV($year, $month) {
        
        $date = "01-$month-$year";

        if (!checkInputDate($date)) {
            send_response(array('message' => 'Invalid input parameters expected input DD-MM-YYYY'), 400);
        }

        $result = $this->model->byMonth($date);

        header('Content-Type: text/csv; charset=utf-8');  
        header('Content-Disposition: attachment; filename=attendance.csv');

        $output = fopen("php://output", "w");
        fputcsv($output, array(
            'id',
            'uid',
            'name',
            'email',
            'check_in_date',
            'check_in_time',
            'check_out_date',
            'check_out_time',
            'check_in_coordinates',
            'check_out_coordinates',
            'check_in_location'
        ));

        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            fputcsv($output, $row);
        }

        fclose($output);
    }

    public function markAttendance() {

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
            send_response(array('message' => 'Missing input parameters'), 400);
        }

        try {
            $this->model->insertAttendance(
                $data['uid'],
                $data['name'],
                $data['email'],
                $data['date'],
                $data['time'],
                $data['coordinates'],
                $data['location']
            );

            send_response(array('message' => 'Attendance successfully saved', 'data' => $data), 201);
        } catch (Exception $err) {
            send_response(array('message' => 'Unable to save attendance, error occurred', 'error' => $err), 500);
        }
    }

    public function markCheckout($uid) {

        $params = array(
            'date',
            'time',
            'coordinates',
        );
        $data = json_decode(file_get_contents("php://input"), true);

        if (count(array_diff($params, array_keys($data))) > 0) {
            send_response(array('message' => 'Missing input parameters'), 400);
        }

        $check_in_date = date('Ymd', strtotime('-6 hours', $data['time']));

        try {
            $this->model->updateCheckout(
                $uid,
                $check_in_date,
                $data['date'],
                $data['time'],
                $data['coordinates']
            );

            send_response(array('message' => 'Checkout successfully saved', 'data' => $data), 201);
        } catch (Exception $err) {
            send_response(array('message' => 'Unable to save checkout, error occurred', 'error' => $err), 500);
        }
    }
}
