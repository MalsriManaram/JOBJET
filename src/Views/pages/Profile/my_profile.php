<?php
include CONTROLLERS.'Profile/MyProfileController.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/profile.css" type="text/css" media="all" />
<main>
    <?php if (isset($id)) { ?>
        <div class="card">
            <a href="<?php echo BASE_URL; ?>profile/edit_profile" class="edit-button">Edit</a>
            <h3>User Profile</h3>
            <hr class="hr1">

            <div class="profile-header">
                <img class="pro_img" src="<?php echo BASE_URL; ?>assets/storage/uploads/profile-pics/<?php echo $pro_img; ?>" alt="Profile Image">
                <div class="For-name">
                    <h2><?php echo $full_name; ?></h2>
                    <span><?php echo $nick_name; ?></span>
                </div>
            </div>

            <div class="info-grid">
                <div class="section basic-info">
                    <h6>Basic Information</h6>
                    <div class="For-infor">
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/from.png" alt=""><strong>From:</strong> <?php echo $address; ?></p>
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/bdy.png" alt=""><strong>Birthday:</strong> <?php echo $birth_day; ?></p>
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/gender.png" alt=""><strong>Gender:</strong> <?php echo $gender; ?></p>
                    </div>
                </div>

                <div class="section contact-info">
                    <h6>Contact Information</h6>
                    <div class="For-infor">
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/call.png" alt=""><strong>Phone Number:</strong> <?php echo $phone_no; ?></p>
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/email.png" alt=""><strong>Email:</strong> <?php echo $pro_email; ?></p>
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/site.png" alt=""><strong>Site:</strong> <?php echo $site; ?></p>
                    </div>
                </div>

                <div class="section skills">
                    <h6>Skills</h6>
                    <div class="For-infor">
                        <ul>
                            <?php foreach ($skills as $skill) { ?>
                                <li><?php echo trim($skill); ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <div class="section work-experiences">
                    <h6>Work Experiences</h6>
                    <div class="For-infor">
                        <?php
                        if (!empty($workexp_data)) {
                            foreach ($workexp_data as $workexp) {
                                ?>
                                <div class="experience">
                                    <h4><?php echo $workexp['position']; ?></h4>
                                    <span><?php echo $workexp['company_name'].' | '.$workexp['time_period']; ?></span>
                                </div>
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

                <div class="section fields">
                    <h6>Interested Career Fields</h6>
                    <div class="For-infor">
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/filed.png" alt=""><strong>Field 01:</strong> <?php echo $field; ?></p>
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/filed.png" alt=""><strong>Field 02:</strong> <?php echo $field2; ?></p>
                        
                    </div>
                </div>
                <a class="view-button" onclick="windowOpen(<?php echo $id; ?>)">View Resume</a>
            </div>
        </div>
    <?php } ?>
    <script>
        function windowOpen(id) {
            var screenWidth = window.screen.width;
            var screenHeight = window.screen.height;

            var windowWidth = 650;
            var windowHeight = 690;

            var left = (screenWidth - windowWidth) / 2;
            var top = (screenHeight - windowHeight) / 2;

            window.open("<?php echo BASE_URL; ?>profile/view_my_resume?id=" + id, "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + left + ", top=" + top);
        }
    </script>
</main>

<?php include LAYOUTS.'footer.php'; ?>