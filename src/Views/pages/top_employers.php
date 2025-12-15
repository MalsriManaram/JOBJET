<?php
$page_title = 'Top Employers';
include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';

?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/top_employers.css" type="text/css" media="all" />
    
<main> 
    
<div  class="container-for-search">
        <form method="post">
            <div class="d-flex gap-2 mb-3">
                <input type="text" name="search" class="form-control search-icon-input" placeholder="Enter Employer Name">
                </input>
                <button type="submit" name="submit" class="search-button">Search</button>
            </div>
        </form>
    </div>
 
    <div class="main-card">
        <?php
            include CONTROLLERS.'TopEmployersController.php';
?>
    </div>

</main>
<?php include LAYOUTS.'footer.php'; ?>
