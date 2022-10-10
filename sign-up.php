<!DOCTYPE html>

<head>
    <?php
    include 'dependencies.php';
    include './api/connection.php'
    ?>

    <link rel="icon" href="./assets/images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/signup.css">
    <link rel="stylesheet" href="./assets/css/loader.css">

    <title>SLSU-KTTO Document Management System</title>
</head>
<div class="loader">
    <img src="./assets/images/loader.gif" class="img-loader">
</div>
<div class="register-container">
    <div class="form-register">
        <div class="logo">
            <img src="./assets/images/logo.png" alt="logo" class="img-logo">
            <h1>SLSU-KTTO Document Management System</h1>
        </div>
        <span class="sign-up">Sign Up</span>
        <form>
            <div class="form-input">
                <i class="fa fa-address-book"></i>
                <div class="input">
                    <select id='usertype'>
                        <option value="patent drafter">Patent Drafter</option>
                        <option value="maker">Maker</option>
                    </select>
                </div>
            </div>
            <div class="form-input" id='form-input-student-id'>
                <i class="fa fa-id-badge"></i>
                <div class="input">
                    <input type="text" id='student-id' autocomplete="off" placeholder="Student Id">
                </div>
            </div>
            <div class="form-input">
                <i class="fa fa-envelope"></i>
                <div class="input">
                    <input type="email" id='email' autocomplete="off" placeholder="Email address">
                </div>
            </div>
            <div class="form-input">
                <i class="fa fa-address-card-o"></i>
                <div class="input">
                    <input type="text" id='fullname' autocomplete="off" placeholder="Fullname">
                </div>
            </div>
            <div class="form-input">
                <i class="fa fa-lock"></i>
                <div class="input">
                    <input type="password" id='password' autocomplete="off" placeholder="Password">
                </div>
            </div>
            <div class="form-input">
                <i class="fa fa-check"></i>
                <div class="input">
                    <input type="password" id='confirm-pass' autocomplete="off" placeholder="Confirm Password">
                </div>
            </div>
            <button type="submit" class="btn btn-block btn-sm btn-primary" id='btn-submit'>Submit</button>
        </form>
        <span class="sign-in">Already have an Account? <a href="#" id='signin-link'>Sign In</a></span>
    </div>
    <div class="display-img">
        <img src="https://images.unsplash.com/photo-1583521214690-73421a1829a9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="">
    </div>
</div>

<script src="./assets/js/main.js"></script>
<script src="./assets/js/signup.js"></script>

</html>