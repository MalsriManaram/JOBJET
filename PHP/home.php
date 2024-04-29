<?php 
$page_title= "Home Page";
include('includes/header.php');
include('includes/navbar.php'); 
include('config.php');
include('includes/footer.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/JOBJET/CSS/home.css" type="text/css" media="all" />

</head>

<body>
    <div class="background-with-gradient">
        <div class="content">
            <h1>Job Jet</h1>
            <h3>Unlock Your Future
                <br>Explore Opportunities
                <br> Ignite Careers</h3>
            <p>Embark on a journey to professional success with our job-seeking platform.<br> Discover a world of opportunities, connect with top employers, and pave the way to your dream career.
                <br>Your next adventure begins here!
                <div>
                    <a href="jobs.php"><button class="find_jobs" type="button"><span class="span1"></span>Find Jobs.</button></a>
                </div>
            </p>
        </div>
    </div>
</body>
</html>



<?php include('includes/footer.php'); ?>

