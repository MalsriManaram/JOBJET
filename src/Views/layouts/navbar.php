<?php
include SRC.'Controllers/NavbarController.php';
?>

<link href="<?php echo BASE_URL; ?>assets/css/navbar.css" rel="stylesheet" type="text/css" media="all" />
<nav class="navbar navbar-expand-lg fixed-top" id="navbar01">
    <div class="container-fluid">
        <a class="me-auto" id="icon" href="<?php echo BASE_URL; ?>home">
            <img src="<?php echo BASE_URL; ?>assets/images/website-images/JOBJET_LOGO.png" alt="JOBJET" width="60px" height="53px">
        </a>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="<?php echo BASE_URL; ?>assets/images/website-images/JOBJET02.png" alt="JOBJET" width="116px" height="56px"></h5>
                <button type="button" class="btn-close" id="close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'home') ? ' active' : ''; ?>" href="<?php echo BASE_URL; ?>home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'jobs') ? ' active' : ''; ?>" href="<?php echo BASE_URL; ?>jobs">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'top_employers') ? ' active' : ''; ?>" href="<?php echo BASE_URL; ?>top_employers">Top Employers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'find_people') ? ' active' : ''; ?>" href="<?php echo BASE_URL; ?>find_people">Find People</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'cv_genarator') ? ' active' : ''; ?>" href="<?php echo BASE_URL; ?>cv_genarator">CV Generator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'aboutus') ? ' active' : ''; ?>" href="<?php echo BASE_URL; ?>aboutus">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2<?php echo ($current_page == 'contactus') ? ' active' : ''; ?>" href="<?php echo BASE_URL; ?>contactus">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
        <?php if ($loggedIn) { ?>
            <div>
                <img class="nav-pro_img" src="<?php echo BASE_URL; ?><?php echo $profileImage; ?>" width="40" height="40" alt="Profile Image" onclick="toggleMenu()">
            </div>
            <!-- Dropdown Menu -->
            <div class="sub-manu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img class="popup_img" src="<?php echo $profileImage; ?>" alt="Profile Image">
                        <p><?php echo $fullName; ?></p>
                        <p1><?php echo $nickName; ?></p1><br>
                        <p2><?php echo $proEmail; ?></p2><br>
                        <a href="<?php echo BASE_URL; ?>profile/my_profile" class="view-pro-button">View Profile</a>
                        <a href="<?php echo BASE_URL; ?>auth/LogoutController" class="login-button02"><img class="login-button02_img" src="<?php echo BASE_URL; ?>assets/images/website-images/logout.png" width="15" height="15"> Logout</a>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <!-- Show Login Button if User is Not Logged In -->
            <a href="<?php echo BASE_URL; ?>auth/login" class="login-button">Login</a>
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