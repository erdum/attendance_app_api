<?php

$db = new SQLite3('database/database.db');

function getAttendanceByMonth($date) {

    global $db;
    $query = <<<SQL
    select * from attendance where check_in_date >= :from_date and check_in_date < :to_date ;
SQL;

    $stmt = $db->prepare($query);

    $from_date = (int) date('Ymd', strtotime($date));
    $to_date = (int) date("Ymd", strtotime('+1 month', strtotime($date)));

    $stmt->bindParam(':from_date', $from_date, SQLITE3_INTEGER);
    $stmt->bindParam(':to_date', $to_date, SQLITE3_INTEGER);

    $result = $stmt->execute();
    $stmt->reset();

    return $result;    
}

function insertCheckIn(
    $uid,
    $name,
    $email,
    $check_in_date,
    $check_in_time,
    $check_in_coordinates,
    $check_in_location
) {

    global $db;
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

    $stmt = $db->prepare($query);

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

function getUserAttendanceByDate($uid, $date) {

    global $db;
    $query = <<<SQL
    select * from attendance where uid = :uid and check_in_date = :date;
SQL;

    $stmt = $db->prepare($query);

    $stmt->bindParam(':uid', $uid, SQLITE3_TEXT);
    $stmt->bindParam(':date', $date, SQLITE3_TEXT);

    $result = $stmt->execute();
    $stmt->reset();

    return $result->fetchArray(SQLITE3_ASSOC);
}
