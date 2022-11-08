<?php

  include './connection.php';
  include_once './getUser.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
  require '../vendor/phpmailer/phpmailer/src/Exception.php';
  require '../vendor/phpmailer/phpmailer/src/SMTP.php';

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

  function deleteCode($code){
    global $conn;
    $query = "Delete from tbl_codes where code = '".$code."'";
    mysqli_query($conn, $query);
  }

  function sendCode($email, $code){
    $mail = new PHPMailer(true);
    $response = new ResponseMessage();

   try{
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'felicilda@gmail.com';
      $mail->Password = 'rif1610131';
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;

      $mail->setFrom('felicilda@gmail.com');
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->Subject = 'OTP Code';
      $mail->Body = $code;
      $mail->send();
   }catch(Exception $err){
      $response->status_code = 500;
      $response->message = $err;
      return $response;
   }
  }
?>