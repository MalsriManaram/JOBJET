<?php 

$page_title= "My Profile";
include('includes/header.php'); 
include ('config.php');
include ('includes/footer.php');
include('includes/navbar.php'); 

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    
    $query0 = "SELECT * FROM users WHERE id = $id";
    $result0 = mysqli_query($conn, $query0);
    $row0 = mysqli_fetch_assoc($result0);
    if (!empty($row0['pro_img'])) {
        $_SESSION['pro_img'] = $row0['pro_img'];
    } else {
        $_SESSION['pro_img'] = 'profile.png'; 
    }

    $query = "SELECT * FROM profile WHERE p_id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
        $_SESSION['full_name'] = !empty($row['full_name']) ? $row['full_name'] : 'Full Name';
        $_SESSION['nick_name'] = !empty($row['nick_name']) ? $row['nick_name'] : '@NickName';
        $_SESSION['address'] = !empty($row['address']) ? $row['address'] : 'None';
        $_SESSION['birth_day'] = !empty($row['birth_day']) ? $row['birth_day'] : 'xx/xx/xxxx';
        $_SESSION['gender'] = !empty($row['gender']) ? $row['gender'] : 'None';
        $_SESSION['phone_no'] = !empty($row['phone_no']) ? $row['phone_no'] : 'None';
        $_SESSION['site'] = !empty($row['site']) ? $row['site'] : 'None';
        $_SESSION['pro_email'] = !empty($row['pro_email']) ? $row['pro_email'] : 'None';


    $query2 = "SELECT * FROM workinfo WHERE w_id = $id";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_assoc($result2);
        $_SESSION['skills'] = !empty($row2['skills']) ? $row2['skills'] : '• None';
        $_SESSION['filed'] = !empty($row2['filed']) ? $row2['filed'] : 'None';
        $_SESSION['filed2'] = !empty($row2['filed2']) ? $row2['filed2'] : 'None';


        $query3 = "SELECT * FROM workexp WHERE work_id = $id";
        $result3 = mysqli_query($conn, $query3);
    
        // Initialize an empty array to store the results
        $workexp_data = array();
    
        // Fetch each row and store it in the $workexp_data array
        while ($row3 = mysqli_fetch_assoc($result3)) {
            $workexp_data[] = $row3;
        }
}


?>

<!DOCTYPE html>
<html lang="zxx">
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="profile">
        
        <link rel="stylesheet" href="/JOBJET/CSS/profile1.css" type="text/css" media="all" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        

    </head>
    <body>
    <?php if(isset($_SESSION['id'])): ?>
        
        <div class="card">
                <h3>User Profile </h3><hr class="hr1">
                    
                        <div><img class="pro_img" src="/JOBJET/UPLOADED_IMG/<?=$_SESSION['pro_img']?>"  alt="Profile Image" ></div>
                    
                
                    
                <div class="all">
                <a href="edit.php" class="edit-button">Edit</a>
                <div class="For-name">
                    <h2><?=$_SESSION['full_name']?><h2>
                    <span><?=$_SESSION['nick_name']?></span>
                    <hr class="hr2">
                </div>
                    
                
                
                <div class="For-infor" id="basic">
                    <h6>BASIC INFORMATION</h6>
                    <div class="para7"><p><img src="/JOBJET/IMAGERS/from.png" alt="">Form<p1><?=$_SESSION['address']?></p1></p>
                    <p><img src="/JOBJET/IMAGERS/bdy.png" alt="">Birthday<p2><?=$_SESSION['birth_day']?></p2></p>
                    <p><img src="/JOBJET/IMAGERS/gender.png" alt="">Gender<p3><?=$_SESSION['gender']?></p3></p></div>
                </div>
                </div>
                <div class="contact">
                    <hr class="hr3">
                    <div class="For-infor">
                        <h6>CONTACT INFORMATION</h6>
                        <p><img src="/JOBJET/IMAGERS/call.png" alt="">Phone Number<p4><?=$_SESSION['phone_no']?></p4></p>
                        <p><img src="/JOBJET/IMAGERS/email.png" alt="">Email<p5><?=$_SESSION['pro_email']?></p5></p>
                        <p><img src="/JOBJET/IMAGERS/site.png" alt="">Site<p6><?=$_SESSION['site']?></p6></p>
                    </div>
                </div>

                <div class="skills">
                    <hr class="hr4">
                    <div class="For-infor">
                        <h6>SKILLS</h6>
                        <div class="para7"><p7><?=$_SESSION['skills']?></p7></div>
                    </div>
                </div>

                <div class="work">
                <hr class="hr5">
                <div class="For-infor">
                    <h6>WORK EXPERIENCES</h6>
                    <?php
                    // Check if $workexp_data is set and not empty
                    if(isset($workexp_data) && !empty($workexp_data)) {
                        // Loop through each work experience
                        foreach($workexp_data as $workexp) {
                    ?>
                            <div class="para9"><p8><?= $workexp['position'] ?></p8>
                            <p9><?= $workexp['company_name'] .' | '. $workexp['time_period'] ?></p9></div><br><br>
                    <?php
                        }
                    } else {

                    ?>
                       <p>None</p> 
                    <?php
                    }
                    ?>
                </div>
            </div>
        
            
            <hr class="hr6">
                <div class="filed">
                   
                    <div class="For-infor"> 
                        <h6>INTERESTED CAREER FIELDS</h6>
                        <p><img src="/JOBJET/IMAGERS/filed.png" alt="">Filed 01<p1><?=$_SESSION['filed']?></p1></p>
                        <p><img src="/JOBJET/IMAGERS/filed.png" alt="">Filed 02<p1><?=$_SESSION['filed2']?></p1></p>
                    </div>
                </div>
                <a href="" class="view-button" onclick="windowOpen()">View Resume</a>
                <?php endif; ?>
                
        </div>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

     <script src="/JOBJET/JavaScript/jquery.min.js"></script>
     <script>
        function windowOpen() {

            var screenWidth = window.screen.width;
            var screenHeight = window.screen.height;

            var windowWidth = 650; // Width of the new window
            var windowHeight = 690; // Height of the new window

            var left = (screenWidth - windowWidth) / 2;
            var top = (screenHeight - windowHeight) / 2;

   
            window.open("/JOBJET/PHP/view_resume.php", "blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + left + ", top=" + top);
        }
    </script>

    </body>
</html>

<?php include('includes/footer.php'); ?>