<?php include '../includes/sidebar.php';?>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: signup.php"); // redirect to login if not authenticated
  exit;
}
$user_id = $_SESSION['user_id'];
?>
<?php
include '../includes/db.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT is_verified FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($is_verified);
$stmt->fetch();
$stmt->close();
?>

<?php if (!$is_verified): ?>
  <div style="background: #ffefc3; color: #8a6d3b; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
    ⚠️ Your account is awaiting verification by the estate admin.
  </div>
<?php else: ?>
  <div style="background: #dff0d8; color: #3c763d; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align:center">
    ✅ You are verified!
  </div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UrbanDrift Dashboard</title>
  <link rel="stylesheet" href="../css/dashboard.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="nav-left"> <div class="logo">
  <a href="../includes/dashboard.php">🚗</a>
</div>

      <span class="site-name">UrbanDrift</span>
      <a href="dashboard.php" class="nav-link">Dashboard</a>
      <a href="./offerride.php" class="nav-link">Offer Ride</a>
      <a href="findride.php" class="nav-link">Find Ride</a>
      <a href="../includes/myrides.php" class="nav-link">My Ride</a>
      
    </div>
    <div class="nav-right">
      <a href="../includes/signup.php" class="nav-link"><i class="fas fa-user"></i> Login/Signup</a>
      <a href="../includes/notifications.php" class="nav-link"><i class="fas fa-bell"></i></a>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="content">
    <h2 class="section-title">Why Use UrbanDrift?</h2>

    <div class="container">
      <i class="fas fa-wallet icon"></i>
      <p><strong>Cost Effective:</strong> Save money by sharing your ride with others.</p>
    </div>

    <div class="container">
      <i class="fas fa-users icon"></i>
      <p><strong>Meet Neighbors:</strong> Get to know people in your area by carpooling.</p>
    </div>

    <div class="container">
      <i class="fas fa-leaf icon"></i>
      <p><strong>Eco-Friendly:</strong> Reduce emissions and help the environment.</p>
    </div>
  </main>
</body>
</html>
