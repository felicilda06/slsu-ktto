<!DOCTYPE html>

<head>
    <?php
       include '../dependencies.php';
      //  session_start();
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
                    while($docType = mysqli_fetch_array($executeQuery)){                        
                      $output.="<option value=".$docType['value'].">".$docType['label']."</option>";
                    }
                    echo $output;
                    
                ?>
              </select>
            </div>
            <input type="text" id="filter_by" placeholder="Find documents by titles, dates & etc...">
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
          <tbody id="tbl_body_documents">
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Jacob</td>
              <td>Thornton</td>
              <td>@fat</td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Larry</td>
              <td>the Bird</td>
              <td>@twitter</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <script src="../assets/js/documents.js"></script>

</body>

</html>