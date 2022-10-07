<?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'slsu-kttoDb';

    $conn  = mysqli_connect($host, $username, $password, $database);

    if(!$conn){
        echo 'Unable to Connect to Database';
        return;
    }
?>