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
    <link rel="stylesheet" href="../assets/css/studies.css">
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
    <div class="documents_wrapper">
      <div class="table_wrapper">
        <div class="search_options">
          <div class="filter_wrapper">
            <input type="text" id="textfield_document_type" placeholder="Search documents..." autocomplete="off">
            <div class="legends">
              <div class="box_wrapper">
                <div class="box bg-success"></div>
                <span>Accept</span>
              </div>
              <div class="box_wrapper">
                <div class="box bg-danger"></div>
                <span>Decline</span>
              </div>
              <div class="box_wrapper">
                <div class="box bg-secondary"></div>
                <span>Pending</span>
              </div>
            </div>
          </div>
          <button class="btn btn-sm btn-primary" id="btn_new_document"  data-toggle="modal" data-backdrop="static" data-keyboard="false">Add New Study</button>
        </div>
        <div class="table_render_wrapper">
          <table class="table table-stripped" id="tbl_documents">
            <thead>
              <tr class="text-secondary">
                <th class="text-center" scope="col">Id</th>
                <th class="text-center" scope="col">Type</th>
                <th class="text-center" scope="col">Proponent</th>
                <th class="text-center" scope="col">Type of Technology</th>
                <th class="text-center" scope="col">Contact Information</th>
                <th class="text-center" scope="col">File</th>
                <th class="text-center" scope="col">Authors</th>
                <th class="text-center" scope="col">Create At</th>
                <th class="text-center" scope="col">Actions</th>
              </tr>
            </thead>
            <tbody id="tbl_body_documents">
              <tr id="tbl_row_placeholder" class="hide">
                <td colspan="9">
                  <?php
                    include_once '../placeholder.php';
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal For Adding New Study -->
    <div class="modal fade" id="modal_document">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary d-block">
            <h5 class="modal-title" id="exampleModalLabel">New Study</h5>
          </div>
          <div class="modal-body d-flex flex-column">
                  <input type="text" id="doc_title" class="form-control my-3" placeholder="Document Title" autocomplete="off">
                  <input type="text" id="proponent" class="form-control my-3" placeholder="Proponent" autocomplete="off">
                  <select id="technology_type" class="form-control my-3">
                    <option value="">Type of Technology</option>
                    <option value="non-chemical">Non-Chemical</option>
                    <option value="chemical">Chemical</option>
                  </select>
                  <input type="text" id="contact_info" class="form-control my-3" placeholder="Contact Information" autocomplete="off" maxlength="11">
                  <input type="file" id="file" class="form-control my-3" accept="image/*,.doc, .docx, .pdf, .odt">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="btn_maker_save">Submit</button>
          </div>
        </div>
      </div>
    </div>

   <!-- Modal For Removing Study -->
    <div class="modal fade" id="modal_delete">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary d-block">
            <h5 class="modal-title" id="exampleModalLabel">Remove Study</h5>
          </div>
          <div class="modal-body d-flex flex-column ml-3 mr-2">
              <div class="d-flex align-items-center mt-2">
                <i class="fa fa-question-circle mr-2"></i>
                <span>Are you sure you want to remove this record?</span>
              </div>
               <div class="reminder text-danger d-flex justify-content-end w-100 mt-5" style="font-size:13px;">
                  <i class="fa fa-exclamation-circle mr-2"></i>
                  <small>Note: Studies that are deleted are move to Archieve Studies.</small>
               </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="btn_maker_delete">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal For Editing Study -->
    <div class="modal fade" id="modal_maker_edit">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary d-block">
              <h5 class="modal-title" id="exampleModalLabel">Update Study</h5>
            </div>
            <div class="modal-body d-flex flex-column">
                Edit
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="btn_maker_delete">Save Changes</button>
            </div>
          </div>
        </div>
    </div>

     <!-- Modal For Viewing Status Of Study-->
     <div class="modal fade" id="modal_maker_study">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary d-block">
              <h5 class="modal-title" id="exampleModalLabel">Status of Study</h5>
            </div>
            <div class="modal-body d-flex flex-column">
                Status
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>



    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/studies.js"></script>

</body>

</html>