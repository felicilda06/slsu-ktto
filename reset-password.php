<!DOCTYPE html>

<?php
global $email;
$email = $_POST['email'];

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

    <title>SLSU-KTTO Document Management System</title>
</head>
<div class="loader">
    <img src="./assets/images/loader.gif" class="img-loader">
</div>
<div class="reset-container">
    <h1>Reset account password</h1>
    <p>Enter a new password for <span class="email"><?php echo $email; ?></span></p>
    <div class="form-reset">
        <form>
            <div class="form-input">
                <i class="fa fa-lock icon-password"></i>
                <div class="input">
                    <input type="password" id="password" placeholder="New Password">
                </div>
            </div>
            <div class="form-input">
                <i class="fa fa-check icon-password"></i>
                <div class="input">
                    <input type="password" id="password" placeholder="Re-type Password">
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-block btn-primary">Reset Password</button>
        </form>
    </div>

</div>

<script src="./assets/js/main.js"></script>
<script src="./assets/js/signup.js"></script>

</html>