CREATE TABLE attendance (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    uid text NOT NULL,
    name text NOT NULL,
    email text NOT NULL,
    check_in_date text NOT NULL,
    check_in_time text NOT NULL,
    check_out_date text,
    check_out_time text,
    check_in_coordinates text NOT NULL,
    check_out_coordinates text,
    check_in_location text NOT NULL
);
