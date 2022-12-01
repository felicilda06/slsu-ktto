<?php
    include '../api/connection.php';
    global $conn;

    $api = $_POST['api'];

    if($api){
      if($api === 'getTotalCountDrafters'){
        $query = "Select * from tbl_accounts where usertype = '".$_POST['userType']."'";
        $executeQuery = mysqli_query($conn, $query);
        $array = array();
        while($row = mysqli_fetch_array($executeQuery)){
           $array[] = $row;
        }

        echo json_encode($array);
      } else if($api === 'getTotatCountStudiesByStatus'){
        $query = "Select * from tbl_log_submission where status = '".$_POST['status']."'";
        $executeQuery = mysqli_query($conn, $query);
        $array = array();
        while($row = mysqli_fetch_array($executeQuery)){
           $array[] = $row;
        }

        echo json_encode($array);

      }
    }else{return;}
?>