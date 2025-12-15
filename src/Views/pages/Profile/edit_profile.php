<?php
$page_title = 'Edit Profile';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';

$msg = '';
$profile_msg = '';
$resume_msg = '';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $query0 = "SELECT * FROM users WHERE id = $id";
    $result0 = mysqli_query($conn, $query0);
    $row0 = mysqli_fetch_assoc($result0);
    $pro_img = !empty($row0['pro_img']) ? $row0['pro_img'] : 'profile.png';

    $query = "SELECT * FROM profile WHERE p_id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $full_name = !empty($row['full_name']) ? $row['full_name'] : '';
    $nick_name = !empty($row['nick_name']) ? $row['nick_name'] : '';
    $address = !empty($row['address']) ? $row['address'] : '';
    $birth_day = !empty($row['birth_day']) ? $row['birth_day'] : '';
    $gender = !empty($row['gender']) ? $row['gender'] : 'None';
    $phone_no = !empty($row['phone_no']) ? $row['phone_no'] : '';
    $site = !empty($row['site']) ? $row['site'] : '';
    $pro_email = !empty($row['pro_email']) ? $row['pro_email'] : '';

    $query2 = "SELECT * FROM workinfo WHERE w_id = $id";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_assoc($result2);
    $skills_str = !empty($row2['skills']) ? trim($row2['skills'], '• ') : '';
    $skills_array = explode(',', $skills_str);
    $field = !empty($row2['filed']) ? $row2['filed'] : '';
    $field2 = !empty($row2['filed2']) ? $row2['filed2'] : '';
    $resume_img = !empty($row2['resume_img']) ? $row2['resume_img'] : '';

    $query3 = "SELECT * FROM workexp WHERE work_id = $id";
    $result3 = mysqli_query($conn, $query3);
    $workexp_data = [];
    while ($row3 = mysqli_fetch_assoc($result3)) {
        $workexp_data[] = $row3;
    }
}

if (isset($_POST['submit'])) {
    // user inputs
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $nick_name = mysqli_real_escape_string($conn, $_POST['nick_name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $birth_day = mysqli_real_escape_string($conn, $_POST['birth_day']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $pro_email = mysqli_real_escape_string($conn, $_POST['pro_email']);
    $site = mysqli_real_escape_string($conn, $_POST['site']);

    if (isset($_POST['skills']) && is_array($_POST['skills'])) {
        $skills_post = array_map('trim', $_POST['skills']);
        $skills = implode(' , ', $skills_post);
    } else {
        $skills = '';
    }
    $filed = mysqli_real_escape_string($conn, $_POST['filed']);
    $filed2 = mysqli_real_escape_string($conn, $_POST['filed2']);

    $id = $_SESSION['id'];
    $check_user = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$id'");
    if (mysqli_num_rows($check_user) > 0) {
        // Begin transaction
        mysqli_begin_transaction($conn);

        try {
            // Check if user has existing profile and workinfo records
            $select_profile = mysqli_query($conn, "SELECT * FROM `profile` WHERE `p_id` = '$id'");
            $select_workinfo = mysqli_query($conn, "SELECT * FROM `workinfo` WHERE `w_id` = '$id'");
            $select_workexp = mysqli_query($conn, "SELECT * FROM `workexp` WHERE `work_id` = '$id'");

            $update_profile = [];
            $update_workinfo = [];

            if (!empty($_POST['full_name'])) {
                $update_profile[] = "full_name = '".mysqli_real_escape_string($conn, $_POST['full_name'])."'";
            }

            if (!empty($_POST['nick_name'])) {
                $update_profile[] = "nick_name = '".mysqli_real_escape_string($conn, $_POST['nick_name'])."'";
            }

            if (!empty($_POST['address'])) {
                $update_profile[] = "address = '".mysqli_real_escape_string($conn, $_POST['address'])."'";
            }

            if (!empty($_POST['birth_day'])) {
                $update_profile[] = "birth_day = '".mysqli_real_escape_string($conn, $_POST['birth_day'])."'";
            }

            if (!empty($_POST['gender'])) {
                $update_profile[] = "gender = '".mysqli_real_escape_string($conn, $_POST['gender'])."'";
            }

            if (!empty($_POST['phone_no'])) {
                $update_profile[] = "phone_no = '".mysqli_real_escape_string($conn, $_POST['phone_no'])."'";
            }

            if (!empty($_POST['pro_email'])) {
                $update_profile[] = "pro_email = '".mysqli_real_escape_string($conn, $_POST['pro_email'])."'";
            }

            if (!empty($_POST['site'])) {
                $update_profile[] = "site = '".mysqli_real_escape_string($conn, $_POST['site'])."'";
            }

            if (!empty($skills)) {
                $update_workinfo[] = "skills = '".mysqli_real_escape_string($conn, $skills)."'";
            }

            if (!empty($_POST['filed'])) {
                $update_workinfo[] = "filed = '".mysqli_real_escape_string($conn, $_POST['filed'])."'";
            }

            if (!empty($_POST['filed2'])) {
                $update_workinfo[] = "filed2 = '".mysqli_real_escape_string($conn, $_POST['filed2'])."'";
            }

            // Update Profile if there are changes
            if (!empty($update_profile)) {
                $update_profile_query = 'UPDATE `profile` SET '.implode(', ', $update_profile)." WHERE `p_id` = '$id'";
                mysqli_query($conn, $update_profile_query);
            }

            // Update Work Info if there are changes
            if (!empty($update_workinfo)) {
                $update_workinfo_query = 'UPDATE `workinfo` SET '.implode(', ', $update_workinfo)." WHERE `w_id` = '$id'";
                mysqli_query($conn, $update_workinfo_query);
            }

            if (
                isset($_POST['position']) && is_array($_POST['position'])
                && isset($_POST['company_name']) && is_array($_POST['company_name'])
                && isset($_POST['time_period']) && is_array($_POST['time_period'])
            ) {
                $positions = $_POST['position'];
                $company_names = $_POST['company_name'];
                $time_periods = $_POST['time_period'];

                $workexp_values = [];
                foreach ($positions as $key => $position) {
                    $position = mysqli_real_escape_string($conn, $position);
                    $company_name = mysqli_real_escape_string($conn, $company_names[$key]);
                    $time_period = mysqli_real_escape_string($conn, $time_periods[$key]);

                    // Check if all required fields are not empty
                    if (!empty($position) && !empty($company_name) && !empty($time_period)) {
                        $workexp_values[] = "('$id', '$position', '$company_name', '$time_period')";
                    }
                }

                if (!empty($workexp_values)) {
                    // Delete existing work experiences
                    mysqli_query($conn, "DELETE FROM `workexp` WHERE `work_id` = '$id'");
                    // Insert new work experiences
                    $workexp_query = 'INSERT INTO `workexp` (work_id, position, company_name, time_period) VALUES '.implode(', ', $workexp_values);
                    mysqli_query($conn, $workexp_query);
                }
            }

            // Commit the transaction
            mysqli_commit($conn);

            $msg = "<div class='positive-msg'>Profile updated successfully!</div>";
        } catch (mysqli_sql_exception $e) {
            // Rollback the transaction on exception
            mysqli_rollback($conn);

            $msg = "<div class='nagative-msg'>Error occurred: ".$e->getMessage().'</div>';
        }
    } else {
        $msg = "<div class='nagative-msg'>User not found!</div>";
    }

    // Handle profile image
    if ($_FILES['upload_image']['error'] === 0) {
        $img_name = $_FILES['upload_image']['name'];
        $img_size = $_FILES['upload_image']['size'];
        $tmp_name = $_FILES['upload_image']['tmp_name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $allowed_exs = ['jpg', 'jpeg', 'png'];

        if (in_array($img_ex, $allowed_exs) && $img_size < 3145728) {
            $new_img_name = uniqid('IMG-', true).'.'.$img_ex;
            $img_upload_path = 'assets/storage/uploads/profile-pics/'.$new_img_name;
            if (move_uploaded_file($tmp_name, $img_upload_path)) {
                // Update database
                $sql_update_image = 'UPDATE users SET pro_img = ? WHERE id = ?';
                $stmt_update_image = mysqli_prepare($conn, $sql_update_image);
                mysqli_stmt_bind_param($stmt_update_image, 'si', $new_img_name, $id);
                if (mysqli_stmt_execute($stmt_update_image)) {
                    // Delete old image if it exists and is not the default
                    if ($pro_img && $pro_img !== 'profile.png') {
                        $old_profile_path = 'assets/storage/uploads/profile-pics/'.$pro_img;
                        if (file_exists($old_profile_path)) {
                            unlink($old_profile_path);
                        }
                    }
                    $profile_msg .= "<div class='positive-img-msg'>Profile image updated successfully!</div>";
                } else {
                    $profile_msg .= "<div class='nagative-img-msg'>Failed to update profile image in database.</div>";
                }
            } else {
                $profile_msg .= "<div class='nagative-img-msg'>Failed to upload profile image.</div>";
            }
        } else {
            $profile_msg .= "<div class='nagative-img-msg'>Invalid image format or size.<br> Please upload a valid image (under 3MB).</div>";
        }
    }

    // Handle resume upload
    if ($_FILES['upload-img2']['error'] === 0) {
        $img_name = $_FILES['upload-img2']['name'];
        $img_size = $_FILES['upload-img2']['size'];
        $tmp_name = $_FILES['upload-img2']['tmp_name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $allowed_exs = ['jpg', 'jpeg', 'png'];

        if (in_array($img_ex, $allowed_exs) && $img_size < 3145728) {
            $new_img_name1 = uniqid('IMG-', true).'.'.$img_ex;
            $img_upload_path = 'assets/storage/uploads/uploaded-resumes/'.$new_img_name1;
            if (move_uploaded_file($tmp_name, $img_upload_path)) {
                // Update database
                $sql_update_image1 = 'UPDATE workinfo SET resume_img = ? WHERE w_id = ?';
                $stmt_update_image1 = mysqli_prepare($conn, $sql_update_image1);
                mysqli_stmt_bind_param($stmt_update_image1, 'si', $new_img_name1, $id);
                if (mysqli_stmt_execute($stmt_update_image1)) {
                    // Delete old resume image if it exists
                    if ($resume_img) {
                        $old_resume_path = 'assets/storage/uploads/uploaded-resumes/'.$resume_img;
                        if (file_exists($old_resume_path)) {
                            unlink($old_resume_path);
                        }
                    }
                    $resume_msg .= "<div class='positive-resume-img-msg'>Resume image updated successfully!</div>";
                } else {
                    $resume_msg .= "<div class='nagative-resume-img-msg'>Failed to update resume image in database.</div>";
                }
            } else {
                $resume_msg .= "<div class='nagative-resume-img-msg'>Failed to upload resume image.</div>";
            }
        } else {
            $resume_msg .= "<div class='nagative-resume-img-msg'>Invalid image format or size.<br> Please upload a valid image (under 3MB).</div>";
        }
    }

    // Refetch data after successful updates only if no errors
    if (strpos($msg, 'successfully') !== false && strpos($profile_msg, 'successfully') !== false && strpos($resume_msg, 'successfully') !== false) {
        $query0 = "SELECT * FROM users WHERE id = $id";
        $result0 = mysqli_query($conn, $query0);
        $row0 = mysqli_fetch_assoc($result0);
        $pro_img = !empty($row0['pro_img']) ? $row0['pro_img'] : 'profile.png';

        $query = "SELECT * FROM profile WHERE p_id = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $full_name = !empty($row['full_name']) ? $row['full_name'] : '';
        $nick_name = !empty($row['nick_name']) ? $row['nick_name'] : '';
        $address = !empty($row['address']) ? $row['address'] : '';
        $birth_day = !empty($row['birth_day']) ? $row['birth_day'] : '';
        $gender = !empty($row['gender']) ? $row['gender'] : 'None';
        $phone_no = !empty($row['phone_no']) ? $row['phone_no'] : '';
        $site = !empty($row['site']) ? $row['site'] : '';
        $pro_email = !empty($row['pro_email']) ? $row['pro_email'] : '';

        $query2 = "SELECT * FROM workinfo WHERE w_id = $id";
        $result2 = mysqli_query($conn, $query2);
        $row2 = mysqli_fetch_assoc($result2);
        $skills_str = !empty($row2['skills']) ? trim($row2['skills'], '• ') : '';
        $skills_array = explode(',', $skills_str);
        $field = !empty($row2['filed']) ? $row2['filed'] : '';
        $field2 = !empty($row2['filed2']) ? $row2['filed2'] : '';
        $resume_img = !empty($row2['resume_img']) ? $row2['resume_img'] : '';

        $query3 = "SELECT * FROM workexp WHERE work_id = $id";
        $result3 = mysqli_query($conn, $query3);
        $workexp_data = [];
        while ($row3 = mysqli_fetch_assoc($result3)) {
            $workexp_data[] = $row3;
        }
    }
}
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/edit_profile.css" type="text/css" media="all" />
    <main>
        <div class="card">
            <form action="" method="post" enctype="multipart/form-data">
                <a href="<?php echo BASE_URL; ?>profile/my_profile" class="view-button">View Profile</a>
                <h3>Edit Profile</h3>
                <hr class="hr1">
                <?php
                    if (!empty($msg)) {
                        if (strpos($profile_msg, 'Profile image updated successfully!') !== false || strpos($resume_msg, 'Resume image updated successfully!') !== false) {
                            echo $msg;
                        } else {
                            echo "<div class='nagative-resume-img-msg'>Profile is not updated</div>";
                        }
                    } ?>
                <div class="profile-header">
                    <div>
                        <div class="profile-image-container">
                            <input type="file" name="upload_image" id="upload-file" class="upload-input"  accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                            <label for="upload-file" class="pro_img_label">
                                <img class="pro_img" src="<?php echo BASE_URL; ?>assets/storage/uploads/profile-pics/<?php echo $pro_img; ?>" alt="Profile Image">
                                <img class="upload_img" src="<?php echo BASE_URL; ?>assets/images/website-images/Upload.png" alt="Upload">
                            </label>
                            
                        </div>
                        <?php echo $profile_msg; ?>
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