<?php

class AttendanceModel {

    public function __construct($db_file_path) {
        $this->db = new SQLite3($db_file_path);
    }

    public function byDay($date) {
        
        $query = <<<SQL
        select * from attendance where check_in_date = :date;
SQL;

        $stmt = $this->db->prepare($query);

        $day = (int) date('Ymd', strtotime($date));
        $stmt->bindParam(':date', $day, SQLITE3_INTEGER);

        $result = $stmt->execute();
        $stmt->reset();

        return $result;
    }

    public function byMonth($date) {

        $query = <<<SQL
        select * from attendance where check_in_date >= :from_date and check_in_date < :to_date;
SQL;

        $stmt = $this->db->prepare($query);

        $from_date = (int) date('Ymd', strtotime($date));
        $to_date = (int) date("Ymd", strtotime('+1 month', strtotime($date)));

        $stmt->bindParam(':from_date', $from_date, SQLITE3_INTEGER);
        $stmt->bindParam(':to_date', $to_date, SQLITE3_INTEGER);

        $result = $stmt->execute();
        $stmt->reset();

        return $result;
    }

    public function insertAttendance(
        $uid,
        $name,
        $email,
        $check_in_date,
        $check_in_time,
        $check_in_coordinates,
        $check_in_location
    ) {
        $query = <<<SQL
        insert into attendance (
            uid,
            name,
            email,
            check_in_date,
            check_in_time,
            check_in_coordinates,
            check_in_location
        ) values (
            :uid,
            :name,
            :email,
            :date,
            :time,
            :coordinates,
            :location
        );
SQL;

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':uid', $uid, SQLITE3_TEXT);
        $stmt->bindParam(':name', $name, SQLITE3_TEXT);
        $stmt->bindParam(':email', $email, SQLITE3_TEXT);
        $stmt->bindParam(':date', date('Ymd', strtotime($check_in_date)), SQLITE3_INTEGER);
        $stmt->bindParam(':time', $check_in_time, SQLITE3_INTEGER);
        $stmt->bindParam(':coordinates', $check_in_coordinates, SQLITE3_TEXT);
        $stmt->bindParam(':location', $check_in_location, SQLITE3_TEXT);

        $stmt->execute();
        $stmt->reset();
    }
}
