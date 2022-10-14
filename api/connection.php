<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'slsu_kttoDb';

date_default_timezone_set('Asia/Manila');

$conn  = mysqli_connect($server, $username, $password, $database);

// echo phpinfo();

if (!$conn) {
    echo 'Unable to Connect to Database';
}

