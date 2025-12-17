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
                    $msg = "<div class='positive-msg'>Profile updated successfully!</div>";
                } else {
                    $profile_msg .= "<div class='nagative-img-msg'>Failed to update profile image in database.</div>";
                    $msg = "<div class='nagative-msg'>Profile not updated successfully!</div>";
                }
            } else {
                $profile_msg .= "<div class='nagative-img-msg'>Failed to upload profile image.</div>";
                $msg = "<div class='nagative-msg'>Profile not updated successfully!</div>";
            }
        } else {
            $profile_msg .= "<div class='nagative-img-msg'>Invalid image format or size for profile image.<br> Please upload a valid image (under 3MB).</div>";
            $msg = "<div class='nagative-msg'>Profile not updated successfully!</div>";
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
                    $msg = "<div class='positive-msg'>Profile updated successfully!</div>";
                } else {
                    $resume_msg .= "<div class='nagative-resume-img-msg'>Failed to update resume image in database.</div>";
                    $msg = "<div class='nagative-msg'>Profile not updated successfully!</div>";
                }
            } else {
                $resume_msg .= "<div class='nagative-resume-img-msg'>Failed to upload resume image.</div>";
                $msg = "<div class='nagative-msg'>Profile not updated successfully!</div>";
            }
        } else {
            $resume_msg .= "<div class='nagative-resume-img-msg'>Invalid image format or size for resume.<br> Please upload a valid image (under 3MB).</div>";
            $msg = "<div class='nagative-msg'>Profile not updated successfully!</div>";
        }
    }

    // Refetch data after successful updates only if no errors
    if (strpos($msg, 'successfully') !== false || strpos($profile_msg, 'successfully') !== false || strpos($resume_msg, 'successfully') !== false) {
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
