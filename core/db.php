<?php

$db = new SQLite3('database.db');

function getAllUsers() {
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

    $query->bindValue()
SQL;
}
