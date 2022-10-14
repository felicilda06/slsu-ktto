<?php

include 'connection.php';

global $conn;

$apiType = $_POST['api'];

if ($apiType == 'login') {
} else if ($apiType == 'register') {
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $studentId = $_POST['studentId'];
    $usertype = $_POST['usertype'];
    $name = $_POST['fullname'];

    $saveUserQuery = "Insert into tbl_accounts values ('', '" . $studentId . "', '" . $email . "', '" . $name . "', '" . $password . "', '" . $usertype . "')";
    $saveUser = mysqli_query($conn, $saveUserQuery);

    if ($saveUser) {
        echo '1';
    } else {
        echo '0';
    }

    // $getUserByEmail = mysqli_query($conn, "Select * from tbl_accounts where email = '" . $email . "'");
    // $result = mysqli_fetch_assoc($getUserByEmail);

    // echo  $result;
} else if ($apiType == 'forgot') {
} else if ($apiType == 'verify') {
}
