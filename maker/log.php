<!DOCTYPE html>

<head>
    <?php
       include '../dependencies.php';
       include '../api/connection.php';
       session_start();
       global $type_of_technology;
       global $user;


       $query = "Select * from tbl_accounts where email = '".$_SESSION['email']."'";
       $executeQuery = mysqli_query($conn, $query);

       while($row = mysqli_fetch_array($executeQuery)){
        $type_of_technology = $row[6];
       }

      //  $query = "Select * from tbl_studies where technology_type = '".$technology_type."' and status = 'Pending' or status = 'Decline'"
 
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
    <link rel="stylesheet" href="../assets/css/drafter_log.css">
    <link rel="stylesheet" href="../assets/css/placeholder.css">

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
      </div>
      <div class="tbl_drafter_log_wrapper mt-4">
          <input type="text" class="d-none" id="user_type" value="<?php echo $user;?>">
          <table class="table table-stripped" id="tbl_patent_drafter_studies">
                <thead id="tbl_head_drafter_log">
                  <tr id="tbl_head_row">
                    <th class="text-center"><span>Id</span></th>
                    <th class="text-center"><span>Application Number</span></th>
                    <th class="text-center"><span>Title</span></th>
                    <th class="text-center"><span>Creator(s)</span></th>
                    <th class="text-center"><span>IP Type</span></th>
                    <th class="text-center"><span>College</span></th>
                    <th class="text-center"><span>Dragon Pay Code</span></th>
                    <th class="text-center"><span>Application Date</span></th>
                    <th class="text-center"><span>Agent</span></th>
                    <th class="text-center"><span>Drafter</span></th>
                    <th class="text-center"><span>Document Where Abouts</span></th>
                    <th class="text-center"><span>Publication Date</span></th>
                    <th class="text-center"><span>Vol.</span></th>
                    <th class="text-center"><span>No.</span></th>
                    <th class="text-center"><span>Registration Date</span></th>
                    <th class="text-center"><span>Vol.</span></th>
                    <th class="text-center"><span>No.</span></th>
                    <th class="text-center"><span>Examiner</span></th>
                    <th class="text-center"><span>Status</span></th>
                    <th class="text-center"><span>IPOPHL Remarks 1</span></th>
                    <th class="text-center"><span>IPOPHL Remarks 2</span></th>
                    <th class="text-center"><span>Office Remarks</span></th>
                    <th class="text-center"><span>Action Steps</span></th>
                    <th class="text-center"><span>Action Steps 2</span></th>
                    <th class="text-center"><span>Certificate in Office?</span></th>
                  </tr>
                </thead>
                <tbody id="tbl_body_drafter_log">
                  <tr id="tbl_row_placeholder" class="hide">
                    <td colspan="25">
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