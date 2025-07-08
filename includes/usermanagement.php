<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/sidebar.php'; // optional
include '../includes/db.php'; // connection to database

// Handle deactivation
if (isset($_POST['deactivate_id'])) {
    $userId = $_POST['deactivate_id'];
    $query = "UPDATE users SET status = 'inactive' WHERE id = $userId";
    mysqli_query($conn, $query);
}

// Fetch all users
$result = mysqli_query($conn, "SELECT id, name, email, age, gender, status FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Management - UrbanDrift</title>
  <link rel="stylesheet" href="../css/findride.css" />
  <link rel="stylesheet" href="../css/usermanagement.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<nav class="navbar">
  <div class="nav-left">
    <div class="logo">🚗</div>
    <span class="site-name">UrbanDrift</span>
    <a href="#" class="nav-link active">User Management</a>
  </div>
  <div class="nav-right">
    <a href="#" class="nav-link"><i class="fas fa-user"></i> Admin</a>
  </div>
</nav>

<main class="main-content">
  <section class="find-ride-container">
    <h2>Registered Users</h2>
    <div class="rides-grid">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="ride-box">
          <p><strong>Username:</strong> <?= htmlspecialchars($row['name'] ?? '') ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($row['email'] ?? '') ?></p>
<p><strong>Status:</strong> <?= htmlspecialchars($row['status'] ?? '') ?></p>
          <?php if ($row['status'] !== 'inactive'): ?>
          <form method="POST">
            <input type="hidden" name="deactivate_id" value="<?= $row['id'] ?>">
            <button class="submit-btn" type="submit">Deactivate</button>
          </form>
          <?php else: ?>
            <button class="submit-btn" disabled>Inactive</button>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  </section>
</main>
</body>
</html>
