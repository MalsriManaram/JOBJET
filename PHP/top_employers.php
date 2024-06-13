<?php
    $page_title = "Top Employers";
    include('includes/header.php');
    include('config.php');
    include('includes/navbar.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/JOBJET/CSS/top_employers.css" type="text/css" media="all" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body> 
    
<div  class="container-for-search">
        <form method="post">
            <input type="text" name="search" class="form-control search-icon-input" placeholder="Enter Employer Name">
            </input>
            <button type="submit" name="submit" class="search-button">Search</button>
        </form>
    </div>
 
    <div class="card03">
    <?php
        $not_search = false;
        if(isset($_POST['submit'])){
            // Sanitize the input
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            
            if(!empty($search)) {

            $not_search = true;
                // Perform a single query joining the tables
                $sql = "SELECT * FROM topemployers WHERE company_name LIKE '%$search%'";
                
                $result = mysqli_query($conn, $sql);
                
                // Check if any result is found
                if(mysqli_num_rows($result) > 0){

                    echo '<div class="container" id="dataContainer">';
                    
                    // Fetch and display data
                    while ($row = mysqli_fetch_assoc($result)) {

                        echo '
                            <div class="data-container">
                            
                                <a href="' . (!empty($row['employers_url']) ? $row['employers_url'] : 'top_employers.php') . '">
                                
                                    <div class="for-img"> 
                                        <img  src="/JOBJET/TOP_EMPLOYERS_IMG/' . (!empty($row['employers_img']) ? $row['employers_img'] : 'Company Logo.png') . '" alt="Employers Image">
                                        <div class="popup-container">
                                            <img src="/JOBJET/TOP_EMPLOYERS_IMG/' . (!empty($row['employers_img']) ? $row['employers_img'] : 'Company Logo.png') . '" alt="Employers Image">
                                            <h3>' . htmlspecialchars($row['company_name']) . '</h3>
                                            <p><b>Location:</b><br>'.htmlspecialchars($row['location']).'</p>
                                            <div class="for-description">
                                                <h6><b>DESCRIPTION</b></h6><span>'.nl2br(htmlspecialchars($row['employers_text'])).'</span>
                                            </div>
                                        </div>
                                    </div>
                
                                    <h3>' . $row['company_name'] . '</h3>
                                    <p><b>Location:<br></b><span>'. $row['location'] .'</span></p>
                                </a>
                                
                            </div>';
                    }

                    echo '</div>';
                    
                } else {
                    echo '<h2 class="text-danger"><i class="fas fa-exclamation-circle" id="mark"></i><br>Data not found</h2>';
                }
            } 
        }
 

        if(!$not_search) {

        $sql = "SELECT * FROM topemployers";
        $result = mysqli_query($conn, $sql);

        echo '<div class="container" id="dataContainer">';
        while ($row = mysqli_fetch_assoc($result)){

            echo '
            <div class="data-container">
            
                <a href="' . (!empty($row['employers_url']) ? $row['employers_url'] : 'top_employers.php') . '">
                
                    <div class="for-img"> 
                        <img  src="/JOBJET/TOP_EMPLOYERS_IMG/' . (!empty($row['employers_img']) ? $row['employers_img'] : 'Company Logo.png') . '" alt="Employers Image">
                        <div class="popup-container">
                            <img src="/JOBJET/TOP_EMPLOYERS_IMG/' . (!empty($row['employers_img']) ? $row['employers_img'] : 'Company Logo.png') . '" alt="Employers Image">
                            <h3>' . htmlspecialchars($row['company_name']) . '</h3>
                            <p><b>Location:</b><br>'.htmlspecialchars($row['location']).'</p>
                            <div class="for-description">
                                <h6><b>DESCRIPTION</b></h6><span>'.nl2br(htmlspecialchars($row['employers_text'])).'</span>
                            </div>
                        </div>
                    </div>

                    <h3>' . $row['company_name'] . '</h3>
                    <p><b>Location:<br></b><span>'. $row['location'] .'</span></p>
                </a>

            </div>';

        }
        echo '</div>';
        }
        

                
        
        ?>
    </div>

</body>

</html>
    <?php include ('includes/footer.php'); ?>
