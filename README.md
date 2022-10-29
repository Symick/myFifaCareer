# myFifaCareer

source code myFifaCareer

## This was a hobby project with minimal skills and knowledge

```bash
    git clone https://github.com/Symick/myFifaCareer.git
    cd myFifaCareer
```

## before beginning with the source code you need to add a connection to the database

### create directory database and add db-handler file

```bash
    cd back-end
    mkdir database
    cd database
    echo > db-handler.php
```

### add php script to handle connection

```php
    <?php
$servername = 'example'; //name of the server you are using
$dbUsername = 'exampleUsername'; // username of your the account your running the database on
$dbPassword = "examplePassword"; // password of the account your running the database on
$dbName = "myfifacareer";

$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

if(!$conn) {
    die("failed to connect to the server, sorry for the inconvenience: " . mysqli_connect_error());
}
```

### download the database to phpmyadmin

[get database](sql/myfifacareer.sql)
