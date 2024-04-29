<?php

include('config.php');

// Check if filter is provided via POST request
if(isset($_POST['filter'])){
    // Sanitize the input
    $filter = mysqli_real_escape_string($conn, $_POST['filter']);
    if ($filter === 'all') {
        // Show all data
        $sql = "SELECT * FROM jobadds";
    } else {

        $sql = "SELECT * FROM jobadds WHERE adds_heading LIKE '%$filter%'";
    }

} elseif(isset($_POST['search'])){
    // Sanitize the input
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT * FROM jobadds WHERE adds_heading LIKE '%$search%' OR ads_position LIKE '%$search%'";

} else {
    // Load all data
    $sql = "SELECT * FROM jobadds";
}

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    echo '<div class="container" id="dataContainer">';

    // Fetch and display data
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="data-container">
                <a href="#" onclick="windowOpen(' . $row['id'] . ')">
                  
                    <div class="for-img"> 
                      <img  src="/JOBJET/JOBS_IMG/' . (!empty($row['ads_img']) ? $row['ads_img'] : 'Ads.png') . '" alt="Ads Image">
                      <div class="popup-container">
                          <img src="/JOBJET/JOBS_IMG/' . (!empty($row['ads_img']) ? $row['ads_img'] : 'Ads.png') . '" alt="Ads Image">
                      </div>
                    </div>

                  <h3>' . $row['adds_heading'] . '</h3>
                  <p>' . htmlspecialchars($row['ads_position']) . '</p>
                </a>
              </div>';
    }
    echo '</div>';
} else {
    // If no data found, display a message
    echo '<h2 class="text-danger"><i class="fas fa-exclamation-circle" id="mark"></i><br>Data not found</h2>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="/JOBJET/JavaScript/jquery.min.js"></script>
    <script>
        function windowOpen(jobId) {
          var screenWidth = window.screen.width;
          var screenHeight = window.screen.height;

          var windowWidth = 1100; // Width of the new window
          var windowHeight = 620; // Height of the new window

          var left = (screenWidth - windowWidth) / 2;
          var top = (screenHeight - windowHeight) / 2;

          // Construct the URL
          var url = "/JOBJET/PHP/apply_job.php?id=" + jobId;

          // Open the new window
          window.open(url, "blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + left + ", top=" + top);
        }
  </script>
</body>
</html>
