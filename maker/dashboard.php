<!DOCTYPE html>

<head>
    <?php
       include '../dependencies.php';
      session_start();

      $user = $_SESSION['usertype'];

      if(empty($user) || $user != 'maker'){
          header('Location: ../sign-in.php');
          return;
      }
     
    ?>

    <link rel="icon" href="../assets/images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/loader.css">
    <link rel="stylesheet" href="../assets/css/message.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <title>SOUTHERN LEYTE STATE UNIVERSITY - ITSO DOCUMENT MANAGEMENT SYSTEM</title>
</head>

<body>
    <div class="" id="message-container"></div>
    <div class="loader">
      <img src="../assets/images/loader1.gif" class="img-loader">
    </div>
    <header>
      <?php
        include '../navbar.php';
      ?>
    </header>
    <main id="main"></main>
    <footer></footer>

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/dashboard.js"></script>

</body>

</html>