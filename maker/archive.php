<!DOCTYPE html>

<head>
    <?php
       include '../dependencies.php';
       session_start();

    ?>

    <link rel="icon" href="../assets/images/logo.png" type="image/icon">

    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/loader.css">
    <link rel="stylesheet" href="../assets/css/message.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">

    <title>SLSU-KTTO Document Management System</title>
</head>

<body>
    <div class="" id="message-container"></div>
    <div class="loader">
      <img src="../assets/images/loader1.gif" class="img-loader">
    </div>
    <?php
      include '../navbar.php';
    ?>


    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>


</body>

</html>