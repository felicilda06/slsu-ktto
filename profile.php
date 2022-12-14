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
    <div class="loader">
      <img src="./assets/images/loader1.gif" class="img-loader">
    </div>
    <header>
      <?php
        include './navbar.php';
      ?>
    </header>
    <div class="profile_container">
        <h4 class="text-primary">Profile</h4>
        <div class="account_information">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="text-primary"><i class="fa fa-cogs"></i> Account Information</h5>
            </div>
            <div class="input_wrapper w-100">
                 <div class="input_1 w-100">
                    <input type="text" class="form-control my-3" placeholder="Employee Id/Student Id">
                    <input type="text" class="form-control my-3 bg-white" placeholder="Type of User" disabled>
                    <input type="text" class="form-control my-3 bg-white" placeholder="Type of Technology" disabled>
                 </div>
                <div class="input_2 w-100">
                    <input type="email" class="form-control my-3" placeholder="Email address">
                    <input type="password" class="form-control my-3" placeholder="Password">
                </div>
            </div>
        </div>
        <div class="personal_information">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="text-primary"><i class="fa fa-user-md"></i> Personal Information</h5>
            </div>
            <div id="upload_profile">
              <img src="./assets/images/profile.jpg" id="user_profile">
              <i class="fa fa-camera text-primary"></i>
            </div>
            <div class="input_1">
              <input type="text" class="form-control" id="" placeholder="Name">
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