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

    <title>SOUTHERN LEYTE STATE UNIVERSITY - ITSO DOCUMENT MANAGEMENT SYSTEM</title>
</head>

<body>
    <input type="text" class="d-none" value="<?php echo $_SESSION['email'];?>" id="user_email">
    <input type="text" class="d-none" value="<?php echo $_SESSION['name']; ?>" id="user_name">
    <input type="text" class="d-none" value="<?php echo $_SESSION['user_id'];?>" id="user_id">
    <div class="" id="message-container"></div>
    <div class="loader">
      <img src="../assets/images/loader1.gif" class="img-loader">
    </div>
    <?php
      include '../navbar.php';
      include_once '.././api/connection.php';
      global $conn;
    ?>
    <div class="main_placeholder">
      <?php include_once '../placeholder.php'; ?>
    </div>
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
            <div class="d-flex align-items-center justify-content-center" id="study_status_wrapper">
                <div class="w-100 text-center" id="study_status"></div>
            </div>
            <div class="comments" id="comments">
            </div>
            <div class="comment_input">
               <form class="w-100 d-flex align-items-center">
                  <input id="comment_field" class="form-control" style="height: 50px;" placeholder="Type something..."></input>
                  <button type="submit" id="btn_send_comment">
                    <i title="Send" class="fa fa-paper-plane text-primary ml-2"></i>
                  </button>
                  
               </form>
            </div>
          </div>
       </div>
    </div>


    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/document.js"></script>

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>  

</body>

</html>