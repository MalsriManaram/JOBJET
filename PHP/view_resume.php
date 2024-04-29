<?php

$page_title = "View Resume";
include('includes/header.php');
include('includes/navbar.php'); 
include('config.php');
include('includes/footer.php');

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    
    $query0 = "SELECT resume_img FROM workinfo WHERE w_id = $id";
    $result0 = mysqli_query($conn, $query0);
    $row0 = mysqli_fetch_assoc($result0);
    if (!empty($row0['resume_img'])) {
        $_SESSION['resume_img'] = $row0['resume_img'];
    } else {
        $_SESSION['resume_img'] = "upload_resume.png";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/JOBJET/CSS/view_resume1.css" type="text/css" media="all" />
</head>
<body>
    <div class="content">
    <?php if(isset($_SESSION['id'])): ?>
        <div>
            <img class="resume_img" src="/JOBJET/UPLOADED_CV/<?=$_SESSION['resume_img']?>" alt="Resume Image" >
        </div>
    <?php endif; ?>
    </div>
    <button class="print_button" id="print">Print</button> 

    <script>
        const printBtn = document.getElementById('print');

        printBtn.addEventListener('click', function() {
            window.print();
        });
    </script>
</body> 
</html>
