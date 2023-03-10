
# Attendance Management API

This API is made for the Super Technologies Attendance web app, initially we are using firebase and Sheetson api to store all the attendances in a google spread sheet which can be shared with all the members in the organization.

The purpose of this API is to over come the complexity of Sheetson API which lacks basic query opreation and all the compution has to be done on the client side.

## API Reference

#### Get daily Attendances by date

```
  GET /attendance/today/{date}
```

| Route Parameter | Type     | Description                |
| :-------------- | :------- | :------------------------- |
| `date`          | `string` | DD-MM-YYYY                 |

#### Get User Attendance by date

```
  GET /attendance/{date}/{uid}
```

| Route Parameter | Type     | Description                |
| :-------------- | :------- | :------------------------- |
| `date`          | `string` | DD-MM-YYYY                 |
| `uid`           | `string` | UID specific to the user   |

#### Mark User Attendance

```
  POST /attendance

  Request JSON Payload
  {
      uid: <string> uid specific to the user,
      name: <string> user name,
      email: <string> user email,
      date: <string> date of attendance DD-MM-YYYY,
      time: <string> epoch time in seconds example 1672992237,
      coordinates: <string> coordinates of user location,
      location: <string> location name,
      avatar: <string> user avatar image url
  }
```

#### Mark User Checkout

```
  POST /attendance/{uid}
```

| Route Parameter | Type     | Description                |
| :-------------- | :------- | :------------------------- |
| `uid`           | `string` | UID specific to the user   |

```
  Request JSON Payload
  {
      date: <string> date of check out DD-MM-YYYY,
      time: <string> epoch time in seconds example 1672992237,
      coordinates: <string> coordinates of user location
  }
```


#### Get monthly Attendance in CSV format

```
  GET /attendance/csv/{year}/{month}
```

| Route Parameter | Type     | Description                |
| :-------------- | :------- | :------------------------- |
| `year`          | `string` | YYYY                       |
| `month`         | `string` | MM from 01 to 12           |


## Deployment Local / Production (Apache only)

Clone the project in your web server root directory e.g. /var/www/html/

```
  git clone https://github.com/erdum/attendance_app_api.git
```

Go to the database directory inside the project directory

```
  cd database/
```

Initializing the database (make sure you have sqlite3 installed)

```
  sqlite3 database.db < schema.sql
```

Give 775 permissions to database.db file

```
  sudo chmod 755 database.db
```

Change the database.db file user to your web server user (if needed)

```
  sudo chown apache.apache database.db
```

#### All set you can now use the API.

## Deployment Local / Production (Nginx)

Follow the same steps as specified for the (Apache) just make sure your web server (Nginx) has equivalent redirection rules as specified in .htaccess file for the apache in the project directory

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


## Copyright

All right reserved by Super Technologies inc

