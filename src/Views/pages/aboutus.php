<?php
$page_title = 'About Us';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';
?>

<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/aboutus.css">

<main class="about-page">
    <div class="section">
        <div class="container">
            <div class="content-section">
                <div class="title">
                    <h1>About Us</h1>
                </div>
                <div class="content">
                    <p>At Jobjet, we are passionate about revolutionizing the job market by bridging the gap between talented individuals and forward-thinking companies. Founded in 2022, our platform has grown to become a trusted resource for millions of job seekers and employers worldwide.</p>
                    <p>Our team is composed of industry experts dedicated to creating innovative tools that simplify the hiring process, from AI-powered resume matching to real-time job alerts. We prioritize diversity, inclusion, and equal opportunities for all.</p>
                    
                    <div class="section-divider"></div>
                    
                    <div class="mission-vision">
                        <div class="card">
                            <h2>Our Mission</h2>
                            <p>To empower job seekers with the resources they need to find meaningful careers and help employers discover top talent efficiently and effectively.</p>
                        </div>
                        <div class="card">
                            <h2>Our Vision</h2>
                            <p>To create a global job ecosystem where opportunities are accessible to everyone, fostering economic growth and personal fulfillment.</p>
                        </div>
                    </div>
                    
                    <div class="team-section">
                        <h2>Meet Our Team</h2>
                        <div class="team-grid">
                            <div class="team-member">
                                <h3>Malsri Manaram</h3>
                                <p>CEO & Founder</p>
                            </div>
                            <div class="team-member">
                                <h3>Jane Smith</h3>
                                <p>CTO</p>
                            </div>
                            <div class="team-member">
                                <h3>Alex Johnson</h3>
                                <p>Head of Marketing</p>
                            </div>
                        
                        </div>
                    </div>
                    
                    <div class="button">
                        <a href="<?php echo BASE_URL; ?>jobs">Explore Jobs</a>
                    </div>
                </div>
                <div class="social">
                    <a href="https://www.facebook.com/"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/?lang=en"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                    <a href="https://www.instagram.com/"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/home/?originalSubdomain=lk"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include LAYOUTS.'footer.php'; ?>