<?php

$db = new SQLite3('database/database.db');

function getAllAttendances() {
    global $db;
    $query = <<<SQL
    select * from attendance;
SQL;

    $result = $db->query($query);
    $rows = array();

    while($row = $result->fetchArray(SQLITE3_ASSOC)) {
        array_push($row, $rows);
    }
    return $rows;
}

function insertCheckIn(
    $uid,
    $name,
    $email,
    $check_in_date,
    $check_in_time,
    $check_in_cordinates,
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
        check_in_cordinates,
        check_in_location
    ) values (
        :uid,
        :name,
        :email,
        :date,
        :time,
        :cordinates,
        :location
    );

    $stmt = $db->prepare($query);

    $stmt->bindParam(':uid', $uid, SQLITE3_INTEGER);
    $stmt->bindParam(':name', $name, SQLITE3_TEXT);
    $stmt->bindParam(':email', $email, SQLITE3_TEXT);
    $stmt->bindParam(':date', $check_in_date, SQLITE3_TEXT);
    $stmt->bindParam(':time', $check_in_time, SQLITE3_TEXT);
    $stmt->bindParam(':cordinates', $check_in_cordinates, SQLITE3_TEXT);
    $stmt->bindParam(':location', $check_in_location, SQLITE3_TEXT);

    $stmt->execute();
    $stmt->reset();
}
