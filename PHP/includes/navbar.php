<?php
session_start();
include 'config.php';
$current_page = basename($_SERVER['PHP_SELF']);

// To remove the navbar from view_resume.php
if ($current_page === 'view_resume.php') {
    return;
}

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $check_user = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$id'");
    mysqli_num_rows($check_user);

    $select_profile = mysqli_query($conn, "SELECT * FROM `profile` WHERE `p_id` = '$id'");
    $select_workinfo = mysqli_query($conn, "SELECT * FROM `workinfo` WHERE `w_id` = '$id'");

    if (mysqli_num_rows($select_profile) == 0 && mysqli_num_rows($select_workinfo) == 0) {
        mysqli_query($conn, "INSERT INTO `profile` (p_id, birth_day, gender) VALUES ('$id','0000-00-00','None')");
        mysqli_query($conn, "INSERT INTO `workinfo` (w_id) VALUES ('$id')");
    }

    if ($conn && isset($_SESSION['id'])) {
        $pro_id = $_SESSION['id'];
        $query = "SELECT * FROM profile WHERE p_id = $id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['nick_name'] = !empty($row['nick_name']) ? $row['nick_name'] : '@NickName';
            $_SESSION['full_name'] = !empty($row['full_name']) ? $row['full_name'] : ($_SESSION['first_name'] ?? '').' '.($_SESSION['last_name'] ?? '');
            $_SESSION['pro_email'] = !empty($row['pro_email']) ? $row['pro_email'] : $_SESSION['email'];
        }
    }
}

?>
<html>
    <head> 
       
    </head>
    <body>
        
        <nav class="navbar navbar-expand-lg fixed-top" id="navbar01" >
        <div class="container-fluid" >

            <a class=" me-auto" id="icon" href="home.php" >
                <img src="/JOBJET/IMAGERS/JOBJET_LOGO.png" alt="JOBJET" width="60px" height="53px"> 
            </a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="/JOBJET/IMAGERS/JOBJET02.png"  alt="JOBJET" width="116px" height="56px" ></h5>
                <button type="button" class="btn-close" id="close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            
            <div class="offcanvas-body">
                
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" >
                    <li class="nav-item" >
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'home.php') ? ' active' : ''; ?>"   href="home.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'jobs.php') ? ' active' : ''; ?>" href="jobs.php">Jobs</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'top_employers.php') ? ' active' : ''; ?>" href="top_employers.php">Top Employers</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'find_people.php') ? ' active' : ''; ?>"  href="find_people.php">Find People</a>
                    </li>
                  
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'cv_genarator.php') ? ' active' : ''; ?>"  href="cv_genarator.php">CV Generator</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'aboutus.php') ? ' active' : ''; ?>"  href="aboutus.php">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'contactus.php') ? ' active' : ''; ?>"  href="contactus.php">Contact Us</a>
                    </li>              
                </ul>
            </div>
            </div>
                <?php if (isset($_SESSION['id'])) { ?>
                    <?php if (isset($_SESSION['pro_img']) && !empty($_SESSION['pro_img'])) { ?>
                        <div>
                            <img class="nav-pro_img" src="/JOBJET/UPLOADED_IMG/<?php echo $_SESSION['pro_img']; ?>" width="40" height="40" alt="Profile Image" onclick="toggleMenu()">
                            
                        </div>
                    <?php } else { ?>
                        <div>
                            <img class="nav-pro_img" src="/JOBJET/UPLOADED_IMG/profile.png" width="40" height="40" alt="Profile Image" onclick="toggleMenu()">
                        </div>
                    <?php } ?>

                    <!-- Dropdown Menu -->
                    <div class="sub-manu-wrap" id="subMenu">
                        <div class="sub-menu">
                            <div class="user-info">
                                <img class="popup_img" src="/JOBJET/UPLOADED_IMG/<?php echo $_SESSION['pro_img'] ?? 'profile.png'; ?>" alt="Profile Image">
                                <p><?php echo $_SESSION['full_name'] ?? ''; ?></p>
                                <p1><?php echo $_SESSION['nick_name'] ?? ''; ?></p1><br>
                                <p2><?php echo $_SESSION['pro_email'] ?? ''; ?></p2><br>
                                <a href="profile.php" class="view-pro-button">View Profile</a>
                                <a href="logout.php" class="login-button02"><img class="login-button02_img" src="/JOBJET/IMAGERS/logout.png" width="15" height="15"> Logout</a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <!-- Show Login Button if User is Not Logged In -->
                    <a href="login.php" class="login-button">Login</a>
                <?php } ?>

                <button class="navbar-toggler" id="navbar-toggler01" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" id="icon2"></span>
                </button>
            </div>
        </nav>

        
        <script>
            let subMenu = document.getElementById("subMenu");

            function toggleMenu() {
                subMenu.classList.toggle("open-menu");
            }
        </script>
            
       
    </body>
</html>
 