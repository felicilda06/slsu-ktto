<!DOCTYPE html>

<head>
    <?php
       include '../dependencies.php';
       session_start();
 
       $user = $_SESSION['usertype'];
 
       if(empty($user) || $user != 'patent drafter'){
           header('Location: ../sign-in.php');
           return;
       }
    ?>

    <link rel="icon" href="../assets/images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/loader.css">
    <link rel="stylesheet" href="../assets/css/message.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/drafter_log.css">

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

    <div class="drafter_log_wrapper pt-5 px-4">
      <div class="wrapper_2 d-flex justify-content-between">
       <input type="text" class="form-control" placeholder="Type something..." id="log_filter">
       <button class="btn btn-primary btn-sm">Add New Record</button>
      </div>
      <div class="tbl_drafter_log_wrapper mt-4">
          <table class="table table-stripped" id="tbl_patent_drafter_studies">
                <thead id="tbl_head_drafter_log">
                  <tr id="tbl_head_row"></tr>
                </thead>
                <tbody id="tbl_body_drafter_log">
                  <tr id="tbl_row_placeholder" class="hide">
                    <td colspan="10">
                      <?php
                        include_once '../placeholder.php';
                      ?>
                    </td>
                  </tr>
                </tbody>
          </table>
    </div>
    </div>


    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/drafter_log_submission.js"></script>

</body>

</html>