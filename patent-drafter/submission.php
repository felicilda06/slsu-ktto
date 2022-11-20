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
    <input type="text" class="d-none" value="<?php echo $_SESSION['user_id'];?>" id="user_id">
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
            <h5 class="modal-title" id="exampleModalLabel">Accept New Study</h5>
          </div>
          <div class="modal-body" style="font-size:14px;">
            <input type="text" id="maker_id" class="d-none">
            <div class="input">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Formality Exam Result</span>
                <span id="formality" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="formality">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="formality"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="formality"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Acknowledgement Reciept from IPOPHIL</span>
                <span id="acknowledgement" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="acknowledgement">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="acknowledgement"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="acknowledgement"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Notice of Withdrawal Application</span>
                <span id="withdrawal" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="withdrawal">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="withdrawal"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="withdrawal"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Notice of Publication</span>
                <span id="publication" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="publication">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="publication"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="publication"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Certification</span>
                <span id="certification" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="certification">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="certification"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="certification"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Log Submission Status</span>
                <span id="log_submission" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="log_submission">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="log_submission"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="log_submission"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Response</span>
                <span id="response" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="response">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="response"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="response"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btn_close_accept_modal" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            <button type="button" id="btn_done_accept_modal" class="btn btn-success btn-sm" data-dismiss="modal" disabled>Done</button>
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
            <span>Are you sure you want to decline this record?</span>
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