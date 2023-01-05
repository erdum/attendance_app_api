
# Attendance Management API

This API is made for the Super Technologies Attendance web app, initially we are using firebase and Sheetson api to store all the attendances in a google spread sheet which can be shared with all the members in the organization.

The purpose of this API is to over come the complexity of Sheetson API which lacks basic query opreation and all the compution has to be done on the client side.

## Deployment Local / Production (Apache only)

Clone the project in your web server root directory e.g. /var/www/html/

```bash
  git clone https://github.com/erdum/attendance_app_api.git
```

Go to the database directory inside the project directory

```bash
  cd database/
```

Initializing the database (make sure you have sqlite3 installed)

```bash
  sqlite3 database.db < schema.sql
```

Give 775 permissions to database.db file

```bash
  sudo chmod 755 database.db
```

Change the database.db file user to your web server user (if needed)

```bash
  sudo chown apache.apache database.db
```

#### All set you can now use the API.

## Deployment Local / Production (Nginx)

Just make sure your web server has equivalent redirection rules as specified in .htaccess file for apache in the project directory

#### All set you can now use the API.
## FAQ

#### What is the minimum version of PHP is required

I have successfully tested it with PHP 5.3 to 8.2

#### What is the minimum version of SQLite3 is required

I have successfully tested it with SQLite3 3.37 to 3.6.2

#### Getting error related to sqlite3

Make sure you have sqlite3 installed in your machine and also php-sqlite3 module is installed and enabled

#### Getting 403 forbidden

Make sure all the php files in the web server root directory are executable also check your server configuration


## Roadmap

- IP white listing

- Request limiting


## Copyright

All right reserved by Super Technologies inc

