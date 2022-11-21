<?php
    include '../api/connection.php';
    include '../api/utils.php';
    include_once '../api/feedback.php';
    global $conn;

    $api = $_POST['api'];

    if(isset($api)){
      if($api === 'get_list_of_studies'){
        $technology_type = $_POST['technology_type'];
        $query = "Select * from tbl_studies where technology_type = '".$technology_type."' and status = 'Pending' or status = 'Decline'";
        $executeQuery = mysqli_query($conn, $query);

        $rows = array();
        while($r = mysqli_fetch_assoc($executeQuery)) {
            $rows[] = $r;
        }
        echo json_encode($rows);
      }else if($api === 'formality'){
         $file = $_FILES['formality']['name'];
         $fileName = 'formality_result_'.$_POST['maker_id'].'_'.$file;

         $query = "Insert into tbl_documents values ('', '".$fileName."', '', '', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."')";
         $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
         $executeQuery = mysqli_query($conn, $selectQuery);
         if(mysqli_num_rows($executeQuery) > 0){
            $row = mysqli_fetch_assoc($executeQuery);
            $updateQuery = "Update tbl_documents set formality_result = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
            saveNewDocument($_FILES['formality'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['formality_result'], $fileName);
         }else{
            saveNewDocument($_FILES['formality'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
         }
      } else if($api === 'acknowledgement'){
        $file = $_FILES['acknowledgement']['name'];
        $fileName = 'acknowledgement_receipt_'.$_POST['maker_id'].'_'.$file;

        $query = "Insert into tbl_documents values ('', '', '".$fileName."', '', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."')";
        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        if(mysqli_num_rows($executeQuery) > 0){
          $updateQuery = "Update tbl_documents set acknowledgement_receipt = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
          $row = mysqli_fetch_assoc($executeQuery);
          saveNewDocument($_FILES['acknowledgement'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['acknowledgement_receipt'], $fileName);
        }else{
          saveNewDocument($_FILES['acknowledgement'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
        }
      } else if($api === 'withdrawal'){
        $file = $_FILES['withdrawal']['name'];
        $fileName = 'notice_of_withdrawal_'.$_POST['maker_id'].'_'.$file;

        $query = "Insert into tbl_documents values ('', '', '', '".$fileName."', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."')";
        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        if(mysqli_num_rows($executeQuery) > 0){
         $row = mysqli_fetch_assoc($executeQuery);
         $updateQuery = "Update tbl_documents set notice_of_withdrawal = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
         saveNewDocument($_FILES['withdrawal'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['notice_of_withdrawal'], $fileName);
        }else{
          saveNewDocument($_FILES['withdrawal'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
        }
      } else if($api === 'publication'){
        $file = $_FILES['publication']['name'];
        $fileName = 'notice_of_publication_'.$_POST['maker_id'].'_'.$file;

        $query = "Insert into tbl_documents values ('', '', '', '', '".$fileName."', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."')";
        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        if(mysqli_num_rows($executeQuery) >0){
         $row = mysqli_fetch_assoc($executeQuery);
         $updateQuery = "Update tbl_documents set notice_of_publication = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
         
         saveNewDocument($_FILES['publication'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['notice_of_publication'], $fileName);
        }else{
          saveNewDocument($_FILES['publication'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
        }
      } else if($api === 'certification'){
        $file = $_FILES['certification']['name'];
        $fileName = 'certification_'.$_POST['maker_id'].'_'.$file;

        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        while($row = mysqli_fetch_array($executeQuery)){
         $query = "Insert into tbl_documents values ('', '', '', '', '', '".$fileName."', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."')";
         $updateQuery = "Update tbl_documents set certification = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
         
         saveNewDocument($_FILES['certification'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['certification'], $fileName);
        }
      } else if($api === 'log_submission'){
        $file = $_FILES['log_submission']['name'];
        $fileName = 'log_submission_status_'.$_POST['maker_id'].'_'.$file;
        
        $query = "Insert into tbl_documents values ('', '', '', '', '', '', '".$fileName."', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."')";
        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        if(mysqli_num_rows($executeQuery) > 0){
         $row = mysqli_fetch_assoc($executeQuery);
         $updateQuery = "Update tbl_documents set log_submission_status = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
         
         saveNewDocument($_FILES['log_submission'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['log_submission_status'], $fileName);
        }else{
          saveNewDocument($_FILES['log_submission'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
        }
      } else if($api === 'response'){
        $file = $_FILES['response']['name'];
        $fileName = 'response_'.$_POST['maker_id'].'_'.$file;

        $query = "Insert into tbl_documents values ('', '', '', '', '', '', '', '".$fileName."', '".$_POST['patent_id']."', '".$_POST['maker_id']."')";
        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        if(mysqli_num_rows($executeQuery)){
         $row = mysqli_fetch_assoc($executeQuery);
         $updateQuery = "Update tbl_documents set response = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
         
         saveNewDocument($_FILES['response'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['response'], $fileName);
        }else{
          saveNewDocument($_FILES['response'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
        }
      } else if($api === 'accept_study_new_comment'){
          $maker_id = $_POST['maker_id'];
          $feedback = $_POST['feedback'];
          $query = "Update tbl_studies set is_new_uploaded = 1 where id = '".$maker_id."'";
          $executeQuery = mysqli_query($conn, $query);
          newFeedback($maker_id, $_POST['patent_id'],$feedback);
       } else if($api === 'accepted_studies'){
          $query = "Select * from tbl_studies where status = 'Accept' and technology_type = '".$_POST['technology_type']."'";
          $executeQuery = mysqli_query($conn, $query);

          $rows_array = array();
          while($r = mysqli_fetch_assoc($executeQuery)) {
              $rows_array[] = $r;
          }
          echo json_encode($rows_array);
       }
    }else{
      return;
    }
?>