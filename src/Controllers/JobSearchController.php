<?php

include CONFIG.'config.php';

// Check if filter is provided via POST request
if (isset($_POST['filter'])) {
    // Sanitize the input
    $filter = mysqli_real_escape_string($conn, $_POST['filter']);
    if ($filter === 'all') {
        // Show all data
        $sql = 'SELECT * FROM jobadds';
    } else {
        $sql = "SELECT * FROM jobadds WHERE adds_heading LIKE '%$filter%'";
    }
} elseif (isset($_POST['search'])) {
    // Sanitize the input
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT * FROM jobadds WHERE adds_heading LIKE '%$search%' OR ads_position LIKE '%$search%'";
} else {
    // Load all data
    $sql = 'SELECT * FROM jobadds';
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="container" id="dataContainer">';

    // Fetch and display data
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="data-container">
                <a onclick="windowOpen('.$row['id'].')">
                    <div class="for-img"> 
                      <img  src="'.BASE_URL.'assets/images/job-adds/'.(!empty($row['ads_img']) ? $row['ads_img'] : 'Ads.png').'" alt="Ads Image">
                      <div class="popup-container">
                          <img src="'.BASE_URL.'assets/images/job-adds/'.(!empty($row['ads_img']) ? $row['ads_img'] : 'Ads.png').'" alt="Ads Image">
                      </div>
                    </div>

                  <h3>'.$row['adds_heading'].'</h3>
                  <p>'.htmlspecialchars($row['ads_position']).'</p>
                </a>
              </div>';
    }
    echo '</div>';
} else {
    // If no data found, display a message
    echo '<h2 class="text-danger"><i class="fas fa-exclamation-circle" id="mark"></i><br>Data not found</h2>';
}
