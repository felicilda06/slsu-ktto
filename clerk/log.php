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

       $user = $_SESSION['usertype'];
 
       if(empty($user) || $user != 'clerk'){
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

    <title>SOUTHERN LEYTE STATE U - ITSO DOCUMENT MANAGEMENT SYSTEM</title>
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
       <input type="text" class="hide" id="user_type" value="<?php echo $user; ?>">
       <input type="text" class="form-control" placeholder="Type something..." id="log_filter">
       <input type="text" class="d-none" id="technology_type" value="<?php echo $type_of_technology; ?>">
       <button class="btn btn-primary btn-sm hide" id="btn_drafter_new_log">Add New Record</button>
      </div>
      <h3 class="p-2">SLSU INTELLECTUAL PROPERTY PORTFOLIO MATRIX</h3>
      <div class="tbl_drafter_log_wrapper mt-4">
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
                    <th class="text-center"><span>Expiration Date</span></th>
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

     <!-- Modal For Adding Record forLog Submission -->
     <div class="modal fade" id="modal_drafter_log" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary d-block">
            <h5 class="modal-title" id="exampleModalLabel">Create New Record</h5>
          </div>
          <div class="modal-body relative" style="font-size:13px;">
              <div class="" id="form_log_1">
                  <div class="input d-flex mt-3">
                      <div class="input_wrapper w-100 mx-2">
                        <span>Application Number</span>
                        <input type="text" class="form-control" id="application_no" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                        <span>Title</span>
                        <small class="text-warning" style="float: right;">This field is requried.</small>
                        <select id="title" class="form-control">
                          <option value="">--Select--</option>
                        </select>
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                          <div class="d-flex justify-content-between">
                            <span>Creator(s)</span>
                            <small class="text-secondary">This field is muted.</small>
                          </div>
                          <input type="text" class="form-control mx-2" placeholder="" id="creator" autocomplete="off" readonly style="background: white;">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>IP Type</span>
                          <select id="ip_type" class="form-control">
                            <option value="INV">INV</option>
                            <option value="UM">UM</option>
                            <option value="CR">CR</option>
                            <option value="ID">ID</option>
                          </select>
                      </div>  
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>College</span>
                            <input type="text" class="form-control" placeholder="" id="college" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Dragon Pay Code</span>
                          <input type="text" class="form-control" placeholder="" id="dragon_pay" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Application Date</span>
                            <input type="date" class="form-control" placeholder="" id="application_date">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Agent</span>
                          <input type="text" class="form-control" placeholder="" id="agent" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Drafter</span>
                            <input type="text" class="form-control" placeholder="" id="drafter" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Document Where Abouts</span>
                          <input type="text" class="form-control" placeholder="" id="document_where_about" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Publication Date</span>
                            <input type="date" class="form-control" placeholder="" id="publication_date">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Vol.</span>
                          <input type="number" class="form-control" placeholder="" id="publication_vol" autocomplete="off">
                      </div>
                  </div>
              </div>
              <div class="hide" id="form_log_2">
                  <div class="input d-flex mt-3">
                      <div class="input_wrapper w-100 mx-2">
                            <span>No.</span>
                            <input type="number" class="form-control" placeholder="" id="publication_no" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Registration Date</span>
                          <input type="date" class="form-control" placeholder="" id="registration_date">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Vol.</span>
                            <input type="number" class="form-control" placeholder="" id="registration_date_vol" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>No.</span>
                          <input type="number" class="form-control" placeholder="" id="registration_date_no" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                          <span>Examiner</span>
                          <input type="text" class="form-control" placeholder="" id="examiner" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Status</span>
                          <select  id="status" class="form-control">
                            <option value="Registered">Registered</option>
                            <option value="Under Substantive Examination">Under Substantive Examination</option>
                            <option value="Under Formality Examination">Under Formality Examination</option>
                            <option value="Forfeited">Forfeited</option>
                            <option value="Published">Published</option>
                            <option value="Withdrawn">Withdrawn</option>
                          </select>
                      </div>   
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>IPOPHL Remarks 1</span>
                            <input type="text" class="form-control" placeholder="" id="remark_1" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>IPOPHL Remarks 2</span>
                          <input type="text" class="form-control" placeholder="" id="remark_2" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Office Remarks</span>
                            <input type="text" class="form-control" placeholder="" id="office_remark" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Action Steps</span>
                          <input type="text" class="form-control" placeholder="" id="action_step_1" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Action Steps 2</span>
                            <input type="text" class="form-control" placeholder="" id="action_step_2" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>CERTIFICATE IN OFFICE?</span>
                          <input type="text" class="form-control" placeholder="" id="certificate_office" autocomplete="off">
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btn_drafter_cancel_log" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" id="btn_drafter_next_log" class="btn btn-primary" disabled>Next</button>
          </div>
        </div>
      </div>
    </div>


     <!-- Modal For Editing Record for Log Submission -->
     <div class="modal fade" id="modal_drafter_log_update" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary d-block">
            <h5 class="modal-title" id="exampleModalLabel">Update Record</h5>
          </div>
          <div class="modal-body relative" style="font-size:13px;">
              <div class="" id="updt_form_log_1">
                  <div class="input d-flex mt-3">
                      <div class="input_wrapper w-100 mx-2">
                        <span>Application Number</span>
                        <input type="text" class="form-control" id="updt_application_no" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                        <div class="d-flex justify-content-between">
                            <span>Title</span>
                            <small class="text-secondary">This field is muted.</small>
                        </div>
                        <select id="updt_title" class="form-control" disabled style="background: white;">
                          <?php
                            $option = '';
                            $query1 = "Select title from tbl_studies where technology_type = '".$type_of_technology."' and status = 'Accept'";
                            $executeQuery = mysqli_query($conn, $query1);
                            while($r = mysqli_fetch_array($executeQuery)){
                                $option.='
                                  <option value="'.$r['title'].'">'.$r['title'].'</option>
                                ';
                            }

                           echo $option;
                          ?>
                        </select>
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                          <div class="d-flex justify-content-between">
                            <span>Creator(s)</span>
                            <small class="text-secondary">This field is muted.</small>
                          </div>
                          <input type="text" class="form-control mx-2" placeholder="" id="updt_creator" autocomplete="off" disabled style="background: white;">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>IP Type</span>
                          <select id="updt_ip_type" class="form-control">
                            <option value="INV">INV</option>
                            <option value="UM">UM</option>
                            <option value="CR">CR</option>
                            <option value="ID">ID</option>
                          </select>
                      </div>  
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>College</span>
                            <input type="text" class="form-control" placeholder="" id="updt_college" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Dragon Pay Code</span>
                          <input type="text" class="form-control" placeholder="" id="updt_dragon_pay" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Application Date</span>
                            <input type="date" class="form-control" placeholder="" id="updt_application_date">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Agent</span>
                          <input type="text" class="form-control" placeholder="" id="updt_agent" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Drafter</span>
                            <input type="text" class="form-control" placeholder="" id="updt_drafter" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Document Where Abouts</span>
                          <input type="text" class="form-control" placeholder="" id="updt_document_where_about" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Publication Date</span>
                            <input type="date" class="form-control" placeholder="" id="updt_publication_date">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Vol.</span>
                          <input type="number" class="form-control" placeholder="" id="updt_publication_vol" autocomplete="off">
                      </div>
                  </div>
              </div>
              <div class="hide" id="updt_form_log_2">
                  <div class="input d-flex mt-3">
                      <div class="input_wrapper w-100 mx-2">
                            <span>No.</span>
                            <input type="number" class="form-control" placeholder="" id="updt_publication_no" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Registration Date</span>
                          <input type="date" class="form-control" placeholder="" id="updt_registration_date">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Vol.</span>
                            <input type="number" class="form-control" placeholder="" id="updt_registration_date_vol" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>No.</span>
                          <input type="number" class="form-control" placeholder="" id="updt_registration_date_no" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                          <span>Examiner</span>
                          <input type="text" class="form-control" placeholder="" id="updt_examiner" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Status</span>
                          <select  id="updt_status" class="form-control">
                            <option value="Registered">Registered</option>
                            <option value="Under Substantive Examination">Under Substantive Examination</option>
                            <option value="Under Formality Examination">Under Formality Examination</option>
                            <option value="Forfeited">Forfeited</option>
                            <option value="Published">Published</option>
                            <option value="Withdrawn">Withdrawn</option>

                          </select>
                      </div>   
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>IPOPHL Remarks 1</span>
                            <input type="text" class="form-control" placeholder="" id="updt_remark_1" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>IPOPHL Remarks 2</span>
                          <input type="text" class="form-control" placeholder="" id="updt_remark_2" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Office Remarks</span>
                            <input type="text" class="form-control" placeholder="" id="updt_office_remark" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>Action Steps</span>
                          <input type="text" class="form-control" placeholder="" id="updt_action_step_1" autocomplete="off">
                      </div>
                  </div>
                  <div class="input d-flex mt-4">
                      <div class="input_wrapper w-100 mx-2">
                            <span>Action Steps 2</span>
                            <input type="text" class="form-control" placeholder="" id="updt_action_step_2" autocomplete="off">
                      </div>
                      <div class="input_wrapper w-100 mx-2">
                          <span>CERTIFICATE IN OFFICE?</span>
                          <input type="text" class="form-control" placeholder="" id="updt_certificate_office" autocomplete="off">
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btn_drafter_cancel_update_log" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" id="btn_drafter_next_update_log" class="btn btn-primary" disabled>Next</button>
          </div>
        </div>
      </div>
    </div>


    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/drafter_log_submission.js"></script>

</body>

</html>