<?php 

  $page_title= "Find People";
  include('includes/header.php'); 
  include ('config.php');
  include('includes/navbar.php'); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="/JOBJET/CSS/find_people.css">
</head>

<body>

  <div class="card">
    <h3>Find People</h3><hr class="hr1">

    <div class="container" id="container2">
      <form method="post">
        <input type="text"  name="search" class="form-control search-icon-input" placeholder="Enter your Data">
        <button type="submit" name="submit" class="search-button">Search</button>
      </form>
    </div>

    <div class="container" id="container">
      <table class="table" >

        <?php

          $not_search = false;
          if(isset($_POST['submit'])){
              // Sanitize the input
              $search = mysqli_real_escape_string($conn, $_POST['search']);
              
              if(!empty($search)) {

                $not_search = true;
                  // Perform a single query joining the tables
                  $sql = "SELECT u.pro_img, u.first_name, u.email, p.full_name, w.filed, p.pro_email, u.identify  FROM users u JOIN profile p ON u.id = p.p_id JOIN workinfo w ON u.id = w.w_id WHERE u.id LIKE '%$search%' OR p.full_name LIKE '%$search%' OR u.first_name LIKE '%$search%' OR u.email LIKE '%$search%' OR p.pro_email LIKE '%$search%' OR w.filed LIKE '%$search%'";
                  
                  $result = mysqli_query($conn, $sql);
                  
                  // Check if any result is found
                  if(mysqli_num_rows($result) > 0){
                      echo '
                          <thead>
                              <tr>
                                  <th>Profile img</th>
                                  <th>Name</th>
                                  <th>Field</th>
                                  <th>Email</th>
                                  <th></th>
                              </tr> 
                          </thead>
                          <tbody>';
                      
                      // Fetch and display data
                      while ($row = mysqli_fetch_assoc($result)) {

                        echo '<tbody>
                                <tr>
                                <td><img src="/JOBJET/UPLOADED_IMG/'.(!empty($row['pro_img']) ? $row['pro_img'] : 'profile.png').'" class="proimg"></td>
                                  <td>'.(!empty($row['full_name']) ? $row['full_name'] : $row['first_name']).'</td>
                                  <td>'.(!empty($row['filed']) ? $row['filed'] : '<span style="color: red">Update The Field</span>').'</td>
                                  <td>'.(!empty($row['pro_email']) ? $row['pro_email'] : $row['email']).'</td>
                                  <td><a href="view_profile.php?identify='.$row['identify'].'" class="view-button">View Profile</a></td>
                                </tr>
                              </tbody>';
                      }
                      
                  } else {
                    echo '<h2 class="text-danger"><i class="fas fa-exclamation-circle" id="mark"></i><br>Data not found</h2>';
                  }
              } 
          }

          
          if(!$not_search) {

            $sql = "SELECT u.pro_img, u.first_name, u.email, p.full_name, w.filed, p.pro_email, u.identify FROM users u JOIN profile p ON u.id = p.p_id JOIN workinfo w ON u.id = w.w_id";
            $result = mysqli_query($conn, $sql);
  
            echo '
            <thead>
                <tr>
                    <th>Profile img</th>
                    <th>Name</th>
                    <th>Field</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>';
  
            while ($row = mysqli_fetch_assoc($result)){
  
              echo '
              <tbody>
                <tr>
                <td><img src="/JOBJET/UPLOADED_IMG/'.(!empty($row['pro_img']) ? $row['pro_img'] : 'profile.png').'" class="proimg"></td>
                <td>'.(!empty($row['full_name']) ? $row['full_name'] : $row['first_name']).'</td>
                <td>'.(!empty($row['filed']) ? $row['filed'] : '<span style="color: red">Update The Field</span>').'</td>
                <td>'.(!empty($row['pro_email']) ? $row['pro_email'] : $row['email']).'</td>
                <td><a href="view_profile.php?identify='.$row['identify'].'" class="view-button">View Profile</a></td> 
                </tr>
              </tbody>';
            }
        }

        ?>
      </table>

    </div>

  </div>

</body>

</html>

<?php include ('includes/footer.php'); ?>