<?php

include CONFIG.'config.php';

$not_search = false;
if (isset($_POST['submit'])) {
    // Sanitize the input
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    if (!empty($search)) {
        $not_search = true;
        $stmt = $conn->prepare("SELECT * FROM topemployers WHERE company_name LIKE ?");
        $like_search = '%' . $_POST['search'] . '%';
        $stmt->bind_param('s', $like_search);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any result is found
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="main-container" id="dataContainer">';

            // Fetch and display data
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                                <div class="data-container">
                                
                                    <a href="'.(!empty($row['employers_url']) ? $row['employers_url'] : 'top_employers.php').'">
                                    
                                        <div class="for-img"> 
                                            <img  src="'.BASE_URL.'assets/images/top-employers/'.(!empty($row['employers_img']) ? $row['employers_img'] : 'Company Logo.png').'" alt="Employers Image">
                                            <div class="popup-container">
                                                <img src="'.BASE_URL.'assets/images/top-employers/'.(!empty($row['employers_img']) ? $row['employers_img'] : 'Company Logo.png').'" alt="Employers Image">
                                                <h3>'.htmlspecialchars($row['company_name']).'</h3>
                                                <p><b>Location:</b><br>'.htmlspecialchars($row['location']).'</p>
                                                <div class="for-description">
                                                    <h6><b>DESCRIPTION</b></h6><span>'.nl2br(htmlspecialchars($row['employers_text'])).'</span>
                                                </div>
                                            </div>
                                        </div>
                    
                                        <h3>'.$row['company_name'].'</h3>
                                        <p><b>Location:<br></b><span>'.$row['location'].'</span></p>
                                    </a>
                                    
                                </div>';
            }

            echo '</div>';
        } else {
            echo '<h2 class="text-danger"><i class="fas fa-exclamation-circle" id="mark"></i><br>Data not found</h2>';
        }
    }
}

if (!$not_search) {
    $stmt = $conn->prepare('SELECT * FROM topemployers');
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div class="main-container" id="dataContainer">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '
                <div class="data-container">
                
                    <a href="'.(!empty($row['employers_url']) ? $row['employers_url'] : 'top_employers.php').'">
                    
                        <div class="for-img"> 
                            <img  src="'.BASE_URL.'assets/images/top-employers/'.(!empty($row['employers_img']) ? $row['employers_img'] : 'Company Logo.png').'" alt="Employers Image">
                            <div class="popup-container">
                                <img src="'.BASE_URL.'assets/images/top-employers/'.(!empty($row['employers_img']) ? $row['employers_img'] : 'Company Logo.png').'" alt="Employers Image">
                                <h3>'.htmlspecialchars($row['company_name']).'</h3>
                                <p><b>Location:</b><br>'.htmlspecialchars($row['location']).'</p>
                                <div class="for-description">
                                    <h6><b>DESCRIPTION</b></h6><span>'.nl2br(htmlspecialchars($row['employers_text'])).'</span>
                                </div>
                            </div>
                        </div>

                        <h3>'.$row['company_name'].'</h3>
                        <p><b>Location:<br></b><span>'.$row['location'].'</span></p>
                    </a>

                </div>';
    }
    echo '</div>';
}
