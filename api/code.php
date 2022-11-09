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
    $query = "Select * from tbl_codes where email = '".$email."'";
    $executeQuery = mysqli_query($conn, $query);

    if(mysqli_num_rows($executeQuery) > 0){
       $queryUpdateCode = "Update tbl_codes set code = '".$code."' where email = '".$email."'";
       mysqli_query($conn, $queryUpdateCode);
    }else{
      insertCode($email, $code);
    }
    
  }

  function deleteCode($email){
    global $conn;
    $query = "Delete from tbl_codes where email = '".$email."'";
    mysqli_query($conn, $query);
  }

  function sendCode($email, $code){
    $url = 'https://script.google.com/macros/s/AKfycbw9emxOFRI05eUmp-aUyuyouS5v_H7uo7Gg6oOl3KMg2mGrOUzd-E9BauRrblk8kIY/exec';
    $ch = curl_init($url);
    curl_setopt_array($ch, [
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_POSTFIELDS => http_build_query([
          "recipient" => $email,
          "subject"   => 'OTP Code',
          "body"      => "OTP Code: ".$code.". This email is auto-generated. Do not reply this email."
       ])
    ]);

    $result = curl_exec($ch);
  }
?>