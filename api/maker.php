<?php
    include_once './connection.php';
    include './response.php';
    global $conn;
    $apiType = $_POST['api'];

    if($apiType){
      if($apiType === 'add_new_study'){
        $title = $_POST['doc_title'];
        $proponent = $_POST['proponent'];
        $technology_type = $_POST['technology_type'];
        $contact_info = $_POST['contact_info'];
        $created_at = $_POST['created_at'];
        $author = $_POST['author'];
        $status = $_POST['status'];
        $color = $_POST['color'];
        
        $file = $_FILES['file']['name'];
        $file_tmp_name = $_FILES['file']['tmp_name'];
        $file_ex = pathinfo($file, PATHINFO_EXTENSION);
        $file_ex_loc = strtolower($file_ex);
        $filepath = '../uploads/'.$_FILES['file']['name'];
        move_uploaded_file($file_tmp_name, $filepath);
        
        $query = "Insert into tbl_studies values ('', '".$title."', '".$proponent."', '".$technology_type."', '".$contact_info."', '".$file."', '".$author."', '".$created_at."', '".$status."', '".$color."')";
        $executeQuery = mysqli_query($conn, $query);

        $response = new Response();
        
        if($executeQuery){
          $response->status_code = 200;
          $response->message = 'New Study Successfully Added.';
        }else{
          $response->status_code = 500;
          $response->message = 'Something went wrong in saveing data.';
        }
        echo json_encode($response);

      }else if($apiType === 'get_record_studies'){
        $response = new Response();
        $query = "Select * from tbl_studies";
        $executeQuery = mysqli_query($conn, $query);

        $rows = array();
        while($r = mysqli_fetch_assoc($executeQuery)) {
            $rows[] = $r;
        }
        echo json_encode($rows);

       
      }
    }

    // if($apiType){
    //    if($apiType === 'get_document_types'){
         

    //       if(mysqli_num_rows($executeQuery) > 0){
    //         $docType = mysqli_fetch_assoc($executeQuery);
    //         for($docs in $docType  ){
                
    //         }
    //       }
    //    }
    // }else{return;}
?>