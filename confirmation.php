<!DOCTYPE html>

<?php
  $code = $_POST['code'];
  if(!$code){
    header('Location: forgot-password.php');
  }
?>

<head>
    <?php
    include 'dependencies.php'
    ?>

    <link rel="icon" href="./assets/images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/loader.css">
    <link rel="stylesheet" href="./assets/css/confirmation.css">

    <title>SLSU-KTTO Document Management System</title>
</head>
<div class="loader">
    <img src="./assets/images/loader.gif" class="img-loader">
</div>
<div class="confirmation-container">
    <div class="form-confirmation">
        <h1>Verification</h1>
        <p>Enter the 4 digit code we sent you via email to continue.</p>
        <form>
            <div class="input">
                <input type="email" id='email' autocomplete="off" placeholder="0">
                <input type="email" id='email' autocomplete="off" placeholder="0">
                <input type="email" id='email' autocomplete="off" placeholder="0">
                <input type="email" id='email' autocomplete="off" placeholder="0">
            </div>
            <button type="submit" class="btn btn-sm btn-block btn-primary">Submit</button>
        </form>
        <span>Did'nt get the code? <a href="#" id='resend'>Resend code</a></span>
    </div>
    <span class="expiration">Code expires in : <span id="timer"></span> sec.</span>
</div>

<script src="./assets/js/main.js"></script>
<script src="./assets/js/signup.js"></script>
<script src="./assets/js/timer.js"></script>

</html>