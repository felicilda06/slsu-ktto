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

   function saveNewDocument($file, $maker_id, $patent_id, $query, $status, $color, $queryUpdate, $removeFile, $fileName){
     global $conn;
     $isExist = isDocumentExist($maker_id, $patent_id);

     $document_tmp_name = $file['tmp_name'];
     $documentPath = '../files/'.$fileName;
     move_uploaded_file($document_tmp_name, $documentPath);

     try{
         if($isExist){
            mysqli_query($conn, $queryUpdate);
            unlink('../files/'.$removeFile);
      }else{
            
            $executeQuery =  mysqli_query($conn, $query);
            if($executeQuery){
               updateStatusOfStudy($maker_id, $status, $color);
               echo '1';
            }else{
               echo `0`;
            } 
      }
     }catch(Exception $e){}
   }

   function sendFeedback($maker_id, $patent_id, $feedback, $receiver, $created, $senderName){
      global $conn;
      $query = "Insert into tbl_comments values ('', '".$feedback."', '".$maker_id."', '".$patent_id."', '".$patent_id."', '".$receiver."', '".$senderName."' ,0, '".$created."')";
      $executeQuery = mysqli_query($conn, $query);
      if($executeQuery){
         updateStatusOfStudy($maker_id, 'Decline', 'fbafa3');
         return 1;
      }else{
         return 0;
      }
   }

   function replyToComment($maker_id, $patent_id, $feedback, $receiver, $created, $senderName, $sender){
      global $conn;
      $query = "Insert into tbl_comments values ('', '".$feedback."', '".$maker_id."', '".$patent_id."', '".$sender."', '".$receiver."', '".$senderName."' ,0, '".$created."')";
      $executeQuery = mysqli_query($conn, $query);
      if($executeQuery){
         return 1;
      }else{
         return 0;
      }
   }
?>