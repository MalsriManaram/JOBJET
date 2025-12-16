<?php include CONTROLLERS.'Profile/ViewMyResumeController.php'; ?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/view_resume.css" type="text/css" media="all" />
<main>
    <div class="content">
    <?php if (isset($_GET['id'])) { ?>
        <div>
            <img class="resume_img" src="<?php echo BASE_URL; ?>assets/storage/uploads/uploaded-resumes/<?php echo $resume_img; ?>" alt="Resume Image" >
        </div>
    <?php } ?>
    <button class="print_button" id="print">Print</button> 
    </div>
    

    <script>
        const printBtn = document.getElementById('print');

        printBtn.addEventListener('click', function() {
            window.print();
        });
    </script>
</main> 

<?php include LAYOUTS.'footer.php'; ?>
