<?php

include './connection.php';

class User
{
    public $email;
    public $password;
    public $message;
    public $usertype;
    public $name;
    public $userId;
}

class ResponseMessage
{
    public $status_code;
    public $message;
    public $usertype;
    public $name;
    public $userId;
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
        $user->name = $userDetails['name'];
        $user->userId = $userDetails['id'];
        return $user;
    }
}

function validatePassword($email, $newPassword){
    global $conn;
    $response = new ResponseMessage();
    $query = "Select * from tbl_accounts where password = '".$newPassword."'";
    $executeQuery = mysqli_query($conn, $query);

    if(mysqli_num_rows($executeQuery) > 0){
        $response->status_code = 500;
        $response->message = "You entered an older password.";
        return $response;
    }else{
       $query = "Update tbl_accounts set password = '".$newPassword."' where email = '".$email."'";
       mysqli_query($conn, $query);
       $response->status_code = 200;
       $response->message = "";
       return $response;
    }
}
