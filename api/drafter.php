<?php
    include '../api/connection.php';
    include '../api/utils.php';
    include './response.php';
    global $conn;

    $api = $_POST['api'];

    if(isset($api)){
      if($api === 'get_all_studies'){
        $query = "Select * from tbl_studies where status = 'Pending' or status = 'Decline'";
        $executeQuery = mysqli_query($conn, $query);

        $rows = array();
        while($r = mysqli_fetch_assoc($executeQuery)) {
            $rows[] = $r;
        }
        echo json_encode($rows);
      } else if($api === 'get_list_of_studies'){
        $technology_type = $_POST['technology_type'];
        $query = "Select * from tbl_studies where technology_type = '".$technology_type."' and status != 'Accept'";
        $executeQuery = mysqli_query($conn, $query);

        $rows = array();
        while($r = mysqli_fetch_assoc($executeQuery)) {
            $rows[] = $r;
        }
        echo json_encode($rows);
      }else if($api === 'formality'){
         $file = $_FILES['formality']['name'];
         $fileName = 'formality_result_'.$_POST['maker_id'].'_'.$file;
         
         $query = "Insert into tbl_documents values ('', '".$fileName."', '', '', '', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
         $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
         $executeQuery = mysqli_query($conn, $selectQuery);
         if(mysqli_num_rows($executeQuery) > 0){
            $row = mysqli_fetch_assoc($executeQuery);
            $updateQuery = "Update tbl_documents set formality_result = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
            saveNewDocument($_FILES['formality'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['formality_result'], $fileName);
         }else{
            saveNewDocument($_FILES['formality'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
         }

         $senderName = $_POST['senderName'];
         $senderFeedback = "$senderName uploaded a formality result.";
         sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
      } else if($api === 'acknowledgement'){
        $file = $_FILES['acknowledgement']['name'];
        $fileName = 'acknowledgement_receipt_'.$_POST['maker_id'].'_'.$file;

        $query = "Insert into tbl_documents values ('', '', '".$fileName."', '', '', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        if(mysqli_num_rows($executeQuery) > 0){
          $updateQuery = "Update tbl_documents set acknowledgement_receipt = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
          $row = mysqli_fetch_assoc($executeQuery);
          saveNewDocument($_FILES['acknowledgement'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['acknowledgement_receipt'], $fileName);
        }else{
          saveNewDocument($_FILES['acknowledgement'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
        }

        $senderName = $_POST['senderName'];
         $senderFeedback = "$senderName uploaded a acknowledgement receipt.";
         sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
      } else if($api === 'withdrawal'){
        $file = $_FILES['withdrawal']['name'];
        $fileName = 'notice_of_withdrawal_'.$_POST['maker_id'].'_'.$file;

        $query = "Insert into tbl_documents values ('', '', '', '".$fileName."', '', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        if(mysqli_num_rows($executeQuery) > 0){
         $row = mysqli_fetch_assoc($executeQuery);
         $updateQuery = "Update tbl_documents set notice_of_withdrawal = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
         saveNewDocument($_FILES['withdrawal'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['notice_of_withdrawal'], $fileName);
        }else{
          saveNewDocument($_FILES['withdrawal'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
        }

        $senderName = $_POST['senderName'];
        $senderFeedback = "$senderName uploaded a notice of withdrawal application.";
        sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
      } else if($api === 'publication'){
        $file = $_FILES['publication']['name'];
        $fileName = 'notice_of_publication_'.$_POST['maker_id'].'_'.$file;

        $query = "Insert into tbl_documents values ('', '', '', '', '".$fileName."', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        if(mysqli_num_rows($executeQuery) >0){
         $row = mysqli_fetch_assoc($executeQuery);
         $updateQuery = "Update tbl_documents set notice_of_publication = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
         
         saveNewDocument($_FILES['publication'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['notice_of_publication'], $fileName);
        }else{
          saveNewDocument($_FILES['publication'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
        }

        $senderName = $_POST['senderName'];
        $senderFeedback = "$senderName uploaded a notice of publication.";
        sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
      } else if($api === 'certification'){
        $file = $_FILES['certification']['name'];
        $fileName = 'certification_'.$_POST['maker_id'].'_'.$file;

        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        while($row = mysqli_fetch_array($executeQuery)){
         $query = "Insert into tbl_documents values ('', '', '', '', '', '".$fileName."', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
         $updateQuery = "Update tbl_documents set certification = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
         
         saveNewDocument($_FILES['certification'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['certification'], $fileName);
        }

        $senderName = $_POST['senderName'];
        $senderFeedback = "$senderName uploaded a certification.";
        sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
      } else if($api === 'log_submission'){
        $file = $_FILES['log_submission']['name'];
        $fileName = 'log_submission_status_'.$_POST['maker_id'].'_'.$file;
        
        $query = "Insert into tbl_documents values ('', '', '', '', '', '', '".$fileName."', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
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

        $query = "Insert into tbl_documents values ('', '', '', '', '', '', '', '".$fileName."', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        if(mysqli_num_rows($executeQuery)){
         $row = mysqli_fetch_assoc($executeQuery);
         $updateQuery = "Update tbl_documents set response = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
         
         saveNewDocument($_FILES['response'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['response'], $fileName);
        }else{
          saveNewDocument($_FILES['response'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
        }

        $senderName = $_POST['senderName'];
        $senderFeedback = "$senderName uploaded a response.";
        sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
      } else if($api === 'drafted_documents'){
        $file = $_FILES['drafted_documents']['name'];
        $fileName = 'drafted_documents'.$_POST['maker_id'].'_'.$file;

        $query = "Insert into tbl_documents values ('', '', '', '', '', '', '', '', '".$fileName."', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
        $selectQuery = "Select * from tbl_documents where maker_id = '".$_POST['maker_id']."'";
        $executeQuery = mysqli_query($conn, $selectQuery);
        if(mysqli_num_rows($executeQuery)){
         $row = mysqli_fetch_assoc($executeQuery);
         $updateQuery = "Update tbl_documents set drafted_documents = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
         
         saveNewDocument($_FILES['drafted_documents'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], $updateQuery, $row['drafted_documents'], $fileName);
        }else{
          saveNewDocument($_FILES['drafted_documents'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color'], '', '', $fileName);
        }

        $senderName = $_POST['senderName'];
        $senderFeedback = "$senderName uploaded a response.";
        sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
      } else if($api === 'accept_study_new_comment'){
        $maker_id = $_POST['maker_id'];
        $feedback = $_POST['feedback'];
        $receiver = $_POST['userId'];
        $createdAt = $_POST['createdAt'];
        $senderName = $_POST['sender_name'];
        $res = new Response();

        try{
          if(isset($_FILES['new_file'])){
            $query =  "Select * from tbl_studies where id = '".$maker_id."'";
            $executeQuery = mysqli_query($conn, $query);
            $newFile =  $_FILES['new_file'];
            if(mysqli_num_rows($executeQuery) > 0){
              $row = mysqli_fetch_assoc($executeQuery);
              $query = "Update tbl_studies set is_new_uploaded = 1, file = '".$newFile['name']."' where id = '".$maker_id."'";
              $executeQuery = mysqli_query($conn, $query);
              unlink('../uploads/'.$row['file']);
              $document_tmp_name = $newFile['tmp_name'];
              $documentPath = '../uploads/'.$newFile['name'];
              move_uploaded_file($document_tmp_name, $documentPath);
              $res->status_code = 200;
              $res->message = "This record is now successfully updated and send feedback to maker.";
              echo json_encode($res);
            }
            $new_feedback = "$senderName uploaded new file.";
            sendFeedback($maker_id, $_POST['patent_id'], $new_feedback , $receiver, $createdAt, $senderName);
          }else{
             $query = "Update tbl_studies set is_new_uploaded = 1 where id = '".$maker_id."'";
             $executeQuery = mysqli_query($conn, $query);
             $res->status_code = 200;
             $res->message = "This record is now successfully updated and send feedback to maker.";
             echo json_encode($res);
             sendFeedback($maker_id, $_POST['patent_id'], $feedback, $receiver, $createdAt, $senderName);
          }

        }catch(Exception $err){
          $res->status_code = 400;
          $res->message = "Something went wrong on updating record. Please try again.";
          echo json_encode($res);
        }
         
       } else if($api === 'admin_accepted_studies'){
        $query = "Select * from tbl_studies where status = 'Accept'";
        $executeQuery = mysqli_query($conn, $query);

        $rows_array = array();
        while($r = mysqli_fetch_assoc($executeQuery)) {
            $rows_array[] = $r;
        }
        echo json_encode($rows_array);
     } else if($api === 'accepted_studies'){
          $query = "Select * from tbl_studies where status = 'Accept' and technology_type = '".$_POST['technology_type']."'";
          $executeQuery = mysqli_query($conn, $query);

          $rows_array = array();
          while($r = mysqli_fetch_assoc($executeQuery)) {
              $rows_array[] = $r;
          }
          echo json_encode($rows_array);
       } else if($api === 'insert_new_log_submission'){
          $query = "Insert into tbl_log_submission values ('', '".$_POST['application_no']."', '".$_POST['title']."', '".$_POST['creator']."', '".$_POST['ip_type']."', '".$_POST['college']."', '".$_POST['dragon_pay']."', '".$_POST['application_date']."', '".$_POST['agent']."', '".$_POST['drafter']."', '".$_POST['document_where_about']."', '".$_POST['publication_date']."', '".$_POST['publication_vol']."', '".$_POST['publication_no']."', '".$_POST['registration_date']."', '".$_POST['registration_date_vol']."', '".$_POST['registration_date_no']."', '".$_POST['examiner']."', '".$_POST['status']."', '".$_POST['expiration_date']."', '".$_POST['remark_1']."', '".$_POST['remark_2']."', '".$_POST['office_remark']."', '".$_POST['action_step_1']."', '".$_POST['action_step_2']."', '".$_POST['certificate_office']."')";
          $executeQuery = mysqli_query($conn, $query);
          $res = new Response();
          if($executeQuery){
            $updateStudyQuery = "Update tbl_studies set has_log_submission = 1 where title = '".$_POST['title']."'";
             mysqli_query($conn, $updateStudyQuery);
            $res->status_code = 200;
            $res->message = 'New Record Successfully Created.';
         }else{
            $res->status_code = 400;
            $res->message = 'Something went wrong in updating record. Please try again.';
         }
         echo json_encode($res);
       } else if($api === 'get_list_of_log_submission'){
          $query = "Select * from tbl_log_submission";
          $executeQuery = mysqli_query($conn, $query);
          $arrLog = array();

          while($r = mysqli_fetch_assoc($executeQuery)) {
            $arrLog[] = $r;
          }
          echo json_encode($arrLog);
       } else if($api === 'get_data_of_log_submission'){
          $query = "Select * from tbl_log_submission where id = '".$_POST['id']."'";
          $executeQuery = mysqli_query($conn, $query);
          $arrLog = array();

          while($r = mysqli_fetch_assoc($executeQuery)) {
            $arrLog[] = $r;
          }
          echo json_encode($arrLog);
       } else if($api === 'update_log_submission'){
           $res = new Response();
           $query = "Update tbl_log_submission set application_no = '".$_POST['updt_application_no']."', title = '".$_POST['updt_title']."', creator = '".$_POST['updt_creator']."', ip_type = '".$_POST['updt_ip_type']."', college = '".$_POST['updt_college']."', dragon_pay = '".$_POST['updt_dragon_pay']."', application_date = '".$_POST['updt_application_date']."', agent = '".$_POST['updt_agent']."', drafter = '".$_POST['updt_drafter']."', document_where_about = '".$_POST['updt_document_where_about']."', publication_date = '".$_POST['updt_publication_date']."', publication_vol = '".$_POST['updt_publication_vol']."', publication_no = '".$_POST['updt_publication_no']."', registration_date = '".$_POST['updt_registration_date']."', registration_date_vol = '".$_POST['updt_registration_date_vol']."', registration_date_no = '".$_POST['updt_registration_date_no']."', examiner= '".$_POST['updt_examiner']."', status = '".$_POST['updt_status']."', expiration_date = '".$_POST['updt_expiration_date']."', remark_1 = '".$_POST['updt_remark_1']."', remark_2 = '".$_POST['updt_remark_2']."', office_remark = '".$_POST['updt_office_remark']."', action_step_1 = '".$_POST['updt_action_step_1']."', action_step_2 = '".$_POST['updt_action_step_2']."', certificate_office = '".$_POST['updt_certificate_office']."' where id = '".$_POST['updt_id']."'";
           $executeQuery = mysqli_query($conn, $query);
           if($executeQuery){
              $res->status_code = 200;
              $res->message = 'Record Successfully Updated.';
           }else{
              $res->status_code = 400;
              $res->message = 'Something went wrong in updating record. Please try again.';
           }

           echo json_encode($res);
       } else if($api === 'send_feedback'){
          $response = new Response();
          if(declineStudy($_POST['maker_id'], $_POST['patent_id'], $_POST['feedback'], $_POST['userId'], $_POST['createdAt'], $_POST['senderName'])){
            $response->status_code = 200;
            $response->message = "Successfully send a feedback.";
          }else{
            $response->status_code = 400;
            $response->message = "Something went wrong.Please try again.";
          }
          echo json_encode($response);
       } else if($api === 'get_list_of_document_by_id'){
          $query = "Select * from tbl_documents where maker_id = '".$_POST['rowId']."'";
          $executeQuery = mysqli_query($conn, $query);
          $arrDocs = array();

          while($r = mysqli_fetch_assoc($executeQuery)) {
            $arrDocs[] = $r;
          }
          echo json_encode($arrDocs);
       } else if($api === 'updt_formality_result'){
          $senderName = $_POST['senderName'];
          $file = $_FILES['formality_result']['name'];
          $fileName = 'formality_result_'.$_POST['maker_id'].'_'.$file;
          $query = "Insert into tbl_documents values ('', '".$fileName."', '', '', '', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
          $selectQuery = "Select * from tbl_documents where study_id = '".$_POST['maker_id']."'";
          $executeQuery = mysqli_query($conn, $selectQuery);
          if(mysqli_num_rows($executeQuery) > 0){
            $row = mysqli_fetch_assoc($executeQuery);
            $senderFeedback = $row['formality_result'] === $file ? "$senderName uploaded a formality result." : "$senderName uploaded a new formality result.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            if(isset($_POST['rowId'])){
              $updateQuery = "Update tbl_documents set formality_result = '".$fileName."' where id = '".$_POST['rowId']."'";
              saveNewDocument($_FILES['formality_result'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['formality_result'], $fileName);
            }else{
              $updateQuery = "Update tbl_documents set formality_result = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
              saveNewDocument($_FILES['formality_result'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['formality_result'], $fileName);
            }
           
            echo $fileName;
          }else{
            $senderFeedback = "$senderName uploaded a formality result.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            saveNewDocument($_FILES['formality_result'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['formality_result'], $fileName);
          }
       } else if($api === 'updt_acknowledgement_receipt'){
          $senderName = $_POST['senderName'];
          $file = $_FILES['acknowledgement_receipt']['name'];
          $fileName = 'acknowledgement_receipt_'.$_POST['maker_id'].'_'.$file;
          $query = "Insert into tbl_documents values ('', '', '".$fileName."', '', '', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
          $selectQuery = "Select * from tbl_documents where study_id = '".$_POST['maker_id']."'";
          $executeQuery = mysqli_query($conn, $selectQuery);
          if(mysqli_num_rows($executeQuery) > 0){
            $row = mysqli_fetch_assoc($executeQuery);
            $senderFeedback = $row['acknowledgement_receipt'] !== $file ? "$senderName uploaded acknowledgement reciept." : "$senderName uploaded a new acknowledgement reciept.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            if(isset($_POST['rowId'])){
              $updateQuery = "Update tbl_documents set acknowledgement_receipt = '".$fileName."' where id = '".$_POST['rowId']."'";
              saveNewDocument($_FILES['acknowledgement_receipt'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['acknowledgement_receipt'], $fileName);
            }else{
              $updateQuery = "Update tbl_documents set acknowledgement_receipt = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
              saveNewDocument($_FILES['acknowledgement_receipt'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['acknowledgement_receipt'], $fileName);
            }
            echo $fileName;
         }else{
            $senderFeedback = "$senderName uploaded acknowledgement receipt.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            saveNewDocument($_FILES['acknowledgement_receipt'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['acknowledgement_receipt'], $fileName);
         }
      } else if($api === 'updt_notice_of_withdrawal'){
          $senderName = $_POST['senderName'];
          $file = $_FILES['notice_of_withdrawal']['name'];
          $fileName = 'notice_of_withdrawal_'.$_POST['maker_id'].'_'.$file;
          $query = "Insert into tbl_documents values ('', '', '', '".$fileName."', '', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
          $selectQuery = "Select * from tbl_documents where study_id = '".$_POST['maker_id']."'";
          $executeQuery = mysqli_query($conn, $selectQuery);
          if(mysqli_num_rows($executeQuery) > 0){
            $row = mysqli_fetch_assoc($executeQuery);
            $senderFeedback = $row['notice_of_withdrawal'] !== $file ? "$senderName uploaded notice of withdrawal." : "$senderName uploaded a new notice of withdrawal.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            if(isset($_POST['rowId'])){
              $updateQuery = "Update tbl_documents set notice_of_withdrawal = '".$fileName."' where id = '".$_POST['rowId']."'";
              saveNewDocument($_FILES['notice_of_withdrawal'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['notice_of_withdrawal'], $fileName);
            }else{
              $updateQuery = "Update tbl_documents set notice_of_withdrawal = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
              saveNewDocument($_FILES['notice_of_withdrawal'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['notice_of_withdrawal'], $fileName);
            }
            echo $fileName;
         }else{
            $senderFeedback = "$senderName uploaded notice of withdrawal.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            saveNewDocument($_FILES['notice_of_withdrawal'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['notice_of_withdrawal'], $fileName);
         }
      } else if($api === 'updt_notice_of_publication'){
          $senderName = $_POST['senderName'];
          $file = $_FILES['notice_of_publication']['name'];
          $fileName = 'notice_of_publication_'.$_POST['maker_id'].'_'.$file;
          $query = "Insert into tbl_documents values ('', '', '', '', '".$fileName."', '', '', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
          $selectQuery = "Select * from tbl_documents where study_id = '".$_POST['maker_id']."'";
          $executeQuery = mysqli_query($conn, $selectQuery);
          if(mysqli_num_rows($executeQuery) > 0){
            $row = mysqli_fetch_assoc($executeQuery);
            $senderFeedback = $row['notice_of_publication'] !== $file ? "$senderName uploaded notice of publication." : "$senderName uploaded a new notice of publication.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            if(isset($_POST['rowId'])){
              $updateQuery = "Update tbl_documents set notice_of_publication = '".$fileName."' where id = '".$_POST['rowId']."'";
              saveNewDocument($_FILES['notice_of_publication'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['notice_of_publication'], $fileName);
            }else{
              $updateQuery = "Update tbl_documents set notice_of_publication = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
              saveNewDocument($_FILES['notice_of_publication'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['notice_of_publication'], $fileName);
            }
            echo $fileName;
         }else{
            $senderFeedback = "$senderName uploaded notice of publication.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            saveNewDocument($_FILES['notice_of_publication'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['notice_of_publication'], $fileName);
         }
      } else if($api === 'updt_certification'){
          $senderName = $_POST['senderName'];
          $file = $_FILES['certification']['name'];
          $fileName = 'certification_'.$_POST['maker_id'].'_'.$file;
          $query = "Insert into tbl_documents values ('', '', '', '', '', '', '".$fileName."', '', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
          $selectQuery = "Select * from tbl_documents where study_id = '".$_POST['maker_id']."'";
          $executeQuery = mysqli_query($conn, $selectQuery);
          if(mysqli_num_rows($executeQuery) > 0){
            $row = mysqli_fetch_assoc($executeQuery);
            $senderFeedback = $row['certification'] !== $file ? "$senderName uploaded a certification." : "$senderName uploaded a new certification.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            if(isset($_POST['rowId'])){
              $updateQuery = "Update tbl_documents set certification = '".$fileName."' where id = '".$_POST['rowId']."'";
              saveNewDocument($_FILES['certification'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['certification'], $fileName);
            }else{
              $updateQuery = "Update tbl_documents set certification = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
              saveNewDocument($_FILES['certification'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['certification'], $fileName);
            }
            echo $fileName;
         }else{
            $senderFeedback = "$senderName uploaded a certification.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            saveNewDocument($_FILES['certification'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['certification'], $fileName);
         }
      } else if($api === 'updt_log_submission_status'){
          $selectQuery = "Select * from tbl_documents where study_id = '".$_POST['maker_id']."'";
          $executeQuery = mysqli_query($conn, $selectQuery);
          if(mysqli_num_rows($executeQuery) > 0){
            $row = mysqli_fetch_assoc($executeQuery);
            $file = $_FILES['log_submission_status']['name'];
            $fileName = 'log_submission_status_'.$_POST['maker_id'].'_'.$file;
            $updateQuery = "Update tbl_documents set log_submission_status = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
            saveNewDocument($_FILES['log_submission_status'], $_POST['maker_id'], $_POST['patent_id'], '', 'Accept', 'a5ffc5', $updateQuery, $row['log_submission_status'], $fileName);
            echo $fileName;
        }
      } else if($api === 'updt_response'){
          $senderName = $_POST['senderName'];
          $file = $_FILES['response']['name'];
          $fileName = 'response_'.$_POST['maker_id'].'_'.$file;
          $query = "Insert into tbl_documents values ('', '', '', '', '', '', '', '".$fileName."', '', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
          $selectQuery = "Select * from tbl_documents where study_id = '".$_POST['maker_id']."'";
          $executeQuery = mysqli_query($conn, $selectQuery);
          if(mysqli_num_rows($executeQuery) > 0){
            $row = mysqli_fetch_assoc($executeQuery);
            $senderFeedback = $row['response'] !== $file ? "$senderName uploaded a response." : "$senderName uploaded a new response.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            if(isset($_POST['rowId'])){
              $updateQuery = "Update tbl_documents set response = '".$fileName."' where id = '".$_POST['rowId']."'";
              saveNewDocument($_FILES['response'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['response'], $fileName);
            }else{
              $updateQuery = "Update tbl_documents set response = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
              saveNewDocument($_FILES['response'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['response'], $fileName);
            }
        }else{
          $senderFeedback = "$senderName uploaded a response.";
          sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
          saveNewDocument($_FILES['response'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['response'], $fileName);
        }
      } else if($api === 'updt_drafted_documents'){
          $senderName = $_POST['senderName'];
          $file = $_FILES['drafted_documents']['name'];
          $fileName = 'drafted_documents_'.$_POST['maker_id'].'_'.$file;
          $query = "Insert into tbl_documents values ('', '', '', '', '', '', '', '', '".$fileName."', '".$_POST['patent_id']."', '".$_POST['maker_id']."', '".$_POST['maker_id']."')";
          $selectQuery = "Select * from tbl_documents where study_id = '".$_POST['maker_id']."'";
          $executeQuery = mysqli_query($conn, $selectQuery);
          if(mysqli_num_rows($executeQuery) > 0){
            $row = mysqli_fetch_assoc($executeQuery);
            $senderFeedback = $row['drafted_documents'] !== $file ? "$senderName uploaded a drafted document." : "$senderName uploaded a new drafted document.";
            sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
            if(isset($_POST['rowId'])){
              $updateQuery = "Update tbl_documents set drafted_documents = '".$fileName."' where id = '".$_POST['rowId']."'";
              saveNewDocument($_FILES['drafted_documents'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['drafted_documents'], $fileName);
            }else{
              $updateQuery = "Update tbl_documents set drafted_documents = '".$fileName."' where maker_id = '".$_POST['maker_id']."'";
              saveNewDocument($_FILES['drafted_documents'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['drafted_documents'], $fileName);
            }
        }else{
          $senderFeedback = "$senderName uploaded a drafted document.";
          sendFeedback($_POST['maker_id'], $_POST['patent_id'], $senderFeedback, $_POST['maker_id'], $_POST['createdAt'], $senderName);
          saveNewDocument($_FILES['drafted_documents'], $_POST['maker_id'], $_POST['patent_id'], $query, 'Accept', 'a5ffc5', $updateQuery, $row['drafted_documents'], $fileName);
        }
      } else if ($api === 'get_studies_with_no_log_submission'){
         if(isset($_POST['technology_type'])){
            $query1 = "Select authors,title from tbl_studies where technology_type = '".$_POST['technology_type']."' and status = 'Accept' and has_log_submission = 0";
            $executeQuery = mysqli_query($conn, $query1);
            $studies = array();
            while($r = mysqli_fetch_array($executeQuery)){
                $studies[] = $r;
            }
    
            echo json_encode($studies);
         }else{
            // These is for admin side
            $query1 = "Select authors,title from tbl_studies where status = 'Accept' and has_log_submission = 0";
            $executeQuery = mysqli_query($conn, $query1);
            $studies = array();
            while($r = mysqli_fetch_array($executeQuery)){
                $studies[] = $r;
            }
    
            echo json_encode($studies);
         }
       
      } else if($api === 'get_author_of_study'){
         $query = "Select * from tbl_accounts where email = '".$_POST['email']."'";
         $executeQuery = mysqli_query($conn, $query);
         $details = mysqli_fetch_assoc($executeQuery);

         echo $details['name'];
      } else if($api === 'reply_to_feedback'){
         replyToComment($_POST['studyId'], $_POST['sender'], $_POST['feedback'], $_POST['receiver'], $_POST['createdAt'], $_POST['senderName'], $_POST['sender']);
      }
      else if($api === 'get_photos'){
        $query = "Select * from tbl_photos where studyId = '".$_POST['studyId']."'";
        $executeQuery = mysqli_query($conn, $query);
        $photos = array();
        while($r = mysqli_fetch_array($executeQuery)){
          $photos[] = $r;
        }
        echo json_encode($photos);
      }
    }else{
      return;
    }
?>