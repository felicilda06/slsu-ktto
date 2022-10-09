<!DOCTYPE html>

<head>
    <?php
    include 'dependencies.php'
    ?>

    <link rel="icon" href="./assets/images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/signin.css">
    <link rel="stylesheet" href="./assets/css/loader.css">

    <title>SLSU-KTTO Document Management System</title>
</head>

<body id='body'>
    <div class="" id="message-container">
        <span id="message"></span>
    </div>
    <div class="loader">
        <img src="./assets/images/loader.gif" class="img-loader">
    </div>
    <div class="login-container">
        <div class="form-login">
            <div class="logo">
                <img src="./assets/images/logo.png" alt="logo" class="img-logo">
                <h1>SLSU-KTTO Document Management System</h1>
            </div>
            <span class="sign-in">Sign In</span>
            <form id="sign-in-form">
                <div class="form-input">
                    <i class="fa fa-user icon-email"></i>
                    <div class="input">
                        <input type="email" id='email' autocomplete="off" placeholder="Email address" required>
                    </div>
                </div>
                <div class="form-input">
                    <i class="fa fa-lock icon-password"></i>
                    <div class="input">
                        <input type="password" id="password" placeholder="Password" required>
                        <i class="fa fa-eye-slash" id="toggle-icon"></i>
                    </div>
                </div>
                <div class="login-settings">
                    <div class="remember">
                        <input type="checkbox" id="remember">
                        <label for="remember">Rememeber me</label>
                    </div>
                    <div class="forgot">
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-sm btn-primary" id="btn-submit">Submit</button>
            </form>
            <span class="sign-up">Don't have an account? <a href="#" id='signup-link'>Sign Up</a></span>
        </div>
        <div class="display-img">
            <img src="https://cdn.pixabay.com/photo/2017/09/25/17/38/chart-2785979_960_720.jpg" alt="">
        </div>
    </div>

    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/signin.js"></script>
</body>

</html>