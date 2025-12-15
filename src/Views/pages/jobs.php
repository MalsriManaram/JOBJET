<?php
$page_title = 'Jobs';

include LAYOUTS.'header.php';
include LAYOUTS.'navbar.php';
include CONFIG.'config.php';
?>

<link href="<?php echo BASE_URL; ?>assets/css/job.css" rel="stylesheet" type="text/css" media="all" />
  
<main>
<div  class="container-for-search">
    <img src="<?php echo BASE_URL; ?>assets/images/website-images/JOBJET_LOGO.png" alt="JobJet">
    <form method="post">
        <input type="text" id="search" name="search" class="form-control search-icon-input" placeholder="Find your jobs">
    </form>
  </div>
  
  <div class="for-filter-container">
    <p>Categories+</p>
    <button class="filter-btn"  data-category="all">All</button><br>
      <?php
      // Define job categories
      $categories = ['Graphic Designer', 'Software Engineer', 'Mobile App Developer', 'Web Developer', 'Full-Stack Developer', 'QA Engineer'];

// Display filter buttons
foreach ($categories as $category) { ?>

          <button class="filter-btn"  data-category="<?php echo $category; ?>"><?php echo $category; ?></button><br>

      <?php } ?>
  </div>

  <div class="for-job-container" id="dataContainer">
     <?php include PAGES.'job_search.php'; ?>
  </div>

  <script>
    $(function() {

       const ajaxURL = "job_search";

      // delegated handler — works even if .filter-btn is replaced later
      $(document).on('click', '.filter-btn', function(e) {
        e.preventDefault();
        var filter = $(this).data('category');
        console.log('Filter clicked:', filter);

        $.ajax({
          url: ajaxURL, // adjust path if needed
          method: 'POST',
          data: { filter: filter },
          success: function(response) {
            $('#dataContainer').html(response);
          },
          error: function(xhr, status, err) {
            console.error('AJAX error:', status, err);
          }
        });
      });

      // search input
      $(document).on('input', '#search', function() {
        var search = $(this).val().trim();
        if (search.length > 0) {
          $.ajax({
            url: ajaxURL,
            method: 'POST',
            data: { search: search },
            success: function(response) {
              $('#dataContainer').html(response);
            },
            error: function(xhr, status, err) {
              console.error('AJAX error:', status, err);
            }
          });
        } else {
          // optional: reload all
          $.ajax({
            url: ajaxURL,
            method: 'POST',
            data: {},
            success: function(response) {
              $('#dataContainer').html(response);
            }
          });
        }
      });
    });
  </script>



</main>
<?php include LAYOUTS.'footer.php'; ?>
 