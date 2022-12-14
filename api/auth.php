<?php

include './connection.php';
include_once './getUser.php';
include_once './code.php';

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
            $_SESSION['usertype'] = $user->usertype;
            $_SESSION['name'] = $user->name;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['user_id'] = $user->userId;
            echo json_encode($response);
        }
    }
   
} else if ($apiType == 'register') {
    $email = htmlspecialchars($_POST['email']);
    $password = sha1(htmlspecialchars($_POST['password']));
    $studentId = $_POST['studentId'];
    $usertype = $_POST['usertype'];
    $name = $_POST['fullname'];
    $technology_type = $_POST['technology_type'];

    $getUser = getUserByEmail($email);

    if ($getUser) {
      echo $getUser->message;
    } else {
        $query = "Insert into tbl_accounts values ('', '" . $studentId . "', '" . $email . "', '" . $name . "', '" . $password . "', '" . $usertype . "', '". $technology_type."')";
        $executeQuery = mysqli_query($conn, $query);
    }
} else if ($apiType === 'verify') {
    $code = $_POST['code'];
    $verify = verifyCode($code);

    if($verify->message){
        echo json_encode($verify);
    }else{
       $_SESSION['email'] = $verify->email;
       $_SESSION['code'] = '';
       deleteCode($code);
    }
} else if ($apiType === 'forgot') {
    $email = htmlspecialchars($_POST['email']);
    $user = checkIfEmailExist($email);

    if($user->message){
       echo json_encode($user);
    }else{
        $_SESSION['code'] = $_POST['code'];
        isEmailExistToTableCodes($email, $_POST['code']);
        $_SESSION['email'] = $_POST['email'];
        sendCode($email, $_POST['code']);
    }
} else if($apiType === 'resend_code'){
     updateOldCode($_POST['email'], $_POST['code']);
     $_SESSION['code'] = $_POST['code'];
     sendCode($_POST['email'], $_POST['code']);
} else if($apiType === 'reset_password'){
         $validatePassword = validatePassword($_SESSION['email'], sha1(htmlspecialchars($_POST['newPassword'])));
   if($validatePassword->message){
        echo json_encode($validatePassword);
   }else{
       $_SESSION['email'] = '';
       echo json_encode($validatePassword);
   }
}
else if($apiType === 'remove_code'){
    deleteCode($_SESSION['email']);
}