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
    <link rel="stylesheet" href="../assets/css/placeholder.css">

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
    <div class="document_maker_wrapper pl-1">
      <div class="document_menus relative">
      </div>
       <div class="document_body">
          <div class="files">
             <div class="placeholder w-100 hide">
                <?php include_once '../placeholder.php'; ?>
             </div>
          </div>
          <div class="comments_wrapper">
            <div class="loading hide">
               <img src="../assets/images/loader2.gif" alt="">
            </div>
            <div class="comments">

            </div>
            <div class="comment_input">
               <textarea id="comment_field" class="form-control" cols="1" rows="3"></textarea>
               <i title="Send" class="fa fa-paper-plane text-primary" id="btn_send_comment"></i>
            </div>
          </div>
       </div>
    </div>


    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/document.js"></script>

</body>

</html>