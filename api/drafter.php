<?php
    include_once './connection.php';
    global $conn;
    $apiType = $_POST['api'];

    if($apiType){
      if($apiType === 'add_new_study'){
            $docType = $_POST['tbl_document_type'];
            $title = $_POST['doc_title'];
            $proponent = $_POST['proponent'];
            $technology_type = $_POST['technology_type'];
            $contact_info = $_POST['contact_info'];

            $file = $_FILES['file']['name'];
            $file_tmp_name = $_FILES['file']['tmp_name'];
            $file_ex = pathinfo($file, PATHINFO_EXTENSION);
            $file_ex_loc = strtolower($file_ex);
            $filepath = '../uploads/'.$_FILES['file']['name'];
            move_uploaded_file($file_tmp_name, $filepath);
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