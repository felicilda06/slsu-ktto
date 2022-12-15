<!DOCTYPE html>

<head>
<?php
      include './dependencies.php';
      session_start();
      
      global $user;
      $user = $_SESSION['usertype'];

      if(empty($user)){
          header('Location: ../sign-in.php');
          return;
      }
    ?> 

    <link rel="icon" href="./assets/images/logo.png" type="image/icon type">

    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/loader.css">
    <link rel="stylesheet" href="./assets/css/message.css">
    <link rel="stylesheet" href="./assets/css/navbar.css">
    <link rel="stylesheet" href="./assets/css/profile.css">

    <title>SLSU-KTTO Document Management System</title>
</head>

<body>
    <div class="" id="message-container"></div>
    <input type="text" value="<?php echo $user;?>" class="d-none" id="profile_user_type">
    <input type="text" value="<?php echo $_SESSION['user_id']?>" class="d-none" id="user_id">
    <div class="loader">
      <img src="./assets/images/loader1.gif" class="img-loader">
    </div>
    <header>
      <?php
        include './navbar.php';
      ?>
    </header>
    <div class="profile_container">
        <h4 class="text-primary" style="text-transform: uppercase; font-weight: 600; letter-spacing: 1px;">Profile</h4>
        <div class="account_information">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="text-primary"><i class="fa fa-cogs"></i> Account Information</h5>
            </div>
            <div class="input_wrapper w-100">
                 <div class="input_1 w-100">
                    <input type="text" class="form-control my-3" placeholder="Employee Id/Student Id" id="studentId">
                    <input type="text" class="form-control my-3 bg-white" placeholder="Type of User" disabled id="usertype">
                    <input type="text" class="form-control my-3 bg-white" placeholder="Type of Technology" disabled id="technology_type">
                 </div>
                <div class="input_2 w-100">
                    <input type="email" class="form-control my-3" placeholder="Email address" id="email">
                    <input type="password" class="form-control my-3" placeholder="Password" id="password">
                </div>
            </div>
        </div>
        <div class="personal_information">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="text-primary"><i class="fa fa-user-md"></i> Personal Information</h5>
            </div>
         <div class="main_wrapper d-flex justify-content-between">
            <div class="wrapper_1 d-flex pr-4 mr-2">
              <div id="upload_profile">
                <img src="./assets/images/profile.jpg" id="user_profile">
                <input type="file" class="d-none" id="profile">
                <i title="Update Profile Picture" class="fa fa-camera text-primary" id="btn_upload_image"></i>
              </div>
              <div class="input_1 w-100">
                <input type="text" class="form-control ml-3 mr-2 my-2" id="" placeholder="Individual's name" id="name">
                <input type="number" class="form-control ml-3 mr-2 my-2" id="" placeholder="Age" id="age">
              </div>
            </div>
            <div class="wrapper_2 w-100">
                 <select id="gender" class="form-control my-2">
                   <option value="">Gender</option>
                   <option value="male">Male</option>
                   <option value="female">Female</option>
                   <option value="others">Others</option>
                 </select>
                <input type="text" class="form-control my-2" id="contact_no" placeholder="Contact No.">
            </div>
         </div>

        </div>
        <button class="btn btn-primary btn-sm mt-3" style="float: right;">Save Changes</button>
    </div>
    <footer></footer>

    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/navbar.js"></script>
    <script src="./assets/js/profile.js"></script>
</body>

</html>