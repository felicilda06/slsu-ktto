<!DOCTYPE html>

    <?php
        session_start();
        global $code;
        $code = $_SESSION['code'];
        if (!$code) {
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
    <link rel="stylesheet" href="./assets/css/message.css">

    <title>SOUTHERN LEYTE STATE U - ITSO DOCUMENT MANAGEMENT SYSTEM</title>
</head>

<body>
    <input type="text" id="email" class="d-none" value="<?php echo $_SESSION['email']; ?>">
    <div class="" id="message-container"></div>
    <div class="alert-message">
        <div class="box">
            <i class="fa fa-close" id="icon-close"></i>
            <i class="fa fa-check-circle" id="icon-check"></i>
            <span>We have send to your email the another OTP Code. Please check your inbox and spam messages.</span>
        </div>
    </div>
    <div class="loader">
        <img src="./assets/images/loader1.gif" class="img-loader">
    </div>
    <div class="confirmation-container">
        <div class="form-confirmation">
            <h1>Verification</h1>
            <p>Enter the 4 digit code we sent you via email to continue.</p>
            <form>
                <div class="input">
                    <input type="text" id='code1' autocomplete="off" placeholder="•" maxlength="1">
                    <input type="text" id='code2' autocomplete="off" placeholder="•" maxlength="1">
                    <input type="text" id='code3' autocomplete="off" placeholder="•" maxlength="1">
                    <input type="text" id='code4' autocomplete="off" placeholder="•" maxlength="1">
                </div>
                <button type="submit" class="btn btn-sm btn-block btn-primary" id='btn-submit' disabled>Submit</button>
            </form>
            <span>Did'nt get the code? <a href="#" id='resend'>Resend code</a></span>
        </div>
        <span class="expiration">Code expires in : <span id="timer">00:11</span> sec.</span>
    </div>

    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/confirmation.js"></script>
    <script src="./assets/js/timer.js"></script>
</body>

</html>