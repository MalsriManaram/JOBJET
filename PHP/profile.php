<?php 

    $page_title= "My Profile";
    include('includes/header.php'); 
    include ('config.php');
    include ('includes/footer.php');
    include('includes/navbar.php'); 


    if (isset($_POST['submit'])){

        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $Email = mysqli_real_escape_string($conn, $_POST['Email']);
        


    }



?>

<!DOCTYPE html>
<html lang="zxx">
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="Login Form">

       
        
        <link rel="stylesheet" href="/JOBJET/CSS/profile.css" type="text/css" media="all" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        

    </head>
    <body>
        <div class="card">
                
                <h3>User Profile </h3><hr class="hr1">
                
                <div><img class="pro_img" src="/JOBJET/UPLOADED_IMG/profile.png"  alt="Profile Image" ></div>
                
                <div class="For-name">
                    <h2>Full Name<h2>
                    <span>@NickName</span>
                </div>

                <hr class="hr2">

                <div class="For-infor">
                    <h6>BASIC INFORMATION</h6>
                    <p><img src="/JOBJET/IMAGERS/from.png" alt="">Form<p1>sadasdas assdasdasd <br> asdasdas asdasdasd</p1></p>
                    <p><img src="/JOBJET/IMAGERS/bdy.png" alt="">Birthday<p2>xx/xx/xxxx</p2></p>
                    <p><img src="/JOBJET/IMAGERS/gender.png" alt="">Gender<p3>None</p3></p>
                </div>
                
                <div class="contact">
                    <hr class="hr3">
                    <div class="For-infor">
                        <h6>CONTACT INFORMATION</h6>
                        <p><img src="/JOBJET/IMAGERS/call.png" alt="">Phone Number<p4>None</p4></p>
                        <p><img src="/JOBJET/IMAGERS/email.png" alt="">Email<p5>None</p5></p>
                        <p><img src="/JOBJET/IMAGERS/site.png" alt="">Site<p6>None</p6></p>
                    </div>
                </div>

                <div class="skills">
                    <hr class="hr4">
                    <div class="For-infor">
                        <h6>SKILLS</h6>
                        <p7>• None</p7>
                    </div>
                </div>
        </div>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

     <script src="/JOBJET/JavaScript/jquery.min.js"></script>

    </body>
</html>

<?php include('includes/footer.php'); ?>