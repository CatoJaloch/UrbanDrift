<?php
include 'db.php'; // Ensure DB connection is available

$user_id = $_SESSION['user_id'] ?? null;
$user_name = 'Guest';
$is_verified = false;

if ($user_id) {
  $stmt = $conn->prepare("SELECT name, is_verified FROM users WHERE id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stmt->bind_result($user_name, $is_verified);
  $stmt->fetch();
  $stmt->close();
}
?>

<nav class="navbar">
  <div class="nav-left">
   <div class="logo">
  <a href="../includes/dashboard.php">🚗</a>
</div>

    <span class="site-name">UrbanDrift</span>
    <a href="../includes/dashboard.php" class="nav-link">Dashboard</a>
    <a href="../includes/offerride.php" class="nav-link">Offer Ride</a>
    <a href="../includes/findride.php" class="nav-link">Find Ride</a>
    <a href="../includes/myrides.php" class="nav-link">My Rides</a>
    <a href="../includes/logout.php" class="nav-link">Logout</a>
  </div>
  <div class="nav-right">
    <span class="user-info">
      <i class="fas fa-user-circle"></i> <?= htmlspecialchars($user_name) ?>
      <?php if ($is_verified): ?>
        <span class="verified-badge"><i class="fas fa-check-circle"></i> Verified</span>
      <?php endif; ?>
    </span>
    <a href="../includes/notifications.php" class="nav-link"><i class="fas fa-bell"></i></a>
  </div>
</nav>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<!-- Navbar Styles -->
<style>
  .navbar {
    position: fixed;
    top: 0;
    width: 97%;
    background-color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 2rem;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    z-index: 1000;
  }

  .nav-left, .nav-right {
    display: flex;
    align-items: center;
    gap: 1.2rem;
  }

  .logo {
    font-size: 1.6rem;
    color: purple;
  }

  .site-name {
    font-size: 1.2rem;
    font-weight: bold;
    color: black;
  }

  .nav-link {
    text-decoration: none;
    color: black;
    font-size: 0.95rem;
    transition: color 0.3s;
  }

  .nav-link:hover {
    color: purple;
  }

  .user-info {
    font-weight: 500;
    color: #333;
  }

  .verified-badge {
    color: #3b82f6;
    font-size: 0.85em;
    margin-left: 6px;
    vertical-align: middle;
  }

  .verified-badge i {
    margin-right: 3px;
  }
</style>
