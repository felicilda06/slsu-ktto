<?php
    include './connection.php';
    global $conn;

    if(isset($_POST['api'])){
        $api = $_POST['api'];

        if($api === 'get_account_info'){
           $query = "Select * from tbl_profiles where userId = '".$_POST['userId']."'";
           $executeQuery = mysqli_query($conn, $query);
           $arrayData = array();
           
           if(mysqli_num_rows($executeQuery) > 0){
                $getAccountQuery = "Select studentId,email,name,usertype,technology_type from tbl_accounts INNER JOIN tbl_profiles ON tbl_accounts.id = tbl_profiles.userId where tbl_profiles.userId = '".$_POST['userId']."'";
                $executeGetAccountQuery = mysqli_query($conn, $getAccountQuery);
                while($row = mysqli_fetch_assoc($executeGetAccountQuery)){
                $arrayData[] = $row;
                }
           }else{
              $getAccountQuery = "Select id,studentId,email,name,usertype,technology_type from tbl_accounts where id = '".$_POST['userId']."'";
              $executeGetAccountQuery = mysqli_query($conn, $getAccountQuery);
              while($row = mysqli_fetch_assoc($executeGetAccountQuery)){
                $arrayData[] = $row;
              }
           }
           echo json_encode($arrayData);
        }
    }else{
        return;
    }
?>