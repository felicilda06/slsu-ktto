<!DOCTYPE html>

<head>
  <?php
  include '../dependencies.php';
  include_once '../api/connection.php';
  global $conn;

  session_start();

  $user = $_SESSION['usertype'];

  if (empty($user) || $user != 'maker') {
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

  <title>SOUTHERN LEYTE STATE U - ITSO DOCUMENT MANAGEMENT SYSTEM</title>
</head>

<body>
  <input type="text" class="d-none" value="<?php echo $_SESSION['email'] ?>" id="user_email">
  <div class='hide' id='image_previewer_wrapper'>
    <div id='image_previewer'>
      <i class='fa fa-close' id='btn_close_image_previewer' title='Close'></i>
      <i class='fa fa-caret-left' id='btn_previous' title='Previous'></i>
      <i class='fa fa-caret-right' id='btn_next' title='Next'></i>
      <img id='image_render_preview' src="https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTB8fGNhcnN8ZW58MHx8MHx8&w=1000&q=80">
      <i class='fa fa-trash remove_image' title='Remove'></i>
    </div>
  </div>
  <div id="message-container"></div>
  <div class="loader">
    <img src="../assets/images/loader1.gif" class="img-loader">
  </div>
  <?php
  include '../navbar.php';
  include_once '.././api/connection.php';
  global $conn;
  ?>
  <div class="documents_wrapper">
    <input type="text" class="d-none" value="<?php echo $_SESSION['user_id']; ?>" id="userId">
    <div class="table_wrapper">
      <div class="search_options">
        <div class="filter_wrapper">
          <input type="text" id="textfield_document_type" placeholder="Search documents..." autocomplete="off" class="form-control">
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
        <button class="btn btn-sm btn-primary" id="btn_new_document" data-toggle="modal" data-backdrop="static" data-keyboard="false">Add New Study</button>
      </div>
      <div class="table_render_wrapper">
        <table class="table table-stripped" id="tbl_documents">
          <thead>
            <tr class="text-secondary">
              <th class="text-center" scope="col">Id</th>
              <th class="text-center" scope="col">Title</th>
              <th class="text-center" scope="col">Proponent</th>
              <th class="text-center" scope="col">Type of Technology</th>
              <th class="text-center" scope="col">Intellectual Property</th>
              <th class="text-center" scope="col">College</th>
              <th class="text-center" scope="col">Contact Information</th>
              <th class="text-center" scope="col">File</th>
              <th class="text-center" scope="col">Authors</th>
              <th class="text-center" scope="col">Create At</th>
              <th class="text-center" scope="col">Actions</th>
            </tr>
          </thead>
          <tbody id="tbl_body_documents">
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
          <select id="intellectual_property" class="form-control my-3">
            <option value="">Type of Intellectual Property</option>
            <option value="UM">UM</option>
            <option value="Industrial">Industrial</option>
            <option value="Copyright">Copyright</option>
            <option value="Patent">Patent</option>
          </select>
          <div class="college">
            <i id="caret" class="fa fa-caret-down"></i>
            <input type="text" id="college_text" class="college_text" placeholder="College" readonly>
            <div class="college_option hide">
            </div>
          </div>
          <input type="text" id="contact_info" class="form-control my-3" placeholder="Contact Information" autocomplete="off" maxlength="11">
          <input type="file" id="file" class="form-control my-3" accept=".doc, .docx, .pdf, .odt">
          <div id="photo_wrapper">
            <input type="file" id="photos" class="form-control my-3 hidden" accept="image/*" multiple>
            <i class='fa fa-photo'></i>
            <label for="photos" id="btn_upload_photos">Add Photos</label>
          </div>
          <div id="photo_view_container">
            <div id="render_photos">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_maker_cancel">Cancel</button>
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
          <input type="text" class="d-none" id="study_id">
          <div class="d-flex align-items-center mt-2">
            <i class="fa fa-question-circle mr-2"></i>
            <span>Are you sure you want to remove this record?</span>
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
          <input type="text" class="d-none" id="row_id">
          <input type="text" id="updt_title" class="form-control my-3" placeholder="Document Title" autocomplete="off">
          <input type="text" id="updt_proponent" class="form-control my-3" placeholder="Proponent" autocomplete="off">
          <select id="updt_technology_type" class="form-control my-3">
            <option value="">Type of Technology</option>
            <option value="non-chemical">Non-Chemical</option>
            <option value="chemical">Chemical</option>
          </select>
          <select id="updt_intellectual_property" class="form-control my-3">
            <option value="">Type of Intellectual Property</option>
            <option value="UM">UM</option>
            <option value="Industrial">Industrial</option>
            <option value="Copyright">Copyright</option>
            <option value="Patent">Patent</option>
          </select>
          <select id="updt_college" class="form-control my-3">
            <option value="">College</option>
            <?php 
              $query = "Select * from tbl_college where userId = '" . $_SESSION['user_id'] . "' or userId = 0";
              $executeQuery = mysqli_query($conn, $query);
              $college='';
              while($row = mysqli_fetch_array($executeQuery)){
                $college.="<option value=".$row['college'].">".$row['college']."</option>";
              }

              echo $college;
            ?>
          </select>
          <input type="text" id="updt_contact_information" class="form-control my-3" placeholder="Contact Information" autocomplete="off" maxlength="11">
          <div class="files d-flex align-items-center">
            <input readonly type="text" id="updt_file" class="form-control my-3" accept=".doc, .docx, .pdf, .odt" placeholder="File">
            <i title="Edit File" id="btn_edit_file" class="fa fa-pencil-square-o text-warning ml-3" style="cursor: pointer; font-size:15px;"></i>
            <i title="Cancel" id="btn_edit_cancel" class="fa fa-times text-danger ml-3 hide" style="cursor: pointer; font-size:15px;"></i>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="btn_maker_cancel_delete" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="btn_maker_save_changes">Save Changes</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal For Creating College -->
  <div class="modal fade" id="modal_create_college">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary d-block">
          <h5 class="modal-title" id="exampleModalLabel">Create New Item</h5>
        </div>
        <div class="modal-body">
          <form>
            <input type="text" class="form-control" id="new_college" placeholder="College Name" autocomplete="off">
            <div class="mt-2 d-flex justify-content-end">
              <button type="button" class="btn btn-danger mr-2" data-dismiss="modal" id="btn_cancel_college">Cancel</button>
              <button type="submit" class="btn btn-success" id="btn_add_college">Add</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script src="../assets/js/main.js"></script>
  <script src="../assets/js/navbar.js"></script>
  <script src="../assets/js/studies.js"></script>
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="https://unpkg.com/tippy.js@6"></script>  
</body>

</html>