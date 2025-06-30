<?php
session_start();
include '../includes/db.php';
include '../includes/navbar.php';
include '../includes/sidebar.php';

$driver_id = intval($_GET['driver_id'] ?? 0);

if ($driver_id === 0) {
  echo "<p>Invalid driver ID.</p>";
  exit;
}

// Fetch driver info
$stmt = $conn->prepare("SELECT name, email, gender, age FROM users WHERE id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$stmt->bind_result($name, $email, $gender, $age);
if (!$stmt->fetch()) {
  echo "<p>Driver not found.</p>";
  $stmt->close();
  exit;
}
$stmt->close();

// Compute average rating
$stmt = $conn->prepare("
  SELECT AVG(rating_by_passenger)
  FROM ride_offers
  WHERE user_id = ? AND rating_by_passenger IS NOT NULL
");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$stmt->bind_result($avg_rating);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Driver Profile</title>
  <link rel="stylesheet" href="../css/findride.css">
  <style>
    .main-content {
      margin-left: 220px;
      padding: 80px 20px 20px;
    }
    .driver-box {
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 20px;
      max-width: 500px;
    }
    .driver-box p {
      margin: 8px 0;
    }
    .btn-back {
      display: inline-block;
      margin-top: 15px;
      padding: 8px 12px;
      background: purple;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <main class="main-content">
    <div class="driver-box">
      <h2>Driver Profile</h2>
      <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
      <p><strong>Gender:</strong> <?= htmlspecialchars($gender) ?></p>
      <p><strong>Age:</strong> <?= htmlspecialchars($age) ?></p>
      <p><strong>Average Rating:</strong> 
        <?= $avg_rating ? "⭐ " . round($avg_rating, 1) . "/5" : "Not rated yet" ?>
      </p>
      <a href="javascript:history.back()" class="btn-back">⬅ Back</a>
    </div>
  </main>
</body>
</html>
