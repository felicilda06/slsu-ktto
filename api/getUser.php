<?php

include './connection.php';

class User
{
    public $email;
    public $password;
}

class ResponseMessage
{
    public $status_code;
    public $message;
}


function getUserByEmail($email)
{
    global $conn;

    $query = "Select * from tbl_accounts where email = '" . $email . "'";
    $executeQuery = mysqli_query($conn, $query);
    $response = new ResponseMessage();

    if (mysqli_num_rows($executeQuery) > 0) {
        $response->status_code = 400;
        $response->message = `Email Already Exist`;
        echo $response;
        return;
    } else {
        echo "";
    }
}

function checkIfEmailExist($email)
{
    global $conn;
    $user = new User();
    $response = new ResponseMessage();

    $query = "Select (email, password) from tbl_accounts where email = '" . $email . "'";
    $executeQuery = mysqli_query($conn, $query);

    if (mysqli_num_rows($executeQuery) <= 0) {
        $response->status_code = 400;
        $response->message = `Email address does'nt exist`;
        echo $response;
        return;
    } else {
        $userDetails = mysqli_fetch_assoc($executeQuery);
        $user->email = $userDetails['email'];
        $user->password = $userDetails['password'];
        echo $user;
    }
}
