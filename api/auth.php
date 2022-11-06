<?php

include './connection.php';
include_once './getUser.php';

global $conn;

$apiType = $_POST['api'];
$response = new ResponseMessage();

if ($apiType == 'login') {
    $email = htmlspecialchars($_POST['email']);
    $password = sha1(htmlspecialchars($_POST['password']));
    $user = checkIfEmailExist($email);

    if ($user['password'] && $user['email']) {
        if ($user['password'] != $password) {
            $response->status_code = 400;
            $response->message = 'The password you entered is incorrect. Please try again.';
            echo $response;
            return;
        } else {
            $response->status_code = 200;
            echo $response;
        }
    }
    var_dump($user);
} else if ($apiType == 'register') {
    $email = htmlspecialchars($_POST['email']);
    $password = sha1(htmlspecialchars($_POST['password']));
    $studentId = $_POST['studentId'];
    $usertype = $_POST['usertype'];
    $name = $_POST['fullname'];

    $getUser = getUserByEmail($email);

    if ($getUser) {
      echo $getUser->message;
    } else {
        $query = "Insert into tbl_accounts values ('', '" . $studentId . "', '" . $email . "', '" . $name . "', '" . $password . "', '" . $usertype . "')";
        $executeQuery = mysqli_query($conn, $query);
    }
} else if ($apiType == 'forgot') {
} else if ($apiType == 'verify') {
}
