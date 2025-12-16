<?php

include CONTROLLERS.'ApplyJobController.php';
?>

<link href="<?php echo BASE_URL; ?>assets/css/apply_job.css" rel="stylesheet">
<main>
    <?php if (isset($_GET['id'])) { ?> 

        <div class="content">
            <?php echo $msg; ?>
            <button class="apply_button" id="applyBtn">Apply By Email</button>
            <button type="button" class="print_button" id="print">Print</button>

            <h3><?php echo $row['adds_heading']; ?></h3> 

            <img class="ads_img" src="<?php echo BASE_URL; ?>assets/images/job-adds/<?php echo $row['ads_img']; ?>" alt="Ads Image">

            <div class="card-container">
                <button class="apply_button" id="applyBtn1">Apply By Email</button>
                <button type="button" class="print_button" id="print1">Print</button>
            </div>
        </div>
        
        <div class="card2 mx-auto my-4" id="applyForm" >
        <h3>Apply By Email</h3>
            
            <form action="" class="mx-2" method="POST" enctype="multipart/form-data" id="emailForm">
                <div class="card border-0">
                    <div class="card-body">
                    <!-- Company Email -->
                    <div class="mb-3">
                        <label class="form-label labels">Company Email</label>
                        <input type="email" name="company_mail" class="form-control w-100"
                        value="<?php if (isset($_POST['submit'])) {
                            echo $company_mail;
                        } ?>"
                        placeholder="Enter company email" required>
                    </div>

                    <!-- Name & Contact -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <label class="form-label labels">Your Name</label>
                        <input type="text" name="your_name" class="form-control w-100"
                            value="<?php if (isset($_POST['submit'])) {
                                echo $your_name;
                            } ?>"
                            placeholder="Enter your name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label class="form-label labels ">Contact No</label>
                        <input type="tel" name="contact_no" class="form-control w-100" maxlength="10"
                            value="<?php if (isset($_POST['submit'])) {
                                echo $contact_no;
                            } ?>"
                            placeholder="Enter contact number" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label labels ">Your Email</label>
                        <input type="email" name="your_email" class="form-control w-100"
                        value="<?php if (isset($_POST['submit'])) {
                            echo $your_email;
                        } ?>"
                        placeholder="Enter your email" required>
                    </div>

                    <!-- Message -->
                    <div class="mb-3">
                        <label class="form-label labels ">Message</label>
                        <textarea name="message" class="form-control w-100 h-25" rows="5"
                        placeholder="Enter your message"><?php if (isset($_POST['submit'])) {
                            echo $message;
                        } ?></textarea>
                    </div>

                    <!-- CV Upload -->
                    <div class="mb-4">
                        <label class="form-label d-block labels ">Attach Your CV</label>
                            <input type="file" id="input-file" class="upload-input" name="upload_image" required>
                            
                        <label for="input-file" class="upload-label">
                            <img src="<?php echo BASE_URL; ?>assets/images/website-images/uploadimg.png" class="uploading-img" alt="">
                        </label>
                        <p class="negative-img-msg-file my-2" id="file-name"></p>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" name="submit" class="btn btn-primary" id="button1" >Send</button>
                    </div>

                    </div>
                </div>
            </form>

            
        </div>

    <?php } ?>


    <script>

        const applyBtn = document.getElementById('applyBtn');
        const applyBtn1 = document.getElementById('applyBtn1');
        const applyForm = document.getElementById('applyForm');
            

        function toggleApplyForm() {
            if (applyForm.style.display === 'none' || !applyForm.style.display) {
                applyForm.style.display = 'block';
                applyForm.scrollIntoView({ behavior: 'smooth' });
                
            } else {
                applyForm.style.display = 'none';
            }
        }

        applyBtn.addEventListener('click', toggleApplyForm);
        applyBtn1.addEventListener('click', toggleApplyForm);


        //for the print function 
        const printBtn = document.getElementById('print');
        const printBtn1 = document.getElementById('print1');

        function toggleApplyForm1() {
            window.print();
        };

        printBtn.addEventListener('click',toggleApplyForm1);
        printBtn1.addEventListener('click',toggleApplyForm1);

        //for the css
        applyBtn1.classList.add('buttonJs');
        printBtn1.classList.add('buttonJs');

        //for the upload file name 
        const inputFile = document.getElementById('input-file');
        const fileNameSpan = document.getElementById('file-name');

        inputFile.addEventListener('change', () => {
            const fileName = inputFile.files[0].name;
            fileNameSpan.textContent = `Uploaded file: ${fileName}`;

        });
    </script>

</main>


<?php include LAYOUTS.'footer.php'; ?>