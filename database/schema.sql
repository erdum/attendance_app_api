CREATE TABLE attendance (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    uid TEXT NOT NULL,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    check_in_date INTEGER NOT NULL,
    check_in_time INTEGER NOT NULL,
    check_out_date INTEGER,
    check_out_time INTEGER,
    check_in_coordinates TEXT NOT NULL,
    check_out_coordinates TEXT,
    check_in_location TEXT NOT NULL
);

CREATE INDEX uid ON attendance (uid);
CREATE UNIQUE INDEX attendance_date ON attendance (uid, check_in_date);
