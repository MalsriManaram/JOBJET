<?php
include CONTROLLERS.'JobSearchController.php';
?>

<main>
    <script>
        function windowOpen(jobId) {
          var screenWidth = window.screen.width;
          var screenHeight = window.screen.height;

          var windowWidth = 1100; // Width of the new window
          var windowHeight = 620; // Height of the new window

          var left = (screenWidth - windowWidth) / 2;
          var top = (screenHeight - windowHeight) / 2;

          // Construct the URL
          var url = "apply_job?id=" + jobId;

          // Open the new window
          window.open(url, "blank", "width=" + windowWidth + ", height=" + windowHeight + ", left=" + left + ", top=" + top);
        }
  </script>
</main>

