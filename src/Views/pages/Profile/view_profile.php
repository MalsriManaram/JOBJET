<?php

$page_title = 'User Profile';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';

if (isset($_GET['identify'])) {
    $identify = mysqli_real_escape_string($conn, $_GET['identify']);

    $query0 = "SELECT * FROM users WHERE identify = $identify";
    $result0 = mysqli_query($conn, $query0);
    $row0 = mysqli_fetch_assoc($result0);
    if (!empty($row0['pro_img'])) {
        $_SESSION['pro_img'] = $row0['pro_img'];
    } else {
        $_SESSION['pro_img'] = 'profile.png';
    }
    $id = $row0['id'];

    $query = "SELECT * FROM profile WHERE p_id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['full_name'] = !empty($row['full_name']) ? $row['full_name'] : $row0['first_name'] . ' ' . $row0['last_name'];
    $_SESSION['nick_name'] = !empty($row['nick_name']) ? $row['nick_name'] : '@NickName';
    $_SESSION['address'] = !empty($row['address']) ? $row['address'] : 'None';
    $_SESSION['birth_day'] = !empty($row['birth_day']) ? $row['birth_day'] : 'xx/xx/xxxx';
    $_SESSION['gender'] = !empty($row['gender']) ? $row['gender'] : 'None';
    $_SESSION['phone_no'] = !empty($row['phone_no']) ? $row['phone_no'] : 'None';
    $_SESSION['site'] = !empty($row['site']) ? $row['site'] : 'None';
    $_SESSION['pro_email'] = !empty($row['pro_email']) ? $row['pro_email'] : $row0['email'];

    $query2 = "SELECT * FROM workinfo WHERE w_id = $id";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_assoc($result2);
    $skills_str = !empty($row2['skills']) ? trim($row2['skills'], ' , ') : 'None';
    $_SESSION['skills'] = explode(',', $skills_str);
    $_SESSION['field'] = !empty($row2['filed']) ? $row2['filed'] : 'None';
    $_SESSION['field2'] = !empty($row2['filed2']) ? $row2['filed2'] : 'None';

    $query3 = "SELECT * FROM workexp WHERE work_id = $id";
    $result3 = mysqli_query($conn, $query3);

    $workexp_data = [];
    while ($row3 = mysqli_fetch_assoc($result3)) {
        $workexp_data[] = $row3;
    }
}

?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/profile.css" type="text/css" media="all" />
<main>
    <?php if (isset($_SESSION['id'])) { ?>
        <div class="card">
            <h3>User Profile</h3>
            <hr class="hr1">

            <div class="profile-header">
                <img class="pro_img" src="<?php echo BASE_URL; ?>assets/storage/uploads/profile-pics/<?php echo $_SESSION['pro_img']; ?>" alt="Profile Image">
                <div class="For-name">
                    <h2><?php echo $_SESSION['full_name']; ?></h2>
                    <span><?php echo $_SESSION['nick_name']; ?></span>
                </div>
            </div>

            <div class="info-grid">
                <div class="section basic-info">
                    <h6>Basic Information</h6>
                    <div class="For-infor">
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/from.png" alt=""><strong>From:</strong> <?php echo $_SESSION['address']; ?></p>
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/bdy.png" alt=""><strong>Birthday:</strong> <?php echo $_SESSION['birth_day']; ?></p>
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/gender.png" alt=""><strong>Gender:</strong> <?php echo $_SESSION['gender']; ?></p>
                    </div>
                </div>

                <div class="section contact-info">
                    <h6>Contact Information</h6>
                    <div class="For-infor">
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/call.png" alt=""><strong>Phone Number:</strong> <?php echo $_SESSION['phone_no']; ?></p>
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/email.png" alt=""><strong>Email:</strong> <?php echo $_SESSION['pro_email']; ?></p>
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/site.png" alt=""><strong>Site:</strong> <?php echo $_SESSION['site']; ?></p>
                    </div>
                </div>

                <div class="section skills">
                    <h6>Skills</h6>
                    <div class="For-infor">
                        <ul>
                            <?php foreach ($_SESSION['skills'] as $skill) { ?>
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
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/filed.png" alt=""><strong>Field 01:</strong> <?php echo $_SESSION['field']; ?></p>
                        <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/filed.png" alt=""><strong>Field 02:</strong> <?php echo $_SESSION['field2']; ?></p>
                        
                    </div>
                </div>
                <a href="#" class="view-button" onclick="windowOpen()">View Resume</a>
            </div>
        </div>
    <?php } ?>
    <script>
        function windowOpen() {
            var screenWidth = window.screen.width;
            var screenHeight = window.screen.height;

            var windowWidth = 650;
            var windowHeight = 690;

            var left = (screenWidth - windowWidth) / 2;
            var top = (screenHeight - windowHeight) / 2;

            window.open("<?php echo BASE_URL; ?>profile/view_resume", "_blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + left + ", top=" + top);
        }
    </script>
</main>

<?php include LAYOUTS.'footer.php'; ?>