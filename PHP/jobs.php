<?php 
$page_title = "Jobs";
include('includes/header.php'); 
include('config.php');
include('includes/navbar.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="/JOBJET/CSS/job.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  

</head>

<body>
<div  class="container-for-search">
    <img src="/JOBJET/IMAGERS/JOBJET_LOGO.png" alt="JobJet">
          <form method="post">
              <input type="text" id="search" name="search" class="form-control search-icon-input" placeholder="Find your jobs">
          </form>
  </div>
  
  <div class="for-filter-container">
    <p>Categories+</p>
    <button class="filter-btn"  data-category="all">All</button><br>
      <?php 
      // Define job categories
      $categories = array("Graphic Designer", "Software Engineer", "Mobile App Developer", "Web Developer","Full-Stack Developer", "QA Engineer");
      
      // Display filter buttons
      foreach ($categories as $category): ?>

          <button class="filter-btn"  data-category="<?php echo $category; ?>"><?php echo $category; ?></button><br>

      <?php endforeach; ?>
  </div>

  <div class="for-job-container" id="dataContainer">
    <?php
      include('job_search.php');
    ?>
  </div>

  <script>

    
    $(document).ready(function() {
      // Handle filter button clicks
      $('.filter-btn').click(function() {
        var filter = $(this).data('category');
        $.ajax({
          url: 'job_search.php',
          method: 'POST',
          data: { filter: filter },
          success: function(response) {
            $('#dataContainer').html(response); 
          }
        });
      });
      
      // Handle search input changes
      $('#search').on('input', function() {
        var search = $(this).val().trim();
        if (search.length > 0) {
          $.ajax({
            url: 'job_search.php',
            method: 'POST',
            data: { search: search },
            success: function(response) {
              $('#dataContainer').html(response); 
            }
          });
        } 
      });
    });
  </script>


</body>

</html>
<?php include('includes/footer.php'); ?>
 