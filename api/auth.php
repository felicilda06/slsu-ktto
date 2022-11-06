<?php

include './connection.php';
include_once './getUser.php';

session_start();

global $conn;

$apiType = $_POST['api'];
$response = new ResponseMessage();

if ($apiType == 'login') {
    $email = htmlspecialchars($_POST['email']);
    $password = sha1(htmlspecialchars($_POST['password']));
    $user = checkIfEmailExist($email);
    if($user->message){
       echo json_encode($user);
    }else{
        if ($user->password != $password) {
            $response->status_code = 500;
            $response->message = 'Incorrect Password. Please try again.';
            echo json_encode($response);
            return;
        } else {
            $response->status_code = 200;
            $response->usertype = $user->usertype;
            echo json_encode($response);
        }
    }
   
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
} else if ($apiType === 'verify') {
} else if ($apiType === 'forgot') {
} else if($apiType === 'redirect'){
   $usertype = $_POST['usertype'];
   $_SESSION['usertype'] = $usertype;
   
   if($usertype === 'patent drafter'){
     echo 0;
   }
}
