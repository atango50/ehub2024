<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'u865382935_honorine');
define('DB_PASSWORD', 'H@n@r1n5');
define('DB_NAME', 'u865382935_honocom');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn === false){
    die("ERREUR : Impossible de se connecter. " . mysqli_connect_error());
}
?>
