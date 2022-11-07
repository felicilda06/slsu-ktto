<?php
  include './connection.php';
  include_once './getUser.php';

  function isEmailExistToTableCodes($email, $code){
    global $conn;
    $query = "Select * from tbl_codes where email = '".$email."'";
    $executeQuery = mysqli_query($conn, $query);

    if(mysqli_num_rows($executeQuery) > 0){
      updateOldCode($email, $code); 
    }else{
      insertCode($email, $code);
    }
  }
  
  function insertCode($email, $code){
    global $conn;
    $query = "Insert into tbl_codes values ('', '".$email."', '".$code."')";
    mysqli_query($conn, $query);
  }

  function verifyCode($code){
    global $conn;
    $query = "Select * from tbl_codes where code = '".$code."'";
    $executeQuery = mysqli_query($conn, $query);

    if(mysqli_num_rows($executeQuery) > 0){
      $user = new User();
      $userDetails = mysqli_fetch_assoc($executeQuery);
      $user->email = $userDetails['email'];
      return $user;
    }else{
      $response = new ResponseMessage();
      $response->status_code = 500;
      $response->message = "Invalid OTP Code.";
      return $response;
    }
  }

  function updateOldCode($email, $code){
    global $conn;
    $query = "Update tbl_codes set code = '".$code."' where email = '".$email."'";
    mysqli_query($conn, $query);
  }
?>