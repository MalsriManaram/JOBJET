<?php
session_start();

?>
<html>
    <head> 
       
    </head>
    <body>
        <nav class="navbar navbar-expand-lg fixed-top" id="navbar01" >
        <div class="container-fluid" >

            <a class=" me-auto" id="icon" href="index.php">
                <img src="/JOBJET/IMAGERS/JOBJET.png" alt="JOBJET" width="77.3333px" height="37.3333px"> 
            </a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="/JOBJET/IMAGERS/JOBJET02.png" alt="JOBJET" width="116px" height="56px"></h5>
                <button type="button" class="btn-close" id="close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            
            <div class="offcanvas-body">
                
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" >
                    <li class="nav-item" >
                        <a class="nav-link mx-lg-2 action" aria-current="page" id="home"  href="index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link mx-lg-2"  href="">Jobs</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link mx-lg-2"  href="">Top Employers</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link mx-lg-2"  href="">Find People</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="">Contact Us</a>
                    </li>              
                </ul>
            </div>
            </div>
                <?php if(isset($_SESSION['id'])){?>
                    <?php if(isset($_SESSION['pro_img'])> 0){?>

                            <div ><img class="nav-pro_img" src="/JOBJET/UPLOADED_IMG/<?=$_SESSION['pro_img']?> " width="40" height= "40" alt="Profile Image" onclick="toggleMenu()"></div>
                            <div class="sub-manu-wrap" id="subMenu">
                                <div class="sub-menu">
                                    <div class="user-info">

                                    
                                        <img class="popup_img" src="/JOBJET/UPLOADED_IMG/<?=$_SESSION['pro_img']?>"  alt="Profile Image" >
                                        <p><?= $_SESSION['first_name']?> <?= $_SESSION['last_name']?></p>
                                        <p1><?= $_SESSION['nick_name']?></p1>
                                        <p2><?= $_SESSION['email']?></p2>
                                        <a href="profile.php" class="view-pro-button">View Profile</a>
                                        <a href="logout.php" class="login-button02"><img src="/JOBJET/IMAGERS/logout.png" width="15" height= "15" > Logout</a>
                                        


                                    </div>
                                </div>
                            </div> 
                        <?php }else{?> 

                                <div ><img class="nav-pro_img" src="/JOBJET/UPLOADED_IMG/profile.png" width="40" height= "40" alt="Profile Image" onclick="toggleMenu()"></div>
                                    <div class="sub-manu-wrap" id="subMenu">
                                        <div class="sub-menu">
                                            <div class="user-info">

                                                <img class="popup_img" src="/JOBJET/UPLOADED_IMG/profile.png"   alt="Profile Image" >
                                                <p><?= $_SESSION['first_name'] ?> <?= $_SESSION['last_name']?></p>
                                                <p1><?= $_SESSION['nick_name']?></p1>
                                                <p2><?= $_SESSION['email']?></p2>
                                                <a href="profile.php" class="view-pro-button">View Profile</a>
                                                <a href="logout.php" class="login-button02"><img src="/JOBJET/IMAGERS/logout.png" width="15" height= "15" > Logout</a>

                                                
                                                
                                        </div>
                                    </div>
                                </div>   

                        <?php }?>

                <?php } else{?>

                    <a href="login.php" class="login-button">Login</a>
                   
                    
                <?php }?>
                <button class="navbar-toggler" id="navbar-toggler01" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="#offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" id= "icon"></span>
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