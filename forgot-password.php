<!DOCTYPE html>

<head>
    <?php
       include 'dependencies.php';
       session_start();
    ?>

    <link rel="icon" href="./assets/images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/loader.css">
    <link rel="stylesheet" href="./assets/css/message.css">
    <link rel="stylesheet" href="./assets/css/forgot.css">

    <title>SLSU-KTTO Document Management System</title>
</head>

<body>
    <div class="" id="message-container"></div>
    <div class="loader">
        <img src="./assets/images/loader1.gif" class="img-loader">
    </div>
    <div class="forgot-container">
        <div class="form-forgot">
            <div class="logo">
                <img src="./assets/images/logo.png" alt="logo" class="img-logo">
                <h1>SLSU-KTTO Document Management System</h1>
            </div>
            <p>Enter the email address associated with your account and we will send you the OTP Code.</p>
            <form>
                <div class="form-input">
                    <i class="fa fa-envelope icon-email"></i>
                    <div class="input">
                        <input type="email" id='email' autocomplete="off" placeholder="Email address">
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-sm btn-primary" id="btn-continue">Continue</button>
            </form>
            <span class="sign-up">Don't have an account? <a href="#" id="signup-link">Sign Up</a></span>
        </div>
    </div>

    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/forgot.js"></script>
</body>

</html>