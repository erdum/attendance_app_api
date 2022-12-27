<?php

function checkInputDate($input) {

    $date_parts = explode('-', $input);
    return checkdate($date_parts[1], $date_parts[0], $date_parts[2]);
}
