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
 
       if(empty($user) || $user != 'admin'){
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
    <link rel="stylesheet" href="../assets/css/feedback.css">
    <link rel="stylesheet" href="../assets/css/drafter_submission.css">

    <title>SLSU-KTTO Document Management System</title>
</head>

<body>
    <input type="text" class="d-none" value="<?php echo $type_of_technology;?>" id="type_of_technology">
    <input type="text" class="d-none" value="<?php echo $_SESSION['user_id'];?>" id="user_id">
    <input type="text" class="d-none" value="<?php echo $_SESSION['name']; ?>" id="user_name">
    <div class="" id="message-container"></div>
    <div class="loader">
      <img src="../assets/images/loader1.gif" class="img-loader">
    </div>
    <?php
      include '../feedback.php';
      include '../navbar.php';

    ?>
    <div class="submission_wrapper">
       <div class="filter_settings">
          <div class="filter_inputs">
            <input type="date" class="form-control" id="filter_by_date">
          </div>
          <div class="sub_container w-100 d-flex justify-content-between">
            <input type="text" class="form-control" placeholder="Type something..." id="input_anything">
            <button class="btn btn-primary" id="btn_see_feedback">
              See Feedback
              <span class="hide" id="feedback_counter">0</span>
            </button>
          </div>
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
                  <th class="text-center" scope="col">Intellectual Property</th>
                  <th class="text-center" scope="col">College</th>
                  <th class="text-center" scope="col">File</th>
                  <th class="text-center" scope="col">Authors</th>
                  <th class="text-center" scope="col">Create At</th>
                  <th class="text-center hide" scope="col">Actions</th>
                </tr>
              </thead>
              <tbody id="tbl_body_drafter_studies">
                <tr id="tbl_row_placeholder" class="hide">
                  <td colspan="11">
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
             <div class="d-flex justify-content-end align-items-center text-success w-100 mb-2 hide" id="notification">
                <i class="fa fa-check-circle mr-2"></i>
                <span style="font-size: 13px;" id="notification_message">Message</span>
             </div>
            <div class="input" id="formality" data-title="Formality Exam Result">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span style="font-size: 14px;">Formality Exam Result</span>
                <span id="formality" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="formality" accept="image/*,.doc, .docx, .pdf, .odt">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="formality"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="formality"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4" id="acknowledgement" data-title="Acknowledgement Reciept">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Acknowledgement Reciept from IPOPHIL</span>
                <span id="acknowledgement" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="acknowledgement" accept="image/*,.doc, .docx, .pdf, .odt">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="acknowledgement"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="acknowledgement"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4" id="withdrawal" data-title="Notice of Withdrawal">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Notice of Withdrawal Application</span>
                <span id="withdrawal" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="withdrawal" accept="image/*,.doc, .docx, .pdf, .odt">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="withdrawal"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="withdrawal"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4" id="publication" data-title="Notice of Publication">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Notice of Publication</span>
                <span id="publication" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="publication" accept="image/*,.doc, .docx, .pdf, .odt">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="publication"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="publication"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4" id="certification" data-title="Certification">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Certification</span>
                <span id="certification" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="certification" accept="image/*,.doc, .docx, .pdf, .odt">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="certification"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="certification"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4" id="response" data-title="Response">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Response</span>
                <span id="response" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="response" accept="image/*,.doc, .docx, .pdf, .odt">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="response"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="response"></i>
                </div>
              </div>
            </div>
            <div class="input mt-4" id="drafted_documents" data-title="Drafted Documents">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span>Drafted Documents</span>
                <span id="drafted_documents" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                <input type="file" class="form-control mt-1" id="drafted_documents" accept="image/*,.doc, .docx, .pdf, .odt">
                <div class="icon_wrapper d-flex align-items-center ml-3">
                  <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="drafted_documents"></i>
                  <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="drafted_documents"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btn_close_accept_modal" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            <button type="button" id="btn_done_accept_modal" class="btn btn-success btn-sm" disabled>Done</button>
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
            <input type="text" id="maker_id_decline" class="d-none">
            <input type="text" class="d-none" id="userId_decline">
             <span style="font-size:14px;">Feedback</span>
             <textarea id="feedback_decline" cols="30" rows="5" class="form-control mt-2" placeholder="Type something..."></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" id="btn_cancel_accept" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="btn_decline_send_feedback" disabled>Submit</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal For Uploading New Document For Maker Study -->
    <div class="modal fade" id="modal_upload_new_document" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary d-block">
            <h5 class="modal-title" id="exampleModalLabel">Upload New Document</h5>
          </div>
          <div class="modal-body" style="font-size:17px;">
             <input type="text" id="maker_id" class="d-none">
             <input type="text" id="uploaded_id" class="d-none">
             <input type="text" class="d-none" id="userId">
             <input type="file" class="form-control my-3" id="new_file" accept="image/*,.doc, .docx, .pdf, .odt">
             <span style="font-size:13px;">Feedback: <span style="font-size:11px;">(Optional)</span></span>
             <textarea id="feedback_move" cols="30" rows="5" class="form-control mt-2 mb-3" placeholder="Type something..." value="This study is now submitted to IPOPHIL.">This study is now submitted to IPOPHIL.</textarea>
             <span class="text-success" style="font-size: 12px;">This will help the maker to be notify about his/her study.</span>
            </div>
          <div class="modal-footer">
            <button type="button" id="btn_cancel_upload_document" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" id="btn_save_upload_document" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/feedback.js"></script>
    <script src="../assets/js/admin_submission.js"></script>

</body>

</html>