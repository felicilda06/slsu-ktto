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
    <link rel="stylesheet" href="../assets/css/document.css">

    <title>SLSU-KTTO Document Management System</title>
</head>

<body>
     <input type="text" class="d-none" value="<?php echo $_SESSION['email']?>" id="user_email">
    <div class="" id="message-container"></div>
    <div class="loader">
      <img src="../assets/images/loader1.gif" class="img-loader">
    </div>
    <?php
      include '../navbar.php';
      include_once '.././api/connection.php';
      global $conn;
    ?>
    <div class="document_maker_wrapper">
      <div class="document_menus relative">
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
           <div class="dot"></div>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
           <div class="dot"></div>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
           <div class="dot"></div>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
           <div class="dot"></div>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
           <div class="dot"></div>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
        </div>
        <div class="menu">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. veniam blanditiis culpa nostrum eius quisquam.</p>
        </div>
      </div>
       <div class="document_body">
          sdasdasd
       </div>
    </div>


    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>

</body>

</html>