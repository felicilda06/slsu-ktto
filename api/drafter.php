<?php
    include '../api/connection.php';
    include '../api/utils.php';
    global $conn;

    $api = $_POST['api'];

    if(isset($api)){
      if($api === 'get_list_of_studies'){
        $technology_type = $_POST['technology_type'];
        $query = "Select * from tbl_studies where technology_type = '".$technology_type."'";
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
         saveNewDocument($_FILES['formality'], $_POST['maker_id'], $_POST['patent_id'], $query, $_POST['status'], $_POST['color']);
      }
    }else{return;}
?>