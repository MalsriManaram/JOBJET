<?php include CONTROLLERS.'CvGeneratorController.php'; ?>

<!-- custom css -->
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/cv_generator.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<main class="cv-page">
    <div class="container">
        <div class="left-side">
            <!-- Content for the left side -->
            <section id="about-sc" class="">
                <div class="about-cnt">
                    <form action="" class="cv-form" id="cv-form">
                        <div class="cv-form-blk">
                            <div class="cv-form-row-title">
                                <h3>About Section</h3>
                            </div>
                            <div class="cv-form-row cv-form-row-about">
                                <div class="cols-2">
                                    <div class="form-elem">
                                        <label for="" class="form-label">First Name</label>
                                        <input name="firstname" type="text" class="form-control firstname" id="" onkeyup="generateCV()" placeholder="First Name" value="<?php if (isset($id)) {
                                            echo htmlspecialchars($first_name);
                                        } ?>">
                                        <span class="form-text"></span>
                                    </div>
                                    <div class="form-elem">
                                        <label for="" class="form-label">Last Name</label>
                                        <input name="lastname" type="text" class="form-control lastname" id="" onkeyup="generateCV()" placeholder="Last Name" value="<?php if (isset($id)) {
                                            echo htmlspecialchars($last_name);
                                        } ?>">
                                        <span class="form-text"></span>
                                    </div>
                                </div>
                                <div class="form-elem">
                                    <label for="" class="form-label">Your Image</label>
                                    <input name="image" type="file" class="form-control image" id="" accept="image/*" onchange="previewImage()">
                                </div>
                                <div class="cols-2">
                                    <div class="form-elem">
                                        <label for="" class="form-label">Designation</label>
                                        <input name="designation" type="text" class="form-control designation" id="" onkeyup="generateCV()" placeholder="Designation" value="<?php if (isset($id)) {
                                            echo htmlspecialchars($field);
                                        } ?>">
                                        <span class="form-text"></span>
                                    </div>
                                    <div class="form-elem">
                                        <label for="" class="form-label">Address</label>
                                        <input name="address" type="text" class="form-control address" id="" onkeyup="generateCV()" placeholder="Address" value="<?php if (isset($id)) {
                                            echo htmlspecialchars($address);
                                        } ?>">
                                        <span class="form-text"></span>
                                    </div>
                                </div>

                                <div class="cols-2">
                                    <div class="form-elem">
                                        <label for="" class="form-label">Email</label>
                                        <input name="email" type="text" class="form-control email" id="" onkeyup="generateCV()" placeholder="Email" value="<?php if (isset($id)) {
                                            echo htmlspecialchars($pro_email);
                                        } ?>">
                                        <span class="form-text"></span>
                                    </div>
                                    <div class="form-elem">
                                        <label for="" class="form-label">Phone No:</label>
                                        <input name="phoneno" type="text" class="form-control phoneno" id="" onkeyup="generateCV()" placeholder="Phone No" value="<?php if (isset($id)) {
                                            echo htmlspecialchars($phone_no);
                                        } ?>">
                                        <span class="form-text"></span>
                                    </div>

                                </div>
                                <div class="form-elem">
                                    <label for="" class="form-label">Summary</label>
                                    <textarea name="summary" class="form-control summary" id="" onkeyup="generateCV()" placeholder="Summary"></textarea>
                                    <span class="form-text"></span>
                                </div>
                            </div>
                        </div>

                        <div class="cv-form-blk">
                            <div class="cv-form-row-title">
                                <h3>Achievements</h3>
                            </div>
                            <div class="row-separator repeater">
                                <div class="repeater" data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="cv-form-row cv-form-row-achievement">           <button data-repeater-delete type="button" class="repeater-remove-btn"><i class="fas fa-minus"></i></button>
                                            <div class="cols-2">
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Title</label>
                                                    <input name="achieve_title" type="text" class="form-control achieve_title" id="" onkeyup="generateCV()" placeholder="Achievements Title">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Description</label>
                                                    <input name="achieve_description" type="text" class="form-control achieve_description" id="" onkeyup="generateCV()" placeholder="Achievements Description">
                                                    <span class="form-text"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <button type="button" data-repeater-create value="Add" class="repeater-add-btn"><i class="fas fa-plus"></i> Add Achievement</button>
                            </div>
                        </div>

                        <div class="cv-form-blk">
                            <div class="cv-form-row-title">
                                <h3>Experience</h3>
                            </div>
                            <div class="row-separator repeater">
                                <div class="repeater" data-repeater-list="group-b">
                                    <div data-repeater-item>
                                        <div class="cv-form-row cv-form-row-experience">
                                            <button data-repeater-delete type="button" class="repeater-remove-btn"><i class="fas fa-minus"></i></button>
                                            <div class="cols-3">
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Title</label>
                                                    <input name="exp_title" type="text" 
                                                    placeholder="Experience Title" class="form-control exp_title" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Organization</label>
                                                    <input name="exp_organization" type="text" placeholder="Experience Organization" class="form-control exp_organization" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Location</label>
                                                    <input name="exp_location" type="text" placeholder="Experience Location" class="form-control exp_location" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                            </div>

                                            <div class="cols-3">
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Start Date</label>
                                                    <input name="exp_start_date" type="date" class="form-control exp_start_date" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">End Date</label>
                                                    <input name="exp_end_date" type="date" class="form-control exp_end_date" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Description</label>
                                                    <input name="exp_description" type="text" class="form-control exp_description" placeholder="Experience Description" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" data-repeater-create value="Add" class="repeater-add-btn"><i class="fas fa-plus"></i> Add Experience</button>
                            </div>
                        </div>

                        <div class="cv-form-blk">
                            <div class="cv-form-row-title">
                                <h3>Education</h3>
                            </div>
                            <div class="row-separator repeater">
                                <div class="repeater" data-repeater-list="group-c">
                                    <div data-repeater-item>
                                        <div class="cv-form-row cv-form-row-education">
                                        <button data-repeater-delete type="button" class="repeater-remove-btn"><i class="fas fa-minus"></i></button>
                                            <div class="cols-3">
                                                <div class="form-elem">
                                                    <label for="" class="form-label">School/University</label>
                                                    <input name="edu_school" type="text" placeholder="Education School/University" class="form-control edu_school" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Degree</label>
                                                    <input name="edu_degree" type="text" placeholder="Education Degree" class="form-control edu_degree" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">City</label>
                                                    <input name="edu_city" type="text" placeholder="Education City" class="form-control edu_city" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                            </div>

                                            <div class="cols-3">
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Start Date</label>
                                                    <input name="edu_start_date" type="date" class="form-control edu_start_date" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Graduation Date</label>
                                                    <input name="edu_graduation_date" type="date" placeholder="Education Graduation Date" class="form-control edu_graduation_date" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Description</label>
                                                    <input name="edu_description" type="text" placeholder="Education Description" class="form-control edu_description" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" data-repeater-create value="Add" class="repeater-add-btn"><i class="fas fa-plus"></i> Add Education</button>
                            </div>
                        </div>

                        <div class="cv-form-blk">
                            <div class="cv-form-row-title">
                                <h3>Projects</h3>
                            </div>
                            <div class="row-separator repeater">
                                <div class="repeater" data-repeater-list="group-d">
                                    <div data-repeater-item>
                                        <div class="cv-form-row cv-form-row-projects">
                                            <button data-repeater-delete type="button" class="repeater-remove-btn"><i class="fas fa-minus"></i></button>
                                            <div class="cols-3">
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Project Name</label>
                                                    <input name="proj_title" type="text" placeholder="Project Name" class="form-control proj_title" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Project Link</label>
                                                    <input name="proj_link" type="text" placeholder="Project Link" class="form-control proj_link" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                                <div class="form-elem">
                                                    <label for="" class="form-label">Description</label>
                                                    <input name="proj_description" type="text" placeholder="Project Description" class="form-control proj_description" id="" onkeyup="generateCV()">
                                                    <span class="form-text"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <button type="button" data-repeater-create value="Add" class="repeater-add-btn"><i class="fas fa-plus"></i> Add Project</button>
                            </div>
                        </div>

                        <div class="cv-form-blk">
                            <div class="cv-form-row-title">
                                <h3>Skills</h3>
                            </div>
                            <div class="row-separator repeater">
                                <div class="repeater" data-repeater-list="group-e">
                                    <div data-repeater-item>
                                        <div class="cv-form-row cv-form-row-skills">
                                            <button data-repeater-delete type="button" class="repeater-remove-btn"><i class="fas fa-minus"></i></button>
                                            <div class="form-elem">
                                                <label for="" class="form-label">Skill</label>
                                                <input name="skill" type="text" placeholder="Skill" class="form-control skill" id="" onkeyup="generateCV()">
                                                <span class="form-text"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <button type="button" data-repeater-create value="Add" class="repeater-add-btn"><i class="fas fa-plus"></i> Add Skill</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <div class="right-side">
            <!-- Content for the right side -->
            <!-- preview section -->
            <section id="preview-sc" class="print_area">
                <div class="preview-cnt" id="printable-content">
                    <div class="preview-cnt-l">
                        <div class="preview-blk">
                            <div class="preview-image">
                                <img class="img" width="140" height="140" src="<?php echo BASE_URL; ?>assets/storage/uploads/profile-pics/<?php if (isset($id)) {
                                    echo $pro_img;
                                } else {
                                    echo 'profile.png';
                                } ?>" alt="" id="image_dsp">
                            </div>
                            <div class="preview-item preview-item-name">
                                <span class="preview-item-val fw-6" id="fullname_dsp"><?php if (isset($id)) {
                                    echo $full_name;
                                } else {
                                    echo 'User Name';
                                } ?></span>
                            </div>
                            <div class="preview-item">
                                <span class="preview-item-val text-uppercase fw-6 ls-1 text-center"  id="designation_dsp"><?php if (isset($id)) {
                                    echo $field;
                                } else {
                                    echo 'Designation';
                                } ?></span>
                            </div>
                        </div>

                        <div class="preview-blk">
                            <div class="preview-blk-title">
                                <h3>About</h3>
                            </div>
                            <div class="preview-blk-list">
                                <div class="preview-item">
                                    <span class="preview-item-val" id="phoneno_dsp"><?php if (isset($id)) {
                                        echo $phone_no;
                                    } else {
                                        echo 'xxx-xxx-xxxx';
                                    } ?></span>
                                </div>
                                <div class="preview-item">
                                    <span class="preview-item-val text-wrap" id="email_dsp"><?php if (isset($id)) {
                                        echo $pro_email;
                                    } else {
                                        echo 'email@example.com';
                                    } ?></span>
                                </div>
                                <div class="preview-item">
                                    <span class="preview-item-val" id="address_dsp"><?php if (isset($id)) {
                                        echo $address;
                                    } else {
                                        echo 'Address';
                                    } ?></span>
                                </div>
                                <div class="preview-item">
                                    <span class="preview-item-val" id="summary_dsp">Summary</span>
                                </div>
                            </div>
                        </div>

                        <div class="preview-blk">
                            <div class="preview-blk-title">
                                <h3>Skills</h3>
                            </div>
                            <div class="skills-items preview-blk-list" id="skills_dsp">
                                <?php if (isset($id) && $skills) {
                                    $skills_array = explode(',', $skills); // Assuming skills are comma-separated
                                    foreach ($skills_array as $skill) {
                                        echo '<div class="preview-item"><span class="preview-item-val">'.trim($skill).'</span></div>';
                                    }
                                } else {
                                    echo '<div class="preview-item"><span class="preview-item-val">Skill 1</span></div>';
                                }?>
                            </div>
                        </div>
                    </div>

                    <div class="preview-cnt-r">
                        <div class="preview-blk">
                            <div class="preview-blk-title">
                                <h3>Achievements</h3>
                            </div>
                            <div class="achievements-items preview-blk-list" id="achievements_dsp"> 
                                Title </br>
                                Description </br></br>
                            </div>
                        </div>

                        <div class="preview-blk">
                            <div class="preview-blk-title">
                                <h3>Education</h3>
                            </div>
                            <div class="educations-items preview-blk-list" id="educations_dsp"> 
                                Title - Organization </br>
                                Location</br>
                                Start Date - End Date </br>
                                Description </br></br>
                            </div>
                        </div>

                        <div class="preview-blk">
                            <div class="preview-blk-title">
                                <h3>Experience</h3>
                            </div>
                            <div class="experiences-items preview-blk-list" id="experiences_dsp">
                                School/University </br>
                                Degree </br>
                                City</br>
                                Start Date - Graduation Date </br>
                                Description </br></br>
                            </div>
                        </div>

                        <div class="preview-blk">
                            <div class="preview-blk-title">
                                <h3>Projects</h3>
                            </div>
                            <div class="projects-items preview-blk-list" id="projects_dsp">
                                Project Name </br>
                                Project Link </br>
                                Description </br></br>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="print-btn-sc">
                <button type="button" class="print-btn btn btn-primary" onclick="printCV()">Print CV</button>
            </section>
        </div>
    </div>
</main>

<!-- custom js -->
<script src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
<!-- app js -->
<script src="<?php echo BASE_URL; ?>assets/js/app.js"></script>

<?php include LAYOUTS.'footer.php'; ?>