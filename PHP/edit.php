<?php
$page_title = "Edit Profile";
include('includes/header.php');
include('config.php');
include('includes/navbar.php');
include('includes/footer.php'); 
$msg = "";


if (isset($_POST['submit'])) {

    //user inputs
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $nick_name = mysqli_real_escape_string($conn, $_POST['nick_name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $birth_day = mysqli_real_escape_string($conn, $_POST['birth_day']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $pro_email = mysqli_real_escape_string($conn, $_POST['pro_email']);
    $site = mysqli_real_escape_string($conn, $_POST['site']);

    $skills = mysqli_real_escape_string($conn, $_POST['skills']);
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
                $update_workexp = [];
            
                if (!empty($_POST['full_name'])) {
                    $update_profile[] = "full_name = '" . mysqli_real_escape_string($conn, $_POST['full_name']) . "'";
                }
            
                if (!empty($_POST['nick_name'])) {
                    $update_profile[] = "nick_name = '" . mysqli_real_escape_string($conn, $_POST['nick_name']) . "'";
                }
            
                if (!empty($_POST['address'])) {
                    $update_profile[] = "address = '" . mysqli_real_escape_string($conn, $_POST['address']) . "'";
                }
            
                if (!empty($_POST['birth_day'])) {
                    $update_profile[] = "birth_day = '" . mysqli_real_escape_string($conn, $_POST['birth_day']) . "'";
                }
            
                if (!empty($_POST['gender'])) {
                    $update_profile[] = "gender = '" . mysqli_real_escape_string($conn, $_POST['gender']) . "'";
                }
            
                if (!empty($_POST['phone_no'])) {
                    $update_profile[] = "phone_no = '" . mysqli_real_escape_string($conn, $_POST['phone_no']) . "'";
                }
            
                if (!empty($_POST['pro_email'])) {
                    $update_profile[] = "pro_email = '" . mysqli_real_escape_string($conn, $_POST['pro_email']) . "'";
                }
            
                if (!empty($_POST['site'])) {
                    $update_profile[] = "site = '" . mysqli_real_escape_string($conn, $_POST['site']) . "'";
                }
            
                if (!empty($_POST['skills'])) {
                    $update_workinfo[] = "skills = '" . mysqli_real_escape_string($conn, $_POST['skills']) . "'";
                }
            
                if (!empty($_POST['filed'])) {
                    $update_workinfo[] = "filed = '" . mysqli_real_escape_string($conn, $_POST['filed']) . "'";
                }
            
                if (!empty($_POST['filed2'])) {
                    $update_workinfo[] = "filed2 = '" . mysqli_real_escape_string($conn, $_POST['filed2']) . "'";
                }
            
                // Update Profile if there are changes
                if (!empty($update_profile)) {
                    $update_profile_query = "UPDATE `profile` SET " . implode(", ", $update_profile) . " WHERE `p_id` = '$id'";
                    mysqli_query($conn, $update_profile_query);
                }
            
                // Update Work Info if there are changes
                if (!empty($update_workinfo)) {
                    $update_workinfo_query = "UPDATE `workinfo` SET " . implode(", ", $update_workinfo) . " WHERE `w_id` = '$id'";
                    mysqli_query($conn, $update_workinfo_query);
                }

                
                if (mysqli_num_rows($select_workexp) === 0) {
 
                    // Loop through the arrays to insert multiple work experiences
                    if (isset($_POST['position']) && is_array($_POST['position'])) {
                        foreach ($_POST['position'] as $key => $value) {
                            $position = mysqli_real_escape_string($conn, $value);
                            $company_name = mysqli_real_escape_string($conn, $_POST['company_name'][$key]);
                            $time_period = mysqli_real_escape_string($conn, $_POST['time_period'][$key]);
    
                            mysqli_query($conn, "INSERT INTO `workexp` (work_id, position, company_name, time_period) 
                                                VALUES ('$id', '$position', '$company_name', '$time_period')");
                        }
                    }
                } else {
                   
                    if (
                        isset($_POST['position']) && is_array($_POST['position']) &&
                        isset($_POST['company_name']) && is_array($_POST['company_name']) &&
                        isset($_POST['time_period']) && is_array($_POST['time_period'])
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
                            $workexp_query = "INSERT INTO `workexp` (work_id, position, company_name, time_period) VALUES " . implode(", ", $workexp_values);
                            mysqli_query($conn, $workexp_query);
                        }
                    }
                    
                }
           

            // Commit the transaction
            mysqli_commit($conn);

            $msg = "<div class='positive-msg'>Profile updated successfully!</div>";

        } catch (mysqli_sql_exception $e) {
            // Rollback the transaction on exception
            mysqli_rollback($conn);

            $msg = "<div class='negative-msg'>Error occurred: " . $e->getMessage() . "</div>";
        }
    } else {
        $msg = "<div class='negative-msg'>User not found!</div>";
    }




    // Handle profile image
    if ($_FILES['upload_image']['error'] === 0) {
        $img_name = $_FILES['upload_image']['name'];
        $img_size = $_FILES['upload_image']['size'];
        $tmp_name = $_FILES['upload_image']['tmp_name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $allowed_exs = array("jpg", "jpeg", "png");
        

        if (in_array($img_ex, $allowed_exs) && $img_size < 3145728) {
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex;
            $img_upload_path = 'E:/XAMPP/htdocs/JOBJET/UPLOADED_IMG/' . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);

            
            $sql_update_image = "UPDATE users SET pro_img = ? WHERE id = ?";
            $stmt_update_image = mysqli_prepare($conn, $sql_update_image);
            mysqli_stmt_bind_param($stmt_update_image, "si", $new_img_name, $id);
            mysqli_stmt_execute($stmt_update_image);

            $msg .= "<div class='positive-img-msg'>Profile image updated successfully!</div>";
        } else {
            $msg .= "<div class='negative-img-msg '>Invalid image format or size.<br> Please upload a valid image (under 3MB).</div>";
        }
    }


    // Handle resume upload
    if ($_FILES['upload-img2']['error'] === 0) {
        $img_name = $_FILES['upload-img2']['name'];
        $img_size = $_FILES['upload-img2']['size'];
        $tmp_name = $_FILES['upload-img2']['tmp_name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $allowed_exs = array("jpg", "jpeg", "png");
        
    
        if (in_array($img_ex, $allowed_exs) && $img_size < 3145728) {
            $new_img_name1 = uniqid("IMG-", true) . '.' . $img_ex;
            $img_upload_path = 'E:/XAMPP/htdocs/JOBJET/UPLOADED_CV/' . $new_img_name1;
            move_uploaded_file($tmp_name, $img_upload_path);
    
            // Update the correct column name in the SQL query
            $sql_update_image1 = "UPDATE workinfo SET resume_img = ? WHERE w_id = ?";
            $stmt_update_image1 = mysqli_prepare($conn, $sql_update_image1);
            mysqli_stmt_bind_param($stmt_update_image1, "si", $new_img_name1, $id);
            mysqli_stmt_execute($stmt_update_image1);
    
            $msg .= "<div class='positive-resume-img-msg'>Profile image updated successfully!</div>";
        } else {
            $msg .= "<div class='nagative-resume-img-msg'>Invalid image format or size.<br> Please upload a valid image (under 3MB).</div>";
        }
    }

   
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="editprofile">

    <link rel="stylesheet" href="/JOBJET/CSS/edit.css" type="text/css" media="all" />
   

</head>

<body>
    <div class="card">
        <form action="edit.php" method="post" enctype="multipart/form-data">
            <h3>Edit Profile </h3>
            <hr class="hr1">
            <?php echo $msg; ?>
            <div class="upload_all">
                <input type="file" name="upload_image" id="upload-file" class="upload-input">
                <label for="upload-file" class="pro_img_label">
                    <div class="pro_img">
                        <img class="pro_img1" src="/JOBJET/UPLOADED_IMG/profile.png" alt="Profile Image">
                    </div>
                    <img class="upload_img" src="/JOBJET/IMAGERS/Upload.png">
                </label>
            </div>

            <div class="For-name">
                <label for="FullName" class="labels">Full Name</label>
                <input type="text" class="form-control" name="full_name" value="<?php if (isset($_POST['submit'])) { echo $full_name;} ?>" placeholder="Enter Your Full Name">
                <label for="NickName" class="labels">Nick Name</label>
                <input type="text" class="form-control" name="nick_name" value="<?php if (isset($_POST['submit'])) { echo $nick_name;} ?>" placeholder="Enter Your Nick Name">
                <hr class="hr2">
            </div>

            <div class="For-infor">

                <h6>BASIC INFORMATION</h6>

                <label for="From" class="labels"><img src="/JOBJET/IMAGERS/from.png" alt="">From</label>
                <input type="text" class="form-control" name="address" value="<?php if (isset($_POST['submit'])) {echo $address;} ?>" placeholder="Enter Your Address">
                <label for="Birthday" class="labels"><img src="/JOBJET/IMAGERS/bdy.png" alt="">Birthday</label>
                <input type="date" class="form-control" id="form-control1" name="birth_day" value="<?php if (isset($_POST['submit'])) {echo $birth_day;} ?>" placeholder="Select Your Birthday">
                <label for="Gender" class="labels"><img src="/JOBJET/IMAGERS/gender.png" alt="">Gender</label>
                <select class="form-control" id="form-control1" name="gender">
                    <option value="None" <?php if (isset($_POST['gender']) && $_POST['gender'] === 'None') {echo 'selected'; }?>>None</option>
                    <option value="male" <?php if (isset($_POST['gender']) && $_POST['gender'] === 'male') {echo 'selected'; } ?>>Male</option>
                    <option value="female" <?php if (isset($_POST['gender']) && $_POST['gender'] === 'female') {echo 'selected'; } ?>>Female</option>
                    <option value="other" <?php if (isset($_POST['gender']) && $_POST['gender'] === 'other') { echo 'selected';} ?>>Other</option>
                </select>

            </div>

            <div class="contact">
                <hr class="hr3">
                <div class="For-infor">
                    <h6>CONTACT INFORMATION</h6>

                    <label for="PhoneNumber" class="labels"><img src="/JOBJET/IMAGERS/call.png" alt="">Phone Number</label>
                    <input type="text" class="form-control" name="phone_no" value="<?php if (isset($_POST['submit'])) {echo $phone_no; } ?>" placeholder="Enter Your Phone Number">
                    <label for="Email" class="labels"><img src="/JOBJET/IMAGERS/email.png" alt="">Email</label>
                    <input type="email" class="form-control" name="pro_email" aria-describedby="emailHelp" value="<?php if (isset($_POST['submit'])) { echo $pro_email; } ?>" placeholder="Enter Your Email">
                    <label for="Site" class="labels"><img src="/JOBJET/IMAGERS/site.png" alt="">Site</label>
                    <input type="text" class="form-control"  name="site" value="<?php if (isset($_POST['submit'])) {echo $site; } ?>" placeholder="Enter Your WebSite">
                </div>
            </div>

           
                <a href="javascript:void(0)" class="add-more-form" ><img src="/JOBJET/IMAGERS/plus.png" id="add-more-button" alt="exit" ></a>
                <div class="work"> 
                    <hr class="hr3">
                    <div class="For-infor"> 
                        <h6>WORK EXPERIENCES</h6>
                        <label for="Position" class="labels">Position</label>
                        <input type="text" class="form-control" name="position[]" value="<?php if (isset($_POST['submit'])) {echo $position;} ?>" placeholder="Enter Your Work position">
                        <label for="CompanyName" class="labels">Company Name</label>
                        <input type="text" class="form-control" name="company_name[]" value="<?php if (isset($_POST['submit'])) {echo $company_name; } ?>" placeholder="Enter Your Company Name">
                        <label for="TimePeriod" class="labels">Time Period</label>
                        <input type="text" class="form-control" name="time_period[]" value="<?php if (isset($_POST['submit'])) {echo $time_period; } ?>" placeholder="Enter Your Time Period">
                        
                    </div>
                </div>
            
            <div class="paste-new-forms">

            </div>


            <div class="filed">
                <hr class="hr3">
                <div class="For-infor">
                    <h6>INTERESTED CAREER FIELDS</h6>
                    <label for="filed" class="labels"><img src="/JOBJET/IMAGERS/filed.png" alt="">Filed 01</label>
                    <input type="text" class="form-control" name="filed" value="<?php if (isset($_POST['submit'])) { echo $filed; } ?>" placeholder="Enter Your Interested 1st Filed">
                    <label for="filed" class="labels"><img src="/JOBJET/IMAGERS/filed.png" alt="">Filed 02</label>
                    <input type="text" class="form-control" name="filed2" value="<?php if (isset($_POST['submit'])) { echo $filed2;} ?>" placeholder="Enter Your Interested 2nd Filed">


                </div>

            </div>

            <div class="skills">
                <hr class="hr3">
                <div class="For-infor">
                    <h6>SKILLS</h6>
                    <label for="skills" class="labels"><img src="/JOBJET/IMAGERS/filed.png" alt="">Skills</label>
                    <textarea class="form-control" id="form-control3" name="skills" placeholder="Enter Your skills" wrap="hard" maxlength="100" value="<?php if (isset($_POST['submit'])) { echo $skills; } ?>"></textarea>

                </div>

                <div class="resume">
                    <hr class="hr3">
                    <div class="For-infor">
                        <h6>UPLOAD RESUME</h6>

                        <input type="file" id="input-file1" class="upload-input" name="upload-img2" >
                        <span class="negative-img-msg-file" id="file-name"></span>
                    </div>
                    <label for="input-file1" class="upload-label">
                    <img src="/JOBJET/IMAGERS/uploadimg.png" class="uploading-img" alt="">
                    </label>

                        <script>
                            const inputFile = document.getElementById('input-file1');
                            const fileNameSpan = document.getElementById('file-name');

                            inputFile.addEventListener('change', () => {
                                const fileName = inputFile.files[0].name;
                                fileNameSpan.textContent = `Uploaded file: ${fileName}`;
                            });
                        </script>

                </div>
                <button type="submit" name="submit" class="save-button">Save</button>
                <a href="profile.php" id="relocating-button" class="relocating-button">View Profile</a>
        </form>
    </div>

    

    <script>
        //display uploaded image
        const display = document.querySelector('.pro_img img');
        const input = document.querySelector('#upload-file');

        input.addEventListener('change', () => {
            let reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.addEventListener('load', () => {
                display.src = reader.result;
            });
        });


        //add more work form
        $(document).ready(function(){
            $(document).on('click', '.add-more-form', function () {
                $('.paste-new-forms').append(
                    '<div class="work">\
                        <div class="For-infor">\
                            <label for="Position" class="labels">Position</label>\
                            <input type="text" class="form-control" name="position[]" value="<?php if (isset($_POST['submit'])) {echo $position;} ?>" placeholder="Enter Your Work position">\
                            <label for="CompanyName" class="labels">Company Name</label>\
                            <input type="text" class="form-control" name="company_name[]" value="<?php if (isset($_POST['submit'])) {echo $company_name; } ?>" placeholder="Enter Your Company Name">\
                            <label for="TimePeriod" class="labels">Time Period</label>\
                            <input type="text" class="form-control" name="time_period[]" value="<?php if (isset($_POST['submit'])) {echo $time_period; } ?>"  placeholder="Enter Your Time Period">\
                            <button type="button" class="remove-button">Remove</button>\
                        </div>\
                    </div>\
                ');
                $(this).hide(); // Hide the clicked .add-more-form button
            });

            $(document).on('click', '.remove-button', function () {
                $(this).closest('.work').remove();
                $('.add-more-form').show(); // Show the add-more-form button again
            });
        });
        //for the print function
        const printBtn = document.getElementById('print');

        printBtn.addEventListener('click', function() {
            window.print();
        });
    </script>



</body>

</html>

<?php ?>