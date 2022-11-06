<?php

include './connection.php';

class User
{
    public $email;
    public $password;
    public $message;
    public $usertype;
}

class ResponseMessage
{
    public $status_code;
    public $message;
    public $usertype;
}


function getUserByEmail($email)
{
    global $conn;

    $query = "Select * from tbl_accounts where email = '" . $email . "'";
    $executeQuery = mysqli_query($conn, $query);
    $response = new ResponseMessage();

    if (mysqli_num_rows($executeQuery) > 0) {
        $response->message = 'Email address already exist.';
        return $response;
    }else{
        return '';
    }
}

function checkIfEmailExist($email)
{
    global $conn;
    $user = new User();
    $response = new ResponseMessage();

    $query = "Select * from tbl_accounts where email = '" . $email . "'";
    $executeQuery = mysqli_query($conn, $query);

    if (mysqli_num_rows($executeQuery) <= 0) {
        $response->status_code = 409;
        $response->message = "Email address does'nt exist.";
        
        return $response;
    } else {
        $userDetails = mysqli_fetch_assoc($executeQuery);
        $user->email = $userDetails['email'];
        $user->password = $userDetails['password'];
        $user->usertype = $userDetails['usertype'];
        return $user;
    }
}
