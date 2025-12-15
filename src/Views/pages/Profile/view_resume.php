<?php

$page_title = 'View Resume';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $query0 = "SELECT resume_img FROM workinfo WHERE w_id = $id";
    $result0 = mysqli_query($conn, $query0);
    $row0 = mysqli_fetch_assoc($result0);
    if (!empty($row0['resume_img'])) {
        $_SESSION['resume_img'] = $row0['resume_img'];
    } else {
        $_SESSION['resume_img'] = 'upload_resume.png';
    }
}
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/view_resume.css" type="text/css" media="all" />
<main>
    <div class="content">
    <?php if (isset($_SESSION['id'])) { ?>
        <div>
            <img class="resume_img" src="<?php echo BASE_URL; ?>assets/storage/uploads/uploaded-resumes/<?php echo $_SESSION['resume_img']; ?>" alt="Resume Image" >
        </div>
    <?php } ?>
    </div>
    <button class="print_button" id="print">Print</button> 

    <script>
        const printBtn = document.getElementById('print');

        printBtn.addEventListener('click', function() {
            window.print();
        });
    </script>
</main> 

<?php include LAYOUTS.'footer.php'; ?>
