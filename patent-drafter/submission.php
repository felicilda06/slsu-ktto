<!DOCTYPE html>

<head>
    <?php
       include '../dependencies.php';
       include_once '../api/connection.php';
       session_start();

       global $conn;
       global $type_of_technology;

       $query = "Select * from tbl_accounts where email = '".$_SESSION['email']."'";
       $executeQuery = mysqli_query($conn, $query);

       while($row = mysqli_fetch_array($executeQuery)){
        $type_of_technology = $row[6];
       }
 
       $user = $_SESSION['usertype'];
 
       if(empty($user) || $user != 'patent drafter'){
           header('Location: ../sign-in.php');
           return;
       }
    ?>

    <link rel="icon" href="../assets/images/logo.png" type="image/icon">

    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/loader.css">
    <link rel="stylesheet" href="../assets/css/message.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/placeholder.css">
    <link rel="stylesheet" href="../assets/css/drafter_submission.css">

    <title>SLSU-KTTO Document Management System</title>
</head>

<body>
    <input type="text" class="d-none" value="<?php echo $type_of_technology;?>" id="type_of_technology">
    <div class="" id="message-container"></div>
    <div class="loader">
      <img src="../assets/images/loader1.gif" class="img-loader">
    </div>
    <?php
      include '../navbar.php';
    ?>
    <div class="submission_wrapper">
       <div class="filter_settings">
          <div class="filter_inputs">
            <span>Filter by: </span>
            <input type="date" class="form-control" id="filter_by_date">
          </div>
          <input type="text" class="form-control" placeholder="Type something..." id="input_anything">
       </div>
       <div class="tbl_drafter_studies_wrapper">
           <table class="table table-stripped" id="tbl_studies">
              <thead>
                <tr class="text-secondary">
                  <th class="text-center" scope="col">Id</th>
                  <th class="text-center" scope="col">Type</th>
                  <th class="text-center" scope="col">Title</th>
                  <th class="text-center" scope="col">Proponent</th>
                  <th class="text-center" scope="col">Type of Technology</th>
                  <th class="text-center" scope="col">Contact Information</th>
                  <th class="text-center" scope="col">File</th>
                  <th class="text-center" scope="col">Authors</th>
                  <th class="text-center" scope="col">Create At</th>
                  <th class="text-center" scope="col">Actions</th>
                </tr>
              </thead>
              <tbody id="tbl_body_drafter_studies">
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


     <!-- Modal For Accept Study -->
     <div class="modal fade" id="modal_accept" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary d-block">
            <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
          </div>
          <div class="modal-body" style="font-size:17px;">
            <i class="fa fa-question-circle text-secondary mr-1"></i>
            <span>Are you sure you want to accept this record?</span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary">Accept</button>
          </div>
        </div>
      </div>
    </div>

     <!-- Modal For Decline Study -->
     <div class="modal fade" id="modal_decline" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary d-block">
            <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
          </div>
          <div class="modal-body" style="font-size:17px;">
            <i class="fa fa-question-circle text-secondary mr-1"></i>
            <span>Are you sure you want to accept this decline?</span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/drafter_submission.js"></script>

</body>

</html>