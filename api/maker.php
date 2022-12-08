<?php
    include_once './connection.php';
    include './response.php';
    include './utils.php';

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
        $userId = $_POST['userId'];
        
        $file = $_FILES['file']['name'];
        $file_tmp_name = $_FILES['file']['tmp_name'];
        $file_ex = pathinfo($file, PATHINFO_EXTENSION);
        $file_ex_loc = strtolower($file_ex);
        $filepath = '../uploads/'.$_FILES['file']['name'];
        move_uploaded_file($file_tmp_name, $filepath);
        
        $query = "Insert into tbl_studies values ('', '".$title."', '".$proponent."', '".$technology_type."', '".$contact_info."', '".$file."', '".$author."', '".$created_at."', '".$status."', '".$color."', 0, '".$userId."', 0)";
        $executeQuery = mysqli_query($conn, $query);

        $response = new Response();
        
        if($executeQuery){
          $response->status_code = 200;
          $response->message = 'New Study Successfully Added.';
        }else{
          $response->status_code = 500;
          $response->message = 'Something went wrong in saving data.';
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

       
      } else if($apiType === 'remove_study'){
         $query = "Delete from tbl_studies WHERE id='".$_POST['rowId']."'";
         $executeQuery = mysqli_query($conn, $query);
         $response = new Response();
         if($executeQuery){
            $response->status_code = 200;
            $response->message = "Study Successfully Deleted.";
         }else{
            $response->status_code = 400;
            $response->message = "Something went wrong in removing study. Please try again.";
         }

         echo json_encode($response);
      } else if($apiType === 'get_study_byId'){
         $query = "Select * from tbl_studies where id = '".$_POST['rowId']."'";
         $executeQuery = mysqli_query($conn,$query);
         $arrOfStudies = array();
         while($row = mysqli_fetch_assoc($executeQuery)){
            $arrOfStudies[] = $row;
         }
         echo json_encode($arrOfStudies);
      } else if($apiType === 'update_study'){
         $response = new Response();
         if(isset($_FILES['updt_file'])){
           echo 1;
         }else{
           $query = "Update tbl_studies set title = '".$_POST['updt_title']."', proponent= '".$_POST['updt_proponent']."', technology_type = '".$_POST['updt_technology_type']."', contact_information = '".$_POST['updt_contact_information']."' where id = '".$_POST['rowId']."'";
           $executeQuery = mysqli_query($conn, $query);
           if($executeQuery){
              $response->status_code = 200;
              $response->message = "Study Successfully Updated.";
           }else{
              $response->status_code = 400;
              $response->message = "Something went wrong on updating data. Please try again";
           }

           echo json_encode($response);
         }
      } else if($apiType === 'get_all_studies'){
         $query = "Select * from tbl_studies where userId = '".$_POST['userId']."' and status != 'Pending'";
         $executeQuery = mysqli_query($conn, $query);
 
         $rows_array = array();
         while($r = mysqli_fetch_assoc($executeQuery)) {
             $rows_array[] = $r;
         }
         echo json_encode($rows_array);
      } else if($apiType === 'get_documents_by_makerId'){
          $query = "Select * from tbl_documents where maker_id = '".$_POST['rowId']."'";
          $executeQuery = mysqli_query($conn, $query);
          
         $rows_array = array();
         while($r = mysqli_fetch_assoc($executeQuery)) {
             $rows_array[] = $r;
         }
         echo json_encode($rows_array);
      } else if($apiType === 'get_feedback_by_id'){
         $query = "Select tbl_comments.*, usertype from tbl_accounts INNER JOIN tbl_comments ON tbl_comments.sender = tbl_accounts.id where tbl_comments.maker_id = '".$_POST['rowId']."'";
          $executeQuery = mysqli_query($conn, $query);
          
         $rows_array = array();
         while($r = mysqli_fetch_assoc($executeQuery)) {
             $rows_array[] = $r;
         }
         echo json_encode($rows_array);
      } else if($apiType === 'get_profile_by_userId'){
         $query = "Select name from tbl_accounts where id = '".$_POST['userId']."'";
         $executeQuery = mysqli_query($conn, $query);
          
         $rows_array = array();
         while($r = mysqli_fetch_assoc($executeQuery)) {
             $rows_array[] = $r;
         }
         echo json_encode($rows_array);
      } else if ($apiType === 'reply_to_comment'){
         replyToComment($_POST['studyId'], $_POST['patentId'], $_POST['feedback'], $_POST['receiver'], $_POST['createdAt'], $_POST['senderName'], $_POST['sender']);
         echo $_POST['studyId'];
      }
    }else{
      return;
    }
?>