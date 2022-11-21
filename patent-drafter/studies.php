<!DOCTYPE html>

<head>
    <?php
      include '../dependencies.php';
      include '../api/connection.php';

      session_start();

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

    <link rel="icon" href="../assets/images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/loader.css">
    <link rel="stylesheet" href="../assets/css/message.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/drafter_studies.css">

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
        <div class="wrapper d-flex justify-content-between">
          <div class="drafter_studies_filter d-flex">
              <input type="date" class="form-control mr-3">
              <input type="text" class="form-control" placeholder="Type something...">
          </div>
          <div class="info d-flex align-items-center pr-2" style="font-size:12px; color:#e8c518;">
            <i class="fa fa-exclamation-circle mr-2"></i>
            <span>All visible studies here are already accepted.</span>
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
                    <th class="text-center" scope="col">File</th>
                    <th class="text-center" scope="col">Authors</th>
                    <th class="text-center" scope="col">Create At</th>
                    <th class="text-center" scope="col">Status</th>
                    <th class="text-center" scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody id="tbl_drafter_studies">
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

     <!-- Modal For Editing Accepted Study -->
     <div class="modal fade" id="modal_drafter_upload_new_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary d-block">
            <h5 class="modal-title" id="exampleModalLabel">Upload New Document</h5>
          </div>
          <div class="modal-body" style="font-size:17px;">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" id="btn_drafer_upload_cancel" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" id="btn_drafer_upload_done" class="btn btn-primary">Done</button>
          </div>
        </div>
      </div>
    </div>

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/drafter_studies.js"></script>

</body>

</html>