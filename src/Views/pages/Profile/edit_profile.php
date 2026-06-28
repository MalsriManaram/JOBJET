<?php

include CONTROLLERS.'Profile/EditProfileController.php';

?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/edit_profile.css?v=<?php echo time(); ?>" type="text/css" media="all" />
    <main>
        <div class="card">
            <form action="" method="post" enctype="multipart/form-data">
                <a href="<?php echo BASE_URL; ?>profile/my_profile" class="view-button">View Profile</a>
                <h3>Edit Profile</h3>
                <hr class="hr1">
                <?php echo $msg; ?>
                <div class="profile-header">
                    <div class="d-flex flex-column align-items-center">
                        <div class="profile-image-container">
                            <input type="file" name="upload_image" id="upload-file" class="upload-input"  accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                            <label for="upload-file" class="pro_img_label">
                                <img class="pro_img" src="<?php echo BASE_URL; ?>assets/storage/uploads/profile-pics/<?php echo $pro_img; ?>" alt="Profile Image">
                                <img class="upload_img" src="<?php echo BASE_URL; ?>assets/images/website-images/Upload.png" alt="Upload">
                            </label>
                        </div>
                        <div style="margin-top: 10px;"><?php echo $profile_msg; ?></div>
                    </div>
                    <div class="For-name">
                        <h2><input name="full_name" placeholder="Full Name" value="<?php echo $full_name; ?>"></h2>
                        <span><input name="nick_name" placeholder="@Nickname" value="<?php echo $nick_name; ?>"></span>
                    </div>
                </div>
                <div class="info-grid">
                    <div class="section basic-info">
                        <h6>Basic Information</h6>
                        <div class="For-infor">
                            <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/from.png" alt=""><strong>From:</strong> <input name="address" placeholder="Address" value="<?php echo $address; ?>"></p>
                            <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/bdy.png" alt=""><strong>Birthday:</strong> <input type="date" name="birth_day" value="<?php echo $birth_day; ?>"></p>
                            <p>
                                <img src="<?php echo BASE_URL; ?>assets/images/website-images/gender.png" alt="">
                                <strong>Gender:</strong> 
                                <select name="gender"  placeholder="Gender">
                                    <option value="gender" <?php if ($gender === 'Gender') {
                                        echo 'selected';
                                    } ?>>Gender</option>
                                    <option value="male" <?php if ($gender === 'Male') {
                                        echo 'selected';
                                    } ?>>Male</option>
                                    <option value="female" <?php if ($gender === 'Female') {
                                        echo 'selected';
                                    } ?>>Female</option>
                                    <option value="other" <?php if ($gender === 'Other') {
                                        echo 'selected';
                                    } ?>>Other</option>
                                </select>
                            </p>
                        </div>
                    </div>

                    <div class="section contact-info">
                        <h6>Contact Information</h6>
                        <div class="For-infor">
                            <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/call.png" alt=""><strong>Phone Number:</strong> <input  name="phone_no" placeholder="Phone Number" value="<?php echo $phone_no; ?>"></p>
                            <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/email.png" alt=""><strong>Email:</strong> <input name="pro_email" placeholder="Email" value="<?php echo $pro_email; ?>"></p>
                            <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/site.png" alt=""><strong>Site:</strong> <input name="site" placeholder="Site" value="<?php echo $site; ?>"></p>
                        </div>
                    </div>

                    <div class="section skills">
                        <h6>Skills</h6>
                        <div class="For-infor">
                            <ul>
                                <?php
                                    if (empty($skills_array)) {
                                        echo '<div class="no-experience">No experience added yet.</div>';
                                    } else {
                                        foreach ($skills_array as $skill) { ?>
                                            <li class="ms-4"><input name="skills[]" placeholder="New Skill" value="<?php echo trim($skill); ?>"> <button type="button" class="remove-skill">Remove</button></li>
                                        <?php }
                                        }?>
                            </ul>
                            <button type="button" class="add-skill">Add Skill</button>
                        </div>
                    </div>

                    <div class="section work-experiences">
                        <h6>Work Experiences</h6>
                        <div class="For-infor">
                            <ul>
                                <?php
                                    if (empty($workexp_data)) {
                                        echo '<div class="no-experience">No experience added yet.</div>';
                                    } else {
                                        foreach ($workexp_data as $workexp) {
                                            ?>
                                            <div class="experience">
                                                <h4><input name="position[]" placeholder="Position" value="<?php echo $workexp['position']; ?>"></h4>
                                                <span><input name="company_name[]" placeholder="Company Name" value="<?php echo $workexp['company_name']; ?>"> | <input name="time_period[]" placeholder="Time Period" value="<?php echo $workexp['time_period']; ?>"></span>
                                                 <button type="button" class="remove-button">Remove</button>
                                            </div>
                                            <?php
                                        }
                                    }
?>
                            </ul>
                            <button type="button" class="add-more-form">Add Experience</button>
                        </div>
                    </div>

                    <div class="section fields">
                        <h6>Interested Career Fields</h6>
                        <div class="For-infor">
                            <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/filed.png" alt=""><strong>Field 01:</strong> <input  name="filed" placeholder="Field 01" value="<?php echo $field; ?>"></p>
                            <p><img src="<?php echo BASE_URL; ?>assets/images/website-images/filed.png" alt=""><strong>Field 02:</strong> <input name="filed2" placeholder="Field 02" value="<?php echo $field2; ?>"></p>
                        </div>
                    </div>

                    <div class="section resume">
                        <h6>Upload Resume</h6>
                        <div class="For-infor">                                    
                            <input type="file" id="input-file1" class="upload-input" name="upload-img2" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                            <div>

                            <label for="input-file1" class="upload-label">
                                <img src="<?php echo BASE_URL; ?>assets/images/website-images/uploadimg.png" class="uploading-img" alt="Upload">
                            </label>
                            </div>
                            <span id="file-name"></span>
                            <?php echo $resume_msg; ?>            
                        </div>
                        <?php if (!empty($resume_img)) { ?>
                        <div class="resume-image-container">
                            <p class="uploaded-resume-label">Uploaded Resume</p>
                            <img class="resume-image" src="<?php echo BASE_URL; ?>assets/storage/uploads/uploaded-resumes/<?php echo $resume_img; ?>" alt="Resume">
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <button type="submit" name="submit" class="edit-button">Save</button>
            </form>
        </div>

    <script>
        // Display uploaded profile image
        const display = document.querySelector('.pro_img');
        const input = document.querySelector('#upload-file');
        input.addEventListener('change', () => {
            let reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.addEventListener('load', () => {
                display.src = reader.result;
            });
        });

        // Add more skills
        $(document).ready(function() {
            $('.add-skill').on('click', function() {
                $('.skills ul').append('<li class="ms-4"><input name="skills[]" placeholder="New Skill"> <button type="button" class="remove-skill">Remove</button></li>');
            });

            $(document).on('click', '.remove-skill', function() {
                $(this).parent('li').remove();
            });

            // Add more work experiences
            $('.add-more-form').on('click', function() {
                $('.work-experiences ul').append('<div class="experience">\
                    <h4><input name="position[]" placeholder="Position"></h4>\
                    <span><input name="company_name[]" placeholder="Company Name"> | <input name="time_period[]" placeholder="Time Period"></span>\
                    <button type="button" class="remove-button">Remove</button>\
                </div>');
            });

            $(document).on('click', '.remove-button', function() {
                $(this).closest('.experience').remove();
            });
        });

        // Display resume file name
        const inputFile = document.getElementById('input-file1');
        const fileNameSpan = document.getElementById('file-name');
        inputFile.addEventListener('change', () => {
            const fileName = inputFile.files[0].name;
            fileNameSpan.textContent = `Uploaded file: ${fileName}`;
            fileNameSpan.className = 'negative-img-msg-file';
        });
        
    </script>

    <!-- Update profile images across the site -->
    <?php if (!empty($profile_msg) && strpos($profile_msg, 'successfully') !== false) { ?>
    <script>

    document.querySelectorAll('.nav-pro_img, .popup_img').forEach(img => {
        if (img) {
            img.src = '<?php echo BASE_URL; ?>assets/storage/uploads/profile-pics/<?php echo $pro_img; ?>?t=' + new Date().getTime();
        }
    });
    </script>
    <?php } ?>
</main>
<?php include LAYOUTS.'footer.php'; ?>