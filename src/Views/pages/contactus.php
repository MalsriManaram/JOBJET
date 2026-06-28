<?php
include CONTROLLERS.'ContactUsController.php';
?>


<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/contatctus.css?v=<?php echo time(); ?>">

<main class='about-page'>
    <section class="contact">
        
        <div class="content">
            <h2>Contact Us</h2>
            <p>We're here to help! Whether you have questions about our platform, need assistance with job listings, or want to provide feedback, feel free to reach out. Our team is dedicated to providing the best support to job seekers and employers alike.</p>
        </div>
        <div class="container">
            <div class="contactInfo">
                <div class="box">
                    <div class="icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Address</h3>
                        <p>Colombo,<br>Rathmalana, Sri Lanka</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class="fas fa-phone" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Phone</h3>
                        <p>071 3588046 – Malsri</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class="fas fa-envelope" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Email</h3>
                        <p>jobjet7878@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="contactForm">
                <form method="POST" action="">
                    <h2>Send Feedback</h2>
                    <?php echo $msg; ?>
                    <div class="inputbox">
                        <input type="text" name="full_name" required="required">
                        <span>Full Name</span>
                    </div>
                    <div class="inputbox">
                        <input type="email" name="Email" required="required">
                        <span>Email</span>
                    </div>
                    <div class="inputbox">
                        <textarea required="required" name="Message"></textarea>
                        <span>Type your Message...</span>
                    </div>
                    <div class="inputbox">
                        <button class="button_submit" type="submit" name="submit">Send</button>
                    </div>
                </form>
            </div>
            <div class="map">
            <p style="color: white; font-weight: bold; font-size: 25px; margin-bottom: 10px;">Location:</p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.9160000000004!2d79.87800000000001!3d6.8210000000000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25b8b0a000001%3A0x9e8e43b4!2sRatmalana%2C%20Dehiwala-Mount%20Lavinia!5e0!3m2!1sen!2slk!4v1720000000000" width="100%" height="500px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <div class="social-links">
            <a href="https://www.facebook.com/"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
            <a href="https://twitter.com/"><i class="fab fa-twitter" aria-hidden="true"></i></a>
            <a href="https://www.instagram.com/"><i class="fab fa-instagram" aria-hidden="true"></i></a>
            <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
        </div>
    </section>

</main>

<?php
include LAYOUTS.'footer.php';
?>