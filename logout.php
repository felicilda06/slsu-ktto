<?php
    session_destroy();
    $_SESSION['usertype'] = '';
    header('Location: sign-in.php');
?>