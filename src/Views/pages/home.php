<?php
$page_title = 'Home Page';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';

?>
<link href="<?php echo BASE_URL; ?>assets/css/home.css" rel="stylesheet" type="text/css" media="all" />
<main>
    <div class="background-with-gradient">
        <div class="content">
            <h1>Job Jet</h1>
            <h3>Unlock Your Future
                <br>Explore Opportunities
                <br> Ignite Careers</h3>
            <p>Embark on a journey to professional success with our job-seeking platform.<br> Discover a world of opportunities, connect with top employers, and pave the way to your dream career.
                <br>Your next adventure begins here!
                <div>
                    <a href="<?php echo BASE_URL; ?>jobs"><button class="find_jobs" type="button"><span class="span1"></span>Find Jobs.</button></a>
                </div>
            </p>
        </div>

        <div class="social-menu">
            <ul>
                <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                <li><a href="https://twitter.com/?lang=en"><i class="fab fa-twitter"></i></a></li>
                <li><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
                <li><a href="https://www.linkedin.com/home/?originalSubdomain=lk"><i class="fab fa-linkedin"></i></a></li>
            </ul>
        </div>
    </div>
 
</main>

<?php include LAYOUTS.'footer.php'; ?>