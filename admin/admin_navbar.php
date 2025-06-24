<?php
session_start();
include '../includes/db.php';

$user_id = $_SESSION['admin_id'] ?? null;
$admin_name = 'Admin';

if ($user_id) {
  $stmt = $conn->prepare("SELECT name FROM admins WHERE id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stmt->bind_result($admin_name);
  $stmt->fetch();
  $stmt->close();
}
?>

<nav class="navbar">
  <div class="nav-left">
    <div class="logo">🚗</div>
    <span class="site-name">UrbanDrift Admin</span>
    <a href="admin_dashboard.php" class="nav-link">Dashboard</a>
    <a href="manage_verification.php" class="nav-link">Verification Requests</a>
    <a href="usermanagement.php" class="nav-link">Users</a>
  </div>
  <div class="nav-right">
    <span class="user-info"><i class="fas fa-user-shield"></i> <?= htmlspecialchars($admin_name) ?></span>
    <a href="admin_logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>
</nav>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
  .navbar {
    position: fixed;
    top: 0;
    width: 97%;
    background-color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 2rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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
</style>
