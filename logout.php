<?php
    session_start();

    if($_SESSION['usertype'] != ''){
        session_destroy();
        header('Location:sign-in.php');
    }
?>