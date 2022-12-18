<?php
    include './connection.php';
    include './response.php';
    
    global $conn;

    function updateProfile($userId, $age, $contact, $gender, $connection){
        $query = "Update tbl_profiles set age = '".$age."', contact_no = '".$contact."', gender = '".$gender."' where userId = '".$userId."'";
        mysqli_query($connection, $query);
    }

    if(isset($_POST['api'])){
        $api = $_POST['api'];
        if($api === 'get_account_info'){
           $query = "Select * from tbl_profiles where userId = '".$_POST['userId']."'";
           $executeQuery = mysqli_query($conn, $query);
           $arrayData = array();
           
           if(mysqli_num_rows($executeQuery) > 0){
                $getAccountQuery = "Select studentId,name,usertype,email,technology_type, tbl_profiles.* from tbl_profiles INNER JOIN tbl_accounts ON tbl_profiles.userId = tbl_accounts.id where tbl_accounts.id = '".$_POST['userId']."'";
                $executeGetAccountQuery = mysqli_query($conn, $getAccountQuery);
                while($row = mysqli_fetch_assoc($executeGetAccountQuery)){
                    $arrayData[] = $row;
                }
                echo json_encode($arrayData);
           }else{
              $getAccountQuery = "Select id,studentId,email,name,usertype,technology_type from tbl_accounts where id = '".$_POST['userId']."'";
              $executeGetAccountQuery = mysqli_query($conn, $getAccountQuery);
              $newArray = array();
              while($row = mysqli_fetch_assoc($executeGetAccountQuery)){
                $newArray[] = $row;
              }
              echo json_encode($newArray);
           }
           
        } else if($api === 'update_profile'){
           $queryHasProfile = "Select * from tbl_profiles where userId = '".$_POST['userId']."'";
           $executeQueryHasProfile = mysqli_query($conn, $queryHasProfile);
           $res = new Response();
           if(mysqli_num_rows($executeQueryHasProfile) > 0){
                if(isset($_POST['password'])){
                    $getPasswordOfUser = "Select * from tbl_accounts where id = '".$_POST['userId']."'";
                    $executeQuery = mysqli_query($conn, $getPasswordOfUser);
                    while($row = mysqli_fetch_assoc($executeQuery)){
                        if($row['password'] === sha1($_POST['password'])){
                            $res->status_code = 401;
                            $res->message = 'You have entered an older password.';
                            echo json_encode($res);
                        }else{
                            $query = "Update tbl_accounts set studentId = '".$_POST['studentId']."',  email = '".$_POST['email']."', name = '".$_POST['name']."', password = '".sha1($_POST['password'])."' where id = '".$_POST['userId']."'";
                            mysqli_query($conn, $query);
                            $res->status_code = 200;
                            $res->message = 'Account Succesfully Updated.';
                            echo json_encode($res);
                        }
                    }   
            }else if(isset($_FILES['profile'])){
                    $file = $_FILES['profile']['name'];
                    $file_tmp_name = $_FILES['profile']['tmp_name'];
                    $file_ex = pathinfo($file, PATHINFO_EXTENSION);
                    $file_ex_loc = strtolower($file_ex);
                    $filepath = '../profiles/'.$_FILES['profile']['name'];
                    move_uploaded_file($file_tmp_name, $filepath);
                    $query = "Update tbl_accounts set studentId = '".$_POST['studentId']."', email = '".$_POST['email']."', name = '".$_POST['name']."' where id = '".$_POST['userId']."'";
                    $executeQuery = mysqli_query($conn, $query);
                    if($executeQuery){
                        $res->status_code = 200;
                        $res->message = 'Account Succesfully Updated.';
                        $updateQueryProfile = "Update tbl_profiles set profile = '".$_FILES['profile']['name']."' where userId = '".$_POST['userId']."'";
                        mysqli_query($conn, $updateQueryProfile);
                        echo json_encode($res);
                    }else{
                        $res->status_code = 400;
                        $res->message = 'Something went wrong on updating account. Please try again.';
                        echo json_encode($res);
                    }
            }else{
                $query = "Update tbl_accounts set studentId = '".$_POST['studentId']."',  email = '".$_POST['email']."', name = '".$_POST['name']."' where id = '".$_POST['userId']."'";
                $executeQuery = mysqli_query($conn, $query);
                if($executeQuery){
                    $res->status_code = 200;
                    $res->message = 'Account Succesfully Updated.';
                    echo json_encode($res);
                }else{
                    $res->status_code = 400;
                    $res->message = 'Something went wrong on updating account. Please try again.';
                    echo json_encode($res);
                }
            }
             updateProfile($_POST['userId'], $_POST['age'], $_POST['contact_no'], $_POST['gender'], $conn);
            } else{
                if(isset($_FILES['profile'])){
                    $file = $_FILES['profile']['name'];
                    $file_tmp_name = $_FILES['profile']['tmp_name'];
                    $file_ex = pathinfo($file, PATHINFO_EXTENSION);
                    $file_ex_loc = strtolower($file_ex);
                    $filepath = '../profiles/'.$_FILES['profile']['name'];
                    move_uploaded_file($file_tmp_name, $filepath);
                    $insertQueryProfile = "Insert into tbl_profiles values ('', '".$_FILES['profile']['name']."', '".$_POST['age']."', '".$_POST['contact_no']."', '".$_POST['gender']."', '', '".$_POST['userId']."')";
                    mysqli_query($conn, $insertQueryProfile);
                    $query = "Update tbl_accounts set studentId = '".$_POST['studentId']."',  email = '".$_POST['email']."', name = '".$_POST['name']."', password = '".sha1($_POST['password'])."' where id = '".$_POST['userId']."'";
                    mysqli_query($conn, $query);
                    $res->status_code = 200;
                    $res->message = 'Account Succesfully Updated.';
                    echo json_encode($res);
                }else{
                    $insertQueryProfile = "Insert into tbl_profiles values ('', '', '".$_POST['age']."', '".$_POST['contact_no']."', '".$_POST['gender']."', '', '".$_POST['userId']."')";
                    mysqli_query($conn, $insertQueryProfile);
                    $query = "Update tbl_accounts set studentId = '".$_POST['studentId']."',  email = '".$_POST['email']."', name = '".$_POST['name']."', password = '".sha1($_POST['password'])."' where id = '".$_POST['userId']."'";
                    mysqli_query($conn, $query);
                    $res->status_code = 200;
                    $res->message = 'Account Succesfully Updated.';
                    echo json_encode($res);
                }
            }
        }
    }else{
        return;
    }
?>