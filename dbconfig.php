<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ProjectDB'); 
/* CC
define('DB_SERVER', 'sql211.hstn.me');
define('DB_USERNAME', 'mseet_28276156');
define('DB_PASSWORD', 'siteADMIN');
define('DB_NAME', 'mseet_28276156_ProjectDB');
MP
define('DB_SERVER', 'sql312.hstn.me');
define('DB_USERNAME', 'mseet_28621983');
define('DB_PASSWORD', 'siteADMIN');
define('DB_NAME', 'mseet_28621983_project_db');
*/
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($conn === false){
    die("ERROR: Could not connect to the database. " . mysqli_connect_error());
}

?>