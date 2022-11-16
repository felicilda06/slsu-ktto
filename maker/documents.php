<!DOCTYPE html>

<head>
    <?php
       include '../dependencies.php';
      session_start();

      $user = $_SESSION['usertype'];
      echo $user;

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
    <link rel="stylesheet" href="../assets/css/documents.css">

    <title>SLSU-KTTO Document Management System</title>
</head>

<body>
    <div class="" id="message-container"></div>
    <div class="loader">
      <img src="../assets/images/loader.gif" class="img-loader">
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
            <div class="document_type_wrapper">
              <span>Document type: </span>
              <select id="document_type">
                <option value="all">All</option>
                <?php
                    $query = "Select * from tbl_document_types";
                    $executeQuery = mysqli_query($conn, $query);
                    while($docType = mysqli_fetch_assoc($executeQuery)){                        
                      $output.="<option value=".$docType['value'].">".$docType['label']."</option>";
                    }
                    echo $output;
                    
                ?>
              </select>
            </div>
            <input type="text" id="textfield_document_type" placeholder="Search documents..." autocomplete="off">
          </div>
          <button class="btn btn-sm btn-primary" id="btn_new_document"  data-toggle="modal" data-backdrop="static" data-keyboard="false">Add New Study</button>
        </div>
        <table class="table table-striped table-hover" id="tbl_documents">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">First</th>
              <th scope="col">Last</th>
              <th scope="col">Handle</th>
            </tr>
          </thead>
          <tbody id="tbl_body_documents"></tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_document">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary d-block">
            <h5 class="modal-title" id="exampleModalLabel">New Study</h5>
          </div>
          <div class="modal-body d-flex flex-column">
                  <select id="document_type" class="form-control mt-4 mb-3">
                    <option value="">Document Type</option>
                      <?php
                          $query = "Select * from tbl_document_types";
                          $executeQuery = mysqli_query($conn, $query);
                          while($docType = mysqli_fetch_assoc($executeQuery)){                        
                            $output.="<option value=".$docType['value'].">".$docType['label']."</option>";
                          }
                          echo $output;
                          
                      ?>
                  </select>
                  <input type="text" class="form-control my-3" placeholder="Document Title">
                  <input type="text" class="form-control my-3" placeholder="Proponent">
                  <select name="" id="" class="form-control my-3">
                    <option value="">Type of Technology</option>
                    <option value="non-chemical">Non-Chemical</option>
                    <option value="chemical">Chemical</option>
                  </select>
                  <input type="text" class="form-control my-3" placeholder="Contact Information">
                  <input type="file" class="form-control my-3">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="btn_sav">Submit</button>
          </div>
        </div>
      </div>
    </div>


    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/documents.js"></script>

</body>

</html>