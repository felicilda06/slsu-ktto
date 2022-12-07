<?php
   include './connection.php';
   global $conn;

   $api = $_POST['api'];

   if($api){
     if($api === 'get_studies_by_patent_Id'){
        $query = "Select * from tbl_studies where technology_type = '".$_POST['technology_type']."' and status != 'Pending'";
        $executeQuery = mysqli_query($conn, $query);
        $studies = array();
        while($row = mysqli_fetch_assoc($executeQuery)){
           $studies[] = $row;
        }

        echo json_encode($studies);
     } else if($api === 'get_feedback_by_study_id'){
        $query = "Select tbl_comments.*, usertype from tbl_accounts INNER JOIN tbl_comments ON tbl_comments.sender = tbl_accounts.id where tbl_comments.maker_id = '".$_POST['studyId']."'";
        $executeQuery = mysqli_query($conn, $query);
        $feedbacks = array();
        while($row = mysqli_fetch_assoc($executeQuery)){
           $feedbacks[] = $row;
        }

        echo json_encode($feedbacks);
     }
   }else{return;}
?>