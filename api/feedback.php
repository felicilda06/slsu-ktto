<?php
    include '../api/connection.php';

    function newFeedback($maker_id, $patent_id, $feedback){
        global $conn;
        $query = "Insert into tbl_comments values ('', '".$feedback."', '".$maker_id."', '".$patent_id."')";
        $executeQuery = mysqli_query($conn, $query);
        if($executeQuery){
            echo 1;
        }else{
            echo 0;
        }
    }
?>