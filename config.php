<?php
/*
This file contains database configuration assuming you are running mysql using user "root" and password ""
*/

/*define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'admin');*/

define('DB_SERVER', 'sql6.freemysqlhosting.net');
define('DB_USERNAME', 'sql6427360');
define('DB_PASSWORD', 'xbmfxZ4wtu');
define('DB_NAME', 'sql6427360');

// Try connecting to the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check the connection
if($conn == false){
    dir('Error: Cannot connect');
}

?>
