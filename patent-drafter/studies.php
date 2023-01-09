<!DOCTYPE html>

<head>
    <?php
      include '../dependencies.php';
      include '../api/connection.php';

      session_start();

      global $type_of_technology;
      global $userId;

       $query = "Select * from tbl_accounts where email = '".$_SESSION['email']."'";
       $executeQuery = mysqli_query($conn, $query);

       while($row = mysqli_fetch_array($executeQuery)){
        $type_of_technology = $row[6];
        $userId = $row[0];
       }

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
    <link rel="stylesheet" href="../assets/css/drafter_studies.css">
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

    <div class="drafter_studies_wrapper pt-5 px-3">
        <input type="text" class="d-none" value="<?php echo $type_of_technology;?>" id="type_of_technology">
        <input type="text" class="d-none" value="<?php echo $userId;?>" id="patent_id">
        <input type="text" class="d-none" value="<?php echo $_SESSION['name'];?>" id="user_name">
        <div class="wrapper d-flex justify-content-between">
          <div class="drafter_studies_filter d-flex">
              <input type="date" class="form-control mr-3" id="filter_date_accepted">
              <input type="text" class="form-control" placeholder="Type something..." id="filter_input_accepted">
          </div>
        </div>
        <div class="tbl_drafter_studies_wrapper mt-4">
            <table class="table table-stripped" id="tbl_patent_drafter_studies">
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
                    <th class="text-center" scope="col">Status</th>
                    <th class="text-center" scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody id="tbl_drafter_studies">
                  <tr id="tbl_row_placeholder" class="hide">
                    <td colspan="12">
                      <?php
                        include_once '../placeholder.php';
                      ?>
                    </td>
                  </tr>
                </tbody>
            </table>
        </div>
    </div>

     <!-- Modal For Editing Accepted Study -->
     <div class="modal fade" id="modal_drafter_update_doc_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary d-block">
            <h5 class="modal-title" id="exampleModalLabel">Edit Documents</h5>
          </div>
          <div class="modal-body" style="font-size:14px;">
             <input type="text" id="maker_id_update_studies" class="d-none">
             <div class="d-flex justify-content-end align-items-center text-success w-100 mb-2 hide" id="notification">
                <i class="fa fa-check-circle mr-2"></i>
                <span style="font-size: 13px;" id="notification_message">Message</span>
             </div>
            <div class="input" id="formality_result" data-title="Formality Exam Result">
              <div class="d-flex justify-content-between" id="label_wrapper">
                <span style="font-size: 14px;">Formality Exam Result</span>
                <span id="formality_result" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
              </div>
              <div class="input_wrapper d-flex align-items-center">
                  <input readonly type="text" class="form-control mt-1" id="formality_result" accept="image/*,.doc, .docx, .pdf, .odt">
                  <i class="fa fa-pencil ml-3 text-secondary" id="formality_result"></i>
                  <div class="icon_wrapper d-flex align-items-center ml-3 hide" id="formality_result">
                    <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="formality_result"></i>
                    <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="formality_result"></i>
                  </div>
                </div>
              </div>
              <div class="input mt-4" id="acknowledgement_receipt" data-title="Acknowledgement Reciept">
                <div class="d-flex justify-content-between" id="label_wrapper">
                  <span>Acknowledgement Reciept from IPOPHIL</span>
                  <span id="acknowledgement_receipt" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
                </div>
                <div class="input_wrapper d-flex align-items-center">
                  <input readonly type="text" class="form-control mt-1" id="acknowledgement_receipt" accept="image/*,.doc, .docx, .pdf, .odt">
                  <i class="fa fa-pencil ml-3 text-secondary" id="acknowledgement_receipt"></i>
                  <div class="icon_wrapper d-flex align-items-center ml-3 hide" id="acknowledgement_receipt">
                    <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="acknowledgement_receipt"></i>
                    <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="acknowledgement_receipt"></i>
                  </div>
                </div>
              </div>
              <div class="input mt-4" id="notice_of_withdrawal" data-title="Notice of Withdrawal">
                <div class="d-flex justify-content-between" id="label_wrapper">
                  <span>Notice of Withdrawal Application</span>
                  <span id="notice_of_withdrawal" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
                </div>
                <div class="input_wrapper d-flex align-items-center">
                  <input readonly type="text" class="form-control mt-1" id="notice_of_withdrawal" accept="image/*,.doc, .docx, .pdf, .odt">
                  <i class="fa fa-pencil ml-3 text-secondary" id="notice_of_withdrawal"></i>
                  <div class="icon_wrapper d-flex align-items-center ml-3 hide" id="notice_of_withdrawal">
                    <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="notice_of_withdrawal"></i>
                    <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="notice_of_withdrawal"></i>
                  </div>
                </div>
              </div>
              <div class="input mt-4" id="notice_of_publication" data-title="Notice of Publication">
                <div class="d-flex justify-content-between" id="label_wrapper">
                  <span>Notice of Publication</span>
                  <span id="notice_of_publication" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
                </div>
                <div class="input_wrapper d-flex align-items-center">
                  <input readonly type="text" class="form-control mt-1" id="notice_of_publication" accept="image/*,.doc, .docx, .pdf, .odt">
                  <i class="fa fa-pencil ml-3 text-secondary" id="notice_of_publication"></i>
                  <div class="icon_wrapper d-flex align-items-center ml-3 hide" id="notice_of_publication">
                    <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="notice_of_publication"></i>
                    <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="notice_of_publication"></i>
                  </div>
                </div>
              </div>
              <div class="input mt-4" id="certification" data-title="Certification">
                <div class="d-flex justify-content-between" id="label_wrapper">
                  <span>Certification</span>
                  <span id="certification" class="hide text-danger" style="font-size:11px;">File Already Exist.</span>
                </div>
                <div class="input_wrapper d-flex align-items-center">
                  <input readonly type="text" class="form-control mt-1" id="certification" accept="image/*,.doc, .docx, .pdf, .odt">
                  <i class="fa fa-pencil ml-3 text-secondary" id="certification"></i>
                  <div class="icon_wrapper d-flex align-items-center ml-3 hide" id="certification">
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
                  <input readonly type="text" class="form-control mt-1" id="response" accept="image/*,.doc, .docx, .pdf, .odt">
                  <i class="fa fa-pencil ml-3 text-secondary" id="response"></i>
                  <div class="icon_wrapper d-flex align-items-center ml-3 hide" id="response">
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
                  <input readonly type="text" class="form-control mt-1" id="drafted_documents" accept="image/*,.doc, .docx, .pdf, .odt">
                  <i class="fa fa-pencil ml-3 text-secondary" id="drafted_documents"></i>
                  <div class="icon_wrapper d-flex align-items-center ml-3 hide" id="drafted_documents">
                    <i title="Save" class="btn_save fa fa-check text-success mr-3 disable" id="drafted_documents"></i>
                    <i title="Cancel" class="btn_cancel fa fa-times text-danger" id="drafted_documents"></i>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btn_drafer_cancel_update_doc" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/drafter_studies.js"></script>

</body>

</html>