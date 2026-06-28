<?php

include CONFIG.'config.php';

if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    if ($filter === 'all') {
        $stmt = $conn->prepare('SELECT * FROM jobadds');
    } else {
        $stmt = $conn->prepare("SELECT * FROM jobadds WHERE adds_heading LIKE ?");
        $like_filter = '%' . $filter . '%';
        $stmt->bind_param('s', $like_filter);
    }
} elseif (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $conn->prepare("SELECT * FROM jobadds WHERE adds_heading LIKE ? OR ads_position LIKE ?");
    $like_search = '%' . $search . '%';
    $stmt->bind_param('ss', $like_search, $like_search);
} else {
    $stmt = $conn->prepare('SELECT * FROM jobadds');
}

$stmt->execute();
$result = $stmt->get_result();

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
