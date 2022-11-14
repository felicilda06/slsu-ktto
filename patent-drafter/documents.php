<!DOCTYPE html>

<head>
    <?php
       include '../dependencies.php';
      session_start();

      $user = $_SESSION['usertype'];

      if(empty($user)){
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
            <input type="text" id="textfield_document_type" placeholder="Search documents...">
          </div>
          <button class="btn btn-sm btn-primary" id="btn_new_document">Upload New Document</button>
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
    <div class="modal fade" id="modal_document" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>


    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/documents.js"></script>

</body>

</html>