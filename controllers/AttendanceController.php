<?php

require_once __DIR__.'/../database/AttendanceModel.php';

class AttendanceController {

    public function __construct($db_file_path) {
        $this->model = new AttendanceModel($db_file_path);
    }

    public function getAttendanceByDay($date) {

        $attendances = $this->model->byDay($date);

        $data = array();

        while($row = $attendances->fetchArray(SQLITE3_ASSOC)) {
            array_push($data, $row);
        }

        send_response(['data' => $data]);
    }

    public function getMonthlyAttendanceCSV($year, $month) {
        
        $date = "01-$month-$year";

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
            send_response(['message' => 'Missing input parameters'], 400);
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

            send_response(['message' => 'Attendance successfully saved', 'data' => $data], 201);
        } catch (Exception $err) {
            send_response(['message' => 'Unable to save attendance, error occurred', 'error' => $err], 500);
        }
    }
}
