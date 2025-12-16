<?php
include CONTROLLERS.'FindPeopleController.php';
?>

  <!-- Bootstrap 5 CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo BASE_URL; ?>assets/css/find_people.css" rel="stylesheet" type="text/css" media="all" />
<main>
  <div class="main-card">
  <h3 class="page-title">Find People</h3><hr class="hr1">

  <!-- Search -->
  <form method="GET" class="row g-2 mb-4 d-flex justify-content-center">
    <div class="col-md-5">
      <input type="text" name="q" class="form-control search-icon-input"
             placeholder="Search by name, field or email"
             value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
    </div>
    <div class="col-auto">
      <button type="submit" class="search-btn">Search</button>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-hover align-left">
      <thead>
        <tr>
          <th>Profile</th>
          <th>Name</th>
          <th>Field</th>
          <th>Email</th>
          <th class="px-5">Action</th>
        </tr>
      </thead>
      <tbody>

<?php
$search = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($search !== '') {
    $search = mysqli_real_escape_string($conn, $search);
    $sql = "
    SELECT u.id, u.pro_img, u.first_name, u.email, u.identify,
           p.full_name, p.pro_email, w.filed
    FROM users u
    LEFT JOIN profile p ON u.id = p.p_id
    LEFT JOIN workinfo w ON u.id = w.w_id
    WHERE p.full_name LIKE '%$search%'
       OR u.first_name LIKE '%$search%'
       OR u.email LIKE '%$search%'
       OR w.filed LIKE '%$search%'
  ";
} else {
    $sql = '
    SELECT u.id, u.pro_img, u.first_name, u.email, u.identify,
           p.full_name, p.pro_email, w.filed
    FROM users u
    LEFT JOIN profile p ON u.id = p.p_id
    LEFT JOIN workinfo w ON u.id = w.w_id
  ';
}

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = !empty($row['full_name']) ? $row['full_name'] : $row['first_name'];
        $email = !empty($row['pro_email']) ? $row['pro_email'] : $row['email'];
        $field = !empty($row['filed']) ? $row['filed'] : 'None';
        $img = !empty($row['pro_img']) ? $row['pro_img'] : 'profile.png';
        $identify = !empty($row['identify']) ? $row['identify'] : '';
        ?>

        <tr>
          <td>
            <img src="<?php echo BASE_URL; ?>assets/storage/uploads/profile-pics/<?php echo $img; ?>"
                 class="proimg" alt="Profile">
          </td>
          <td><?php echo htmlspecialchars($name); ?></td>
          <td class="text-danger"><?php echo htmlspecialchars($field); ?></td>
          <td><?php echo htmlspecialchars($email); ?></td>
          <td>
            <a href="<?php echo BASE_URL; ?>profile/view_profile?identify=<?php echo $identify; ?>" class="view-button">
              View Profile
            </a>
          </td>
        </tr>

        <?php
    }
} else {
    ?>
        <tr>
          <td colspan="5" class="text-danger fw-semibold my-3">
            Data not found
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

</main>

<?php include LAYOUTS.'footer.php'; ?>