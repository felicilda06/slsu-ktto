<!DOCTYPE html>

<?php
session_start();
$email = $_SESSION['email'];

if (!$email) {
    header('Location: confirmation.php');
}
?>

<head>
    <?php
    include 'dependencies.php'
    ?>

    <link rel="icon" href="./assets/images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/loader.css">
    <link rel="stylesheet" href="./assets/css/reset-pass.css">
    <link rel="stylesheet" href="./assets/css/message.css">

    <title>SOUTHERN LEYTE STATE U - ITSO DOCUMENT MANAGEMENT SYSTEM</title>
</head>
<div class="loader">
    <img src="./assets/images/loader1.gif" class="img-loader">
</div>
<div class="reset-container">
    <div class="" id="message-container"></div>
    <h1>Reset account password</h1>
    <p>Enter a new password for <span class="email"><?php echo $_SESSION['email']; ?></span></p>
    <div class="form-reset">
        <form>
            <div class="form-input">
                <i class="fa fa-lock icon-password"></i>
                <div class="input">
                    <input type="password" id="newPass" placeholder="New Password" autocomplete="off">
                </div>
            </div>
            <div class="form-input">
                <i class="fa fa-check icon-password"></i>
                <div class="input">
                    <input type="password" id="confirmPass" placeholder="Re-type Password" autocomplete="off">
                </div>
            </div>
            <button type="submit" id="btn-reset" class="btn btn-sm btn-block btn-primary">Reset Password</button>
        </form>
    </div>

</div>

<script src="./assets/js/main.js"></script>
<script src="./assets/js/reset.js"></script>

</html>