<div class="navbar_wrapper">
    <i class="fa fa-bars" id="burger"></i>
    <div class="logo">
        <img src="" alt="logo" id="logo">
        <h1 class="title">SLSU-KTTO DOCUMENT MANAGEMENT SYSTEM</h1>
    </div>
    <nav>
        <ul class="menus">
            <li class="menu" id="dashboard">Dashboard</li>
            <li class="menu" id="log">Log Submission</li>
             <?php
                $user = $_SESSION['usertype'];
                $output = '<li class="menu" id="submission">View Submission</li>
                <li class="menu" id="studies">Accepted Studies</li>
                ';
                $output2 = '<li class="menu relative" id="documents">
                    View Documents
                    <span id="notification_counter">5</span>
                </li>
                <li class="menu" id="studies">View Studies</li>
                ';
                
                if(isset($user) && $user === 'patent drafter' || $user === 'admin'){
                    echo $output;
                }else{
                    echo $output2;
                }

             ?>
            <!-- <li id="chat_menu">
                <i class="fa fa-comments"></i>
            </li> -->
            <div class="settings_wrapper">
                <i class="fa fa-caret-down" id="caret_down"></i>
                <div class="settings">
                    <div class="settings_menu" id="profile">
                        <i class="fa fa-user"></i>
                        <span>Profile</span>
                    </div>
                    <div class="settings_menu" id="signout">
                        <i class="fa fa-sign-out"></i>
                        <span>Sign out</span>
                    </div>
                </div>
            </div>
        </ul>
    </nav>
</div>