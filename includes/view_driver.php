<?php
session_start();
include '../includes/db.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$driver_id = intval($_GET['driver_id'] ?? 0);

// Get driver profile
$stmt = $conn->prepare("SELECT name, email ,car_model ,license_plate FROM users WHERE id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$driver = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get ratings
$stmt = $conn->prepare("
  SELECT rr.rating, rr.feedback, rr.created_at, u.name AS passenger_name
  FROM ride_ratings rr
  JOIN users u ON rr.user_id = u.id
  WHERE rr.ride_id IN (SELECT id FROM ride_offers WHERE user_id = ?)
  ORDER BY rr.created_at DESC
");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Driver Profile</title>
  <link rel="stylesheet" href="../css/myride.css">
  <style>
    body {
      background: #f5f5f5;
    }
    .main-content {
      margin-left: 220px;
      padding: 80px 20px 20px;
    }
    .profile-box, .ratings-box {
      background: #fff;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 6px;
    }
    .ratings-box p {
      margin: 5px 0;
    }
  </style>
</head>
<body>
<main class="main-content">
  <h2>Driver Profile</h2>
  <?php if ($driver): ?>
    <div class="profile-box">
      <p><strong>Name:</strong> <?= htmlspecialchars($driver['name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($driver['email']) ?></p>
       <p><strong>model:</strong> <?= htmlspecialchars($driver['car_model']) ?></p>
        <p><strong>license plate:</strong> <?= htmlspecialchars($driver['license_plate']) ?></p>
    </div>

    <h3>Passenger Ratings & Feedback</h3>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="ratings-box">
          <p><strong><?= htmlspecialchars($row['passenger_name']) ?>:</strong> ⭐ <?= $row['rating'] ?>/5</p>
          <p><em><?= htmlspecialchars($row['feedback']) ?></em></p>
          <p style="font-size: 0.85em; color: gray;"><?= $row['created_at'] ?></p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No ratings yet.</p>
    <?php endif; ?>

  <?php else: ?>
    <p>Driver not found.</p>
  <?php endif; ?>
</main>
</body>
</html>
