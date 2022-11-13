<?php
    session_destroy();
    $_SESSION['usertype'] = '';
    $_SESSION['email'] = '';
    header('Location: sign-in.php');
?>