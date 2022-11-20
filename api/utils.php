<?php
   include '../api/connection.php';

   function isDocumentExist($maker_id, $patent_id){
      global $conn;
      $query = "Select * from tbl_documents where maker_id = '".$maker_id."' and patent_id = '".$patent_id."'";
      $executeQuery = mysqli_query($conn, $query);
      
      if(mysqli_num_rows($executeQuery) > 0){
         return true;
      }else{
         return false;
      }
   }

   function updateStatusOfStudy($maker_id, $status, $color){
      global $conn;
      $query = "Update tbl_studies set status = '".$status."', bg_color = '".$color."' where id = '".$maker_id."'";
      mysqli_query($conn, $query);
   }

   function saveNewDocument($file, $maker_id, $patent_id, $query, $status, $color){
    global $conn;
     $isExist = isDocumentExist($maker_id, $patent_id);

     if($isExist){
         
     }else{
         $document = $file['name'];
         $document_tmp_name = $file['tmp_name'];
         $documentPath = '../files/'.'formality_result_'.$maker_id.'_'.$document;
         move_uploaded_file($document_tmp_name, $documentPath);
         $executeQuery =  mysqli_query($conn, $query);

         if($executeQuery){
            updateStatusOfStudy($maker_id, $status, $color);
            echo '1';
         }else{
            echo `0`;
         }
         
     }
   }
?>