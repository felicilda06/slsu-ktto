<!DOCTYPE html>

<head>
    <?php
       include 'dependencies.php';
       session_start();
       $usertype = $_SESSION['usertype'];

       if($usertype === 'patent drafter'){
           header('Location:patent-drafter.php');
           return;
        }else if($usertype === 'maker'){
           header('Location:maker.php');
           return;
       }
    ?>

    <link rel="icon" href="./assets/images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/signin.css">
    <link rel="stylesheet" href="./assets/css/loader.css">
    <link rel="stylesheet" href="./assets/css/message.css">

    <title>SLSU-KTTO Document Management System</title>
</head>

<body>
    <div class="" id="message-container"></div>
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
                        <input type="text" id='email' autocomplete="off" placeholder="Email address">
                    </div>
                </div>
                <div class="form-input">
                    <i class="fa fa-lock icon-password"></i>
                    <div class="input">
                        <input type="password" id="password" placeholder="Password">
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
            <img src="https://images.unsplash.com/photo-1583521214690-73421a1829a9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="">
        </div>
    </div>

    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/signin.js" type="text/javascript"></script>

</body>

</html>

<!-- https://images.unsplash.com/photo-1565688534245-05d6b5be184a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80 -->