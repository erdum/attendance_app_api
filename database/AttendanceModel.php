<?php

class AttendanceModel {

    private $db;

    public function __construct($db_file_path) {
        $this->db = new SQLite3($db_file_path);
    }

    public function userByDay($uid, $date) {
        $query = <<<SQL
        select * from attendance where uid = :uid and check_in_date = :date;
SQL;

        $stmt = $this->db->prepare($query);

        $day = (int) date('Ymd', strtotime($date));
        $stmt->bindParam(':date', $day, SQLITE3_INTEGER);
        $stmt->bindParam(':uid', $uid, SQLITE3_TEXT);

        $result = $stmt->execute();
        $stmt->reset();

        return $result->fetchArray(SQLITE3_ASSOC);
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
        $check_in_location,
        $avatar
    ) {
        $query = <<<SQL
        insert into attendance (
            uid,
            name,
            email,
            check_in_date,
            check_in_time,
            check_in_coordinates,
            check_in_location,
            avatar
        ) values (
            :uid,
            :name,
            :email,
            :date,
            :time,
            :coordinates,
            :location,
            :avatar
        );
SQL;

        $stmt = $this->db->prepare($query);
        $formatted_date = (int) date('Ymd', strtotime($check_in_date));

        $stmt->bindParam(':uid', $uid, SQLITE3_TEXT);
        $stmt->bindParam(':name', $name, SQLITE3_TEXT);
        $stmt->bindParam(':email', $email, SQLITE3_TEXT);
        $stmt->bindParam(':date', $formatted_date, SQLITE3_INTEGER);
        $stmt->bindParam(':time', $check_in_time, SQLITE3_INTEGER);
        $stmt->bindParam(':coordinates', $check_in_coordinates, SQLITE3_TEXT);
        $stmt->bindParam(':location', $check_in_location, SQLITE3_TEXT);
        $stmt->bindParam(':avatar', $avatar, SQLITE3_TEXT);

        $stmt->execute();
        $stmt->reset();
    }

    public function updateCheckout($uid, $check_in_date, $date, $time, $coordinates) {

        $query = <<<SQL
        update attendance set
            check_out_date = :date,
            check_out_time = :time,
            check_out_coordinates = :coordinates
        where uid = :uid and check_in_date = :check_in_date;
SQL;

        $stmt = $this->db->prepare($query);
        $formatted_date = date('Ymd', strtotime($date));

        $stmt->bindParam(':uid', $uid, SQLITE3_TEXT);
        $stmt->bindParam(':check_in_date', $check_in_date, SQLITE3_INTEGER);
        $stmt->bindParam(':date', $formatted_date, SQLITE3_INTEGER);
        $stmt->bindParam(':time', $time, SQLITE3_INTEGER);
        $stmt->bindParam(':coordinates', $coordinates, SQLITE3_TEXT);

        $stmt->execute();
        $stmt->reset();
    }
}
